<?php


use App\Game;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /** @test  */
    public function it_scores_a_gutter_game_as_zero(): void
    {
        $game = new Game();

        foreach (range(1, 20) as $roll) {
            $game->roll(0);
        }

        self::assertSame(0, $game->score());
    }

    /** @test  */
    public function it_scores_all_ones(): void
    {
        $game = new Game();

        foreach (range(1, 20) as $roll) {
            $game->roll(1);
        }

        self::assertSame(20, $game->score());
    }

    /** @test  */
    public function it_awards_a_one_roll_bonus_for_every_spare(): void
    {
        $game = new Game();

        $game->roll(5);
        $game->roll(5);

        $game->roll(8);

        foreach (range(1, 17) as $roll) {
            $game->roll(0);
        }

        self::assertSame(26, $game->score());
    }

    /** @test  */
    public function it_awards_a_two_roll_bonus_for_every_strike(): void
    {
        $game = new Game();

        $game->roll(10);

        $game->roll(5);
        $game->roll(2);

        foreach (range(1, 16) as $roll) {
            $game->roll(0);
        }

        self::assertSame(24, $game->score());
    }

    /** @test  */
    public function a_spare_on_the_final_frame_grants_one_extra_balls(): void
    {
        $game = new Game();

        foreach (range(1, 18) as $roll) {
            $game->roll(0);
        }

        $game->roll(5);
        $game->roll(5);

        $game->roll(5);

        self::assertSame(15, $game->score());
    }

    /** @test  */
    public function a_strike_on_the_final_frame_grants_two_extra_balls(): void
    {
        $game = new Game();

        foreach (range(1, 18) as $roll) {
            $game->roll(0);
        }

        $game->roll(10);

        $game->roll(10);
        $game->roll(10);

        self::assertSame(30, $game->score());
    }

    /** @test  */
    public function it_scores_a_perfect_game(): void
    {
        $game = new Game();

        foreach (range(1, 12) as $roll) {
            $game->roll(10);
        }

        self::assertSame(300, $game->score());
    }
}
