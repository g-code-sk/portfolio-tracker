<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

final class HttpClientService
{
    public function client(
        int $timeoutSeconds = 10,
        int $retryTimes = 2,
        int $retrySleepMilliseconds = 1000,
        bool $throwOnRetry = false,
    ): PendingRequest {
        return Http::timeout(seconds: $timeoutSeconds)
            ->retry(
                times: $retryTimes,
                sleepMilliseconds: $retrySleepMilliseconds,
                throw: $throwOnRetry,
                when: fn(Exception $exception): bool => $exception instanceof ConnectionException,
            );
    }
}
