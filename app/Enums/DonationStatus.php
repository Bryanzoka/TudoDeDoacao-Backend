<?php

namespace App\Enums;

enum DonationStatus: string
{
    case Active = 'active';
    case Pending = 'pending';
    case Disable = 'disable';
}
?>