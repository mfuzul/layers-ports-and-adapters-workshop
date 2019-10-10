<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: mateo-gbb
 * Date: 2019-10-10
 * Time: 10:00
 */

namespace MeetupOrganizing\Entity;


class MeetupRepository extends AbstractRepository
{
    /** {@inheritdoc} */
    protected function tableName(): string
    {
        return 'meetups';
    }

}