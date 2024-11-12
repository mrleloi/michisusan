<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitePaymentSetting extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'site_id',
        'show_payment_button',
        'show_paypal',
        'show_aupay',
        'show_dpay',
        'show_merpay',
        'show_rakutenpay',
        'show_visa',
        'show_master',
        'show_jcb',
        'show_amex',
        'show_diners',
        'show_discover',
        'show_unionpay',
        'show_electronicmoney',
        'description',
    ];
}
