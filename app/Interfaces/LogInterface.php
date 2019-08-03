<?php

namespace Fitest\Interfaces;

interface LogInterface
{
    public function createTaskLog(object $user, string $desc);
}