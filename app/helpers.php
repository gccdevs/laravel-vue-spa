<?php

/**
 * Money Format
 */
if(!function_exists('monie_format')) {
    function monie_format($val)
    {
        return number_format(floatval($val), 2);
    }
}

/**
 * Return 400 json object
 */
if (! function_exists('json_error')) {

    /**
     * @param $message
     * @param int $code
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    function json_error($message, $code = 500, $data = [])
    {
        if ($data instanceof \Illuminate\Contracts\Support\Arrayable) {
            $data = $data->toArray();
        }
        if (!is_array($data)) {
            $data = [$data];
        }

        if (env('APP_ENV') != 'local') {
            logger('Error ' . 400, [
                'code' => $code,
                'data' => $data,
                'message' => $message
            ]);
        }

        return response()->json([
            'status'  => 'ERROR',
            'code'    => $code,
            'message' => $message,
            'data'    => $data
        ], 400);
    }
}

/**
 * Return 400 json object
 */
if (! function_exists('report_error')) {

    /**
     * @param $type
     * @param $message
     * @param null $throwException
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    function report_error($type, $message, $throwException = null)
    {
        trace_log($message);
        if (env('APP_ENV') !== 'local') {
            Bugsnag\BugsnagLaravel\Facades\Bugsnag::notifyError($type, $message);
        }
        Illuminate\Support\Facades\Notification::send(new App\Models\SlackNotificationSender(), new App\Notifications\SlackNotification($type . ': ' . $message));
        if ($throwException) {
            throw new \Exception($message);
        }
        return json_error($message);
    }
}

/**
 * Trace log
 */
if (! function_exists('trace_log')) {

    function trace_log($message)
    {
        Illuminate\Support\Facades\Log::info($message);
    }
}

/**
 * Round up
 */
if (! function_exists('round_up')) {
    function round_up ($value, $precision ) {
        $pow = pow ( 10, $precision );
        return ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow;
    }
}
