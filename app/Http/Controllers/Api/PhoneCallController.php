<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePhoneCallRequest;
use App\Services\PhoneCallService;
use Illuminate\Http\JsonResponse;

class PhoneCallController extends Controller
{
    protected $phoneCallService;

    public function __construct(PhoneCallService $phoneCallService)
    {
        $this->phoneCallService = $phoneCallService;
    }

    public function store(StorePhoneCallRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $validatedData['access_ip'] = getClientIp();

            $phoneCall = $this->phoneCallService->create($validatedData);

            if ($phoneCall) {
                return responseOkAPI();
            }
            return responseErrorAPI(
                null,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                'エラーが発生しました。システムの管理者に連絡してください。'
            );
        } catch (\Exception $e) {
            return responseErrorAPI(
                null,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    public function index(): JsonResponse
    {
        try {
            $data = $this->phoneCallService->getPhoneCallMetrics();
            return response()->json($data);
        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'message' => 'Failed to fetch phone call metrics'
            ], 500);
        }
    }
}
