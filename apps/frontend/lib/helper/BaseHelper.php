<?php

/**
	Prepare a string to be used as a document title
*/
function prepare_document_title($title)
{
	$title = strtr($title, array(
		'<br />' => ' — ',
	));
	$title = strip_tags($title);
	$title = preg_replace('/&[^;]+;/', '', $title);

	return $title;
}

function format_meaning($meaning)
{
	$meaning = preg_replace('/#(\d+)/', '<b>$1.</b>', $meaning);
	$meaning = preg_replace('/__([^_]+)__/U', '<b>$1</b>', $meaning);
	$meaning = preg_replace('/_([^_]+)_/U', '<i>$1</i>', $meaning);

	$meaning = strtr($meaning, array(
		'+мн.' => '<abbr title="множествено число">мн.</abbr>',
		'+ед.' => '<abbr title="единствено число">ед.</abbr>',
		'+м.' => '<abbr title="мъжки род">м.</abbr>',
		'+ж.' => '<abbr title="женски род">ж.</abbr>',
		'+ср.' => '<abbr title="среден род">ср.</abbr>',
		'+мин. несв.' => '<abbr title="минало несвършено време">мин. несв.</abbr>',
		'+мин. св.' => '<abbr title="минало свършено време">мин. св.</abbr>',
		'+мин. прич.' => '<abbr title="минало причастие">мин. прич.</abbr>',
		'+несв.' => '<abbr title="несвършен вид">несв.</abbr>',
		'+св.' => '<abbr title="свършен вид">св.</abbr>',
		'+същ.' => '<abbr title="съществително име">същ.</abbr>',
		'+прил.' => '<abbr title="прилагателно име">прил.</abbr>',
		'+Прен.' => '<abbr title="В преносен смисъл">Прен.</abbr>',
		'+Пренебр.' => '<abbr title="Пренебрежително">Пренебр.</abbr>',
		'+Разг.' => '<abbr title="Разговорно">Разг.</abbr>',
		'+Спец.' => '<abbr title="Специализирано">Спец.</abbr>',
		'+вж.' => '<abbr title="виж">вж.</abbr>',
		'+мат.' => '<abbr title="В математиката">мат.</abbr>',
		'+Филос.' => '<abbr title="Във философията">Филос.</abbr>',
		'`' => '&#768;',
		"\n" => "\n<br>",
		"----\n" => '<hr>',
		'*' => '•',
	));

	$meaning = preg_replace('/\+(\S[^.]+\.)/U', '<i>$1</i>', $meaning);

	$meaning = preg_replace_callback('/\[\[w:([^]]+)\]\]/', function($matches) {
		return link_to_wikipedia($matches[1]);
	}, $meaning);
	$meaning = preg_replace_callback('/\[\[([^]]+)\]\]/', function($matches) {
		return link_to_word_by_name($matches[1]);
	}, $meaning);

	return $meaning;
}

function format_synonyms($synonyms)
{
	$synonyms = preg_replace_callback('/([а-я-]+)(?=[,\s])/u', function($matches) {
		return link_to($matches[1], '@word?query='.$matches[1]);
	}, $synonyms.' ');

	$synonyms = strtr(trim($synonyms), array(
		"\n" => "</li>\n<li>",
	));
	$synonyms = '<ul><li>' . $synonyms . '</li></ul>';

	return $synonyms;
}


function format_etymology($etymology)
{
	$etymology = preg_replace('/__([^_]+)__/U', '<b>$1</b>', $etymology);
	$etymology = preg_replace('/_([^_]+)_/U', '<i>$1</i>', $etymology);
	$etymology = strtr($etymology, array(
		'`' => '&#768;',
		"\n" => "\n<br>",
	));
	$etymology = preg_replace('/\+(\S[^.]+\.)/U', '<i>$1</i>', $etymology);

	return $etymology;
}


function format_word_type($type)
{
	switch ($type) {
		case 'noun_male': return 'съществително име, мъжки род';
		case 'noun_female': return 'съществително име, женски род';
		case 'noun_neutral': return 'съществително име, среден род';
		case 'noun_plurale-tantum': return 'съществително име, плуралия тантум';
		case 'adjective': return 'прилагателно име';
		case 'pronominal_personal': return 'лично местоимение';
		case 'pronominal_demonstrative': return 'показателно местоимение';
		case 'pronominal_possessive': return 'притежателно местоимение';
		case 'pronominal_interrogative': return 'въпросително местоимение';
		case 'pronominal_relative': return 'относително местоимение';
		case 'pronominal_indefinite': return 'неопределено местоимение';
		case 'pronominal_negative': return 'отрицателно местоимение';
		case 'pronominal_general': return 'обобщително местоимение';
		case 'numeral_cardinal': return 'числително редно име';
		case 'numeral_ordinal': return 'числително бройно име';
		case 'verb': return 'глагол';
		case 'verb_intransitive_imperfective': return 'непреходен глагол от несвършен вид';
		case 'verb_intransitive_terminative': return 'непреходен глагол от свършен вид';
		case 'verb_transitive_imperfective': return 'преходен глагол от несвършен вид';
		case 'verb_transitive_terminative': return 'преходен глагол от свършен вид';
		case 'adverb': return 'наречие';
		case 'conjunction': return 'съюз';
		case 'interjection': return 'междуметие';
		case 'particle': return 'частица';
		case 'preposition': return 'предлог';
		case 'name_month': return 'име на месец';
		case 'name_bg-various': return 'географски топоним в България';
		case 'name_bg-place': return 'географски топоним в България';
		case 'name_country': return 'държава';
		case 'name_capital': return 'столица';
		case 'name_city': return 'град';
		case 'name_various': return 'име';
		case 'name_popular': return 'популярно име';
		case 'name_people_family': return 'фамилно име';
		case 'name_people_name': return 'лично име';
		case 'prefix': return 'представка';
		case 'suffix': return 'наставка';
		case 'phrase': return 'фраза';
		case 'abbreviation': return 'съкращение';
		case 'other': return 'некласифицирана дума';
		default: return $type;
	}
}


function format_stress($wordPlain)
{
	return strtr($wordPlain, array('`' => '&#768;'));
}

function format_deriv_form_desc($description)
{
	return strtr($description, array(
		'бъд.вр.' => '<abbr title="бъдеще време">бъд.вр.</abbr>',
		'бъд.пред.вр.' => '<abbr title="бъдеще предварително време">бъд. пред. вр.</abbr>',
		'бъд.вр. в мин.' => '<abbr title="бъдеще време в миналото">бъд. вр. в мин.</abbr>',
		'бъд.пред.вр. в мин.' => '<abbr title="бъдеще предварително време в миналото">бъд.пред.вр. в мин.</abbr>',
		'сег.вр.' => '<abbr title="сегашно време">сег. вр.</abbr>',
		'мин.св.вр.' => '<abbr title="минало свършено време">мин. св. вр.</abbr>',
		'мин.несв.вр.' => '<abbr title="минало несвършено време">мин. несв. вр.</abbr>',
		'мин.неопр.вр.' => '<abbr title="минало неопределено време">мин.неопр.вр.</abbr>',
		'мин.пред.вр.' => '<abbr title="минало предварително време">мин. пред. вр.</abbr>',
		'бъд.вр.' => '<abbr title="бъдеще време">бъд. вр.</abbr>',
		'бъд.пред.вр.' => '<abbr title="бъдеще предварително време">бъд. пред. вр.</abbr>',
		'пр.накл.' => '<abbr title="преизказно наклонение">преизк. накл.</abbr>',
		'мин.страд.прич.' => '<abbr title="минало страдателно причастие">мин. страд. прич.</abbr>',
		'мин.деят.св.прич.' => '<abbr title="минало деятелно свършено причастие">мин. деят. св. прич.</abbr>',
		'мин.деят.несв.прич.' => '<abbr title="минало деятелно несвършено причастие">мин. деят. несв. прич.</abbr>',
		'сег.деят.прич.' => '<abbr title="сегашно деятелно причастие">сег. деят. прич.</abbr>',
		'1л.' => '<abbr title="първо лице">1 л.</abbr>',
		'2л.' => '<abbr title="второ лице">2 л.</abbr>',
		'3л.' => '<abbr title="трето лице">3 л.</abbr>',
		'ед.ч.' => '<abbr title="единствено число">ед. ч.</abbr>',
		'мн.ч.' => '<abbr title="множествено число">мн. ч.</abbr>',
		'м.р.' => '<abbr title="мъжки род">м. р.</abbr>',
		'ж.р.' => '<abbr title="женски род">ж. р.</abbr>',
		'ср.р.' => '<abbr title="среден род">ср. р.</abbr>',
	));
}

function format_translation($content)
{
	$content = strtr($content, array(
		"\n" => "\n<br>",
	));

	return $content;
}

function myformat_language($language, $culture = null)
{
	$langs = array(
		'sq' => 'албански',
		'en' => 'английски',
		'ar' => 'арабски',
		'hy' => 'арменски',
		'bg' => 'български',
		'el' => 'гръцки',
		'da' => 'датски',
		'he' => 'иврит',
		'es' => 'испански',
		'it' => 'италиански',
		'zh' => 'китайски',
		'ko' => 'корейски',
		'de' => 'немски',
		'no' => 'норвежки',
		'fa' => 'персийски',
		'pl' => 'полски',
		'pt' => 'португалски',
		'ro' => 'румънски',
		'ru' => 'руски',
		'sa' => 'санскрит',
		'sk' => 'словашки',
		'sl' => 'словенски',
		'sr' => 'сръбски',
		'hr' => 'хърватски',
		'tr' => 'турски',
		'hu' => 'унгарски',
		'fi' => 'фински',
		'fr' => 'френски',
		'hi' => 'хинди',
		'nl' => 'холандски',
		'cs' => 'чешки',
		'sv' => 'шведски',
		'jp' => 'японски',
	);

	return isset($langs[$language]) ? $langs[$language] : $language;
}

/**
* @param Word|array  $word      Word data
* @param string      $text      Link text
* @param bool        $loggable  Should the link click be logged
*/
function link_to_word($word, $text = '', $loggable = true)
{
	if ($word['name'] == '—') {
		return $word['name'];
	}

	$options = array();
	if ( ! $loggable ) {
		$options['query_string'] = 'log=0';
	}

	return link_to(($text ? $text : $word['name']), '@word?query=' . $word['name'], $options);
}

function link_to_word_by_name($name)
{
	if ($name == '—') {
		return $name;
	}

	return link_to($name, '@word?query=' . MyI18nToolkit::normalizeWordForLink($name));
}

function link_to_type($type, $text = '')
{
	$text = empty($text) ? $type : sprintf($text, $type);

	return link_to($text, '@type_list?name=' . $type);
}

function link_to_translation($word, $lang, $text = '')
{
	$text = empty($text) ? myformat_language($lang, 'bg') : $text;

	return link_tag($text, url_for(sprintf('@word_translation?word_id=%d&lang=%s', $word['id'], $lang)), array('class' => 'translation'));
}

function link_to_wikipedia($article)
{
	return sprintf('<a href="https://bg.wikipedia.org/wiki/%s"><i>%s</i> в Уикипедия</a>',
		urlencode(str_replace(' ', '_', $article)),
		$article);
}

function link_to_wiktionary($word)
{
	return sprintf('<a href="https://bg.wiktionary.org/wiki/%s"><b class="word">%s</b> в Уикиречник</a>',
		urlencode($word['name']),
		$word['name']);
}

function link_to_slovored($word)
{
	return sprintf('<a href="http://slovored.com/search/all/%s"><b class="word">%s</b> в Словоред</a>',
		urlencode($word['name']),
		$word['name']);
}

function link_to_new_word($user)
{
	return link_to_new('word', array(), $user);
}

function link_to_delete_word($word, $user)
{
	return link_to_delete('word', $word, $user);
}


function link_to_edit_name_stressed($word, $user)
{
	return link_to_edit('name_stressed', $word, $user);
}

function link_to_edit_meaning($word, $user)
{
	return link_to_edit('meaning', $word, $user);
}

function link_to_edit_type($word, $user)
{
	return link_to_edit('type', $word, $user);
}

function link_to_edit_etymology($word, $user)
{
	return link_to_edit('etymology', $word, $user);
}

function link_to_edit_synonyms($word, $user)
{
	return link_to_edit('synonyms', $word, $user);
}

function link_to_new_incorrect_form($word, $user)
{
	return link_to_new('incorrect', array('word_id' => $word['id']), $user);
}

function link_to_edit_incorrect_form($form, $user)
{
	return link_to_edit('incorrect', $form, $user);
}

function link_to_delete_incorrect_form($form, $user)
{
	return link_to_delete('incorrect', $form, $user);
}

function link_to_edit_derivative_form($form, $user)
{
	return link_to_edit('derivative', $form, $user);
}

function link_to_delete_derivative_form($form, $user)
{
	return link_to_delete('derivative', $form, $user);
}

function link_to_new_translation($word, $user)
{
	return link_to_new('translation', array(
		'word_id' => $word['id'],
	), $user);
}

function link_to_edit_translation($word, $lang, $user)
{
	return link_to_edit('translation', $word, $user);
}

function link_to_new($route, $params = array(), $user)
{
	if ( ! $user->isEditor()) {
		return '';
	}

	$route = empty($params)
		? sprintf('@%s_new', $route)
		: sprintf('@%s_new?%s', $route, http_build_query($params));

	return link_tag(image_tag_new(), url_for($route), array('class' => 'new'));
}

function link_to_edit($route, $obj, $user)
{
	if ( ! $user->isEditor()) {
		return '';
	}

	return link_tag(image_tag_edit(), url_for(sprintf('@%s_edit?id=%d', $route, $obj['id'])), array('class' => 'edit'));
}

function link_to_edit_fake($user)
{
	if ( $user->isEditor()) {
		return '';
	}

	return link_tag(image_tag_edit_fake(), url_for('@faq_edit_rights'), array('class' => 'edit-fake'));
}

function link_to_delete($route, $obj, $user)
{
	if ( ! $user->isFullEditor()) {
		return '';
	}

	return sprintf('<form action="%s" method="post" class="delete-form">%s<input type="hidden" name="sf_method" value="delete"></form>',
		url_for(sprintf('@%s_delete?id=%d', $route, $obj['id'])),
		image_tag_delete());
}


function image_tag_new()
{
	return image_tag('add', array('alt' => 'добавяне', 'title' => 'добавяне', 'width' => 16));
}

function image_tag_edit()
{
	return image_tag('edit', array('alt' => 'редактиране', 'title' => 'редактиране', 'width' => 16));
}

function image_tag_edit_fake()
{
	return image_tag('edit_fake', array('alt' => 'редактиране', 'title' => 'Не разполагате с редакторски права', 'width' => 16));
}

function image_tag_delete()
{
	return tag('input', array(
		'type'  => 'image',
		'src'   => image_path('delete'),
		'width' => 16,
		'alt'   => 'изтриване',
		'title' => 'изтриване',
	));
}

function link_tag($content, $href = '', $options = array())
{
	return content_tag('a', $content, array('href' => $href) + $options);
}

function include_partial_forms($word, $user)
{
	$patterns = array();
	foreach ($word['DerivativeForms'] as $form) {
		$key = '{'. $form['description'] .'}';
		$patterns[$key][] = get_partial('derivative_form', array('form' => $form));
	}

	foreach ($patterns as $key => $forms) {
		if (count($forms) == 1) {
			$patterns[$key] = $forms[0];
		} else {
			$patterns[$key] = '<ul><li>' . implode('</li><li>', $forms) . '</li></ul>';
		}
	}

	$partial = get_partial('forms_'.$word['Type']['speech_part']);
	// existing forms
	$partial = strtr($partial, $patterns);
	// empty forms
	$partial = preg_replace('/\{[^}]+\}/', '—', $partial);

	echo $partial;
}
