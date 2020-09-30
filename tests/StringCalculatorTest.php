<?php

use App\StringCalculator;
use PHPUnit\Framework\TestCase;

class StringCalculatorTest extends TestCase
{
    /** @test  */
    public function it_evaluates_an_empty_string_as_0(): void
    {
        $calculator = new StringCalculator();

        self::assertSame(0, $calculator->add(''));
    }

    /** @test  */
    public function it_finds_the_sum_of_a_single_number(): void
    {
        $calculator = new StringCalculator();

        self::assertSame(5, $calculator->add('5'));
    }

    /** @test  */
    public function it_finds_the_sum_of_two_numbers(): void
    {
        $calculator = new StringCalculator();

        self::assertSame(10, $calculator->add('5,5'));
    }

    /** @test  */
    public function it_finds_the_sum_of_any_amount_of_numbers(): void
    {
        $calculator = new StringCalculator();

        self::assertSame(19, $calculator->add('5,5,5,4'));
    }

    /** @test  */
    public function it_accepts_a_new_line_characters_as_a_delimiter_too(): void
    {
        $calculator = new StringCalculator();

        self::assertSame(10, $calculator->add("5\n5"));
    }

    /** @test  */
    public function negative_numbers_are_not_allowed(): void
    {
        $calculator = new StringCalculator();

        $this->expectException(Exception::class);

        $calculator->add('5,-4');
    }

    /** @test  */
    public function numbers_greater_than_1000_are_ignored(): void
    {
        $calculator = new StringCalculator();

        self::assertEquals(5, $calculator->add('5,1001'));
    }

    /** @test  */
    public function it_supports_custom_delimiters(): void
    {
        $calculator = new StringCalculator();

        self::assertEquals(20, $calculator->add("//:\n5:4:11"));
    }
}
