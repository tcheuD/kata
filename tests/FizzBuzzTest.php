<?php

use App\FizzBuzz;
use PHPUnit\Framework\TestCase;

class FizzBuzzTest extends TestCase
{
    /** @test */
    public function it_returns_fizz_for_multiples_of_three(): void
    {
        foreach ([3, 6, 9, 12] as $number) {
            self::assertEquals('fizz', FizzBuzz::convert($number));
        }
    }

    /** @test */
    public function it_returns_fizz_for_multiples_of_five(): void
    {
        foreach ([5, 10, 20, 25] as $number) {
            self::assertEquals('buzz', FizzBuzz::convert($number));
        }
    }

    /** @test */
    public function it_returns_fizzbuzz_for_multiples_of_three_and_five(): void
    {
        foreach ([15, 30, 45, 60] as $number) {
            self::assertEquals('fizzbuzz', FizzBuzz::convert($number));
        }
    }

    /** @test */
    public function it_returns_the_original_number_if_not_divisible_by_three_or_five(): void
    {
        foreach ([1, 2, 4, 7, 8, 11] as $number) {
            self::assertEquals($number, FizzBuzz::convert($number));
        }
    }
}
