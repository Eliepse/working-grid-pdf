<?php
/**
 * Created by PhpStorm.
 * User: micro
 * Date: 13/10/2018
 * Time: 12:34
 */

namespace Eliepse\WorkingGrid\Elements;


use Eliepse\WorkingGrid\Character;
use Eliepse\WorkingGrid\DrawableCell;

class CharacterGroup extends Group implements \Iterator, \Countable
{
    public const DRAW_MASTER = 0;
    public const DRAW_MODEL = 1;

    /** @var int $columns */
    protected $columns;

    /** @var int $iterator */
    protected $iterator = 0;

    /** @var int $draw_style */
    public $draw_style = self::DRAW_MASTER;


    public function __construct(int $x, int $y, Word $word)
    {
        parent::__construct($x, $y, $word->getCharacters());
    }


    public function addCharacter(Character $character): self
    {
        $this->children[] = $character;

        return $this;
    }


    public function current(): DrawableCell
    {
        return new DrawableCell($this->x + $this->key(), $this->y, parent::current());
    }
}