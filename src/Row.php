<?php


namespace Eliepse\WorkingGrid;


use Eliepse\WorkingGrid\Config\GridConfig;
use Eliepse\WorkingGrid\Elements\Group;
use Eliepse\WorkingGrid\Elements\EmptyGroup;
use Eliepse\WorkingGrid\Elements\CharacterGroup;
use Eliepse\WorkingGrid\Elements\ModelCharacterGroup;
use Eliepse\WorkingGrid\Elements\Word;

class Row implements \Iterator, \Countable
{
    /**
     * @var Word $word
     */
    private $word;

    /**
     * @var GridConfig $config
     */
    protected $config;

    /**
     * @var int
     */
    private $iterator = 0;

    /**
     * @var int $y
     */
    private $y;


    /**
     * Row constructor.
     * @param int $y
     * @param Word $word
     * @param GridConfig $config
     */
    public function __construct(int $y, Word $word, GridConfig $config)
    {
        $this->y = $y;
        $this->word = $word;
        $this->config = $config;
    }


    /**
     * @return int
     */
    public function getColumnCount(): int
    {
        return $this->count() * $this->word->getColumnSize();
    }


    public function getY(): int
    {
        return $this->y;
    }


    public function getWord(): Word { return $this->word; }


    /**
     * Return the index of the row within the page
     * @return int
     */
    public function getIndex(): int { return $this->y; }


    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return Group Can return any type.
     * @since 5.0.0
     */
    public function current(): Group
    {
        if ($this->key() === 0) {

            return new CharacterGroup($this->key() * $this->word->getColumnSize(), $this->y, $this->word);

        } else if ($this->key() <= $this->config->models_amount) {

            return new ModelCharacterGroup($this->key() * $this->word->getColumnSize(), $this->y, $this->word);

        }

        return new EmptyGroup($this->key() * $this->word->getColumnSize(), $this->y, $this->word->getColumnSize());
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
     * @return int scalar on success, or null on failure.
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
        return $this->iterator < $this->count();
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
        return floor($this->config->columns_amount / $this->word->getColumnSize());
    }
}