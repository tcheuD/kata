<?php

namespace App;

use Exception;

class StringCalculator
{
    public const MAX_NUMBER_ALLOWED = 100;

    protected string $delimiter = ",|\n";

    public function add(string $numbers)
    {
        $this->disallowNegatives($numbers = $this->parseString($numbers));

        return array_sum(
            $this->ignoreGreaterThan1000($numbers)
        );
    }

    protected function parseString(string $numbers): array
    {
        $customDelimiter = "\/\/(.)\n";

        if (preg_match("/{$customDelimiter}/", $numbers, $matches)) {
            $this->delimiter = $matches[1];

            $numbers = str_replace($matches[0], '', $numbers);
        }

        return preg_split("/{$this->delimiter}/", $numbers);
    }

    protected function disallowNegatives(array $numbers): void
    {
        foreach ($numbers as $number) {
            if ($number < 0) {
                throw new Exception('Negative numbers are disallowed');
            }
        }
    }

    protected function ignoreGreaterThan1000(array $numbers): array
    {
        return array_filter(
            $numbers,
            fn($number) => $number <= self::MAX_NUMBER_ALLOWED);
    }
}
