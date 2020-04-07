<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/08/16
 * Time: 16.36
 */

namespace App;


use Exception;

class PiGardenSocketClient {

    protected $ip;
    protected $port;
    protected $socket;
    protected $prevRequest;

    public function __construct()
    {
        $this->ip = config('pigarden.socket_client_ip');
        $this->port = config('pigarden.socket_client_port');
        $prevRequest = [];
    }

    /**
     * Open the socket connection
     */
    protected  function open()
    {
        $connection = "tcp://".$this->ip.":".$this->port;
        $this->socket = stream_socket_client($connection, $errno, $errstr, 30);
        if (!$this->socket) {
            throw new Exception($errstr, $errno);
        }
    }

    /**
     * Close the socket connection
     */
    protected  function close()
    {
        if ( $this->socket )
        {
            fclose($this->socket);
        }
    }

    /**
     * Get stream from socket
     * @throws Exception
     * @return string
     */
    protected  function get()
    {
        if ( !$this->socket )
        {
            throw new Exception("No socket exists");
        }

        $in = "";
        while (!feof($this->socket)) {
            $in .= fgets($this->socket, 1024);
        }
        return $in;
    }

    /**
     * Write stream to socket
     * @param $out string
     * @throws Exception
     */
    protected  function put($out)
    {
        if ( !$this->socket )
        {
            throw new Exception("No socket exists");
        }
        if( fwrite($this->socket, $out."\r\n") == false )
        {
            throw new Exception("Socket read error");
        }
    }

    /**
     * Add credentials for socket server to commend string
     * @param $command
     * @return string
     */
    protected function addCredentialsToCommand($command) {
        $user = config('pigarden.socket_client_user');
        $pwd = config('pigarden.socket_client_pwd');
        if ( !empty($user) && !empty($pwd) ){
            $command = "$user\r\n$pwd\r\n$command";
        }

        return $command;
    }

    /**
     * @param $command
     * @param $getPrevRequest
     * @return mixed|string
     * @throws Exception
     */
    protected  function execCommand($command, $getPrevRequest=false)
    {
        if ( $getPrevRequest && !empty($this->prevRequest[$command]))
        {
            return $this->prevRequest[$command];
        }

        $this->open();
        $this->put($this->addCredentialsToCommand($command));
        $json_response = $this->get();
        if (!$json_response)
        {
            throw new Exception("Invalid socket client response");
        }

        $response = json_decode($json_response);
        if( $response === null)
        {
            throw new Exception("Invalid json socket client response");
        }

        if (property_exists($response, "error") && $response->error->description)
        {
            throw new Exception($response->error->description, $response->error->code);
        }

        if (property_exists($response, "version") && ($response->version->ver != config('pigarden.pigarden_version_support.ver') || $response->version->sub != config('pigarden.pigarden_version_support.sub') )  )
        {
            throw new Exception("Invalid version of piGarden (required version ".config('pigarden.pigarden_version_support.ver').'.'.config('pigarden.pigarden_version_support.sub').".* )");
        }

        $this->close();
        $this->prevRequest[$command] = $response;
        return $response;
    }

    /**
     * @return mixed|string
     * @param array|null $additionalParameters
     * @param boolean $getPrevRequest
     * @throws Exception
     */
    public function getStatus($additionalParameters=null, $getPrevRequest=false)
    {
        $ap = '';
        if (!is_null($additionalParameters)){
            $ap = ' '.implode(' ',$additionalParameters);
        }
        return $this->execCommand('status'.$ap, $getPrevRequest);
    }

    /**
     * @param $zone string
     * @param bool $force
     * @return mixed|string
     * @throws Exception
     */
    public function zoneOpen( $zone, $force=false )
    {
        return $this->execCommand('open '.$zone.($force ? ' force' : ''));
    }

    /**
     * @param $zone string
     * @param int $start
     * @param int $length
     * @param bool $force
     * @throws Exception
     * @return mixed|string
     */
    public function zoneOpenIn( $zone, $start, $length, $force=false )
    {
        return $this->execCommand('open_in '.$start.' '.$length.' '.$zone.($force ? ' force' : ''));
    }

    /**
     * @param $zone
     * @return mixed|string
     * @throws Exception
     */
    public function zoneOpenInCancel( $zone ){
        return $this->execCommand('del_cron_open_in '.$zone);
    }

    /**
     * @param $zone
     * @return mixed|string
     * @throws Exception
     */
    public function zoneClose( $zone )
    {
        return $this->execCommand('close '.$zone);
    }

    /**
     * @param boolean $disable_scheduling
     * @return mixed|string
     * @throws Excepion
     */
    public function zoneCloseAll( $disable_scheduling=false )
    {
        return $this->execCommand('close_all'.($disable_scheduling ? ' disable_scheduling' : ''));
    }

    /**
     * @return mixed|string
     * @throws Excepion
     */
    public function zoneAllCronEnable()
    {
        return $this->execCommand('cron_enable_all_open_close');
    }

    /**
     * @return mixed|string
     * @throws Excepion
     */
    public function reboot( )
    {
        return $this->execCommand('reboot');
    }

    /**
     * @return mixed|string
     * @throws Excepion
     */
    public function poweroff( )
    {
        return $this->execCommand('poweroff');
    }

    /**
     * @param $zone
     * @return mixed|string
     * @throws Exception
     */
    public function delCronOpen( $zone )
    {
        return $this->execCommand('del_cron_open '.$zone);
    }

    /**
     * @param $zone
     * @return mixed|string
     * @throws Exception
     */
    public function delCronClose( $zone )
    {
        return $this->execCommand('del_cron_close '.$zone);
    }

    /**
     * @param $zone
     * @param $min
     * @param $hour
     * @param $dom
     * @param $month
     * @param $dow
     * @param $enabled
     * @return mixed|string
     * @throws Exception
     */
    public function addCronOpen( $zone, $min, $hour, $dom, $month, $dow, $enabled)
    {
        $disabled = $enabled ? '' : 'disabled';
        return $this->execCommand("add_cron_open $zone $min $hour $dom $month $dow $disabled");
    }

    /**
     * @param $zone
     * @param $min
     * @param $hour
     * @param $dom
     * @param $month
     * @param $dow
     * @param $enabled
     * @return mixed|string
     * @throws Exception
     */
    public function addCronClose( $zone, $min, $hour, $dom, $month, $dow, $enabled)
    {
        $disabled = $enabled ? '' : 'disabled';
        return $this->execCommand("add_cron_close $zone $min $hour $dom $month $dow $disabled");
    }

    /**
     * Set multiple scheduling on zone
     * @param $type string, accepted value ('open', 'close')
     * @param $zone string
     * @param $schedule array
     * @throws Exception
     */
    public function setCronZone( $type, $zone, $schedule )
    {
        $type = ucfirst($type);
        if($type != 'Open' && $type != 'Close'){
            throw new Exception( __METHOD__ . ": wrong value of 'type' argument");
        }
        $this->{"delCron$type"}( $zone );
        if(is_array($schedule) && !empty($schedule)){
            foreach($schedule as $s){
                $this->{"addCron$type"}( $zone, $s['min'], $s['hour'], $s['dom'], $s['month'], $s['dow'], $s['enable'] );
            }
        }
    }

    /**
     * @return mixed|string
     * @throws Exception
     */
    public function setGeneralCron(){
        return $this->execCommand("set_general_cron set_cron_init set_cron_start_socket_server set_cron_check_rain_sensor set_cron_check_rain_online set_cron_close_all_for_rain");
    }


    /**
     * Set multiple schedule of piGardenSched
     * @param $zone string
     * @param $duration integer
     * @param $time array
     * @param $frequency integer
     * @param $seq array
     * @return mixed|string
     * @throws Exception
     */
    public function setSchedule( $zone, $duration, $time, $frequency, $seq=null ) {

        $this->delSchedule( $zone );
        if(is_array($time) && !empty($time)){
            $first = true;
            foreach($time as $t){
                if($first) {
                    $first = false;
                    $this->addSchedule( $zone, $duration, $t, $frequency );
                } else {
                    $this->addTimeSchedule( $zone, $t );
                }
            }

            if(is_array($seq) && !empty($seq)) {
                array_unshift($seq, $zone);
                $this->seqSchedule( $seq );
            }
        }

    }

    /**
     * @param $zone
     * @return mixed|string
     * @throws Exception
     */
    public function delSchedule( $zone )
    {
        return $this->execCommand('cmd_pigardensched del '.$zone);
    }

    /**
     * @param $zone string
     * @param $duration integer
     * @param $time string
     * @param $frequency integer
     * @return mixed|string
     * @throws Exception
     */
    public function addSchedule( $zone, $duration, $time, $frequency )
    {
        return $this->execCommand("cmd_pigardensched add $zone $duration $time $frequency");
    }

    /**
     * @param $zone string
     * @param $time string
     * @return mixed|string
     * @throws Exception
     */
    public function addTimeSchedule( $zone, $time )
    {
        return $this->execCommand("cmd_pigardensched add_time $zone $time");
    }

    /**
     * @param $seq array
     * @return mixed|string
     * @throws Exception
     */
    public function seqSchedule( $seq )
    {
        return $this->execCommand('cmd_pigardensched seq '.implode(' ', $seq));
    }



}
