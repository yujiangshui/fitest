<?php

namespace Fitest\Interfaces;

interface UserInterface
{
    /**
     * Create a user.
     *
     * @param array $data
     * @return void
     */
    public function createUser(array $data);

    /**
     * Update a user info.
     *
     * @param array $data
     * @return void
     */
    public function updateUser(array $data);
}