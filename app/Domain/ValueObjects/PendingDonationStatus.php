<?php

namespace App\Domain\ValueObjects;

enum PendingDonationStatus: string
{
    case Active = 'active';
    case Pending = 'pending';
    case rejected = 'rejected';
}
?>