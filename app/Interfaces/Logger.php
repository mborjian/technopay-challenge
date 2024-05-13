<?php

namespace App\Interfaces;

interface Logger
{
    public function error(string $message, array $context = []): void;
}
