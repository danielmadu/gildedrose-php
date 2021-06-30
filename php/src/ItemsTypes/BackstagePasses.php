<?php

namespace GildedRose\ItemsTypes;

class BackstagePasses extends ItemType
{
    public const NAME = 'Backstage passes to a TAFKAL80ETC concert';

    protected function getQualityIncrement(): int
    {
        if ($this->item->sell_in <= 5) {
            return 3;
        }

        if ($this->item->sell_in <= 10) {
            return 2;
        }

        return 1;
    }

    protected function calculateQuality(): int
    {
        if ($this->isPassedSellIn()) {
            return self::MIN_QUALITY;
        }

        $calculate = $this->item->quality + $this->getQualityIncrement();

        if (! $this->verifyQuality($calculate)) {
            if ($calculate > self::MAX_QUALITY) {
                return self::MAX_QUALITY;
            }

            return self::MIN_QUALITY;
        }

        return $calculate;
    }

    private function isPassedSellIn(): bool
    {
        return $this->item->sell_in < 0;
    }
}
