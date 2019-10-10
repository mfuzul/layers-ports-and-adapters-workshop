<?php
declare(strict_types=1);

namespace MeetupOrganizing\Command;

use Doctrine\DBAL\Connection;
use MeetupOrganizing\CommandObject\MeetupSchedule;
use MeetupOrganizing\Entity\Meetup;
use MeetupOrganizing\Entity\MeetupRepository;
use MeetupOrganizing\Entity\ScheduledDate;
use MeetupOrganizing\Entity\UserId;
use MeetupOrganizing\Service\MeetupScheduler;
use Webmozart\Console\Api\Args\Args;
use Webmozart\Console\Api\IO\IO;

final class ScheduleMeetupConsoleHandler
{
    /**
     * @var MeetupRepository
     */
    private $meetupScheduler;

    public function __construct(MeetupScheduler $meetupScheduler)
    {
        $this->meetupScheduler = $meetupScheduler;
    }

    public function handle(Args $args, IO $io): int
    {
        $this->meetupScheduler->schedule(
            new MeetupSchedule(
                (int) $args->getArgument('organizerId'),
                $args->getArgument('name'),
                $args->getArgument('description'),
                $args->getArgument('scheduledFor')
            )
        );

        $io->writeLine('<success>Scheduled the meetup successfully</success>');

        return 0;
    }
}
