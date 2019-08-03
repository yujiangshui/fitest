<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    /**
     * A register test
     *
     * @return void
     */
    public function testRegister()
    {
        $data = [
            'email' => 'test@qq.com',
            'name' => 'test',
            'username' => 'test',
            'password' => '12345678',
        ];
        
        //Send post request
        $this->call('POST', route('register'), $data)
             ->assertStatus(Response::HTTP_FOUND);

        $this->deleteUser('test@qq.com');
    }

    /**
     * @test
     * Test email login
     */
    public function testEmailLogin()
    {
        $user = $this->createUser();

        //attempt login
        $this->call('POST', route('login'),[
            'email' => $user->email,
            'password' => '12345678',
        ])->assertStatus(Response::HTTP_FOUND);

        $this->deleteUser($user->email);
    }

    /**
     * @test
     * Test username login
     */
    public function testUsernameLogin()
    {
        $user = $this->createUser();

        //attempt login
        $this->call('POST', route('login'),[
            'username' => $user->username,
            'password' => '12345678',
        ])->assertStatus(Response::HTTP_FOUND);

        $this->deleteUser($user->email);
    }
}
