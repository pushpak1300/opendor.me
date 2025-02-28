<?php

namespace App\Console\Commands;

use App\Jobs\UpdateUserDetails;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class GithubUserDetails extends Command
{
    protected $signature = 'github:user:details {name?}';
    protected $description = 'Load user details.';

    public function handle(): void
    {
        User::query()
            ->whereIsRegistered()
            ->when(
                $this->argument('name'),
                fn (Builder $query, string $name) => $query->where('name', $name)
            )
            ->each(static function (User $use): void {
                UpdateUserDetails::dispatch($use);
            });
    }
}
