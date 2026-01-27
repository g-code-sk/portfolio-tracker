<?php

declare(strict_types=1);

namespace App\Domain\Portfolio\Policies;

use App\Models\Portfolio;
use App\Models\User;

final class PortfolioPolicy
{
    public function userIndex(User $user): bool
    {
        return true;
    }

    public function userShow(User $user, Portfolio $portfolio): bool
    {
        return $user->id === $portfolio->user_id;
    }

    public function userStore(User $user): bool
    {
        return true;
    }

    public function userDelete(User $user, Portfolio $portfolio): bool
    {
        return $user->id === $portfolio->user_id;
    }

    public function userImportTransactions(User $user, Portfolio $portfolio): bool
    {
        return $user->id === $portfolio->user_id;
    }
}
