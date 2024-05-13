<?php

namespace App\Services;


use App\Interfaces\Logger;
use Illuminate\Support\Facades\Log;


class LogLogger implements Logger
{
    public function error(string $message, array $context = []): void
    {
        Log::error('An error occurred (LOG): ' . $message, $context);
    }
}
