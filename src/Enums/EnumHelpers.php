<?php

namespace ElastiCo\Enums\Enums;


use Illuminate\Support\Str;


trait EnumHelpers
{
	public static function make($enum) : self
	{
		return is_string($enum)
			? self::from($enum)
			: $enum;
	}


	public function is(self $enum) : bool
	{
		return $this->value === $enum->value;
	}


	public static function keys() : array
	{
		return array_column(self::cases(), 'name');
	}


	public static function values() : array
	{
		return array_column(self::cases(), 'value');
	}


	public static function options() : array
	{
		return collect(self::cases())
			->mapWithKeys(fn($item) => [$item->value => $item->label()])
			->toArray();
	}


	public function key() : string
	{
		return Str::snake($this->name, '-');
	}


	public function label() : string
	{
		/** Abbreviations handle */
		if (Str::upper($this->name) === $this->name) {
			return __($this->name);
		}

		return __(Str::ucfirst(Str::lower(Str::headline($this->name))));
	}


	public function labelPlural() : string
	{
		/** Abbreviations handle */
		if (Str::upper($this->name) === $this->name) {
			return __(Str::plural($this->name));
		}

		return __(Str::title(Str::of($this->name)->plural()->studly()->ucsplit()->implode(' ')));
	}
}
