<?php

namespace Fitest\Services;

use Fitest\Interfaces\LogInterface;
use Fitest\Models\Log;

class LogService implements LogInterface
{
    /**
     * create one record in the log table for tasks.
     * This table is better than default Log record, if you generate a chart to review tasks efficiency.
     *
     * @param object $user
     * @param string $desc
     * @return void
     */
    public function createTaskLog(object $user, string $desc)
    {
        return Log::firstOrCreate([
            'desc' => $desc,
            'user_id' => $user->id
        ]);
    }
}