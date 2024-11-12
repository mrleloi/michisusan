<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
use Illuminate\Http\Response;

if (!function_exists('responseOkAPI')) {
    function responseOkAPI($data = null, $code = Response::HTTP_OK)
    {
        if (!empty($data)) {
            if (is_array($data)) {
                $data = count($data) > 0 ? $data : null;
            } elseif (is_object($data)) {
                $data = $data->count() > 0 ? $data : null;
            } else {
                $data = $data ? $data : null;
            }
        }

        $output = [
            'success' => SUCCESS_OK,
            'data' => (object) $data,
            'errors' => null,
        ];

        return response()->json($output, $code);
    }
}

if (!function_exists('responseErrorAPI')) {
    function responseErrorAPI($data = null, $code, $errorCode, $message)
    {
        $output = [
            'success' => SUCCESS_FALSE,
            'data' => (object) $data,
            'errors' => [
                'error_code' => $errorCode,
                'error_message' => $message,
            ],
        ];

        return response()->json($output, $code);
    }
}

if (!function_exists('getClientIp')) {
    function getClientIp()
    {
        foreach (array(
                     'HTTP_CLIENT_IP',
                     'HTTP_X_FORWARDED_FOR',
                     'HTTP_X_FORWARDED',
                     'HTTP_X_CLUSTER_CLIENT_IP',
                     'HTTP_FORWARDED_FOR',
                     'HTTP_FORWARDED',
                     'REMOTE_ADDR'
                 ) as $key) {
            if (array_key_exists($key, $_SERVER)) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);

                    // Validate IP
                    if (filter_var($ip, FILTER_VALIDATE_IP,
                            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // Fallback
    }
}
// kiai_loi.le 2024.09.10 feature/setting_base add end
