<?php
namespace App\Http\Controllers;

use App\PiGardenSocketClient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Redirect;

class PiGardenBaseController extends Controller
{
    /**
     * @var array data to pass view
     */
    protected $data = array();

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->data['status'] = null;
        $this->data['zones'] = null;
        $this->data['error'] = null;
        $this->data['weather'] = null;
        $this->data['last_rain_sensor'] = null;
        $this->data['last_rain_online'] = null;
    }

    /**
     * Set data view from status retrived from socket server pigarden
     * @param $status status data retrived from socket server pigarden
     */
    protected  function setDataFromStatus($status)
    {
        $this->data['status'] = $status;
        if(property_exists($status, 'zones'))
        {
            $this->data['zones'] = collect($status->zones);
            $this->data['zones']->each(function( &$zone, $id_zone){
                $zone->name_stripped = str_replace('_', ' ', $zone->name);
                $zone->actionHref = route($zone->state == 0 ? 'zone.play' : 'zone.pause', ['zone' => $zone->name]);
                $zone->actionButtonClass = $zone->state == 0 ? 'fa-play' : 'fa-pause';
                $zone->actionButtonText = trans($zone->state == 0 ? 'pigarden.start' : 'pigarden.pause');
                $zone->imageSrc = asset('images/sprinkler-'.($zone->state == 0 ? 'pause' : 'play').'.gif');
            });
        }
        if(property_exists($status, 'error'))
        {
            $this->data['error'] = $status->error;
        }
        if(property_exists($status, 'last_weather_online'))
        {
            //$this->data['weather'] = $status->last_weather_online;
            try{
                $weather = new \stdClass();
                $weather->observation_time = Carbon::createFromTimestamp($status->last_weather_online->observation_epoch, $status->last_weather_online->local_tz_long)->format('d/m/Y H:i');
                $weather->weather = trans('pigarden.'.$status->last_weather_online->weather);
                if($status->last_weather_online->icon_url && 0 === strpos($status->last_weather_online->icon_url, 'http://icons.wxug.com/i/c/k/')){
                    $i = pathinfo($status->last_weather_online->icon_url);
                    $weather->icon_url = '//icons.wxug.com/i/c/v1/'.$i['filename'].'.svg';
                } else {
                    $weather->icon_url = $status->last_weather_online->icon_url;
                }
                $weather->temp_c = $status->last_weather_online->temp_c;
                $weather->feelslike_c = $status->last_weather_online->feelslike_c;
                $weather->relative_humidity = $status->last_weather_online->relative_humidity;
                $weather->wind_degrees = $status->last_weather_online->wind_degrees; // Gradi direzione vento
                $weather->wind_degress_style = "transform:rotate({$weather->wind_degrees}deg);-ms-transform:rotate({$weather->wind_degrees}deg);-webkit-transform:rotate({$weather->wind_degrees}deg);";
                $weather->wind_dir = trans('pigarden.'.$status->last_weather_online->wind_dir);
                $weather->wind_kph = $status->last_weather_online->wind_kph;
                $weather->wind_gust_kph = $status->last_weather_online->wind_gust_kph; // Raffiche
                $weather->pressure_mb = $status->last_weather_online->pressure_mb;
                $weather->dewpoint_c = $status->last_weather_online->dewpoint_c; // Punto di rugiada

                $this->data['weather'] = $weather;
            } catch (\Exception $e) {
                $this->data['weather'] = null;
            }
        }
        if(property_exists($status, 'last_rain_sensor'))
        {
            $this->data['last_rain_sensor'] = $status->last_rain_sensor ? Carbon::createFromTimestamp($status->last_rain_sensor, config('pigarden.tz'))->format('d/m/Y H:i') : trans('pigarden.unknown');
        }
        if(property_exists($status, 'last_rain_online'))
        {
            $this->data['last_rain_online'] = $status->last_rain_online ? Carbon::createFromTimestamp($status->last_rain_online, config('pigarden.tz'))->format('d/m/Y H:i') : trans('pigarden.unknown');
        }

    }

    protected function makeError($description, $code=0)
    {
        $error = new \stdClass();
        $error->description = $description;
        $error->code = $code;
        return $error;
    }

    /**
     * Set alert messages from status
     * @param $status
     * @param bool $setFlash set messages in flesh session
     *
     */
    protected function setMessagesFromStatus($status, $setFlash=false)
    {
        $a = null;
        if(property_exists($status, 'info') && !empty($status->info))
        {
            $a = \Alert::info(trans('pigarden.'.$status->info));
        }
        if(property_exists($status, 'warning') && !empty($status->warning))
        {
            $a = \Alert::warning(trans('pigarden.'.$status->warning));
        }
        if(property_exists($status, 'error') && !empty($status->error->description))
        {
            $a = \Alert::error(trans('pigarden.'.$status->error->description));
        }
        if(property_exists($status, 'success') && !empty($status->success))
        {
            $a = \Alert::success(trans('pigarden.'.$status->success));
        }

        if($setFlash && !is_null($a))
        {
            $a->flash();
        }

        // Set messages in data array
        $m = array();
        foreach(\Alert::getMessages() as $type => $messages){
            foreach ($messages as $message){

                if(!isset($m[$type]))
                {
                    $m[$type] = array();
                }
                $m[$type][] = $message;
            }
        }
        $this->data['messages'] = $m;

    }

    /**
     * Get json dashboard status
     * @param Request $request
     * @return string
     */
    public function getJsonDashboardStatus(Request $request)
    {
        $client = new PiGardenSocketClient();
        $status = null;
        try {
            $status = $client->getStatus();
        } catch (\Exception $e) {
            $status = new \stdClass();
            $status->error = $this->makeError($e->getMessage().' at line '.$e->getLine().' of file '.$e->getFile(), $e->getCode());
        }
        $this->setDataFromStatus($status);
        $this->setMessagesFromStatus($status);

        return json_encode($this->data);
    }

} 
