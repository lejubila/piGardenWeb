<?php


namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function postLog(Request $request) {

        if($request->user()->hasPermissionTo('api log', backpack_guard_name()))
            Log::create([
                'type' => $request->input('type'),
                'level' => $request->input('level'),
                'datetime_log' => $request->input('datetime_log'),
                'message' => $request->input('message'),
                'username' => $request->user()->email,
                'client_ip' => $request->getClientIp(),
            ]);
        else
            return abort(401, "Permission denied");

    }

}
