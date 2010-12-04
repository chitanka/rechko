<?php
class BgHyphenatorConstructor
{
	static private $hyphenator = null;


	static public function getHyphenator()
	{
		if (is_null(self::$hyphenator)) {
			self::$hyphenator = new BgHyphenator;
		}

		return self::$hyphenator;
	}

}
