<?php

namespace App;

class Game
{
    public const FRAMES_PER_GAME = 10;

    protected array $rolls = [];

    public function roll(int $pins): void
    {
        $this->rolls[] = $pins;
    }

    public function score(): int
    {
        $score = 0;
        $roll = 0;

        foreach (range(1, self::FRAMES_PER_GAME) as $frame) {

            if ($this->isStrike($roll)) {
                $score += $this->pinCount($roll) + $this->strikeBonus($roll);

                ++$roll;

                continue;
            }

            $score += $this->defaultFrameScore($roll);

            if ($this->isSpare($roll)) {
                $score += $this->spareBonus($roll);

                $roll += 2;

                continue;
            }

            $roll += 2;

        }

        return $score;
    }

    protected function isStrike(int $roll): bool
    {
        return $this->pinCount($roll) === 10;
    }

    protected function isSpare(int $roll): bool
    {
        return $this->defaultFrameScore($roll) === 10;
    }

    protected function defaultFrameScore(int $roll): int
    {
        return $this->pinCount($roll) + $this->pinCount($roll + 1);
    }

    protected function strikeBonus(int $roll): int
    {
        return $this->defaultFrameScore($roll + 1);
    }

    protected function spareBonus(int $roll): int
    {
        return $this->pinCount($roll + 2);
    }

    protected function pinCount(int $roll): int
    {
        return $this->rolls[$roll];
    }
}
