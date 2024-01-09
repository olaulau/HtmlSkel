$(function() {
	
	// bootstrap js / jquery compat
	var bootstrapButton = $.fn.button.noConflict() // return $.fn.button to previously assigned value
	$.fn.bootstrapBtn = bootstrapButton // give $().bootstrapBtn the Bootstrap functionality
	
	
	// prepare confirmation modal dialog 
	$("#dialog-confirm").dialog({
		autoOpen: false,
		modal: true,
		draggable: false,
		resizable: false,
		width: "auto",
		show: {
			effect: "blind",
			duration: "fast"
		},
		open: function( event, ui ) {
			$(".ui-widget-overlay").addClass("ui-widget-overlay-after")
		},
		hide: {
			effect: "drop",
			duration: "fast"
		},
		buttons: [
			 {
				text: "Oui",
				open: function() {
					$(this).addClass('btn btn-success');
				},
				click: function() {
					window.location = link.href;
				}
			},
			{
				text: "Non",
				open: function() {
					$(this).addClass('btn btn-danger');
				},
				click: function() {
					$(this).dialog("close");
				}
			}
		]
	});
	$("#dialog-confirm").parent().find("button.btn").removeClass("ui-button ui-corner-all ui-widget");
	$("#dialog-confirm").removeClass("d-none");
	
	
	// open confirmation dialog when clicking on a specific link
	$("a.confirm").click(function(event) {
		event.preventDefault();
		link = this;
		$("#dialog-confirm").dialog("open");
	});
	
	
	// autocomplete for select
	$("select:not(.no-select2)").select2();
	
	// open on (keyboard) focus
	// on first focus (bubbles up to document), open the menu
	$(document).on('focus', '.select2-selection.select2-selection--single', function(e) {
		$(this).closest(".select2-container").siblings('select:enabled').select2('open');
	});
	// steal focus during close - only capture once and stop propogation
	$('select.select2').on('select2:closing', function(e) {
		$(e.target).data("select2").$selection.one('focus focusin', function(e) {
			e.stopPropagation();
		});
	});
	
	// focus on search when opening
	$(document).on('select2:open', e => {
		const select2 = $(e.target).data('select2');
		if (!select2.options.get('multiple')) {
			select2.dropdown.$search.get(0).focus();
		}
	});
	
	
	// popver
	const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
	const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

});
