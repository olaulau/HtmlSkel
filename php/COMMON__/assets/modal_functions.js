/* refresh a select with values from AJAX */
function refreshSelectValuesAjax (field, field_value, query_string)
{
	var field_name = field.field_name;
	
	// clean values
	$("#"+field_name).children().remove();
	
	
	// cache query string for JQDialog return use
	if(query_string == null && typeof CACHED_query_string !== 'undefined' && CACHED_query_string != null)
		query_string = CACHED_query_string;
	else
		CACHED_query_string = query_string;
	if(query_string == null)
		query_string = '';
	
	$.getJSON(field.ajax_url+"?"+query_string, null, function( data )
	{
		// add default option (disabled "choose" label)
		var newOption = new Option("choisir", "", true, true);
		$("#"+field_name).append(newOption);
		$("#"+field_name+">option[value='']").attr('disabled','disabled');

//		console.log(data);
		for (const id in data)
		{
			var element = data[id];
			var text = element.label;
			var value = element.value;
			selected = (value == field_value ? "selected" : "");
			$("#"+field_name).append(new Option(text, value, false, selected));
		}
		$("#"+field_name).attr("disabled", false);
	});
	$("#"+field_name).change();
}


/* open a jQuery ui modal dialog with a page loaded dynamically */
function JQDialog(field)
{
	var dialog = $("<div>").load(field.content_url, function() {
		$(this).dialog(
		{
			modal: true,
			draggable: false,
			resizable: false,
			width: "auto",
			show: { effect: "blind", duration: "fast" },
			hide: { effect: "drop", duration: "fast" },
			open: function( event, ui ) {
				$(".ui-widget-overlay").addClass("ui-widget-overlay-after")
			},
			close: function() {
				$(this).dialog("close");
			}
		});
		
		// intercept form submition to force it beeing sent by AJAX
		var form = dialog.find("form").on("submit", function(event) {
			event.preventDefault();
			
			var formAction = $(this)[0].getAttribute("action");
			var formValues = $(this).serialize();
			
			$.post(formAction, formValues, function(data) {
				//TODO more structured response
				var field_value = data;
				
				dialog.dialog("close");
				refreshSelectValuesAjax (field, field_value);
			})
			.fail(function(data) {
				alert("error");
				console.log(data);
				dialog.dialog("close");
			});
		});
	});
}


function ajaxifySelect(field, load=true)
{
	if(load === true)
	{
		// load values list by AJAX
		refreshSelectValuesAjax (field, $("#initial_"+field.field_name).val());
	}
	
	// new form with JQDialog
	$("#new_"+field.field_name).on("click", function(event)
	{
		event.preventDefault();
		JQDialog(field);
	});
}
