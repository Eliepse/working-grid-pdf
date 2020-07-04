<?php


namespace Eliepse\WorkingGrid;


use Eliepse\WorkingGrid\Config\GridConfig;

class GridPage implements \Iterator, \Countable
{

	/** @var array $words */
	protected $words;

	/** @var GridConfig $config */
	protected $config;

	/** @var int $iterator */
	protected $iterator = 0;

	/**
	 * @var int
	 */
	private $page_number;


	/**
	 * GridPage constructor.
	 *
	 * @param int $page_number
	 * @param array $words An array of array (a line) wich contain characters
	 * @param GridConfig $config
	 */
	public function __construct(int $page_number, array $words, GridConfig $config)
	{
		$this->words = $words;
		$this->config = $config;
		$this->page_number = $page_number;
	}


	public function getPageNumber(): int { return $this->page_number; }


	/**
	 * Return the current element
	 *
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return mixed Can return any type.
	 * @since 5.0.0
	 */
	public function current(): Row
	{
		return new Row($this->key(), $this->words[ $this->key() ], $this->config);
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
		return count($this->words);
	}
}