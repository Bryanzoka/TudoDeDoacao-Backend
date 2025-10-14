<?php

namespace App\Infrastructure\Services;

use App\Application\Contracts\IEmailService;
use App\Infrastructure\Mail\EmailSender;
use Mail;

class EmailService implements IEmailService
{
    public function send(string $to, string $subject, string $body): void
    {
        Mail::to($to)->send(new EmailSender($subject, $body, null));
    }
}
