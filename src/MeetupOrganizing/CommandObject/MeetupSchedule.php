<?php
/**
 * Created by PhpStorm.
 * User: mateo-gbb
 * Date: 2019-10-10
 * Time: 11:31
 */

namespace MeetupOrganizing\CommandObject;


use MeetupOrganizing\Entity\ScheduledDate;
use MeetupOrganizing\Entity\UserId;

class MeetupSchedule
{
    /** @var int */
    private $organizerId;

    /** @var string */
    private $name;

    /** @var string */
    private $description;

    /** @var string */
    private $scheduledFor;

    /** @var int */
    private $wasCancelled;

    /**
     * MeetupSchedule constructor.
     *
     * @param int $organizerId
     * @param string $name
     * @param string $description
     * @param string $scheduledFor
     * @param int $wasCancelled
     */
    public function __construct(
        int $organizerId,
        string $name,
        string $description,
        string $scheduledFor,
        int $wasCancelled = 0
    ) {
        $this->organizerId = $organizerId;
        $this->name= $name;
        $this->description = $description;
        $this->scheduledFor = $scheduledFor;
        $this->wasCancelled = $wasCancelled;
    }

    /**
     * @return UserId
     */
    public function organizerId(): UserId
    {
        return UserId::fromInt($this->organizerId);
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

    /**
     * @return ScheduledDate
     */
    public function scheduledFor(): ScheduledDate
    {
        return ScheduledDate::fromString($this->scheduledFor);
    }

    /**
     * @return int
     */
    public function wasCancelled(): int
    {
        return $this->wasCancelled;
    }

}