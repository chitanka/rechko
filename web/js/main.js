var sfSearch = {
	redirect: function (form)
	{
		var query = this.normalizeQuery(form.q.value);

		if (query === false) {
			return true;
		}

		location.href = form.action + "/" + encodeURIComponent(query);

		return false;
	},

	normalizeQuery: function(query)
	{
		return query.replace(/[^а-яА-Яa-zA-Z- ]/g, "");
	}
};

function showTranslation(link)
{
	$link = $(link);
	$link.addClass("loading");

	$.get(link.href, function(data){
		$link.parent().next().html(data);
		$link.replaceWith($link.text());
	});
}


$("body")
	.delegate("a.translation", "click", function(){
		showTranslation(this);

		return false;
	});

// $("#q").autocomplete("/bg", {
// 	minChars: 2,
// 	max:      10
// }).result(function(event, item) {
// 	event.target.form.submit();
// });
