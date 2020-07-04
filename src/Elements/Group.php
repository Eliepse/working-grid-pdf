<?php


namespace Eliepse\WorkingGrid\Elements;

class Group implements \Iterator, \Countable
{
	use UnitPosition;


	/** @var int $iterator */
	private $iterator = 0;

	protected $children = [];


	public function __construct(int $x, int $y, array $children = [])
	{
		$this->x = $x;
		$this->y = $y;
		$this->children = $children;
	}


	public function current()
	{
		return $this->children[ $this->key() ];
	}


	/**
	 * Move forward to next element
	 *
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
	 *
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
	 *
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
	 *
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
	 *
	 * @link http://php.net/manual/en/countable.count.php
	 * @return int The custom count as an integer.
	 * </p>
	 * <p>
	 * The return value is cast to an integer.
	 * @since 5.1.0
	 */
	public function count(): int
	{
		return count($this->children);
	}


	public function getSize(): int
	{
		return $this->count();
	}

}