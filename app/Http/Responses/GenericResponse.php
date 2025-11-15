<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class GenericResponse implements Responsable
{
    public function __construct(
        protected readonly string $message,
        protected readonly int $status = Response::HTTP_OK
    ) {}

    public static function make(string $message): static
    {
        return new static($message);
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json([
            'message' => $this->message,
        ], $this->status);
    }
}
