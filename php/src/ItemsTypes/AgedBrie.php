<?php

namespace GildedRose\ItemsTypes;

class AgedBrie extends ItemType
{
    public const NAME = 'Aged Brie';

    protected int $qualityCount = 1;

//    public function update(): void
//    {
//        \GildedRose\dd(self::QUALITY);
//    }

//    protected function getQualityIncrement(): int
//    {
//        if (!$this->verifySellIn()) {
//            return self::QUALITY * 2;
//        }
//
//        return self::QUALITY;
//    }
}
