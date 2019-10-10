<?php
/**
 * Created by PhpStorm.
 * User: mateo-gbb
 * Date: 2019-10-10
 * Time: 12:20
 */

namespace MeetupOrganizing\Validation;

class FormErrorCollection implements \Iterator
{
    /**
     * @var array
     */
    private $items;

    /**
     * @var string
     */
    private $position = 0;

    /**
     * FormErrorCollection constructor.
     *
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /** {@inheritdoc} */
    public function current()
    {
        return $this->items[$this->position];
    }

    /** {@inheritdoc} */
    public function next()
    {
        $this->position++;
    }

    /** {@inheritdoc} */
    public function key()
    {
        return array_keys($this->items)[$this->position];
    }

    /** {@inheritdoc} */
    public function valid()
    {
        return array_key_exists($this->key(), $this->items);
    }

    /** {@inheritdoc} */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function push(string $key, string $value)
    {
        $this->items[$key][] = $value;

        $this->position = $key;
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        return $this->items;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return 0 === count($this->items);
    }

}