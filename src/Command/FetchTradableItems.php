<?php

    namespace App\Command;

    use App\Entity\ItemTradable;
    use App\Repository\ItemTradableRepository;
    use App\Service\Notification\NotificationService;
    use App\Service\WarframeMarket\MarketService;
    use App\UniqueNameInterface\WarframeApiInterface;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Component\Console\Attribute\AsCommand;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;

    #[AsCommand(
        name: 'items:fetch-new-items',
        description: 'Scan list of all items in game and updates them',
        hidden: false
    )]
    class FetchTradableItems extends Command
    {
        protected static $defaultDescription = 'Scan list of all items in game and updates them';

        public function __construct(
            private MarketService           $marketService,
            private ItemTradableRepository  $itemTradableRepository,
            private EntityManagerInterface  $entityManager,
        ) {
            parent::__construct();
        }

        protected function execute(InputInterface $input, OutputInterface $output): int
        {
//        $output->writeln("Started scanning warframe market for Items");
//        $availableItems = $this->marketService->scanMarket();
//        if (0 === count($availableItems)) {
//            $output->writeln("No items matched requirements");
//        } else {
//            $output->writeln("Found ". count($availableItems). " matched items for users");
//            $createdNotifications = $this->notificationService->handleData($availableItems);
//            $output->writeln("Created $createdNotifications notifications");
//        }
//        $output->writeln("Ended scanning for Items");
            $output->writeln("Started scanning products at ". date('Y-m-d H:i:s'));
            $items = $this->marketService->getAllItems();
            $output->writeln('Fetched: ' . count($items) . ' items from WFD');
            $newCount = 0;
            $editCount = 0;
            foreach ($items as $itemSingle){
                $exists = null;
                try {
                    $fetched = $this->marketService->getItemData($itemSingle['slug']);
                    $exists = $this->itemTradableRepository->findOneBy(['slug' => $fetched['slug']]);
                    if (!empty($exists)) {
                        $editCount++;
                        $item = $exists;
                    } else {
                        $newCount++;
                        $item = new ItemTradable();
                    }
                    $enData = $fetched[WarframeApiInterface::ITEM_I18][WarframeApiInterface::ITEM_EN];

                    $iconUrl = (isset($enData[WarframeApiInterface::ITEM_ICON])) ? 'https://warframe.market/static/assets/'. $enData[WarframeApiInterface::ITEM_ICON] : '';

                    $item->setSlug($fetched[WarframeApiInterface::ITEM_SLUG]);
                    $item->setTags($fetched[WarframeApiInterface::INCLUDE_ITEM_ITEMSINSET_TAGS]);
                    $item->setVaulted($fetched[WarframeApiInterface::ITEM_VAULTED] ?? false);
                    $item->setTradable($fetched[WarframeApiInterface::ITEM_TRADABLE] ?? false);
                    $item->setExternalId($fetched[WarframeApiInterface::ITEM_ID] ?? '');
                    $item->setName($enData[WarframeApiInterface::ITEM_NAME]);
                    $item->setWikiLink($enData[WarframeApiInterface::ITEM_WIKI_LINK] ?? '');
                    $item->setIcon($iconUrl);
                    $item->setDescription($enData[WarframeApiInterface::ITEM_DESCRIPTION] ?? '');

                    $this->entityManager->persist($item);
                    $this->entityManager->flush();
                } catch (\Exception $e) {
                    if (!$exists) {
                        $item = new ItemTradable();
                        $item->setSlug($fetched[WarframeApiInterface::ITEM_SLUG]);
                        $this->entityManager->persist($item);
                        $this->entityManager->flush();
                    }
                }
            }

            $output->writeln('Finished');
            $output->writeln('New: '. $newCount);
            $output->writeln('Edited: '. $editCount);

            return OutputInterface::OUTPUT_NORMAL;
        }

        protected function configure(): void
        {
            $this
                ->setHelp(self::$defaultDescription)
            ;
        }
    }
