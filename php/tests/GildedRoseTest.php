<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use GildedRose\ItemsTypes\AgedBrie;
use GildedRose\ItemsTypes\BackstagePasses;
use GildedRose\ItemsTypes\Conjured;
use GildedRose\ItemsTypes\DefaultItem;
use GildedRose\ItemsTypes\Sulfuras;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function testFoo(): void
    {
        $items = [new Item('foo', 0, 0)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame('foo', $items[0]->name);
    }

    public function testGetTypedItems(): void
    {
        $items = [new Item('foo', 0, 0)];
        $gildedRose = new GildedRose($items);

        $this->assertCount(1, $gildedRose->getItems());
    }

    public function testCorrectTypes(): void
    {
        $items = [
            new Item('+5 Dexterity Vest', 10, 20),
            new Item('Aged Brie', 2, 0),
            new Item('Elixir of the Mongoose', 5, 7),
            new Item('Sulfuras, Hand of Ragnaros', 0, 80),
            new Item('Backstage passes to a TAFKAL80ETC concert', 15, 20),
            new Item('Conjured Mana Cake', 3, 6),
        ];
        $gildedRose = new GildedRose($items);

        $typedItems = $gildedRose->getItems();

        $this->assertSame(DefaultItem::class, get_class($typedItems[0]));
        $this->assertSame(AgedBrie::class, get_class($typedItems[1]));
        $this->assertSame(DefaultItem::class, get_class($typedItems[2]));
        $this->assertSame(Sulfuras::class, get_class($typedItems[3]));
        $this->assertSame(BackstagePasses::class, get_class($typedItems[4]));
        $this->assertSame(Conjured::class, get_class($typedItems[5]));
    }

    public function testUpdateQuality(): void
    {
        $items = [
            new Item('+5 Dexterity Vest', 10, 20),
            new Item('Aged Brie', 2, 0),
            new Item('Sulfuras, Hand of Ragnaros', 0, 80),
            new Item('Backstage passes to a TAFKAL80ETC concert', 15, 20),
            new Item('Backstage passes to a TAFKAL80ETC concert', 9, 20),
            new Item('Conjured Mana Cake', 3, 6),
        ];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        // DefaultItem
        $this->assertSame(9, $items[0]->sell_in);
        $this->assertSame(19, $items[0]->quality);
        // AgedBrie
        $this->assertSame(1, $items[1]->sell_in);
        $this->assertSame(1, $items[1]->quality);
        // Sulfuras
        $this->assertSame(0, $items[2]->sell_in);
        $this->assertSame(80, $items[2]->quality);
        // Backstage passes sell in 15 days
        $this->assertSame(14, $items[3]->sell_in);
        $this->assertSame(21, $items[3]->quality);
        // Backstage passes sell in 9 days
        $this->assertSame(8, $items[4]->sell_in);
        $this->assertSame(22, $items[4]->quality);
        // Conjured
        $this->assertSame(2, $items[5]->sell_in);
        $this->assertSame(4, $items[5]->quality);
    }
}
