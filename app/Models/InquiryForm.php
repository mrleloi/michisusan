<?php

namespace App\Models;

use App\Behavior\SiteMust;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InquiryForm extends Model
{
    use HasFactory;
    use SiteMust;

    protected $fillable = [
        'site_id',
        'form_name',
        'form_description',
        'dest_mailaddress',
        'from_mailaddress',
        'privacy_policy',
        'finish_message',
        'for_admin_title',
        'for_admin_body',
        'for_user_title',
        'for_user_body',
        'for_user_signature',
        'add_user_to_reply_to',
        'conversion_tag1',
        'conversion_tag2',
        'conversion_tag3',
        'remark_type',
        'ignore_unspecified',
        'ignore_ip',
        'recaptcha_site_key',
        'recaptcha_secret_key',
        'smtp_account_name',
        'smtp_password',
        'smtp_server',
        'smtp_port_number',
    ];

    public function inquiryLogs(): hasMany
    {
        return $this->hasMany(InquiryLog::class);
    }

    public function inquiryFormAdditions(): HasMany
    {
        return $this->hasMany(InquiryFormAddition::class);
    }
}
