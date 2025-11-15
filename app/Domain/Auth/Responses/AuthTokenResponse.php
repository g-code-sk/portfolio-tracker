<?php

namespace App\Domain\Auth\Responses;

use App\Models\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthTokenResponse implements Responsable
{
    public function __construct(
        protected readonly string $message,
        protected readonly User $user,
        protected readonly string $token,
        protected readonly int $status
    ) {}

    public static function make(string $message, User $user, string $token, int $status = Response::HTTP_OK): self
    {
        return new self($message, $user, $token, $status);
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json([
            'message' => $this->message,
            'user' => $this->user,
            'token' => $this->token,
        ], $this->status);
    }
}
