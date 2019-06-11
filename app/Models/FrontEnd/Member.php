<?php

namespace App\Models\FrontEnd;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable {

    use Notifiable;

    protected $guard = 'member';
    protected $table = 'players';
    protected $fillable = [
        'reg_name', 'reg_email', 'reg_password', 'reg_date', 'reg_ip', 'reg_phone', 'lastip', 'lastloggin', 'reg_remain_balance', 'reg_activation_code'
    ];
    protected $hidden = [
        'reg_password', 'session_id', 'remember_token'
    ];

  

}
