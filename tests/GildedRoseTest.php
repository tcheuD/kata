<?php

use App\GildedRose;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    /** @test */
    public function updates_normal_items_before_sell_date(): void
    {
        $item = GildedRose::of('normal', 10, 5); // quality, sell in X days

        $item->tick();

        self::assertEquals(9, $item->quality);
        self::assertEquals(4, $item->sellIn);
    }

    /** @test */
    public function updates_normal_items_on_the_sell_date(): void
    {
        $item = GildedRose::of('normal', 10, 0);

        $item->tick();

        self::assertEquals(8, $item->quality);
        self::assertEquals(-1, $item->sellIn);
    }

    /** @test */
    public function updates_normal_items_after_the_sell_date(): void
    {
        $item = GildedRose::of('normal', 10, -5);

        $item->tick();

        self::assertEquals(8, $item->quality);
        self::assertEquals(-6, $item->sellIn);
    }

    /** @test */
    public function updates_normal_items_with_a_quality_of_0(): void
    {
        $item = GildedRose::of('normal', 0, 5);

        $item->tick();

        self::assertEquals(0, $item->quality);
        self::assertEquals(4, $item->sellIn);
    }

    /** @test */
    public function updates_brie_items_before_the_sell_date(): void
    {
        $item = GildedRose::of('Aged Brie', 10, 5);

        $item->tick();

        self::assertEquals(11, $item->quality);
        self::assertEquals(4, $item->sellIn);
    }

    /** @test */
    public function updates_brie_items_before_the_sell_date_with_maximum_quality(): void
    {
        $item = GildedRose::of('Aged Brie', 50, 5);

        $item->tick();

        self::assertEquals(50, $item->quality);
        self::assertEquals(4, $item->sellIn);
    }

    /** @test */
    public function updates_brie_items_on_the_sell_date(): void
    {
        $item = GildedRose::of('Aged Brie', 10, 0);

        $item->tick();

        self::assertEquals(12, $item->quality);
        self::assertEquals(-1, $item->sellIn);
    }

    /** @test */
    public function updates_brie_items_on_the_sell_date_near_maximum_quality(): void
    {
        $item = GildedRose::of('Aged Brie', 49, 0);

        $item->tick();

        self::assertEquals(50, $item->quality);
        self::assertEquals(-1, $item->sellIn);
    }

    /** @test */
    public function updates_brie_items_on_the_sell_date_with_maximum_quality(): void
    {
        $item = GildedRose::of('Aged Brie', 50, 0);

        $item->tick();

        self::assertEquals(50, $item->quality);
        self::assertEquals(-1, $item->sellIn);
    }

    /** @test */
    public function updates_brie_items_after_the_sell_date(): void
    {
        $item = GildedRose::of('Aged Brie', 10, -10);

        $item->tick();

        self::assertEquals(12, $item->quality);
        self::assertEquals(-11, $item->sellIn);
    }

    /** @test */
    public function updates_brie_items_after_the_sell_date_with_maximum_quality(): void
    {
        $item = GildedRose::of('Aged Brie', 50, -10);

        $item->tick();

        self::assertEquals(50, $item->quality);
        self::assertEquals(-11, $item->sellIn);
    }

    /** @test */
    public function updates_sulfuras_items_before_the_sell_date(): void
    {
        $item = GildedRose::of('Sulfuras, Hand of Ragnaros', 10, 5);

        $item->tick();

        self::assertEquals(10, $item->quality);
        self::assertEquals(5, $item->sellIn);
    }

    /** @test */
    public function updates_sulfuras_items_on_the_sell_date(): void
    {
        $item = GildedRose::of('Sulfuras, Hand of Ragnaros', 10, 5);

        $item->tick();

        self::assertEquals(10, $item->quality);
        self::assertEquals(5, $item->sellIn);
    }

    /** @test */
    public function updates_sulfuras_items_after_the_sell_date(): void
    {
        $item = GildedRose::of('Sulfuras, Hand of Ragnaros', 10, -1);

        $item->tick();

        self::assertEquals(10, $item->quality);
        self::assertEquals(-1, $item->sellIn);
    }

    /*
        "Backstage passes", like aged brie, increases in Quality as it's SellIn
        value approaches; Quality increases by 2 when there are 10 days or
        less and by 3 when there are 5 days or less but Quality drops to
        0 after the concert
     */

    /** @test */
    public function updates_backstage_pass_items_long_before_the_sell_date(): void
    {
        $item = GildedRose::of(
            'Backstage passes to a TAFKAL80ETC concert',
            10,
            11
        );

        $item->tick();

        self::assertEquals(11, $item->quality);
        self::assertEquals(10, $item->sellIn);
    }

    /** @test */
    public function updates_backstage_pass_items_close_to_the_sell_date(): void
    {
        $item = GildedRose::of(
            'Backstage passes to a TAFKAL80ETC concert',
            10,
            10
        );

        $item->tick();

        self::assertEquals(12, $item->quality);
        self::assertEquals(9, $item->sellIn);
    }

    /** @test */
    public function updates_backstage_pass_items_close_to_the_sell_data_at_max_quality(): void
    {
        $item = GildedRose::of(
            'Backstage passes to a TAFKAL80ETC concert',
            50,
            10
        );

        $item->tick();

        self::assertEquals(50, $item->quality);
        self::assertEquals(9, $item->sellIn);
    }

    /** @test */
    public function updates_backstage_pass_items_very_close_to_the_sell_date(): void
    {
        $item = GildedRose::of(
            'Backstage passes to a TAFKAL80ETC concert',
            10,
            5
        );

        $item->tick();

        self::assertEquals(13, $item->quality);
        self::assertEquals(4, $item->sellIn);
    }

    /** @test */
    public function updates_backstage_pass_items_very_close_to_the_sell_date_at_max_quality(): void
    {
        $item = GildedRose::of(
            'Backstage passes to a TAFKAL80ETC concert',
            50,
            5
        );

        $item->tick();

        self::assertEquals(50, $item->quality);
        self::assertEquals(4, $item->sellIn);
    }

    /** @test */
    public function updates_backstage_pass_items_with_one_day_left_to_sell(): void
    {
        $item = GildedRose::of(
            'Backstage passes to a TAFKAL80ETC concert',
            10,
            1
        );

        $item->tick();

        self::assertEquals(13, $item->quality);
        self::assertEquals(0, $item->sellIn);
    }

    /** @test */
    public function updates_backstage_pass_items_with_one_day_left_to_sell_at_max_quality(): void
    {
        $item = GildedRose::of(
            'Backstage passes to a TAFKAL80ETC concert',
            50,
            1
        );

        $item->tick();

        self::assertEquals(50, $item->quality);
        self::assertEquals(0, $item->sellIn);
    }

    /** @test */
    public function updates_backstage_pass_items_on_the_sell_date(): void
    {
        $item = GildedRose::of(
            'Backstage passes to a TAFKAL80ETC concert',
            10,
            0
        );

        $item->tick();

        self::assertEquals(0, $item->quality);
        self::assertEquals(-1, $item->sellIn);
    }

    /** @test */
    public function updates_backstage_pass_items_after_the_sell_date(): void
    {
        $item = GildedRose::of(
            'Backstage passes to a TAFKAL80ETC concert',
            10,
            -1
        );

        $item->tick();

        self::assertEquals(0, $item->quality);
        self::assertEquals(-2, $item->sellIn);
    }

    /** @test */
    public function _updates_conjured_items_before_the_sell_date(): void
    {
        $item = GildedRose::of('Conjured Mana Cake', 10, 10);

        $item->tick();

        self::assertEquals(8, $item->quality);
        self::assertEquals(9, $item->sellIn);
    }

    /** @test */
    public function updates_conjured_items_at_zero_quality(): void
    {
        $item = GildedRose::of('Conjured Mana Cake', 0, 10);

        $item->tick();

        self::assertEquals(0, $item->quality);
        self::assertEquals(9, $item->sellIn);
    }

    /** @test */
    public function updates_conjured_items_on_the_sell_date(): void
    {
        $item = GildedRose::of('Conjured Mana Cake', 10, 0);

        $item->tick();

        self::assertEquals(6, $item->quality);
        self::assertEquals(-1, $item->sellIn);
    }

    /** @test */
    public function updates_conjured_items_on_the_sell_date_at_0_quality(): void
    {
        $item = GildedRose::of('Conjured Mana Cake', 0, 0);

        $item->tick();

        self::assertEquals(0, $item->quality);
        self::assertEquals(-1, $item->sellIn);
    }

    /** @test */
    public function updates_conjured_items_after_the_sell_date(): void
    {
        $item = GildedRose::of('Conjured Mana Cake', 10, -10);

        $item->tick();

        self::assertEquals(6, $item->quality);
        self::assertEquals(-11, $item->sellIn);
    }

    /** @test */
    public function updates_conjured_items_after_the_sell_date_at_zero_quality(): void
    {
        $item = GildedRose::of('Conjured Mana Cake', 0, -10);

        $item->tick();

        self::assertEquals(0, $item->quality);
        self::assertEquals(-11, $item->sellIn);
    }
}
