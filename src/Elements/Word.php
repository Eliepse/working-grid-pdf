<?php


namespace Eliepse\WorkingGrid\Elements;


use Eliepse\WorkingGrid\Character;
use Eliepse\WorkingGrid\Drawable;

class Word implements \Iterator, \Countable
{

	private $characters;

	private $iterator = 0;


	public function __construct(array $charaters)
	{
		foreach ($charaters as $drawable)
			$this->addDrawable($drawable);
	}


	public function addDrawable(Character $character): void
	{
		$this->characters[] = $character;
	}


	public function getText(): string
	{
		$text = 0;

		foreach ($this as $drawable)
			$text .= $drawable->getText();

		return $text;
	}


	public function getColumnSize(): int
	{
		return count($this->characters);
	}


	/**
	 * Return the current element
	 *
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return mixed Can return any type.
	 * @since 5.0.0
	 */
	public function current(): Character
	{
		return $this->characters[ $this->iterator ];
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
		return $this->iterator < count($this->characters);
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
		return $this->getColumnSize();
	}


	public function getCharacters(): array
	{
		return $this->characters;
	}
}