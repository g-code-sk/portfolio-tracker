<?php

declare(strict_types=1);

namespace App\Domain\Portfolio\Policies;

use App\Models\Portfolio;
use App\Models\User;

final class PortfolioPolicy
{
    /**
     * Determine if the user can view the portfolio.
     */
    public function view(User $user, Portfolio $portfolio): bool
    {
        return $user->id === $portfolio->user_id;
    }

    /**
     * Determine if the user can update the portfolio.
     */
    public function update(User $user, Portfolio $portfolio): bool
    {
        return $user->id === $portfolio->user_id;
    }

    /**
     * Determine if the user can delete the portfolio.
     */
    public function delete(User $user, Portfolio $portfolio): bool
    {
        return $user->id === $portfolio->user_id;
    }
}
