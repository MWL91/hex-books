<?php

namespace App\Enums;

enum PenaltyStatus: string
{
    case UNPAID = 'unpaid';
    case PAID = 'paid';
}
