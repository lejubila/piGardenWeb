<?php
/**
 * Controller for pigarden admin pages
 */
namespace App\Http\Controllers\PiGardenBase;

use App\Http\Controllers\PiGardenBaseController;
use App\PiGardenSocketClient;
use App\ScheduleHelper;
use App\CronHelper;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;
use Redirect;
use Illuminate\Support\Facades\Input;
use Validator;

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
            //$status = $client->getStatus(['get_cron_open_in']);
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
            if(!backpack_user()->hasPermissionTo('start stop zones', backpack_guard_name()))
                throw new \Exception("Permission denied");
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
     * Open a solenoid in a delayed manner
     * @param Request $request
     * @param $zone
     * @param $start
     * @param $length
     * @param $force
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function getZonePlayIn(Request $request, $zone, $start, $length, $force='')
    {
        $client = new PiGardenSocketClient();
        $status = null;
        $start = (int)$start;
        $length = (int)$length;
        try{
            if(!backpack_user()->hasPermissionTo('start stop zones', backpack_guard_name()))
                throw new \Exception("Permission denied");

            if($start > 1440){
                throw new \Exception("Start time wrong: $start");
            }
            if($length > 600 || $length < 1){
                throw new \Exception("Length time is wrong: $length");
            }

            $status = $client->zoneOpenIn($zone, $start, $length, $force === 'force');
        } catch (\Exception $e) {
            $status = new \stdClass();
            $status->error = $this->makeError($e->getMessage().' at line '.$e->getLine().' of file '.$e->getFile(), $e->getCode());
        }
        $this->setDataFromStatus($status);
        $this->setMessagesFromStatus($status, !$request->ajax());

        return $request->ajax() ? json_encode($this->data) : Redirect::back();
    }

    /**
     * Cancell the programming for open a solenoid in daley manner
     * @param Request $request
     * @param $zone
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function getZonePlayInCancel(Request $request, $zone){
        $client = new PiGardenSocketClient();
        $status = null;
        try{
            if(!backpack_user()->hasPermissionTo('start stop zones', backpack_guard_name()))
                throw new \Exception("Permission denied");

            $status = $client->zoneOpenInCancel($zone);
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
            if(!backpack_user()->hasPermissionTo('start stop zones', backpack_guard_name()))
                throw new \Exception("Permission denied");

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
        $zoneCron = ['open' => [], 'close' => [], 'strOpen' => [], 'strClose' => ''];
        $client = new PiGardenSocketClient();
        $status = null;
        try{
            $status = $client->getStatus(["get_cron:$zone", "get_cron_open_in:$zone get_schedule"]);
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
                                    if(!empty($item)){
                                        $zoneCron['open'][] = CronHelper::explode($item) + ['string' => CronHelper::normalize($item)] ;
                                    }
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
                                    if(!empty($item)) {
                                        $zoneCron['close'][] = CronHelper::explode($item) + ['string' => CronHelper::normalize($item)];
                                    }
                                }
                            }
                        }
                    }
                }

                $this->data['manageSchedule'] = false;
                if(property_exists($this->data['status'], 'schedule')) {
                    $this->data['manageSchedule'] = true;
                    $this->data['schedule'] = ScheduleHelper::getScheduleFromStatus($this->data['status']);
                    $this->data['sequenceSchedule'] = ScheduleHelper::getSequence($this->data['schedule']);
                    $this->data['scheduleZone'] = [];
                    if(isset($this->data['schedule']['alias'][$zone])) {
                        $this->data['scheduleZone'] = $this->data['schedule']['alias'][$zone];
                    }
                    $this->data['sequenceZone'] = [];
                    if(isset($this->data['sequenceSchedule'][$zone])){
                        $this->data['sequenceZone'] = $this->data['sequenceSchedule'][$zone];
                    }
                }

            }

        } catch (\Exception $e) {
            $zoneData = null;
            $this->data['error'] = $this->makeError($e->getMessage().' at line '.$e->getLine().' of file '.$e->getFile(), $e->getCode());
        }

        $this->data['zone'] = $zoneData;
        $this->data['cron'] = $zoneCron;
        $this->data['title'] = trans('pigarden.zone').' '.(!is_null($zoneData) && property_exists($zoneData, 'name_stripped') ? $zoneData->name_stripped : ''); // set the page title

        return view('zone.edit', $this->data);

    }

    /**
     * Put the cron scheduling
     * @param Request $request
     * @param $zone
     * @return string
     */
    public function postCronPut(Request $request, $zone){

        $type = $request->get('type');

        $validateMin = 'required|in:' . implode(',', array_keys(CronHelper::getMinSelectItemArray()));
        $validateHour = 'required|in:' . implode(',', array_keys(CronHelper::getHourSelectItemArray()));
        $validateDom = 'required|in:' . implode(',', array_keys(CronHelper::getDomSelectItemArray()));
        $validateMonth = 'required|in:' . implode(',', array_keys(CronHelper::getMonthSelectItemArray()));
        $validateDow = 'required|in:' . implode(',', array_keys(CronHelper::getDowSelectItemArray()));

        $validateRules = [
            'type' => 'required|in:open,close'
        ];

        if ($type == 'open'){
            $validateRules += [
                'open.*.min.*' => $validateMin,
                'open.*.hour.*' => $validateHour,
                'open.*.dom.*' => $validateDom,
                'open.*.month.*' => $validateMonth,
                'open.*.dow.*' => $validateDow,
            ];
        } elseif($type == 'close') {
            $validateRules += [
                'close.*.min.*' => $validateMin,
                'close.*.hour.*' => $validateHour,
                'close.*.dom.*' => $validateDom,
                'close.*.month.*' => $validateMonth,
                'close.*.dow.*' => $validateDow,
            ];
        }

        $data = $request->all();
        if(!empty($data[$type])){
            foreach($data[$type] as $k => $cron){
                $arrayCron = [];
                $arrayCron['min'] = explode(',', $cron['min']);
                $arrayCron['hour'] = explode(',', $cron['hour']);
                $arrayCron['dom'] = explode(',', $cron['dom']);
                $arrayCron['month'] = explode(',', $cron['month']);
                $arrayCron['dow'] = explode(',', $cron['dow']);
                $data[$type][$k] = $arrayCron;
            }
        }

        $validator = Validator::make($data, $validateRules);

        //return '<pre>' . print_r($data,true) . '</pre><br><br><pre>' . print_r($validateRules,true) . '</pre>';

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }


        $cronJobs = $request->get($type);
        $scheduling = [];

        if(is_array($cronJobs) && !empty($cronJobs)){
            foreach($cronJobs as $cron){
                $scheduling[] = [
                    'min' => str_replace('min-', '', $cron['min']),
                    'hour' => str_replace('hour-', '', $cron['hour']),
                    'dom' => str_replace('dom-', '', $cron['dom']),
                    'month' => str_replace('month-', '', $cron['month']),
                    'dow' => str_replace('dow-', '', $cron['dow']),
                    'enable' => (isset($cron['enable']) && $cron['enable']) ? true : false,
                ];
            }
        }

        $client = new PiGardenSocketClient();
        $status = null;

        try{
            if(!backpack_user()->hasPermissionTo('manage cron zones', backpack_guard_name()))
                throw new \Exception("Permission denied");

            $status = $client->setCronZone($type, $zone, $scheduling);
        } catch (\Exception $e) {
            //return $e->getMessage();
            \Alert::error($e->getMessage())->flash();
            return redirect()->back()->withInput();
        }

        \Alert::success(trans('pigarden.cron.success'))->flash();

        return redirect()->back();

        /*
        \Alert::error(trans('pigarden.prova'))->flash();
        return redirect()->back()->withInput($request->input());
        */

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getInitialSetup(Request $request){
        if(!backpack_user()->hasPermissionTo('manage setup', backpack_guard_name()))
            abort(403, "permission denied");

        $client = new PiGardenSocketClient();
        $status = null;

        try{
            $status = $client->getStatus();
            $this->setDataFromStatus($status);
            $this->setMessagesFromStatus($status);
        } catch (\Exception $e) {
            $zoneData = null;
            $this->data['error'] = $this->makeError($e->getMessage().' at line '.$e->getLine().' of file '.$e->getFile(), $e->getCode());
        }
        $this->data['title'] = trans('pigarden.initial_setup.title'); // set the page title

        return view('initial_setup', $this->data);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postInitialSetup(Request $request){

        $client = new PiGardenSocketClient();
        $status = null;
        try{
            if(!backpack_user()->hasPermissionTo('manage setup', backpack_guard_name()))
                throw new \Exception("Permission denied");

            $client->setGeneralCron();
            \Alert::success(trans('pigarden.initial_setup.success'))->flash();
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();
        }

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param string $disable_scheduling
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function getZoneAllStop(Request $request, $disable_scheduling=null) {

        $client = new PiGardenSocketClient();
        $status = null;
        try{
            if(!backpack_user()->hasPermissionTo('start stop zones', backpack_guard_name()))
                throw new \Exception("Permission denied");

            if($disable_scheduling && !backpack_user()->hasPermissionTo('manage cron zones', backpack_guard_name()))
                throw new \Exception("Permission denied");

            $status = $client->zoneCloseAll(!empty($disable_scheduling));
        } catch (\Exception $e) {
            $status = new \stdClass();
            $status->error = $this->makeError($e->getMessage().' at line '.$e->getLine().' of file '.$e->getFile(), $e->getCode());
        }
        $this->setDataFromStatus($status);
        $this->setMessagesFromStatus($status, !$request->ajax());

        return $request->ajax() ? json_encode($this->data) : Redirect::back();

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function getZoneAllCronEnable(Request $request) {

        $client = new PiGardenSocketClient();
        $status = null;
        try{
            if(!backpack_user()->hasPermissionTo('manage cron zones', backpack_guard_name()))
                throw new \Exception("Permission denied");

            $status = $client->zoneAllCronEnable();
        } catch (\Exception $e) {
            $status = new \stdClass();
            $status->error = $this->makeError($e->getMessage().' at line '.$e->getLine().' of file '.$e->getFile(), $e->getCode());
        }
        $this->setDataFromStatus($status);
        $this->setMessagesFromStatus($status, !$request->ajax());

        return $request->ajax() ? json_encode($this->data) : Redirect::back();

    }



    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function getReboot(Request $request) {

        $client = new PiGardenSocketClient();
        $status = null;
        try{
            if(!backpack_user()->hasPermissionTo('shutdown restart', backpack_guard_name()))
                throw new \Exception("Permission denied");
            $status = $client->reboot();
        } catch (\Exception $e) {
            $status = new \stdClass();
            $status->error = $this->makeError($e->getMessage().' at line '.$e->getLine().' of file '.$e->getFile(), $e->getCode());
        }
        $this->setDataFromStatus($status);
        $this->setMessagesFromStatus($status, !$request->ajax());

        return $request->ajax() ? json_encode($this->data) : Redirect::back();

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function getPoweroff(Request $request) {

        $client = new PiGardenSocketClient();
        $status = null;
        try{
            if(!backpack_user()->hasPermissionTo('shutdown restart', backpack_guard_name()))
                throw new \Exception("Permission denied");
            $status = $client->poweroff();
        } catch (\Exception $e) {
            $status = new \stdClass();
            $status->error = $this->makeError($e->getMessage().' at line '.$e->getLine().' of file '.$e->getFile(), $e->getCode());
        }
        $this->setDataFromStatus($status);
        $this->setMessagesFromStatus($status, !$request->ajax());

        return $request->ajax() ? json_encode($this->data) : Redirect::back();

    }

    /*
    public function getProva(){

        return view('prova');

    }

    public function postProva(Request $request){

        $input = $request->input();
        return '<pre>'.print_r($input,true).'</pre>';

        return redirect()->back()->withInput(Input::all())->with('message', 'prova messaggio');

    }
    */

}
