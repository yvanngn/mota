/* global twentytwentyoneGetHexLum */
jQuery(document).ready(function($) {
	console.log(ajax_object.rest_url);
	$('#category-filter, #format-filter, #sort-filter').change(function() {
		var category = $('#category-filter').val();
		var format = $('#format-filter').val();
		var sort = $('#sort-filter').val();

		$.ajax({
			type: 'POST',
			url: ajax_object.ajax_url,
			data: {
				action: 'filter_photos',
				category: category,
				format: format,
				sort: sort
			},
			success: function(response) {
				$('.image-list').html(response);
			}
		});
	});

	// Load infini
	var offset = 0;
	var perPage = 2;

	function loadMorePhotos() {
		var category = $('#category-filter').val();
		var format = $('#format-filter').val();

		$.ajax({
			type: 'POST',
			url: ajax_object.ajax_url,
			data: {
				action: 'load_more_photos',
				offset: offset,
				per_page: perPage,
				category: category,
				format: format
			},
			success: function(response) {
				$('.image-list').append(response);
				offset += perPage;
			}
		});
	}

	loadMorePhotos();

	$('#load-more').click(function() {
		loadMorePhotos();
	});

	$('#menu-item-13').click(function() {
		$('#contact-modal').fadeIn();
		return false;
	});

	$('#close-contact-modal').click(function() {
		$('#contact-modal').fadeOut();
	});

	$("#category-filter").select2({
		templateSelection: function(option) {
		//	$(option.element).css("background-color", "red");
			return option.text;
		}
	});

});
