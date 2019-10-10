<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: mateo-gbb
 * Date: 2019-10-10
 * Time: 09:42
 */

namespace MeetupOrganizing\Entity;

use Assert\Assertion;

class Meetup extends AbstractEntity
{
    /** @var int */
    protected $meetupId;

    /** @var UserId */
    protected $organizerId;

    /** @var string */
    protected $name;

    /** @var string */
    protected $description;

    /** @var ScheduledDate */
    protected $scheduledFor;

    /** @var int */
    protected $wasCancelled;

    /**
     * Meetup constructor.
     *
     * @param UserId $organizerId
     * @param string $name
     * @param string $description
     * @param ScheduledDate $scheduledFor
     * @param int $wasCancelled
     */
    private function __construct(
        UserId $organizerId,
        string $name,
        string $description,
        ScheduledDate $scheduledFor,
        int $wasCancelled
    ) {
        $this->organizerId = $organizerId;
        $this->name = $name;
        $this->description = $description;
        $this->scheduledFor = $scheduledFor;
        $this->wasCancelled = $wasCancelled;
    }

    /**
     * @param UserId $organizerId
     * @param string $name
     * @param string $description
     * @param ScheduledDate $scheduledFor
     * @param int $wasCancelled
     *
     * @return Meetup
     *
     * @throws \Assert\AssertionFailedException
     */
    public static function create(
        UserId $organizerId,
        string $name,
        string $description,
        ScheduledDate $scheduledFor,
        int $wasCancelled = 0
    ): Meetup {
        Assertion::notBlank($name, 'Name cannot be an empty string');
        Assertion::notBlank($description, 'Description cannot be an empty string');

        return new self(
            $organizerId,
            $name,
            $description,
            $scheduledFor,
            $wasCancelled
        );
    }

    /** {@inheritdoc} */
    public function getData(): array
    {
        return [
            'organizerId' => $this->organizerId->asInt(),
            'name' => $this->name,
            'description' => $this->description,
            'scheduledFor' => $this->scheduledFor->asString(),
            'wasCancelled' => $this->wasCancelled,
        ];
    }

}