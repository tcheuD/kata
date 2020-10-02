<?php

namespace App;

class Brie extends Item
{
    public function tick(): void
    {
        --$this->sellIn;
        ++$this->quality;

        if ($this->sellIn <= 0) {
            ++$this->quality;
        }

        if ($this->quality > 50) {
            $this->quality = 50;
        }
    }
}
