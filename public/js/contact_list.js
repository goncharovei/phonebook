$(function () {
	$('#js_contact_trash_button').click(function (e) {
		contactDelete();
		$('#contactTrash').modal('hide');
		return e.preventDefault();
	});

	$('#contactTrash').on('show.bs.modal', function (event) {
		obj_contact_trash = $(event.relatedTarget).length ? $(event.relatedTarget) : null;
	});
	$('#contactTrash').on('hide.bs.modal', function (event) {
		obj_contact_trash = null;
	});

	var obj_contact_trash = null;
	function contactDelete() {
		if (!obj_contact_trash) {
			return;
		}

		var contact_trash_url = obj_contact_trash.attr('href');
		var box_contact_trash = obj_contact_trash.closest('.js-box-contact');
		if (!contact_trash_url || !box_contact_trash || !$('meta[name="csrf-token"]').length) {
			return;
		}

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.post(contact_trash_url, function (response) {
			if (typeof response !== 'object' || !('success' in response) || !response.success) {
				alert('Unexpected error');
				return;
			}

			box_contact_trash.remove();
			if ($(".alert").length) {
				$(".js-alert-box").hide();
			}
			if ($("#js_content_box").length && response.success_box) {
				$("#js_content_box").before(response.success_box);
			}
			if (!$('.js-box-contact').size()) {
				document.location.reload(true);
			}

		}, "json");
	}

});