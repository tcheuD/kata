<?php

namespace App;

class BackstagePasses extends Item
{
    public function tick(): void
    {
        ++$this->quality;

        if ($this->sellIn <= 10) {
            ++$this->quality;
        }

        if ($this->sellIn <= 5) {
            ++$this->quality;
        }

        if ($this->sellIn <= 0) {
            $this->quality = 0;
        }

        if ($this->quality > 50) {
            $this->quality = 50;
        }

        --$this->sellIn;
    }
}
