<?php

namespace App\Domain\ValueObjects;

enum DonationStatus: string
{
    case Active = 'active';
    case Pending = 'pending';
    case Disable = 'disable';
}

?>