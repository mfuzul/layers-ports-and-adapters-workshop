<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: mateo-gbb
 * Date: 2019-10-10
 * Time: 09:44
 */

namespace MeetupOrganizing\Entity;

abstract class AbstractEntity
{
    /**
     * Returns an associative array of entity data
     * with keys representing the table columns.
     *
     * @return array
     */
    abstract public function getData(): array;

}