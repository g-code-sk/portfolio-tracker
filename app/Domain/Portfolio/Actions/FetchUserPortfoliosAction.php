declare(strict_types=1);

namespace App\Domain\Portfolio\Actions;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Support\Collection;

final class FetchUserPortfoliosAction
{
/**
* @return Collection<int, Portfolio>
    */
    public function handle(User $user): Collection
    {
    return $user->portfolios()->with(['currency:id,code'])->orderByDesc('created_at')->get();
    }
    }