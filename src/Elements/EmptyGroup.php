<?php


namespace Eliepse\WorkingGrid\Elements;


use Eliepse\WorkingGrid\EmptyCell;
use Eliepse\WorkingGrid\Cell;

class EmptyGroup extends Group
{

    /** @var int $iterator */
    protected $iterator = 0;

    /** @var int $size */
    protected $size;


    public function __construct(int $x, int $y, int $size)
    {
        parent::__construct($x, $y);

        $this->size = $size;
    }


    public function current(): EmptyCell
    {
        return new EmptyCell($this->x + $this->key(), $this->y);
    }


    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next(): void
    {
        $this->iterator++;
    }


    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key(): int
    {
        return $this->iterator;
    }


    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid(): bool
    {
        return $this->iterator < $this->size;
    }


    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind(): void
    {
        $this->iterator = 0;
    }


    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count(): int
    {
        return $this->size;
    }
}