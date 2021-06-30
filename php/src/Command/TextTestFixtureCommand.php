<?php

namespace GildedRose\Command;

use GildedRose\GildedRose;
use GildedRose\Item;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TextTestFixtureCommand extends Command
{
    protected static $defaultName = 'app:texttest';

    private array $items = [];

    protected function configure(): void
    {
        $this->setDescription('Run the TextTest fixture.');
        $this->addOption('days', null, InputOption::VALUE_REQUIRED, 'Number of days to run the application', '2');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->generateItems();
        $days = $input->getOption('days');

        $app = new GildedRose($this->items);

        for ($i = 0; $i < $days; $i++) {
            $table = new Table($output);
            $table->setHeaders([
                [
                    new TableCell("Day ${i}", [
                        'colspan' => 3,
                    ]), ],
                ['Name', 'Sell In', 'Quality'],
            ]);
            $rows = [];
            foreach ($this->items as $item) {
                /** @var Item $item */
                $rows[] = [$item->name, $item->sell_in, $item->quality];
            }
            $table->setRows($rows);
            $table->render();
            $app->updateQuality();
        }

        return Command::SUCCESS;
    }

    private function generateItems(): void
    {
        $this->items = [
            new Item('+5 Dexterity Vest', 10, 20),
            new Item('Aged Brie', 2, 0),
            new Item('Elixir of the Mongoose', 5, 7),
            new Item('Sulfuras, Hand of Ragnaros', 0, 80),
            new Item('Sulfuras, Hand of Ragnaros', -1, 80),
            new Item('Backstage passes to a TAFKAL80ETC concert', 15, 20),
            new Item('Backstage passes to a TAFKAL80ETC concert', 10, 49),
            new Item('Backstage passes to a TAFKAL80ETC concert', 5, 49),
            new Item('Conjured Mana Cake', 3, 6),
        ];
    }
}
