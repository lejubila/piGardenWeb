<?php
/**
 * Cron Helper
 * User: lejubila
 * Date: 01/19/19
 */

namespace App;


class ScheduleHelper
{

    /**
     * @param $status object
     * @return array
     */
    public static function getScheduleFromStatus($status) {

        $dataSchedule = [
            'ev' => [],
            'alias' => [],
        ];
        foreach ($status->schedule as $ev => $sched) {
            list(
                $ev,
                $duration,
                $time_seq,
                $frequency,
                $state
            ) = explode(';', $sched->entry);

            $schedule = [
                'ev'    => $ev,
                'alias' => $sched->alias,
                'duration'  => $duration,
                'time' => [],
                'frequency' => $frequency,
                'disable' => false,
                'after' => null,
            ];

            // Sequenza
            if(substr($time_seq,0,2) == "EV") {
                $schedule['after'] = $time_seq;
            }
            // Time
            else {
                $schedule['time'] = explode(',', $time_seq);
            }

            // Enable
            if ($state == 'active') {
                $schedule['disable'] = false;
            }
            // Disable
            elseif ($state == 'inactive') {
                $schedule['disable'] = true;
            }

            $dataSchedule['ev'][$ev] = $schedule;
            $dataSchedule['alias'][$sched->alias] = $schedule;
        }

        return $dataSchedule;
    }

    /**
     * @param $dataSchedule
     * @ev object
     * @return array
     */
    public static function getSequence($dataSchedule) {
        $sequence = [];
        foreach ($dataSchedule['alias'] as $alias => $schedule) {
            if(empty($schedule['after'])){
                $sequence[$alias][] = [
                    'alias' => $alias,
                    'ev' => $schedule['ev'],
                    'duration' => $schedule['duration'],
                    'checked' => true
                ];
                self::createSequenceChain($alias, $schedule['ev'], $dataSchedule,$sequence);
            }
        }

        return $sequence;
    }

    /**
     * @param $alias
     * @param $ev
     * @param $dataSchedule
     * @param $sequence
     */
    public static function createSequenceChain($alias, $ev, $dataSchedule, &$sequence) {
        foreach($dataSchedule['alias'] as $a => $schedule) {
            if($schedule['after'] == $ev){
                $sequence[$alias][] = [
                    'alias' => $a,
                    'ev' => $schedule['ev'],
                    'duration' => $schedule['duration'],
                    'checked' => true
                ];

                self::createSequenceChain($alias, $schedule['ev'], $dataSchedule, $sequence);
            }
        }
    }

    public static function getOptionsSequence($sequence, $schedule) {

    }




    /**
     * Controlla se un alias fa parte di una sequenza e restituisce l'alias della zona che fa da capo squenza
     * @param $alias
     * @param $sequence
     * @return boolean|string
     */
    public static function aliasIsInSequence($alias, $sequence) {
        foreach ($sequence as $a => $seq){
            foreach($seq as $i){

                \Debugbar::info([
                    'i[alias]' => $i['alias'],
                    'alias' => $alias,
                ]);

                if($i['alias'] == $alias) {
                    return $a;
                }
            }
        }
        return false;
    }



}
