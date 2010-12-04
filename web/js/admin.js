function showNewForm(link)
{
	$(link).addClass("loading");

	$.get(link.href, function(data){
		$(link).before(data).removeClass("loading").prev("form").find(":input:visible:eq(0)").focus();
	});
}

function showEditForm(link)
{
	$(link).addClass("loading");

	var match = link.href.match(/edit\/(.+)/);
	if (match === null) {
		alert(link.href + " is an invalid edit link.");

		return;
	}

	$.get(link.href, function(data){
		var sel = $("#"+match[1].replace(/\//g, "_"));
		$(sel).hide().after(data).next("form").find(":input:visible:eq(0)").focus();
		$(link).removeClass("loading");
	});
}

function submitNewForm(form)
{
	var $form = $(form);
	$(":submit", $form).addClass("loading");
	$.post(form.action, $form.serialize(), function(data){
		$form.prev().append(data).end().remove();
	});
}

function submitEditForm(form)
{
	var $form = $(form);
	$(":submit", $form).addClass("loading");
	$.post(form.action, $form.serialize(), function(data){
		$form.prev().html(data).show().end().remove();
	});
}

function submitDeleteForm(form)
{
	var $form = $(form);
	$(":input", $form).addClass("loading");
	$.post(form.action, $form.serialize(), function(data){
		$form.parent().remove();
	});
}


function enhanceModifying()
{
	$("body")
		.delegate("a.new", "click", function(){
			showNewForm(this);

			return false;
		})
		.delegate("a.edit", "click", function(){
			showEditForm(this);

			return false;
		})
		.delegate("form.new-form", "submit", function(){
			submitNewForm(this);

			return false;
		})
		.delegate("form.edit-form", "submit", function(){
			submitEditForm(this);

			return false;
		})
		.delegate("form.delete-form", "submit", function(){
			if (confirm("Наистина ли да се изтрие? Връщане назад няма.")) {
				submitDeleteForm(this);
			}

			return false;
		})
		.delegate("button.cancel", "click", function(){
			$(this.form).prev().show().end().remove();
		});
}

enhanceModifying();
