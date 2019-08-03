<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Login the given user or create the first if none supplied.
     *
     * @param $user
     *
     * @return User
     */
    public function loginAsUser()
    {
        $user = \Fitest\Models\User::first();
        $this->actingAs($user);

        return $user;
    }

    public function createUser()
    {
        $qq = mt_rand(1, 10000);
        $data = [
            'name' => $qq,
            'username' => $qq,
            'email' => $qq . '@qq.com',
            'password' => '12345678',
        ];

        return \Fitest\Models\User::create($data);
    }

    public function deleteUser($email = 'test@qq.com')
    {
        \Fitest\Models\User::where('email', $email)->delete();
    }
}
