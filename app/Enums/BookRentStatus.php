<?php

namespace App\Enums;

enum BookRentStatus: string
{
    case RENTED = 'rented';
    case RETURNED = 'returned';
    case LOST = 'lost';
    case RESERVED = 'reserved';
}
