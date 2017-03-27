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

    public function __construct()
    {
        $this->ip = config('pigarden.socket_client_ip');
        $this->port = config('pigarden.socket_client_port');
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
     * @param $command
     * @return mixed|string
     * @throws Exception
     */
    protected  function execCommand($command)
    {
        $this->open();
        $this->put($command);
        $json_response = $this->get();
        $response = "";
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
        $this->close();
        return $response;
    }

    /**
     * @return mixed|string
     * @param array|null $additionalParameters
     * @throws Exception
     */
    public function getStatus($additionalParameters=null)
    {
        $ap = '';
        if (!is_null($additionalParameters)){
            $ap = ' '.implode(' ',$additionalParameters);
        }
        return $this->execCommand('status'.$ap);
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
     * @param $zone
     * @return mixed|string
     * @throws Exception
     */
    public function zoneClose( $zone )
    {
        return $this->execCommand('close '.$zone);
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
     * @return mixed|string
     * @throws Exception
     */
    public function addCronOpen( $zone, $min, $hour, $dom, $month, $dow)
    {
        return $this->execCommand("add_cron_open $zone $min $hour $dom $month $dow");
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
                $this->{"addCron$type"}( $zone, $s['min'], $s['hour'], $s['dom'], $s['month'], $s['dow'] );
            }
        }
    }



} 
