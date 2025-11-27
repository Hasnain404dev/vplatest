<?php

namespace App;

enum PaymentMethod: string
{
    case CASH_ON_DELIVERY = 'cash_on_delivery';
    case JAZZCASH = 'jazzcash';
    case MEEZAN_BANK = 'meezan_bank';
}
