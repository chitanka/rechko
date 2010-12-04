<?php slot('title', 'За речника') ?>

<p>Този речник официално видя бял свят на трети март 2010 г. Кодовото му име е <strong>Речко</strong>.</p>

<p>В него са включени:</p>
<ul>
	<li><?php echo link_to('тълковен речник', '@talkoven') ?></li>
	<li><?php echo link_to('правописен речник', '@pravopisen') ?></li>
	<li><?php echo link_to('синонимен речник', '@sinonimen') ?></li>
	<li>словоформен речник — ще са изброени всички словоформи в българския език.</li>
</ul>

<p>Някой ден може да се добави и фразеологичен речник.</p>

<p>Все още има грешки в данните или пък липсват думи, но с времето всичко това ще се оправи. :-)</p>

<h2>Началните данни</h2>

<p>Тълковната информация на думите е взета от речниците <a href="http://eurodict.com/">eurodict.com</a> и <a href="http://www.onlinerechnik.com/">onlinerechnik.com</a>.</p>

<p>Словоформите са генерирани с помощта на данни от програмата <a href="http://ididictionary.com/bulgarian_spell_checker/">IDI Spell Checker</a>, които пък са базирани на данни от <a href="http://bgoffice.sourceforge.net/">проекта БГ Офис</a>. От БГ Офис идва и синонимната база.</p>

<p>Грешните изписвания на думите са създадени автоматично.</p>

<h2>Задвижващото ядро</h2>

<p>Двигателят на системата е създаден с помощта на <a href="http://www.symfony-project.org">symfony</a> и <a href="http://www.doctrine-project.org">Doctrine</a>.</p>

<h2>Сваляне</h2>

<p>По-нататък ще бъде възможно пълното сваляне на речника за собствена употреба.</p>
