<?php

namespace App\Enums;

enum PaymentProvider: string
{
    case Manual = 'manual';
    case ClickPesa = 'clickpesa';
    case Selcom = 'selcom';
    case PesaPal = 'pesapal';
    case AzamPay = 'azampay';
}
