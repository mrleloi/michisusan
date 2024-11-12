<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sendmail\SendInquiryTestMailRequest;
use Exception;
use App\Services\MailService;
use Log;

class SendMailController extends Controller
{
    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function sendInquiryTestMail(SendInquiryTestMailRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $result = $this->mailService->sendInquiryMail($validatedData);

            if ($result) {
                return responseOkAPI();
            }
            return responseErrorAPI(
                null,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                'エラーが発生しました。システムの管理者に連絡してください。'
            );
        } catch (Exception $e) {
            Log::error($e);
            return responseErrorAPI(
                null,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }
}
