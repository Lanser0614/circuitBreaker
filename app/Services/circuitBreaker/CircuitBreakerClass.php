<?php
declare(strict_types=1);

namespace App\Services\circuitBreaker;

use Carbon\Carbon;
use Illuminate\Cache\RateLimiter;

class CircuitBreakerClass
{
    protected ?RateLimiter $limiter = null;

    private ?string $key = null;
    private ?int $threshold = null;
    private ?int $delaySec = null;

    /**
     *
     */
    public function __construct()
    {
        /** @var RateLimiter $limiter */
        $this->limiter = app(RateLimiter::class);
    }

    /**
     * @param string $key
     * @return CircuitBreakerClass
     */
    public function setActionKay(string $key): CircuitBreakerClass
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @param int $threshold
     * @return $this
     */
    public function setThreshold(int $threshold): static
    {
        $this->threshold = $threshold;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTooManyAttempts(): bool
    {
        return $this->limiter->tooManyAttempts($this->key, $this->threshold);
    }

    /**
     * @param int $delaySec
     * @return void
     */
    public function setDelayOnException(int $delaySec): void
    {
        $this->limiter->hit($this->key, Carbon::now()->addSeconds($delaySec));
    }

    /**
     * @return void
     */
    public function setDefaultDelayOnException(): void
    {
        $this->limiter->hit($this->key, Carbon::now()->addSeconds($this->delaySec));
    }
    /**
     * @param int $delay
     * @return $this
     */
    public function setDelay(int $delay): static
    {
        $this->delaySec = $delay;
        return $this;
    }


}
