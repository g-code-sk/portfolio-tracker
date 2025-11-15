<?php

namespace App\Domain\Auth\Data;

use App\Models\User;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class LoginData extends Data
{
    public function __construct(
        #[Required, Email, Exists(table: User::class, column: 'email')]
        public string $email,

        #[Required, StringType]
        public string $password,

        #[Required, StringType, Max(255)]
        public string $device_name,
    ) {}
}
