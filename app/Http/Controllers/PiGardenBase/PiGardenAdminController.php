<?php
/**
 * Controller for pigardin admin pages
 */
namespace App\Http\Controllers\PiGardenBase;

use App\Http\Controllers\PiGardenBaseController;
use App\PiGardenSocketClient;
use App\CronHelper;
use Illuminate\Http\Request;
use Redirect;

class PiGardenAdminController extends PiGardenBaseController
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('admin');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDashboard()
    {
        $client = new PiGardenSocketClient();
        try {
            $status = $client->getStatus();
            $this->setDataFromStatus($status);
            $this->setMessagesFromStatus($status);
        } catch (\Exception $e) {
            $this->data['error'] = $this->makeError($e->getMessage().' at line '.$e->getLine().' of file '.$e->getFile(), $e->getCode());
        }
        $this->data['title'] = trans('pigarden.dashboard'); // set the page title

        return view('backpack::dashboard', $this->data);
    }

    /**
     * Open a solenoid
     * @param Request $request
     * @param $zone
     * @param $force
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function getZonePlay(Request $request, $zone, $force='')
    {
        $client = new PiGardenSocketClient();
        $status = null;
        try{
            $status = $client->zoneOpen($zone, $force === 'force');
        } catch (\Exception $e) {
            $status = new \stdClass();
            $status->error = $this->makeError($e->getMessage().' at line '.$e->getLine().' of file '.$e->getFile(), $e->getCode());
        }
        $this->setDataFromStatus($status);
        $this->setMessagesFromStatus($status, !$request->ajax());

        return $request->ajax() ? json_encode($this->data) : Redirect::back();
    }

    /**
     * Close a solenoid
     * @param Request $request
     * @param $zone
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function getZonePause(Request $request, $zone)
    {
        $client = new PiGardenSocketClient();
        $status = null;
        try{
            $status = $client->zoneClose($zone);
        } catch (\Exception $e) {
            $status = new \stdClass();
            $status->error = $this->makeError($e->getMessage().' at line '.$e->getLine().' of file '.$e->getFile(), $e->getCode());
        }
        $this->setDataFromStatus($status);
        $this->setMessagesFromStatus($status, !$request->ajax());

        return $request->ajax() ? json_encode($this->data) : Redirect::back();
    }

    /**
     * Show edit zone page
     * @param Request $request
     * @param $zone
     * @return string
     */
    public function getZoneEdit(Request $request, $zone)
    {
        $zoneData = null;
        $zoneCron = ['open' => [], 'close' => []];
        $client = new PiGardenSocketClient();
        $status = null;
//        try{
            $status = $client->getStatus(['get_cron']);
            $this->setDataFromStatus($status);
            $this->setMessagesFromStatus($status);
            if(isset($this->data['zones']) && $this->data['zones']->count()>0){
                $z = $this->data['zones']->all();
                foreach($z as $item)
                {
                    if($item->name == $zone)
                    {
                        $zoneData = $item;
                        break;
                    }
                }
            }

            if(property_exists($this->data['status'], 'cron'))
            {
                if(property_exists($this->data['status']->cron, 'open'))
                {
                    foreach($this->data['status']->cron->open as $i => $cron)
                    {
                        if($i == $zone)
                        {
                            $zoneCron['open'] = [];
                            $arrTmp = explode('%%', $cron);
                            if(count($arrTmp)>0)
                            {
                                foreach($arrTmp as $item)
                                {
                                    $zoneCron['open'][] = CronHelper::explode($item);
                                }
                            }
                        }
                    }
                }
                if(property_exists($this->data['status']->cron, 'close'))
                {
                    foreach($this->data['status']->cron->close as $i => $cron)
                    {
                        if($i == $zone)
                        {
                            $zoneCron['close'] = [];
                            $arrTmp = explode('%%', $cron);
                            if(count($arrTmp)>0)
                            {
                                foreach($arrTmp as $item)
                                {
                                    $zoneCron['close'][] = CronHelper::explode($item);
                                }
                            }
                        }
                    }
                }

            }

//        } catch (\Exception $e) {
//            $zoneData = null;
//        }

        $this->data['zone'] = $zoneData;
        $this->data['cron'] = $zoneCron;
        $this->data['title'] = trans('pigarden.zone').' '.(property_exists($zoneData, 'name_stripped') ? $zoneData->name_stripped : ''); // set the page title

        return view('zone.edit', $this->data);

    }

} 
