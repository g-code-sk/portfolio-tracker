<?php

namespace App\Domain\Auth\Responses;

use App\Models\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class AuthUserResponse implements Responsable
{
    public function __construct(
        protected readonly User $user
    ) {}

    public static function make(User $user): self
    {
        return new self($user);
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json([
            'user' => $this->user,
        ]);
    }
}
