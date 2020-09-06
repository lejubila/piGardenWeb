<?php


namespace App\Http\Controllers\Auth;


use App\Http\Requests\Auth\AccountApiTokenRerquest;
use Prologue\Alerts\Facades\Alert;

class MyAccountController extends \Backpack\Base\app\Http\Controllers\Auth\MyAccountController
{

    /**
     * Show the user a form to change his personal information.
     */
    public function getApiTokenForm()
    {
        $this->data['title'] = trans('backpack::base.my_account');
        $this->data['user'] = $this->guard()->user();

        return view('backpack::auth.account.api_token', $this->data);
    }

    /**
     * Save the modified personal information for a user.
     */
    public function postApiTokenForm(AccountApiTokenRerquest $request)
    {
        $result = $this->guard()->user()->update($request->except(['_token']));

        if ($result) {
            Alert::success(trans('backpack::base.account_updated'))->flash();
        } else {
            Alert::error(trans('backpack::base.error_saving'))->flash();
        }

        return redirect()->back();
    }


}
