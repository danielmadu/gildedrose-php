<?php

namespace GildedRose\ItemsTypes;

use GildedRose\Item;

abstract class ItemType
{
    protected const MAX_QUALITY = 50;

    protected const MIN_QUALITY = 0;

    protected Item $item;

    protected int $qualityCount = -1;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function update(): void
    {
        $this->item->sell_in--;

        $this->item->quality = $this->calculateQuality();
    }

    protected function verifyQuality(int $value): bool
    {
        if ($value > self::MAX_QUALITY) {
            return false;
        }

        if ($value < self::MIN_QUALITY) {
            return false;
        }

        return true;
    }

    protected function getQualityIncrement(): int
    {
        return $this->item->sell_in >= 0 ? $this->qualityCount : $this->qualityCount * 2;
    }

    protected function calculateQuality(): int
    {
        $calculate = $this->item->quality + $this->getQualityIncrement();

        if (! $this->verifyQuality($calculate)) {
            if ($calculate > self::MAX_QUALITY) {
                return self::MAX_QUALITY;
            }

            return self::MIN_QUALITY;
        }

        return $calculate;
    }
}
