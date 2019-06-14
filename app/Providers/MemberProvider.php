<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class MemberProvider extends ServiceProvider  {

    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        //
    }

    public function validateCredentials(UserContract $user, array $credentials) {
        $plain = $credentials['password'];
        \Log::info('working');
        return $this->hasher->check($plain, $user->getAuthPassword());
    }

}
