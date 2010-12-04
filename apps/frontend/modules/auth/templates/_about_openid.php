<h2>Какво е OpenID?</h2>

<p><a href="http://openid.net/get-an-openid/">OpenID</a> е нов стандарт, който ви позволява да влизате в различни сайтове, без да се налага да се регистрирате във всеки от тях поотделно. Нужно е само да въведете един-единствен адрес — вашето OpenID — и да натиснете върху <button class="fake-button">Влизане</button>.</p>

<p>Съществуват сайтове, чиято основна цел е да предоставят OpenID на своите потребители. Такива са например <a href="http://claimid.com/">claimid.com</a> и <a href="https://www.myopenid.com/">myopenid.com</a>. Някои от по-големите сайтове в Мрежата също дават възможност на потребителите си да ги ползват като OpenID. Ето няколко примера:</p>
<ul>
	<li><b>username</b>.wordpress.com</li>
	<li><b>blogname</b>.blogspot.com</li>
	<li>www.flickr.com/<b>username</b></li>
</ul>

<h3>Как работи тази магия?</h3>

<p>Ето как точно сработва влизането чрез OpenID. Да кажем, че Иванчо използва сайта myopenid.com.</p>
<ol>
	<li>Иванчо въвежда своето OpenID <b>ivancho.myopenid.com</b> в сайта <a href="http://rechnik.chitanka.info/">rechnik.chitanka.info</a> и щраква върху бутона <button class="fake-button">Влизане</button>.</li>
	<li>След това Иванчо бива препратен към myopenid.com, където от него се иска да въведе своята парола за влизане в myopenid.com. Това е единствената парола, която той трябва да помни.</li>
	<li>Иванчо все още се намира на myopenid.com и там го питат дали наистина иска да влезе в rechnik.chitanka.info. Той казва „Да, искам“, щраква върху един бутон, за да потвърди, и след секунда отново се озовава на rechnik.chitanka.info.</li>
</ol>

<p>В повечето случаи стъпки 2 и 3 отпадат.</p>