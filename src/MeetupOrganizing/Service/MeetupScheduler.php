<?php
/**
 * Created by PhpStorm.
 * User: mateo-gbb
 * Date: 2019-10-10
 * Time: 10:40
 */

namespace MeetupOrganizing\Service;


use MeetupOrganizing\CommandObject\MeetupSchedule;
use MeetupOrganizing\Entity\Meetup;
use MeetupOrganizing\Entity\MeetupRepository;

class MeetupScheduler
{
    /** @var MeetupRepository */
    private $meetupRepository;

    /**
     * MeetupScheduler constructor.
     *
     * @param MeetupRepository $meetupRepository
     */
    public function __construct(
        MeetupRepository $meetupRepository
    ) {
        $this->meetupRepository = $meetupRepository;
    }

    /**
     * Generate meetup entity, save through repository
     * and return the id of the last saved meetup.
     *
     * @param MeetupSchedule $meetupSchedule
     *
     * @return int
     */
    public function schedule(MeetupSchedule $meetupSchedule): int {
        $meetupEntity = new Meetup(
            $meetupSchedule->organizerId(),
            $meetupSchedule->name(),
            $meetupSchedule->description(),
            $meetupSchedule->scheduledFor(),
            $meetupSchedule->wasCancelled()
        );

        return $this->meetupRepository->save($meetupEntity);
    }

}