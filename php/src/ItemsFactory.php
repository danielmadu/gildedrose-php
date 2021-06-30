<?php

namespace GildedRose;

use GildedRose\ItemsTypes\AgedBrie;
use GildedRose\ItemsTypes\BackstagePasses;
use GildedRose\ItemsTypes\Conjured;
use GildedRose\ItemsTypes\DefaultItem;
use GildedRose\ItemsTypes\Sulfuras;

class ItemsFactory
{
    private array $typedItems = [];

    public function __construct(array $items)
    {
        foreach ($items as $item) {
            switch ($item->name) {
                case AgedBrie::NAME:
                  $this->typedItems[] = new AgedBrie($item);
                  break;
                case Sulfuras::NAME:
                    $this->typedItems[] = new Sulfuras($item);
                    break;
                case BackstagePasses::NAME:
                    $this->typedItems[] = new BackstagePasses($item);
                    break;
                case Conjured::NAME:
                    $this->typedItems[] = new Conjured($item);
                    break;
                default:
                    $this->typedItems[] = new DefaultItem($item);
                    break;
            }
        }
    }

    public function getTypedItems(): array
    {
        return $this->typedItems;
    }
}
