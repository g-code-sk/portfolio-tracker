<?php

declare(strict_types=1);

namespace App\Domain\Portfolio\Rules;

use App\Models\Portfolio;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

final class PortfolioBelongsToAuthenticatedUser implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if ($value === null) {
            return;
        }

        $portfolio = Portfolio::find($value);

        if ($portfolio === null || $portfolio->user_id !== Auth::id()) {
            $fail('The selected portfolio does not belong to you.');
        }
    }
}
