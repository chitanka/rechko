<?php

class DerivativeFormsGenerator
{
	static public function getDerivativeForms($word)
	{
		//$rules = self::extractRulesFromDataFile(self::getDataFileFromWord($word));
		$rules = explode("\n", trim($word['Type']['rules']));

		return self::computeDerivativeForms($word, $rules);
	}


	static public function computeDerivativeForms($word, array $rules)
	{
		$rules = self::removeEmptyRules($rules);
		if ( empty($rules) ) {
			return array();
		}

		$first = array_shift($rules);

		$parts = explode(',', $first);
		$first = $parts[0];

		if ($first[0] !== '0') {
			$regexp = str_replace(array('[', ']'), array('([', '])'), $first);
			$regexp = "/$regexp$/u";
		} else {
			$regexp = '';
		}

		$forms = array();
		foreach ($rules as $end) {
			if ($end == '-') {
				$forms[] = '';
				continue;
			}
			$lforms = array();
			foreach (explode(',', $end) as $l_end) {
				$l_end = trim($l_end);
				if ($l_end === '0') {
					$l_end = '';
				}
				if ($regexp) {
					$repl = str_replace('?', '$1', $l_end);
					$form = preg_replace($regexp, $repl, $word['name']);
				} else {
					$form = $word['name'] . $l_end;
				}
				$lforms[] = $form;
			}
			$forms[] = $lforms;
		}

		return self::fillForms($word, $forms);
	}


	static private function removeEmptyRules($rules)
	{
		foreach ($rules as $i => $rule) {
			if ( $rule === '' ) {
				unset($rules[$i]);
			}
		}

		return $rules;
	}

	/**
	* The data file contains:
	*  one section Окончания:
	*  one or more sections Тест:
	*  one section Думи:
	*/
	static public function extractRulesFromDataFile($file)
	{
		$rules = array();
		$in = false;

		foreach (file($file) as $line) {
			$line = self::removeCommentFromDataLine($line);

			if ($line === '') {
				continue;
			}

			if ($line == 'Окончания:') {
				$in = true;
				continue;
			}

			if ($line[strlen($line) - 1] == ':') {
				break;
			}

			if ($in) {
				$rules[] = $line;
			}
		}

		return $rules;
	}


	/**
	* @see extractRulesFromDataFile
	*/
	static public function extractWordsFromDataFile($file)
	{
		$words = array();
		$in = false;

		foreach (file($file) as $line) {
			$line = self::removeCommentFromDataLine($line);

			if (empty($line)) {
				continue;
			}

			if ($line == 'Думи:') {
				$in = true;
				continue;
			}

			if ($in) {
				$words[] = $line;
			}
		}

		return $words;
	}


	static public function getDataFileFromWord($word)
	{
		return self::getDataFile($word['Type']['speech_part'], $word['Type']['name']);
	}

	static public function getDataFile($speechPart, $type)
	{
		return sprintf('%s/bgoffice_data/%s/bg%s.dat',
			sfConfig::get('sf_data_dir'),
			strtr($speechPart, '_', '/'),
			preg_replace('/(\d+)([a-z]*)/e', "str_pad('$1', 3, '0', STR_PAD_LEFT) . '$2'", $type));
	}


	static private function removeCommentFromDataLine($line)
	{
		return trim(preg_replace('/#.*/', '', $line));
	}


	static private function buildDerivForm($bases, $prefix = '', $suffix = '')
	{
		$forms = array();
		foreach ((array) $bases as $base) {
			$forms[] = $base == '' ? '' : trim("$prefix $base $suffix");
		}

		return $forms;
	}

	static public function fillForms($word, array $forms)
	{
		$filled = array();

		switch ($word['Type']['speech_part']) {
			case 'noun_male':                $filled = self::fillNounMaleForms($forms); break;
			case 'noun_female':              $filled = self::fillNounFemaleForms($forms); break;
			case 'noun_neutral':             $filled = self::fillNounNeutralForms($forms); break;
			case 'noun_plurale-tantum':      $filled = self::fillNounPluraleForms($forms); break;
			case 'adjective':                $filled = self::fillAdjectiveForms($forms); break;
			case 'pronominal_personal':      $filled = self::fillPronPersonalForms($forms); break;
			case 'pronominal_demonstrative': $filled = self::fillPronPersonalForms($forms); break;
			case 'pronominal_possessive':    $filled = self::fillPronPossessiveForms($forms); break;
			case 'pronominal_interrogative': $filled = self::fillPronInterrogativeForms($forms); break;
			case 'pronominal_relative':      $filled = self::fillPronRelativeForms($forms); break;
			case 'pronominal_indefinite':    $filled = self::fillPronIndefiniteForms($forms); break;
			case 'pronominal_negative':      $filled = self::fillPronNegativeForms($forms); break;
			case 'pronominal_general':       $filled = self::fillPronGeneralForms($forms); break;
			case 'numeral_cardinal':         $filled = self::fillNumCardinalForms($forms); break;
			case 'numeral_ordinal':          $filled = self::fillNumOrdinalForms($forms); break;
			case 'verb_intransitive_imperfective':
			case 'verb_intransitive_terminative':
			case 'verb_transitive_imperfective':
			case 'verb_transitive_terminative':
			case 'verb':                     $filled = self::fillVerbForms($forms); break;
			case 'name_people_family':       $filled = self::fillNamePeopleFamilyForms($forms); break;
			case 'name_people_name':         $filled = self::fillNamePeopleNameForms($forms); break;
		}

		foreach ($filled as $k => $v) {
			if (empty($v)) {
				unset($filled[$k]);
			}
		}

		return $filled;
	}

	static private function fillNounMaleForms($forms)
	{
		return array(
			'ед.ч.'              => @$forms[0],
			'ед.ч. непълен член' => @$forms[1],
			'ед.ч. пълен член'   => @$forms[2],
			'мн.ч.'              => @$forms[3],
			'мн.ч. членувано'    => @$forms[4],
			'бройна форма'       => @$forms[5],
			'звателна форма'     => @$forms[6],
		);
	}

	static private function fillNounFemaleForms($forms)
	{
		return array(
			'ед.ч.'           => @$forms[0],
			'ед.ч. членувано' => @$forms[1],
			'мн.ч.'           => @$forms[2],
			'мн.ч. членувано' => @$forms[3],
			'звателна форма'  => @$forms[4],
		);
	}

	static private function fillNounNeutralForms($forms)
	{
		return array(
			'ед.ч.'           => @$forms[0],
			'ед.ч. членувано' => @$forms[1],
			'мн.ч.'           => @$forms[2],
			'мн.ч. членувано' => @$forms[3],
		);
	}

	static private function fillNounPluraleForms($forms)
	{
		return array(
			'ед.ч.'           => @$forms[0],
			'ед.ч. членувано' => @$forms[1],
			'мн.ч.'           => @$forms[2],
			'мн.ч. членувано' => @$forms[3],
		);
	}

	static private function fillAdjectiveForms($forms)
	{
		return array(
			'м.р.'              => @$forms[0],
			'м.р. непълен член' => @$forms[1],
			'м.р. пълен член'   => @$forms[2],
			'ж.р.'              => @$forms[3],
			'ж.р. членувано'    => @$forms[4],
			'ср.р.'             => @$forms[5],
			'ср.р. членувано'   => @$forms[6],
			'мн.ч.'             => @$forms[7],
			'мн.ч. членувано'   => @$forms[8],
		);
	}

	static private function fillVerbForms($forms)
	{
		return array(
			'сег.вр., 1л., ед.ч.' => @$forms[0],
			'сег.вр., 1л., мн.ч.' => @$forms[3],
			'сег.вр., 2л., ед.ч.' => @$forms[1],
			'сег.вр., 2л., мн.ч.' => @$forms[4],
			'сег.вр., 3л., ед.ч.' => @$forms[2],
			'сег.вр., 3л., мн.ч.' => @$forms[5],

			'мин.св.вр., 1л., ед.ч.' => @$forms[6],
			'мин.св.вр., 1л., мн.ч.' => @$forms[9],
			'мин.св.вр., 2л., ед.ч.' => @$forms[7],
			'мин.св.вр., 2л., мн.ч.' => @$forms[10],
			'мин.св.вр., 3л., ед.ч.' => @$forms[8],
			'мин.св.вр., 3л., мн.ч.' => @$forms[11],

			'мин.несв.вр., 1л., ед.ч.' => @$forms[12],
			'мин.несв.вр., 1л., мн.ч.' => @$forms[15],
			'мин.несв.вр., 2л., ед.ч.' => @$forms[13],
			'мин.несв.вр., 2л., мн.ч.' => @$forms[16],
			'мин.несв.вр., 3л., ед.ч.' => @$forms[14],
			'мин.несв.вр., 3л., мн.ч.' => @$forms[17],

			'мин.неопр.вр., 1л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[20], '', 'съм'),
			'мин.неопр.вр., 1л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[23], '', 'съм'),
			'мин.неопр.вр., 1л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[25], '', 'съм'),
			'мин.неопр.вр., 1л., мн.ч.'        => self::buildDerivForm(@$forms[27], '', 'сме'),
			'мин.неопр.вр., 2л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[20], '', 'си'),
			'мин.неопр.вр., 2л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[23], '', 'си'),
			'мин.неопр.вр., 2л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[25], '', 'си'),
			'мин.неопр.вр., 2л., мн.ч.'        => self::buildDerivForm(@$forms[27], '', 'сте'),
			'мин.неопр.вр., 3л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[20], '', 'е'),
			'мин.неопр.вр., 3л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[23], '', 'е'),
			'мин.неопр.вр., 3л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[25], '', 'е'),
			'мин.неопр.вр., 3л., мн.ч.'        => self::buildDerivForm(@$forms[27], '', 'са'),

			'мин.пред.вр., 1л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[20], 'бях'),
			'мин.пред.вр., 1л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[23], 'бях'),
			'мин.пред.вр., 1л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[25], 'бях'),
			'мин.пред.вр., 1л., мн.ч.'        => self::buildDerivForm(@$forms[27], 'бяхме'),
			'мин.пред.вр., 2л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[20], 'беше'),
			'мин.пред.вр., 2л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[23], 'беше'),
			'мин.пред.вр., 2л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[25], 'беше'),
			'мин.пред.вр., 2л., мн.ч.'        => self::buildDerivForm(@$forms[27], 'бяхте'),
			'мин.пред.вр., 3л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[20], 'беше'),
			'мин.пред.вр., 3л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[23], 'беше'),
			'мин.пред.вр., 3л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[25], 'беше'),
			'мин.пред.вр., 3л., мн.ч.'        => self::buildDerivForm(@$forms[27], 'бяха'),

			'бъд.вр., 1л., ед.ч.' => self::buildDerivForm(@$forms[0], 'ще'),
			'бъд.вр., 1л., мн.ч.' => self::buildDerivForm(@$forms[3], 'ще'),
			'бъд.вр., 2л., ед.ч.' => self::buildDerivForm(@$forms[1], 'ще'),
			'бъд.вр., 2л., мн.ч.' => self::buildDerivForm(@$forms[4], 'ще'),
			'бъд.вр., 3л., ед.ч.' => self::buildDerivForm(@$forms[2], 'ще'),
			'бъд.вр., 3л., мн.ч.' => self::buildDerivForm(@$forms[5], 'ще'),

			'бъд.пред.вр., 1л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[20], 'ще съм'),
			'бъд.пред.вр., 1л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[23], 'ще съм'),
			'бъд.пред.вр., 1л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[25], 'ще съм'),
			'бъд.пред.вр., 1л., мн.ч.'        => self::buildDerivForm(@$forms[27], 'ще сме'),
			'бъд.пред.вр., 2л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[20], 'ще си'),
			'бъд.пред.вр., 2л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[23], 'ще си'),
			'бъд.пред.вр., 2л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[25], 'ще си'),
			'бъд.пред.вр., 2л., мн.ч.'        => self::buildDerivForm(@$forms[27], 'ще сте'),
			'бъд.пред.вр., 3л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[20], 'ще е'),
			'бъд.пред.вр., 3л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[23], 'ще е'),
			'бъд.пред.вр., 3л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[25], 'ще е'),
			'бъд.пред.вр., 3л., мн.ч.'        => self::buildDerivForm(@$forms[27], 'ще са'),

			'бъд.вр. в мин., 1л., ед.ч.' => self::buildDerivForm(@$forms[0], 'щях да'),
			'бъд.вр. в мин., 1л., мн.ч.' => self::buildDerivForm(@$forms[3], 'щяхме да'),
			'бъд.вр. в мин., 2л., ед.ч.' => self::buildDerivForm(@$forms[1], 'щеше да'),
			'бъд.вр. в мин., 2л., мн.ч.' => self::buildDerivForm(@$forms[4], 'щяхте да'),
			'бъд.вр. в мин., 3л., ед.ч.' => self::buildDerivForm(@$forms[2], 'щеше да'),
			'бъд.вр. в мин., 3л., мн.ч.' => self::buildDerivForm(@$forms[5], 'щяха да'),

			'бъд.пред.вр. в мин., 1л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[20], 'щях да съм'),
			'бъд.пред.вр. в мин., 1л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[23], 'щях да съм'),
			'бъд.пред.вр. в мин., 1л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[25], 'щях да съм'),
			'бъд.пред.вр. в мин., 1л., мн.ч.'        => self::buildDerivForm(@$forms[27], 'щяхме да сме'),
			'бъд.пред.вр. в мин., 2л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[20], 'щеше да си'),
			'бъд.пред.вр. в мин., 2л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[23], 'щеше да си'),
			'бъд.пред.вр. в мин., 2л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[25], 'щеше да си'),
			'бъд.пред.вр. в мин., 2л., мн.ч.'        => self::buildDerivForm(@$forms[27], 'щяхте да сте'),
			'бъд.пред.вр. в мин., 3л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[20], 'щеше да е'),
			'бъд.пред.вр. в мин., 3л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[23], 'щеше да е'),
			'бъд.пред.вр. в мин., 3л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[25], 'щеше да е'),
			'бъд.пред.вр. в мин., 3л., мн.ч.'        => self::buildDerivForm(@$forms[27], 'щяха да са'),

			'пр.накл., сег.вр., 1л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[29], '', 'съм'),
			'пр.накл., сег.вр., 1л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[32], '', 'съм'),
			'пр.накл., сег.вр., 1л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[34], '', 'съм'),
			'пр.накл., сег.вр., 1л., мн.ч.'        => self::buildDerivForm(@$forms[36], '', 'сме'),
			'пр.накл., сег.вр., 2л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[29], '', 'си'),
			'пр.накл., сег.вр., 2л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[32], '', 'си'),
			'пр.накл., сег.вр., 2л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[34], '', 'си'),
			'пр.накл., сег.вр., 2л., мн.ч.'        => self::buildDerivForm(@$forms[36], '', 'сте'),
			'пр.накл., сег.вр., 3л., ед.ч., м.р.'  => array_merge(
				self::buildDerivForm(@$forms[29]),
				self::buildDerivForm(@$forms[29], '', 'е')
			),
			'пр.накл., сег.вр., 3л., ед.ч., ж.р.'  => array_merge(
				self::buildDerivForm(@$forms[32]),
				self::buildDerivForm(@$forms[32], '', 'е')
			),
			'пр.накл., сег.вр., 3л., ед.ч., ср.р.' => array_merge(
				self::buildDerivForm(@$forms[34]),
				self::buildDerivForm(@$forms[34], '', 'е')
			),
			'пр.накл., сег.вр., 3л., мн.ч.'        => array_merge(
				self::buildDerivForm(@$forms[36]),
				self::buildDerivForm(@$forms[36], '', 'са')
			),

			'пр.накл., мин.св.вр., 1л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[20], '', 'съм'),
			'пр.накл., мин.св.вр., 1л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[23], '', 'съм'),
			'пр.накл., мин.св.вр., 1л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[25], '', 'съм'),
			'пр.накл., мин.св.вр., 1л., мн.ч.'        => self::buildDerivForm(@$forms[27], '', 'сме'),
			'пр.накл., мин.св.вр., 2л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[20], '', 'си'),
			'пр.накл., мин.св.вр., 2л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[23], '', 'си'),
			'пр.накл., мин.св.вр., 2л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[25], '', 'си'),
			'пр.накл., мин.св.вр., 2л., мн.ч.'        => self::buildDerivForm(@$forms[27], '', 'сте'),
			'пр.накл., мин.св.вр., 3л., ед.ч., м.р.'  => array_merge(
				self::buildDerivForm(@$forms[20]),
				self::buildDerivForm(@$forms[20], '', 'е')
			),
			'пр.накл., мин.св.вр., 3л., ед.ч., ж.р.'  => array_merge(
				self::buildDerivForm(@$forms[23]),
				self::buildDerivForm(@$forms[23], '', 'е')
			),
			'пр.накл., мин.св.вр., 3л., ед.ч., ср.р.' => array_merge(
				self::buildDerivForm(@$forms[25]),
				self::buildDerivForm(@$forms[25], '', 'е')
			),
			'пр.накл., мин.св.вр., 3л., мн.ч.'        => array_merge(
				self::buildDerivForm(@$forms[27]),
				self::buildDerivForm(@$forms[27], '', 'са')
			),

			'пр.накл., мин.неопр.вр., 1л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[20], 'бил съм'),
			'пр.накл., мин.неопр.вр., 1л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[23], 'била съм'),
			'пр.накл., мин.неопр.вр., 1л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[25], 'било съм'),
			'пр.накл., мин.неопр.вр., 1л., мн.ч.'        => self::buildDerivForm(@$forms[27], 'били сме'),
			'пр.накл., мин.неопр.вр., 2л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[20], 'бил си'),
			'пр.накл., мин.неопр.вр., 2л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[23], 'била си'),
			'пр.накл., мин.неопр.вр., 2л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[25], 'било си'),
			'пр.накл., мин.неопр.вр., 2л., мн.ч.'        => self::buildDerivForm(@$forms[27], 'били сте'),
			'пр.накл., мин.неопр.вр., 3л., ед.ч., м.р.'  => array_merge(
				self::buildDerivForm(@$forms[20], 'бил'),
				self::buildDerivForm(@$forms[20], 'бил е')
			),
			'пр.накл., мин.неопр.вр., 3л., ед.ч., ж.р.'  => array_merge(
				self::buildDerivForm(@$forms[23], 'била'),
				self::buildDerivForm(@$forms[23], 'била е')
			),
			'пр.накл., мин.неопр.вр., 3л., ед.ч., ср.р.' => array_merge(
				self::buildDerivForm(@$forms[25], 'било'),
				self::buildDerivForm(@$forms[25], 'било е')
			),
			'пр.накл., мин.неопр.вр., 3л., мн.ч.'        => array_merge(
				self::buildDerivForm(@$forms[27], 'били'),
				self::buildDerivForm(@$forms[27], 'били са')
			),

			'пр.накл., бъд.вр., 1л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[0], 'щял съм да'),
			'пр.накл., бъд.вр., 1л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[0], 'щяла съм да'),
			'пр.накл., бъд.вр., 1л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[0], 'щяло съм да'),
			'пр.накл., бъд.вр., 1л., мн.ч.'        => self::buildDerivForm(@$forms[3], 'щели сме да'),
			'пр.накл., бъд.вр., 2л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[1], 'щял си да'),
			'пр.накл., бъд.вр., 2л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[1], 'щяла си да'),
			'пр.накл., бъд.вр., 2л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[1], 'щяло си да'),
			'пр.накл., бъд.вр., 2л., мн.ч.'        => self::buildDerivForm(@$forms[4], 'щели сте да'),
			'пр.накл., бъд.вр., 3л., ед.ч., м.р.'  => array_merge(
				self::buildDerivForm(@$forms[2], 'щял да'),
				self::buildDerivForm(@$forms[2], 'щял е да')
			),
			'пр.накл., бъд.вр., 3л., ед.ч., ж.р.'  => array_merge(
				self::buildDerivForm(@$forms[2], 'щяла да'),
				self::buildDerivForm(@$forms[2], 'щяла е да')
			),
			'пр.накл., бъд.вр., 3л., ед.ч., ср.р.' => array_merge(
				self::buildDerivForm(@$forms[2], 'щяло да'),
				self::buildDerivForm(@$forms[2], 'щяло е да')
			),
			'пр.накл., бъд.вр., 3л., мн.ч.'        => array_merge(
				self::buildDerivForm(@$forms[5], 'щели да'),
				self::buildDerivForm(@$forms[5], 'щели са да')
			),

			'пр.накл., бъд.пред.вр., 1л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[20], 'щял съм да съм'),
			'пр.накл., бъд.пред.вр., 1л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[23], 'щяла съм да съм'),
			'пр.накл., бъд.пред.вр., 1л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[25], 'щяло съм да съм'),
			'пр.накл., бъд.пред.вр., 1л., мн.ч.'        => self::buildDerivForm(@$forms[27], 'щели сме да сме'),
			'пр.накл., бъд.пред.вр., 2л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[20], 'щял си да си'),
			'пр.накл., бъд.пред.вр., 2л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[23], 'щяла си да си'),
			'пр.накл., бъд.пред.вр., 2л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[25], 'щяло си да си'),
			'пр.накл., бъд.пред.вр., 2л., мн.ч.'        => self::buildDerivForm(@$forms[27], 'щели сте да сте'),
			'пр.накл., бъд.пред.вр., 3л., ед.ч., м.р.'  => array_merge(
				self::buildDerivForm(@$forms[20], 'щял да е'),
				self::buildDerivForm(@$forms[20], 'щял е да е')
			),
			'пр.накл., бъд.пред.вр., 3л., ед.ч., ж.р.'  => array_merge(
				self::buildDerivForm(@$forms[23], 'щяла да е'),
				self::buildDerivForm(@$forms[23], 'щяла е да е')
			),
			'пр.накл., бъд.пред.вр., 3л., ед.ч., ср.р.' => array_merge(
				self::buildDerivForm(@$forms[25], 'щяло да е'),
				self::buildDerivForm(@$forms[25], 'щяло е да е')
			),
			'пр.накл., бъд.пред.вр., 3л., мн.ч.'        => array_merge(
				self::buildDerivForm(@$forms[27], 'щели да са'),
				self::buildDerivForm(@$forms[27], 'щели са да са')
			),

			'условно наклонение, 1л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[20], 'бих'),
			'условно наклонение, 1л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[23], 'бих'),
			'условно наклонение, 1л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[25], 'бих'),
			'условно наклонение, 1л., мн.ч.'        => self::buildDerivForm(@$forms[27], 'бихме'),
			'условно наклонение, 2л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[20], 'би'),
			'условно наклонение, 2л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[23], 'би'),
			'условно наклонение, 2л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[25], 'би'),
			'условно наклонение, 2л., мн.ч.'        => self::buildDerivForm(@$forms[27], 'бихте'),
			'условно наклонение, 3л., ед.ч., м.р.'  => self::buildDerivForm(@$forms[20], 'би'),
			'условно наклонение, 3л., ед.ч., ж.р.'  => self::buildDerivForm(@$forms[23], 'би'),
			'условно наклонение, 3л., ед.ч., ср.р.' => self::buildDerivForm(@$forms[25], 'би'),
			'условно наклонение, 3л., мн.ч.'        => self::buildDerivForm(@$forms[27], 'биха'),

			'повелително наклонение, ед.ч.' => @$forms[18],
			'повелително наклонение, мн.ч.' => @$forms[19],

			'мин.страд.прич. м.р.'              => @$forms[38],
			'мин.страд.прич. м.р. непълен член' => @$forms[39],
			'мин.страд.прич. м.р. пълен член'   => @$forms[40],
			'мин.страд.прич. ж.р.'              => @$forms[41],
			'мин.страд.прич. ж.р. членувано'    => @$forms[42],
			'мин.страд.прич. ср.р.'             => @$forms[43],
			'мин.страд.прич. ср.р. членувано'   => @$forms[44],
			'мин.страд.прич. мн.ч.'             => @$forms[45],
			'мин.страд.прич. мн.ч. членувано'   => @$forms[46],

			'мин.деят.св.прич. м.р.'              => @$forms[20],
			'мин.деят.св.прич. м.р. непълен член' => @$forms[21],
			'мин.деят.св.прич. м.р. пълен член'   => @$forms[22],
			'мин.деят.св.прич. ж.р.'              => @$forms[23],
			'мин.деят.св.прич. ж.р. членувано'    => @$forms[24],
			'мин.деят.св.прич. ср.р.'             => @$forms[25],
			'мин.деят.св.прич. ср.р. членувано'   => @$forms[26],
			'мин.деят.св.прич. мн.ч.'             => @$forms[27],
			'мин.деят.св.прич. мн.ч. членувано'   => @$forms[28],

			'мин.деят.несв.прич. м.р.'              => @$forms[29],
			'мин.деят.несв.прич. м.р. непълен член' => @$forms[30],
			'мин.деят.несв.прич. м.р. пълен член'   => @$forms[31],
			'мин.деят.несв.прич. ж.р.'              => @$forms[32],
			'мин.деят.несв.прич. ж.р. членувано'    => @$forms[33],
			'мин.деят.несв.прич. ср.р.'             => @$forms[34],
			'мин.деят.несв.прич. ср.р. членувано'   => @$forms[35],
			'мин.деят.несв.прич. мн.ч.'             => @$forms[36],
			'мин.деят.несв.прич. мн.ч. членувано'   => @$forms[37],

			'сег.деят.прич. м.р.'              => @$forms[47],
			'сег.деят.прич. м.р. непълен член' => @$forms[48],
			'сег.деят.прич. м.р. пълен член'   => @$forms[49],
			'сег.деят.прич. ж.р.'              => @$forms[50],
			'сег.деят.прич. ж.р. членувано'    => @$forms[51],
			'сег.деят.прич. ср.р.'             => @$forms[52],
			'сег.деят.прич. ср.р. членувано'   => @$forms[53],
			'сег.деят.прич. мн.ч.'             => @$forms[54],
			'сег.деят.прич. мн.ч. членувано'   => @$forms[55],

			'деепричастие' => @$forms[56],
		);
	}


	static private function fillPronPersonalForms($forms)
	{
		return array(
			'именителен падеж'               => @$forms[0],
			'винителен падеж'                => @$forms[1],
			'винителен падеж, кратка форма'  => @$forms[2],
			'дателен падеж'                  => @$forms[3],
			'дателен падеж, предложна форма' => @$forms[4],
			'дателен падеж, кратка форма'    => @$forms[5],
		);
	}

	static private function fillPronDemonstrativeForms($forms)
	{
		return array(
			'м.р., ед.ч.'               => @$forms[0],
			'м.р., ед.ч., непълен член' => @$forms[1],
			'м.р., ед.ч., пълен член'   => @$forms[2],
			'ж.р., ед.ч.'               => @$forms[3],
			'ж.р., ед.ч., членувано'    => @$forms[4],
			'ср.р., ед.ч.'              => @$forms[5],
			'ср.р., ед.ч., членувано'   => @$forms[6],
			'мн.ч.'                     => @$forms[7],
			'мн.ч., членувано'          => @$forms[8],
		);
	}

	static private function fillPronPossessiveForms($forms)
	{
		return array(
			'м.р., ед.ч.'               => @$forms[0],
			'м.р., ед.ч., непълен член' => @$forms[1],
			'м.р., ед.ч., пълен член'   => @$forms[2],
			'ж.р., ед.ч.'               => @$forms[3],
			'ж.р., ед.ч., членувано'    => @$forms[4],
			'ср.р., ед.ч.'              => @$forms[5],
			'ср.р., ед.ч., членувано'   => @$forms[6],
			'мн.ч.'                     => @$forms[7],
			'мн.ч., членувано'          => @$forms[8],
			'кратка форма'              => @$forms[9],
		);
	}

	static private function fillPronInterrogativeForms($forms)
	{
		return array(
			'м.р., ед.ч.'                    => @$forms[0],
			'винителен падеж'                => @$forms[1],
			'дателен падеж'                  => @$forms[2],
			'дателен падеж, предложна форма' => @$forms[3],
			'ж.р., ед.ч.'                    => @$forms[4],
			'ср.р., ед.ч.'                   => @$forms[5],
			'мн.ч.'                          => @$forms[6],
		);
	}

	static private function fillPronRelativeForms($forms)
	{
		return array(
			'м.р., ед.ч.'                    => @$forms[0],
			'винителен падеж'                => @$forms[1],
			'дателен падеж'                  => @$forms[2],
			'дателен падеж, предложна форма' => @$forms[3],
			'ж.р., ед.ч.'                    => @$forms[4],
			'ср.р., ед.ч.'                   => @$forms[5],
			'мн.ч.'                          => @$forms[6],
		);
	}

	static private function fillPronIndefiniteForms($forms)
	{
		return array(
			'м.р., ед.ч.'                    => @$forms[0],
			'винителен падеж'                => @$forms[1],
			'дателен падеж'                  => @$forms[2],
			'дателен падеж, предложна форма' => @$forms[3],
			'ж.р., ед.ч.'                    => @$forms[4],
			'ср.р., ед.ч.'                   => @$forms[5],
			'мн.ч.'                          => @$forms[6],
		);
	}

	static private function fillPronNegativeForms($forms)
	{
		return array(
			'м.р., ед.ч.'                    => @$forms[0],
			'винителен падеж'                => @$forms[1],
			'дателен падеж'                  => @$forms[2],
			'дателен падеж, предложна форма' => @$forms[3],
			'ж.р., ед.ч.'                    => @$forms[4],
			'ср.р., ед.ч.'                   => @$forms[5],
			'мн.ч.'                          => @$forms[6],
		);
	}

	static private function fillPronGeneralForms($forms)
	{
		return array(
			'м.р., ед.ч.'                    => @$forms[0],
			'м.р., ед.ч., непълен член'      => @$forms[1],
			'м.р., ед.ч., пълен член'        => @$forms[2],
			'винителен падеж'                => @$forms[3],
			'дателен падеж'                  => @$forms[4],
			'дателен падеж, предложна форма' => @$forms[5],
			'ж.р., ед.ч.'                    => @$forms[6],
			'ж.р., ед.ч., членувано'         => @$forms[7],
			'ср.р., ед.ч.'                   => @$forms[8],
			'ср.р., ед.ч., членувано'        => @$forms[9],
			'мн.ч.'                          => @$forms[10],
			'мн.ч., членувано'               => @$forms[11],
		);
	}

	static private function fillNumCardinalForms($forms)
	{
		return array(
			'м.р., ед.ч.'                   => @$forms[0],
			'м.р., ед.ч., непълен член'     => @$forms[1],
			'м.р., ед.ч., пълен член'       => @$forms[2],
			'ж.р., ед.ч.'                   => @$forms[3],
			'ж.р., ед.ч., членувано'        => @$forms[4],
			'ср.р., ед.ч.'                  => @$forms[5],
			'ср.р., ед.ч., членувано'       => @$forms[6],
			'мн.ч.'                         => @$forms[7],
			'мн.ч., членувано'              => @$forms[8],
			'бройна форма'                  => @$forms[9],
			'м.р., мн.ч.'                   => @$forms[10],
			'м.р., мн.ч., членувано'        => @$forms[11],
			'ж.р., мн.ч.'                   => @$forms[12],
			'ж.р., мн.ч., членувано'        => @$forms[13],
			'ср.р., мн.ч.'                  => @$forms[14],
			'ср.р., мн.ч., членувано'       => @$forms[15],
			'мъжколична форма'              => @$forms[16],
			'мъжколична форма, членувано'   => @$forms[17],
			'приблизителен брой'            => @$forms[18],
			'приблизителен брой, членувано' => @$forms[19],
		);
	}

	static private function fillNumOrdinalForms($forms)
	{
		return array(
			'м.р., ед.ч.'               => @$forms[0],
			'м.р., ед.ч., непълен член' => @$forms[1],
			'м.р., ед.ч., пълен член'   => @$forms[2],
			'ж.р., ед.ч.'               => @$forms[3],
			'ж.р., ед.ч., членувано'    => @$forms[4],
			'ср.р., ед.ч.'              => @$forms[5],
			'ср.р., ед.ч., членувано'   => @$forms[6],
			'мн.ч.'                     => @$forms[7],
			'мн.ч., членувано'          => @$forms[8],
		);
	}

	static private function fillNamePeopleFamilyForms($forms)
	{
		return array(
			'мъжка форма'  => @$forms[0],
			'женска форма' => @$forms[1],
		);
	}

	static private function fillNamePeopleNameForms($forms)
	{
		return array(
			'мъжка форма'  => @$forms[0],
			'женска форма' => @$forms[1],
		);
	}

}
