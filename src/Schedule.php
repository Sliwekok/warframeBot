<?php

namespace App;

use Cron\CronExpression;
use Symfony\Component\Console\Messenger\RunCommandMessage;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule as SymfonySchedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use Symfony\Component\Scheduler\Trigger\CronExpressionTrigger;
use Symfony\Contracts\Cache\CacheInterface;

#[AsSchedule]
class Schedule implements ScheduleProviderInterface
{
    public function __construct(
        private CacheInterface $cache,
    ) {
    }

    public function getSchedule(): SymfonySchedule
    {
        return (new SymfonySchedule())
            ->stateful($this->cache) // ensure missed tasks are executed
            ->processOnlyLastMissedRun(true) // ensure only last missed task is run

            ->add(
                RecurringMessage::trigger(
                    new CronExpressionTrigger((new CronExpression('* * * * *'))),
                    new RunCommandMessage('notification:scan_market_item')
                )
            )

            ->add(
            RecurringMessage::trigger(
                    new CronExpressionTrigger((new CronExpression('* * * * *'))),
                    new RunCommandMessage('notification:scan_market_riven')
                )
            )
            // add your own tasks here
            // see https://symfony.com/doc/current/scheduler.html#attaching-recurring-messages-to-a-schedule
        ;
    }
}
