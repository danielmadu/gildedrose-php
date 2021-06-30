<?php

declare(strict_types=1);

namespace GildedRose;

use GildedRose\ItemsTypes\ItemType;

final class GildedRose
{
    /**
     * @var Item[]
     */
    private $items;

    private array $typedItems = [];

    public function __construct(array $items)
    {
        $this->items = $items;
        $this->buildTypedItems();
    }

    public function updateQuality(): void
    {
        foreach ($this->typedItems as $item) {
            /** @var ItemType $item */
            $item->update();
        }
    }

    public function getItems(): array
    {
        return $this->typedItems;
    }

    private function buildTypedItems(): void
    {
        $this->typedItems = (new ItemsFactory($this->items))->getTypedItems();
    }
}
