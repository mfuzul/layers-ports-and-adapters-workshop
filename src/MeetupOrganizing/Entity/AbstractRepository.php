<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: mateo-gbb
 * Date: 2019-10-10
 * Time: 09:51
 */

namespace MeetupOrganizing\Entity;


use Doctrine\DBAL\Connection;

abstract class AbstractRepository
{
    /** @var Connection */
    private $connection;

    /**
     * AbstractRepository constructor.
     *
     * @param Connection $connection
     */
    public function __construct(
        Connection $connection
    ) {
        $this->connection = $connection;
    }

    /**
     * @return string
     */
    abstract protected function tableName(): string;

    /**
     * @param AbstractEntity $entity
     *
     * @return int
     */
    public function save(AbstractEntity $entity): int
    {
        $this->connection->insert($this->tableName(), $entity->getData());

        return (int) $this->connection->lastInsertId() ?? 0;
    }

}