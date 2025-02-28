<?php

namespace App\Jobs;

use App\Enums\BlockReason;
use App\Jobs\Concerns\RateLimited;
use App\Models\Organization;
use App\Models\Repository;
use App\Models\User;
use Carbon\CarbonInterval;
use Closure;
use DateTimeInterface;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

abstract class GithubJob extends Job implements ShouldBeUnique
{
    use RateLimited;

    public function __construct()
    {
        $this->queue = 'github';
        $this->timeout = CarbonInterval::hour()->totalSeconds;
    }

    public function handle(): bool
    {
        if ($this->entity()->isBlocked()) {
            $this->delete();
        }

        try {
            $this->run();

            return true;
        } catch (ClientException $exception) {
            if ($this->rateLimit($exception)) {
                return false;
            }

            if (
                $exception->hasResponse()
                && $exception->getResponse()->getStatusCode() === Response::HTTP_NOT_FOUND
            ) {
                if (property_exists($this, 'user')) {
                    $this->user->update([
                        'block_reason' => BlockReason::DELETED(),
                        'blocked_at' => now(),
                    ]);
                }

                if (property_exists($this, 'repository')) {
                    $this->repository->update([
                        'block_reason' => BlockReason::DELETED(),
                        'blocked_at' => now(),
                    ]);
                }

                if (property_exists($this, 'organization')) {
                    $this->organization->update([
                        'block_reason' => BlockReason::DELETED(),
                        'blocked_at' => now(),
                    ]);
                }

                $this->delete();
            }

            throw $exception;
        }
    }

    public function retryUntil(): ?DateTimeInterface
    {
        return now()->addHours(18);
    }

    public function uniqueId(): ?string
    {
        return Str::snake(class_basename($this->entity())).':'.$this->entity()->id;
    }

    public function tags(): array
    {
        return [
            Str::snake(class_basename($this->entity())).':'.$this->entity()->id,
            $this->entity()->name,
        ];
    }

    /**
     * @return int|int[]
     */
    public function backoff(): int | array
    {
        return [
            CarbonInterval::minute()->totalSeconds,
            CarbonInterval::minutes(15)->totalSeconds,
            CarbonInterval::minutes(30)->totalSeconds,
            CarbonInterval::hour()->totalSeconds,
        ];
    }

    abstract protected function run(): void;

    /**
     * @param \Closure $callback
     * @param int $perPage
     */
    protected function paginated(Closure $callback, int $perPage = 100): void
    {
        $page = 1;
        do {
            $response = $callback($page, $perPage);

            $page++;
        } while ($response->count() >= $perPage);
    }

    protected function entity(): User | Organization | Repository
    {
        return $this->user ?? $this->organization ?? $this->repository;
    }
}
