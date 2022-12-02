<?php
declare(strict_types=1);

namespace Tools\Phlambda;

class Stopper
{
    public static function create(): self
    {
        return new self();
    }

    public function start(): void
    {
        $this->start = microtime(true);
    }

    public function stop(): void
    {
        $this->stop = microtime(true);
    }

    public function time(): float
    {
        return $this->stop - $this->start;
    }

    private float $start;
    private float $stop;
}