<?php

namespace App\Enums;

enum OrderStatus: string
{
    case REQUESTED = 'REQUESTED';
    case APPROVED = 'APPROVED';
    case CANCELED = 'CANCELED';
}
