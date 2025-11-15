<?php

namespace App\Domain\Auth\Data;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Data;

class RegisterData extends Data
{
    public function __construct(
        #[Required, StringType, Max(255)]
        public string $name,

        #[Required, StringType, Email, Max(255), Unique('users', 'email')]
        public string $email,

        #[Required, StringType, Min(8), Confirmed]
        public string $password,

        // Validation is handled by the Confirmed attribute 
        public ?string $password_confirmation = null,

        #[Required, StringType, Max(255)]
        public string $device_name,
    ) {}
}
