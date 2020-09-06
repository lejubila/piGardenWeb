<?php

namespace App\Models;

use App\User;
use Backpack\Base\app\Models\Traits\InheritsRelationsFromParentModel;
use Backpack\Base\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;

use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;


class BackpackUser extends User
{
    use InheritsRelationsFromParentModel;
    use CrudTrait;
    use HasRoles;

    protected $table = 'users';

    protected $_action_api_token = null;

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    public function setActionApiTokenAttribute($value)
    {
        $this->_action_api_token = $value;
        if($value){
            if(isset($this->attributes['api_token']))
                $this->attributes['api_token'] .= 'changed';
            else
                $this->attributes['api_token'] = 'changed';
        }

    }

    public function getActionApiTokenAttribute()
    {
        return $this->_action_api_token;
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function (BackpackUser $user) {
            if($user->action_api_token == 'remove_token')
                $user->api_token = null;
            elseif($user->action_api_token == 'regenerate_token') {
                $user->api_token = $user->generateApiToken();
            }
        });

        static::updating(function (BackpackUser $user) {
            if($user->action_api_token == 'remove_token')
                $user->api_token = null;
            elseif($user->action_api_token == 'regenerate_token') {
                $user->api_token = $user->generateApiToken();
            }
        });

    }

    protected function generateApiToken() {
        while(true) {
            $t = Str::random(60);
            $id = (int)$this->id;
            if(!static::where('id', $id)->where('api_token', $t)->first())
                break;
        }
        return $t;
   }

}
