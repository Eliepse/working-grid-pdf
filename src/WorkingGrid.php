<?php


namespace Eliepse\WorkingGrid;


use Eliepse\WorkingGrid\Config\GridConfig;
use Eliepse\WorkingGrid\Config\PageConfig;
use Eliepse\WorkingGrid\Elements\Word;
use Eliepse\WorkingGrid\Template\Template;

class WorkingGrid implements \Iterator, \Countable
{

	/**
	 * @var string $title The title of the document
	 */
	public $title;

	/**
	 * @var array $words
	 */
	private $words = [];

	/**
	 * @var int $page_iterator
	 */
	private $page_iterator = 0;

	/**
	 * @var GridConfig
	 */
	private $grid_config;

	/**
	 * @var PageConfig
	 */
	private $page_config;

	/**
	 * @var Template
	 */
	private $template;


	/**
	 * WorkingGrid constructor.
	 *
	 * @param string $title
	 * @param GridConfig $grid_config
	 * @param PageConfig $page_config
	 * @param Template $template
	 */
	public function __construct(string $title, GridConfig $grid_config, PageConfig $page_config, Template $template)
	{
		$this->title = $title;
		$this->grid_config = $grid_config;
		$this->page_config = $page_config;
		$this->template = $template;
	}


	public static function inlinePrint(Template $template, array $words)
	{
		(new GridPainter($template->generate($words)))->inlinePrint();
	}


	public static function download(Template $template, array $words)
	{
		(new GridPainter($template->generate($words)))->download();
	}


	/**
	 * Add a character to the list of characters to draw. Characters are drawn in the order added.
	 *
	 * @param Word $word The content to add to the list
	 *
	 * @return WorkingGrid
	 */
	public function addWord(Word $word): self
	{
		array_push($this->words, $word);

		return $this;
	}


	/**
	 * @param array $words
	 *
	 * @return WorkingGrid
	 */
	public function addWords(array $words): self
	{
		$this->words = array_merge($this->words, $words);

		return $this;
	}


	/**
	 * Return the current element
	 *
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return mixed Can return any type.
	 * @since 5.0.0
	 */
	public function current(): GridPage
	{
		return new GridPage($this->key() + 1,
			$this->getPageCharacters($this->key()),
			$this->grid_config);
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
		$this->page_iterator++;
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
		return $this->page_iterator;
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
		return $this->page_iterator < $this->count();
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
		$this->page_iterator = 0;
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
		return $this->getPageCount();
	}


	public function getTemplate(): Template { return $this->template; }


	public function getGridConfig(): GridConfig { return $this->grid_config; }


	public function getPageConfig(): PageConfig { return $this->page_config; }


	public function getPageCount(): int
	{
		return count(array_chunk($this->words, $this->grid_config->getWordsPerPage($this->page_config)));
	}


	private function getPageCharacters(int $page_number): array { return array_chunk($this->words, $this->grid_config->getWordsPerPage($this->page_config))[ $page_number ]; }
}