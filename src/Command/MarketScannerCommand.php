<?php

namespace App\Command;

use App\Service\Notification\NotificationService;
use App\Service\WarframeMarket\MarketService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'notification:scan_market',
    description: 'Scans warframe market and add notification to user if matched requirements',
    aliases: ['notification:scan-market'],
    hidden: false
)]
class MarketScannerCommand extends Command
{
    protected static $defaultDescription = 'Scans warframe market and add notification to user if matched requirements';

    public function __construct(
        private NotificationService $notificationService,
        private MarketService       $marketService
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("Started scanning warframe market");
        $avaibleItems = $this->marketService->scanMarket();
        if (0 === count($avaibleItems)) {
            $output->writeln("No items matched requirements");
        } else {
            $output->writeln("Found ". count($avaibleItems). " matched items for users");
            $createdNotifications = $this->notificationService->handleData($avaibleItems);
            $output->writeln("Created $createdNotifications notifications");
        }
        $output->writeln("Ended scanning market");

        return OutputInterface::OUTPUT_NORMAL;
    }

    protected function configure(): void
    {
        $this
            ->setHelp(self::$defaultDescription)
        ;
    }
}
