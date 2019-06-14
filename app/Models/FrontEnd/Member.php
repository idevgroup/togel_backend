<?php

namespace App\Models\FrontEnd;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class Member extends Authenticatable implements JWTSubject {

    use Notifiable;

    protected $guard = 'api';
    protected $table = 'players';
    protected $fillable = [
        'reg_name', 'reg_email', 'reg_username', 'reg_date', 'reg_ip', 'reg_phone', 'lastip', 'lastloggin', 'reg_remain_balance', 'reg_activation_code', 'api_token'
    ];
    protected $hidden = [
        'session_id', 'api_token'
    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    public function isOnline() {
        return Cache::has('member-is-online-' . $this->id);
    }

    public function rollApiKey($token) {
        do {
            $this->api_token = $token;
        } while ($this->where('api_token', $this->api_token)->exists());
        $this->save();
    }

//    public function setPasswordAttribute($password) {
//        if ($password !== null & $password !== "") {
//            $this->attributes['password'] = _EncryptPwd($password);
//        }
//        // $this->attributes['password'] = _EncryptPwd($value);
//    }
//
//    public function getAuthPassword() {
//        return $this->reg_password;
//    }
//
//    public function validateCredentials(UserContract $user, array $credentials) {
//        $plain = $credentials['password'];
//        return $this->hasher->check($plain, $user->getAuthPassword());
//    }
//
//    public function getPasswordAttribute() {
//        return $this->getAttribute('reg_password');
//    }

}
