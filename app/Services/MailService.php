<?php

namespace App\Services;

use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mailer\Mailer as SymfonyMailer;
use Symfony\Component\Mailer\Transport\Smtp\Stream\SocketStream;

class MailService
{
    public function sendInquiryMail($params)
    {
        $isSsl = $params['smtp_port_number'] == 465;

        $transport = new EsmtpTransport($params['smtp_server'], $params['smtp_port_number'], $isSsl);
        $transport->setUsername($params['smtp_account_name']);
        $transport->setPassword($params['smtp_server']);
        if(($stream = $transport->getStream()) instanceof SocketStream) {
            $stream->setTimeout(10); // SocketTimeoutが長いので
        }
        $transport->start();
    }
}
