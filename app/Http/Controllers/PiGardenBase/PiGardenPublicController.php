<?php
/**
 * Controller for pigardin public page
 */

namespace app\Http\Controllers\PiGardenBase;


use App\Http\Controllers\PiGardenBaseController;
use App\PiGardenSocketClient;

class PiGardenPublicController extends PiGardenBaseController {

    public function __construct(){
        parent::__construct();
    }

    public function getHome(){

        if( \Auth::check() ) {
            return \Redirect::route('admin.dashboard');
        }

        $client = new PiGardenSocketClient();
        try {
            $status = $client->getStatus();
            $this->setDataFromStatus($status);
            $this->setMessagesFromStatus($status);
        } catch (\Exception $e) {
            $this->data['error'] = $this->makeError($e->getMessage().' at line '.$e->getLine().' of file '.$e->getFile(), $e->getCode());
        }
        $this->data['title'] = trans('pigarden.home'); // set the page title
        return view('home', $this->data);
    }


} 