<?php
/**
 * Created by PhpStorm.
 * User: mateo-gbb
 * Date: 2019-10-10
 * Time: 10:40
 */

namespace MeetupOrganizing\Service;


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
     * @param int $organizerId
     * @param string $name
     * @param string $description
     * @param string $scheduledFor
     * @param int $wasCancelled
     *
     * @return int
     */
    public function schedule(
        int $organizerId,
        string $name,
        string $description,
        string $scheduledFor,
        int $wasCancelled = 0
    ): int {
        $meetupEntity = new Meetup(
            $organizerId,
            $name,
            $description,
            $scheduledFor,
            $wasCancelled
        );

        return $this->meetupRepository->save($meetupEntity);
    }

}