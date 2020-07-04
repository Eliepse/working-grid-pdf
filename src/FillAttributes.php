<?php
/**
 * Created by PhpStorm.
 * User: micro
 * Date: 14/10/2018
 * Time: 12:22
 */

namespace Eliepse\WorkingGrid;


trait FillAttributes
{

	/**
	 * @param array $attributes
	 *
	 * @return FillAttributes
	 */
	public function fill(array $attributes): self
	{
		$attrs = get_class_vars(self::class);

		foreach ($attributes as $name => $value) {

			// Check if the attribute exists and the given value is not null
			if (array_key_exists($name, $attrs) && ! is_null($value))
				$this->$name = $value;

		}

		return $this;
	}

}