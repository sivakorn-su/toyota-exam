<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log(string $message, array $context = []): void
    {
        $user = Auth::user();
        $ip = Request::ip();

        $logData = [
            'user_id' => $user?->id,
            'user_name' => $user?->name ?? 'Guest',
            'ip' => $ip,
            'message' => $message,
            'context' => $context,
        ];

        Log::channel('activity')->info(json_encode($logData));
    }
}
?>
