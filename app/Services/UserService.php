<?php

namespace Fitest\Services;

use Fitest\Interfaces\UserInterface;
use Fitest\Models\User;

class UserService implements UserInterface
{
    /**
     * Create a user.
     *
     * @param array $data
     * @return void
     */
    public function createUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }

    /**
     * Update a user info.
     *
     * @param array $data
     * @return void
     */
    public function updateUser(array $data)
    {

    }
}