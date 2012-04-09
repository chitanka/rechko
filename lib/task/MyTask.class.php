<?php

class MyTask extends sfBaseTask
{
	protected $dataTypes = array(
		/*'noun_male' => array(
			1,
			2,
			'2a',
			3,
			4,
			5,
			6,
			7,
			'7a',
			'7b',
			8,
			'8a',
			9,
			'9a',
			10,
			11,
			12,
			13,
			14,
			'14a',
			15,
			16,
			17,
			18,
			'18a',
			19,
			'19a',
			20,
			21,
			22,
			23,
			24,
			'24a',
			25,
			26,
			27,
			28,
			'28a',
			29,
			30,
			31,
			'31a',
			32,
			'32a',
			33,
			34,
			35,
			'35a',
			36,
			37,
			38,
			39,
			40,
			'40a',
		),
		'noun_female' => array(
			41,
			'41a',
			'41b',
			42,
			'42a',
			43,
			'43a',
			44,
			45,
			46,
			47,
			48,
			49,
			50,
			51,
			52,
			'52a',
			53,
		),
		'noun_neutral' => array(
			54,
			55,
			56,
			57,
			'57a',
			58,
			59,
			60,
			61,
			62,
			63,
			64,
			65,
			66,
			67,
			68,
			69,
			70,
			71,
			72,
			73,
		),
		'noun_plurale-tantum' => array(
			74,
			75,
		),
		'adjective' => array(
			76,
			77,
			78,
			79,
			80,
			81,
			82,
			'82a',
			83,
			84,
			'84a',
			85,
			86,
			87,
			88,
			89,
			'89a',
		),*/
/*		'pronominal_personal' => array(
			90,
			91,
			92,
			93,
			94,
			95,
			96,
			97,
		),
		'pronominal_demonstrative' => array(
			98,
			99,
			100,
			101,
			102,
			103,
			104,
			105,
		),
		'pronominal_possessive' => array(
			106,
			107,
			108,
			109,
			110,
			111,
			112,
			113,
		),
		'pronominal_interrogative' => array(
			114,
			115,
			116,
			117,
		),
		'pronominal_relative' => array(
			118,
			119,
			120,
		),
		'pronominal_indefinite' => array(
			121,
			122,
			123,
		),
		'pronominal_negative' => array(
			124,
			125,
			126,
		),
		'pronominal_general' => array(
			127,
			128,
			129,
			130,
		),
		'numeral_cardinal' => array(
			131,
			132,
			133,
			'134a',
			134,
			135,
			136,
			'137a',
			137,
			138,
			139,
		),
		'numeral_ordinal' => array(
			140,
			141,
		),*/
/*		'verb' => array(
			142,
			143,
			144,
			145,
			'145a',
			'145b',
			146,
			'146a',
			147,
			148,
			149,
			150,
			'150a',
			151,
			152,
			'152a',
			153,
			154,
			155,
			156,
			157,
			158,
			159,
			160,
			'160a',
			161,
			'161a',
			162,
			163,
			164,
			165,
			166,
			167,
			168,
			169,
			170,
			171,
			172,
			173,
			174,
			175,
			176,
			177,
			'177a',
			178,
			179,
			180,
			181,
			182,
			'182a',
			183,
			184,
			185,
			186,
			'186a',
			187,
		),*/
/*		'adverb' => array(
			188,
		),
		'conjunction' => array(
			189,
		),
		'interjection' => array(
			190,
		),
		'particle' => array(
			191,
		),
		'preposition' => array(
			192,
		),
		'name_month' => array(
			193,
		),
		'name_bg-various' => array(
			194,
		),
		'name_bg-place' => array(
			195,
		),
		'name_country' => array(
			196,
		),
		'name_capital' => array(
			197,
		),
		'name_city' => array(
			198,
		),
		'name_various' => array(
			199,
		),
		'name_popular' => array(
			200,
		),*/
		'name_people_family' => array(
			201,
			202,
			203,
			204,
		),
		'name_people_name' => array(
			205,
			206,
			207,
		),
	);


	protected
		$idi_latin = array(5, 18, 63, 128),
		$idi_male_first = 0,
		$idi_male_last = 82,
		$idi_female_first = 83,
		$idi_female_last = 111,
		$idi_neutral_first = 112,
		$idi_neutral_last = 138,
		$idi_adjective_first = 139,
		$idi_adjective_last = 166,
		$idi_verb_first = 224,
		$idi_verb_last = 444;


	protected function configure()
	{
		// // add your own arguments here
		// $this->addArguments(array(
		//   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
		// ));

		$this->addOptions(array(
			new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
			new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
			new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
			// add your own options here
		));

		$this->namespace        = '';
		$this->name             = 'my';
		$this->briefDescription = '';
		$this->detailedDescription = <<<EOF
The [my|INFO] task does things.
Call it with:

  [php symfony my|INFO]
EOF;
	}

	protected function execute($arguments = array(), $options = array())
	{
		// initialize the database connection
		$databaseManager = new sfDatabaseManager($this->configuration);
		$connection = $databaseManager->getDatabase($options['connection'])->getConnection();

		mb_internal_encoding('utf-8');

		//$this->createWords();
		//$this->addMeaningsFromEurodict();
		//$this->addMeaningsFromOnrechnik();
		//$this->eliminateExistingSourcesByOnrechnik();
		//$this->addSynonyms();
		//$this->addIncorrectForms();
		//$this->fixMeanings();
		//$this->fixSynonyms();
		//$this->getDoubleIdiWords();
		//$this->checkIdiWords();
		//$this->splitIdiWords();
		//$this->importIdiWords();
		//$this->importIdiExtraWords();
		//echo $this->genWordTypeProdUpdate();
		//$this->repairWords();
		//$this->updateFromMeanings();
		//$this->printNonStressed();
		//$this->updateNonStressed();
		//$this->getDoubleIncorrectForms();
		//$this->getInvalidIncorrectForms();
		//$this->addExtraIncorrectForms();

		//$this->addCondensedName('Word');
		//$this->addCondensedName('DerivativeForm');

		$this->checkWordsFromTranslations('bg_en');
	}

	protected function createWords()
	{
		foreach ($this->dataTypes as $dataType => $subTypes) {
			$this->log(sprintf('Обработка на вид %s', $dataType));
			foreach ($subTypes as $subType) {
				$this->log(array(sprintf('Обработка на тип %s', $subType), str_repeat('=', 60)));

				$file = DerivativeFormsGenerator::getDataFile($dataType, $subType);
				$rules = DerivativeFormsGenerator::extractRulesFromDataFile($file);
				$words = DerivativeFormsGenerator::extractWordsFromDataFile($file);

				foreach ($words as $wordPlain) {
					$this->log(sprintf('Съхраняване на %s', $wordPlain));
					$this->createWord($rules, $wordPlain, $dataType, $subType);
				}
			}
		}
	}

	protected function createWord($rules, $name, $speechPart, $subType)
	{
		if ( Doctrine_Core::getTable('Word')->exists($name, $subType) ) {
			return;
		}

		$word = new Word;
		$type = Doctrine_Core::getTable('WordType')->findOneBy('name', $subType);

		$word->fromArray(array(
			'name' => $name,
			'type_id' => $type->id,
			'source' => 'bgoffice',
		));

		$word->fillDerivativeForms(DerivativeFormsGenerator::computeDerivativeForms($word, $rules));
		$word->save();
		$word->free(true);
	}


	protected function addMeaningsFromEurodict()
	{
		$dir = sfConfig::get('sf_data_dir') . '/raw/entries/eurodict';
		$ndir = sfConfig::get('sf_data_dir') . '/raw/new_entries/eurodict';
		$odir = $dir;
		$table = Doctrine_Core::getTable('Word');

		$dh  = opendir($dir);
		while (false !== ($file = readdir($dh))) {
			if ($file[0] == '.') {
				continue;
			}

			$name = str_replace('_', '', $file);

// 			if ( ! $table->exists($name) ) {
// 				echo "$name не съществува.\n";
// 				rename("$dir/$file", "$ndir/$file");
// 				continue;
// 			}

			$nameStressed = str_replace('_', '`', $file);
			$meaning = trim(file_get_contents("$dir/$file"));
			$meaning = preg_replace('/__([^_\s]+)__/', '[[$1]]', $meaning);


// 			// възвратни глаголи
// 			if ( preg_match('/(.+) се/u', $name, $match) ) {
// 				$word = $table->findOneBy('name', $match[1]);
// 				if ( ! $word ) {
// 					continue;
// 				}
// 				$this->log(sprintf('Съхраняване на значение на %s', $nameStressed));
//
// 				if ($word['meaning'] != '') {
// 					$nword = $word->copy();
// 					$nword['name'] = $name;
// 					$nword['meaning'] = $meaning;
// 					$nword['classification'] = '+reflexive';
// 					$nword['name_stressed'] = $nameStressed;
// 					$nword->save();
// 					$nword->free(true);
// 				} else {
// 					$word['meaning'] = $meaning;
// 					$word['classification'] = 'reflexive';
// 					$word['name_stressed'] = $nameStressed;
// 					$word['source'] = 'eurodict';
// 					$word->save();
// 					$word->free(true);
// 				}
//
// 				rename("$dir/$file", "$odir/$file");
// 			}
// 			continue;

			$this->log(sprintf('Съхраняване на значение на %s', $nameStressed));


// 			$word = new Word;
// 			$word['name'] = $name;
// 			$word['meaning'] = $meaning;
// 			$word['name_stressed'] = $nameStressed;
// 			$word['source'] = 'eurodict';
// 			$word['type_id'] = 398; // other
// 			$word->save();
// 			$word->free(true);
// 			rename("$dir/$file", "$odir/$file");


			$table->createQuery()->update()
				->set('meaning', '?', $meaning)
				->set('name_stressed', '?', $nameStressed)
				->set('source', '?', 'eurodict')
				->where('name = ?', $name)
				->execute();
		}
	}


	protected function addMeaningsFromOnrechnik()
	{
		$dir = sfConfig::get('sf_data_dir') . '/raw/new_entries/onlinerechnik';
		$odir = sfConfig::get('sf_data_dir') . '/raw/entries/onlinerechnik';
		$table = Doctrine_Core::getTable('Word');

		$dh  = opendir($dir);
		while (false !== ($file = readdir($dh))) {
			if ($file[0] == '.') { continue; }

			$nameStressed = str_replace('_', '`', $file);
			$name = str_replace('_', '', $file);
			$meaning = trim(file_get_contents("$dir/$file"));
			$meaning = preg_replace('/__([^_\s]+)__/', '[[$1]]', $meaning);

			$this->log(sprintf('Съхраняване на значение на %s', $nameStressed));

			#if ( $table->exists($name) ) {
				$table->createQuery()->update()
					->set('meaning', '?', $meaning)
					->set('name_stressed', '?', $nameStressed)
					->set('source', '?', 'onlinerechnik')
					->where('name = ? AND source = "idi" AND (type_id < 278 OR type_id > 292)', $name)
					->execute();
/*			} else {
				$word = new Word;
				$word->fromArray(array(
					'name'          => $name,
					'meaning'       => $meaning,
					'name_stressed' => $nameStressed,
					'source'        => 'onlinerechnik',
					'type_id'       => 398, // other
				));
				$word->save();
				$word->free(true);*/
			#}

			rename("$dir/$file", "$odir/$file");
		}
	}


	protected function clearMeaningForComparison($meaning)
	{
		$meaning = mb_strtolower($meaning);
		$meaning = preg_replace('/[^а-я]/u', '', $meaning);

		return $meaning;
	}


	protected function eliminateExistingSourcesByOnrechnik()
	{
		$dir = sfConfig::get('sf_data_dir') . '/raw/new_entries/onlinerechnik';
		$odir = sfConfig::get('sf_data_dir') . '/raw/entries/onlinerechnik';
		$table = Doctrine_Core::getTable('Word');

		$dh  = opendir($dir);
		while (false !== ($file = readdir($dh))) {
			if ($file[0] == '.') { continue; }

			$name = str_replace('_', '', $file);

			$collection = $table->findByName($name);
			if ($collection->count()) {
				$meaning = $this->clearMeaningForComparison(file_get_contents("$dir/$file"));
				foreach ($collection as $word) {
					if ( $this->clearMeaningForComparison($word['meaning']) == $meaning ) {
						$this->log(sprintf('„%s“ вече я има в речника със същото значение.', $name));
						if ( empty($word['name_stressed']) ) {
							$word['name_stressed'] = str_replace('_', '`', $file);
							$word->save();
						}
						rename("$dir/$file", "$odir/$file");
					}
				}
			}
		}
	}


	protected function addSynonyms()
	{
		$dir = sfConfig::get('sf_data_dir') . '/raw/thesaurus';
		$table = Doctrine_Core::getTable('Word');

		foreach (scandir($dir) as $file) {
			if ($file[0] == '.') {
				continue;
			}

			foreach ($this->extractSynonyms("$dir/$file") as $word => $synonyms) {
				$this->log(sprintf('Съхраняване на синоними на %s', $word));

				$table->createQuery()->update()
					->set('synonyms', '?', implode("\n", $synonyms))
					->where('name = ? AND (type_id < 278 OR type_id > 292)', $word)
					->execute();
			}
		}
	}

	protected function extractSynonyms($file)
	{
		$synonyms = array();
		$currentWord = '';
		foreach (file($file) as $line) {
			$line = trim($line);
			if ($line == '') {
				continue;
			}
			if ($line[0] == '(') {
				$synonyms[$currentWord][] = $line;
			} else {
				$currentWord = $line;
			}
		}

		return $synonyms;
	}

	protected function addIncorrectForms()
	{
		$table = Doctrine_Core::getTable('Word');
		$maxId = $table->getMaxId();

		for ($i = 1; $i <= $maxId; $i++) {
			$word = $table->find($i);
			#$word = $table->findOneBy('name', 'уринирам');

			if ( ! $word) {
				continue;
			}

			if ( $word['name_stressed'] == '' ) {
				$word['name_stressed'] = $word['name'];
			}

			if (count($word->IncorrectForms) == 0) {
				$this->log(sprintf('Съхраняване на грешни изписвания на %s', $word['name']));
				$word->updateIncorrectForms();
				$word->save();
			}

			$word->free(true);
		}
	}


	protected function addExtraIncorrectForms()
	{
		$table = Doctrine_Core::getTable('Word');
		$maxId = $table->getMaxId();

		for ($i = 1; $i <= $maxId; $i++) {
			$word = $table->find($i);

			if ( ! $word) { continue; }

			$forms = IncorrectFormsGenerator::getIncorrectForms($word['name_stressed']);
			if ( count($forms) > 50 ) {
				$word->free(true);
				continue;
			}

			$oldForms = array();
			foreach ($word->IncorrectForms->toArray() as $form) {
				$oldForms[] = $form['name'];
			}

			$newForms = array_diff($forms, $oldForms);
			if ( count($newForms) == 0 ) {
				$word->free(true);
				continue;
			}

			foreach ($newForms as $newForm) {
				$word->addIncorrectForm($newForm, false);
			}

			$this->log(sprintf('Съхраняване на нови грешни изписвания при %s', $word['name']));
			print_r($newForms);
			$word->save();

			$word->free(true);
		}
	}


	protected function fixMeanings()
	{
		$table = Doctrine_Core::getTable('Word');
		$maxId = $table->getMaxId();

		for ($i = 1; $i <= $maxId; $i++) {
			$word = $table->find($i);
			if ( ! $word) { continue; }

			$meaning = $word['meaning'];
			$meaning = strtr($meaning, array(
// 				' – ' => ' — ',
// 				'<br />' => "\n",
// 				'ѝ' => 'и`',
//				',]]' => ']],',
				'[[.]]' => '.',
			));
// 			$meaning = preg_replace('/ — __([^_]+)__\./', "\n__$1.__ —", $meaning);
// 			$meaning = preg_replace('/ — __([^_]+)__/', "\n__$1__ —", $meaning);
// 			$meaning = preg_replace('/ • __([^_]+)__\./', "\n* _$1._ —", $meaning);
// 			$meaning = preg_replace('/ • __([^_]+)__/', "\n* _$1_ —", $meaning);

			if ( $word['meaning'] != $meaning ) {
				$this->log(sprintf('Преработка на значението на %s', $word['name']));
				$word['meaning'] = $meaning;
				$word->save();
			}

			$word->free(true);
		}
	}


	protected function fixSynonyms()
	{
		$table = Doctrine_Core::getTable('Word');
		$maxId = $table->getMaxId();

		for ($i = 1; $i <= $maxId; $i++) {
			$word = $table->find($i);
			if ( ! $word || empty($word['synonyms']) ) { continue; }

			$repl = '';
			list($type) = explode('_', $word['Type']['speech_part']);
			switch ($type) {
				case 'noun': $repl = 'същ.'; break;
				case 'adjective': $repl = 'прил.'; break;
				case 'verb': $repl = 'гл.'; break;
				case 'preposition': $repl = 'предл.'; break;
				case 'conjunction': $repl = 'съюз'; break;
				case 'particle': $repl = 'частица'; break;
				case 'interjection': $repl = 'межд.'; break;
				case 'adverb': $repl = 'нар.'; break;
			}
			if ( ! empty($repl) ) {
				$this->log(sprintf('Преработка на синонимите на %s', $word['name']));
				$word['synonyms'] = str_replace("($repl) ", '', $word['synonyms']);
				$word->save();
			}

			$word->free(true);
		}
	}


	protected function updateFromMeanings()
	{
		$table = Doctrine_Core::getTable('Word');
		$maxId = $table->getMaxId();

		for ($i = 1; $i <= $maxId; $i++) {
			$word = $table->find($i);
			if ( ! $word ) { continue; }

			$linked = $this->extractLinked($word['meaning']);
			if (empty($linked)) {
				$word->free(true);
				continue;
			}

			foreach ($linked as $wlinked) {
				$wname = MyI18nToolkit::removeAccent($wlinked);
				if ($wname == $word['name']) {
					$this->log(sprintf('!!!!!! Автовръзка при %s', $word['name']));
					continue;
				}

				$lword = $table->findOneBy('name', $wname);
				$meaning = sprintf('+вж. [[%s]]', $word['name_stressed']);
				if ($lword) {
					if ( empty($lword['meaning']) ) {
						$lword['meaning'] = $meaning;
					}
					if ($wlinked != $wname && $lword['name_stressed'] != $wlinked) {
						$lword['name_stressed'] = $wlinked;
						$lword->updateIncorrectForms(true);
					}
					$this->log(sprintf('Обновяване на %s (от %s)', $wlinked, $word['name']));
					$lword->save();
					$lword->free(true);
				} else {
					$this->log(sprintf('=== Непозната дума: %s %s', $wlinked, $word['name_stressed']));
				}
			}
			$word->free(true);
		}
	}


	protected function extractLinked($meaning)
	{
		$linked = array();

		if (strpos($meaning, '+вж.') === 0) {
			return $linked;
		}

		if (preg_match_all('/\[\[([^]]+)\]\]/', $meaning, $matches)) {
			$linked = $matches[1];
		}

		return $linked;
	}


	protected function printNonStressed()
	{
		$table = Doctrine_Core::getTable('Word');
		$maxId = $table->getMaxId();

		$words = array();
		for ($i = 1; $i <= $maxId; $i++) {
			$word = $table->find($i);
			if ($word && $word->isMissingStress()) {
				$words[] = $word['name'] .','. $word['id'];
				$word->free(true);
			}
		}

		echo implode("\n", $words);
	}


	protected function updateNonStressed()
	{
		$file = sfConfig::get('sf_root_dir') . '/temp/stressed_words';
		$words = unserialize(file_get_contents($file));
		$table = Doctrine_Core::getTable('Word');

		foreach ($words as $id => $stressedName) {
			$this->log(sprintf('Запис на ударение: %s', $stressedName));
			$word = $table->find($id);
			$word['name_stressed'] = $stressedName;
			$word->updateIncorrectForms(true);
			$word->save();
			$word->free(true);
		}
	}


	protected function getDoubleIdiWords()
	{
		$orig_file = sfConfig::get('sf_root_dir') . '/temp/idi_words';
		$data = array();
		foreach (file($orig_file) as $line) {
			if ( strpos($line, ' ') !== false ) {
				list($form, $base, $rang, $type) = explode(' ', rtrim($line));
				$data[$base][$rang][] = $form;
			}
		}

		foreach ($data as $word => $rangs) {
			if (count($rangs) == 2) {
				$rang1 = array_shift($rangs);
				$rang2 = array_shift($rangs);
				sort($rang1);
				sort($rang2);
				if ($rang1 != $rang2) {
					echo $word, ' = ', implode(', ', $rang1), "\n";
					echo $word, ' = ', implode(', ', $rang2), "\n";
				}
			} else if (count($rangs) > 2) {
				foreach ($rangs as $rang => $forms) {
					echo $word, ': ', $rang, ' - ', implode(', ', $forms), "\n";
				}
			}
		}
	}


	protected function splitIdiWords()
	{
		$orig_file = sfConfig::get('sf_root_dir') . '/temp/idi_words';
		$data = array();
		foreach (file($orig_file) as $line) {
			if ( strpos($line, ' ') !== false ) {
				$line = rtrim($line);
				list($form, $base, $rang, $type) = explode(' ', $line);
				$data[$rang][] = $line;
			}
		}

		$outDir = sfConfig::get('sf_data_dir') . '/idi';
		foreach ($data as $rang => $lines) {
			file_put_contents("$outDir/$rang", implode("\n", $lines));
		}
	}


	protected function checkIdiWords()
	{
		$table = Doctrine_Core::getTable('Word');
		$data_file = sfConfig::get('sf_root_dir') . '/temp/idi_words_flipped';
		$data = array();
		foreach (file($data_file) as $line) {
			list($base, $form) = explode(' ', rtrim($line));
			$data[$base][] = $form;
		}

		foreach ($data as $base => $forms) {
			$word = $table->findOneBy('name', $base);
			if ( ! $word || $word['name'] != $base) {
				continue;
			}

			$db_forms = $this->extractOneWordForms($word->DerivativeForms->toArray());
			if (empty($db_forms)) {
				$db_forms[] = $base;
			}
			sort($forms);
			sort($db_forms);

			if ($forms != $db_forms) {
				echo "\n", str_repeat('=', 70);
				echo "\n", 'Разлики при ', $base, "\n";
				$extra_new = array_diff($forms, $db_forms);
				$extra_old = array_diff($db_forms, $forms);
				if (count($extra_new)) {
					echo "\n", 'Нови форми:', "\n\t";
					echo implode("\n\t", $extra_new);
				}
				if (count($extra_old)) {
					echo "\n", 'Стари форми:', "\n\t";
					echo implode("\n\t", $extra_old);
				}
			}
			$word->free(true);
		}
	}


	protected function extractOneWordForms($forms)
	{
		$oforms = array();
		foreach ($forms as $form) {
			if ( $form['name'] != '—' && strpos($form['name'], ' ') === false ) {
				$oforms[] = $form['name'];
			}
		}

		return $oforms;
	}



	protected function importIdiWords()
	{
		$typeTable = Doctrine_Core::getTable('WordType');

		$data = $this->getValidIdiWords();
		foreach ($data as $idiNumber => $words) {
			$type = $typeTable->findOneBy('idi_number', $idiNumber);
			if ( ! $type ) {
				$this->log(sprintf('ГРЕШКА: %d не е валиден номер от IDI.', $idiNumber));
				continue;
			}

			$this->log(str_repeat('=', 60));
			$this->log(sprintf('Съхраняване на думи от тип %d.', $idiNumber));

			foreach ($words as $name => $forms) {
				$this->log(sprintf('Съхраняване на %s', $name));
				$word = new Word;
				$word->name = $name;
				$word->source = 'idi';
				$word->type_id = $type['id'];
				$word->fillDerivativeForms(DerivativeFormsGenerator::fillForms($word, $forms));
				$word->save();
				#print_r($word->toArray());
				$word->free(true);
			}
		}
	}


	protected function importIdiExtraWords()
	{
		$typeTable = Doctrine_Core::getTable('WordType');
		$wordTable = Doctrine_Core::getTable('Word');

		$data = $this->getValidIdiWords('to_insert', true);
		foreach ($data as $idiNumber => $words) {
			$type = $typeTable->findOneBy('idi_number', $idiNumber);
			if ( ! $type ) {
				$this->log(sprintf('ГРЕШКА: %d не е валиден номер от IDI.', $idiNumber));
				continue;
			}

			$this->log(str_repeat('=', 60));
			$this->log(sprintf('Съхраняване на думи от тип %s (%d).', $type['name'], $idiNumber));

			$typeId = $type['id'];
			foreach ($words as $name => $forms) {
				$word = $wordTable->findOneBy('name', $name);
				$this->log(sprintf('Съхраняване на %s.', $name));
				if ($word && $this->canChangeWordsType($word)) {
					$this->log(sprintf('%s съществува: тип %s.', $name, $word['Type']['name']));
				} else {
					$word = new Word;
					$word->name = $name;
					$word->source = 'idi';
				}
				$word->type_id = $typeId;
				$word->fillDerivativeForms(DerivativeFormsGenerator::fillForms($word, $forms));
				$word->save();
				$word->free(true);
			}
		}
	}

	protected function getValidIdiWords($file = null, $forceValid = false)
	{
		$file = sfConfig::get('sf_root_dir') . '/temp/'. ($file ? $file : 'idi_words');
		$data = array();
		foreach (file($file) as $line) {
			if ( strpos($line, ' ') !== false ) {
				$line = rtrim($line);
				list($form, $base, $type, $subtype) = explode(' ', $line);
				if ($forceValid || $this->isValidIdiType($type)) {
					$data[$type][$base][$subtype] = $form;
				}
			}
		}

		return $data;
	}


	protected function isValidIdiType($type)
	{
		return ! in_array($type, $this->idi_latin)
			#&& $type >= $this->idi_male_first && $type <= $this->idi_adjective_last;
			&& $type >= $this->idi_verb_first && $type <= $this->idi_verb_last;
	}


	protected function canChangeWordsType($word)
	{
		$type = (int) $word['Type']['name'];

		return $type == 500 || ($type >= 194 && $type <= 200);
	}


	protected function genWordTypeProdUpdate()
	{
		$types = Doctrine_Core::getTable('WordType')->findAll(Doctrine_Core::HYDRATE_ARRAY);
		$qs = array();
		foreach ($types as $type) {
			$qs[] = sprintf('UPDATE word_type SET name = "%s", speech_part = "%s", `comment` = "%s", rules = "%s", rules_test = "%s" WHERE idi_number = %d;',
				$type['name'],
				$type['speech_part'],
				$type['comment'],
				$type['rules'],
				$type['rules_test'],
				$type['idi_number']);
		}

		return implode("\n", $qs);
	}


	protected function repairWords()
	{
		$words = Doctrine_Core::getTable('Word')->createQuery('w')
			->leftJoin('w.DerivativeForms')
			->where('type_id = ?', 135 /*301*/)
			->execute();

		foreach ($words as $word) {
			if ( count($word['DerivativeForms']) == 0 ) {
				$this->log(sprintf('При %s няма форми.', $word['name']));
				$word->updateDerivativeForms();
				$word->save();
			}
		}
	}


	protected function getDoubleIncorrectForms()
	{
		$table = Doctrine_Core::getTable('Word');
		$maxId = $table->getMaxId();

		$doubles = array();

		for ($i = 1; $i <= $maxId; $i++) {
			$word = $table->find($i);
			if ( ! $word) { continue; }

			$curr = array();
			foreach ($word->IncorrectForms->toArray() as $form) {
				if ( isset($curr[$form['name']]) ) {
					$doubles[ $form['id'] ] = $form['name'];
					$this->log(sprintf('Двойна форма при %s: %s', $word['name'], $form['name']));
				} else {
					$curr[$form['name']] = true;
				}
			}

			$word->free(true);
		}

		echo implode("\n", array_keys($doubles));
	}


	protected function getInvalidIncorrectForms()
	{
		$table = Doctrine_Core::getTable('Word');
		$maxId = $table->getMaxId();

		$doubles = array();

		for ($i = 1; $i <= $maxId; $i++) {
			$word = $table->find($i);
			if ( ! $word) { continue; }

			if ( strpos($word['name_stressed'], 'я`') !== false) {

				$falseForm = str_replace('я`', 'ъ', $word['name_stressed']);

				foreach ($word->IncorrectForms->toArray() as $form) {
					if ( $form['name'] == $falseForm ) {
						$doubles[ $form['id'] ] = $form['name'];
						$this->log(sprintf('Невалидна форма при %s: %s', $word['name'], $form['name']));
					}
				}
			}

			$word->free(true);
		}

		echo implode("\n", array_keys($doubles));
	}


	protected function addCondensedName($model = 'Word')
	{
		$table = Doctrine_Core::getTable($model);
		$maxId = $table->getMaxId();

		for ($i = 1; $i <= $maxId; $i++) {
			if ($i % 100 == 0) {
				$this->log(sprintf('%s: до номер %d', date('Y-m-d H:i:s'), $i));
			}

			$word = $table->find($i);
			if ( ! $word) { continue; }

			$word->updateNameCondensed();
			$word->save();
			$word->free(true);
		}
	}


	protected function checkWordsFromTranslations($dict)
	{
		$dir = sfConfig::get('sf_data_dir') . '/raw/html/eurodict/' . $dict;
		$table = Doctrine_Core::getTable('Word');

		$dh  = opendir($dir);
		while (false !== ($file = readdir($dh))) {
			if ($file[0] == '.') {
				continue;
			}

			$contents = $this->normalizeRawTranslation(file_get_contents("$dir/$file"));
			$name = $this->getWordFromRawTranslation($contents);

			if ( ! $table->exists($name) ) {
				$this->log(sprintf('„%s“ не съществува (%s).', $name, $file));
			}
		}
	}


	protected function getWordFromRawTranslation($contents)
	{
		if (preg_match('|<span class="wordtitle">(.+)</span>|', $contents, $m)) {
			return trim(strtr($m[1], array(
				'`' => ''
			)));
		}

		return '';
	}


	protected function normalizeRawTranslation($contents)
	{
		$contents = strtr($contents, array(
			'&#0768;' => '`',
			'&#0768' => '`',
		));
		return $contents;
	}
}
