<?php

class MyI18nToolkit
{
	static private $cyrlats = array(
		'щ' => 'sht', 'ш' => 'sh', 'ю' => 'ju', 'я' => 'ja', 'ч' => 'ch',
		'ц' => 'ts',
		'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
		'е' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'j',
		'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
		'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
		'ф' => 'f', 'х' => 'h', 'ъ' => 'y', 'ь' => 'x',

		'Щ' => 'Sht', 'Ш' => 'Sh', 'Ю' => 'Ju', 'Я' => 'Ja', 'Ч' => 'Ch',
		'Ц' => 'Ts',
		'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D',
		'Е' => 'E', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I', 'Й' => 'J',
		'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
		'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U',
		'Ф' => 'F', 'Х' => 'H', 'Ъ' => 'Y', 'Ь' => 'X',
	);
	static private $latcyrs = null;


	static public function cyrlat($s)
	{
		return strtr($s, self::$cyrlats);
	}

	static public function latcyr($s)
	{
		if ( ! isset(self::$latcyrs) ) {
			self::$latcyrs = array_flip(self::$cyrlats);
		}

		return strtr($s, self::$latcyrs);
	}


	static public function removeAccent($name)
	{
		return strtr($name, array(
			'`'      => '',
			'&#768;' => '',
		));
	}


	static public function glueBroken($brokenName)
	{
		return str_replace('-', '', $brokenName);
	}


	static public function normalizeWordForLink($name)
	{
		$name = mb_strtolower($name, 'UTF-8');

		return self::removeAccent($name);
	}

	static public function condenseWord($name)
	{
		$name = mb_strtolower($name, 'UTF-8');
		$name = strtr($name, array(
			'а' => '', 'о' => '', 'е' => '',
			'ъ' => '', 'у' => '', 'и' => '',
			'й' => '', 'ю' => '', 'я' => '', 'ь' => '',
			'нн' => 'н', 'тт' => 'т',
			'шт' => 'щ', 'дж' => 'ж',
			'-' => '', ' ' => '',
		));

		return $name;
	}


	/*
	* This function starts out with several checks in an attempt to save time.
	*   1.  The shorter string is always used as the "right-hand" string (as the size of the array is based on its length).
	*   2.  If the left string is empty, the length of the right is returned.
	*   3.  If the right string is empty, the length of the left is returned.
	*   4.  If the strings are equal, a zero-distance is returned.
	*   5.  If the left string is contained within the right string, the difference in length is returned.
	*   6.  If the right string is contained within the left string, the difference in length is returned.
	* If none of the above conditions were met, the Levenshtein algorithm is used.
	*
	* Taken from http://php.net/manual/en/function.levenshtein.php#87175
	*/
	static public function levenshtein($s1, $s2)
	{
		$enc = 'UTF-8';
		$nLeftLength = mb_strlen($s1, $enc);
		$nRightLength = mb_strlen($s2, $enc);
		if ($nLeftLength >= $nRightLength) {
			$sLeft = $s1;
			$sRight = $s2;
		} else {
			$sLeft = $s2;
			$sRight = $s1;
			// swap left and right length
			$tmp = $nRightLength;
			$nRightLength = $nLeftLength;
			$nLeftLength = $tmp;
		}

		if ($nLeftLength == 0)
			return $nRightLength;

		if ($nRightLength == 0)
			return $nLeftLength;

		if ($sLeft === $sRight)
			return 0;

		if (($nLeftLength < $nRightLength) && (strpos($sRight, $sLeft) !== FALSE))
			return $nRightLength - $nLeftLength;

		if (($nRightLength < $nLeftLength) && (strpos($sLeft, $sRight) !== FALSE))
			return $nLeftLength - $nRightLength;

		$nsDistance = range(0, $nRightLength);
		for ($nLeftPos = 1; $nLeftPos <= $nLeftLength; ++$nLeftPos) {
			$cLeft = mb_substr($sLeft, $nLeftPos - 1, 1, $enc);
			$nDiagonal = $nLeftPos - 1;
			$nsDistance[0] = $nLeftPos;
			for ($nRightPos = 1; $nRightPos <= $nRightLength; ++$nRightPos) {
				$cRight = mb_substr($sRight, $nRightPos - 1, 1, $enc);
				$nCost = ($cRight == $cLeft) ? 0 : 1;
				$nNewDiagonal = $nsDistance[$nRightPos];
				$nsDistance[$nRightPos] = min(
					$nsDistance[$nRightPos] + 1,
					$nsDistance[$nRightPos - 1] + 1,
					$nDiagonal + $nCost);
				$nDiagonal = $nNewDiagonal;
			}
		}

		return $nsDistance[$nRightLength];
	}

}
