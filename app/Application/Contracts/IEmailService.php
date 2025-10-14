<?php

namespace App\Application\Contracts;

interface IEmailService
{
    public function send(string $to, string $subject, string $body);
}
