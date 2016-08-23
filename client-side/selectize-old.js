
function selectize(callback, selector, customOptions)
{
	if ($.fn.selectize === undefined) {
		console.error('Plugin "selectize.js" is missing! Run `bower install selectize` and load it.');
		return;
	}

	if (selector === undefined) {
		selector = $('.selectize');
	}

	$( selector ).each(function() {
		var item = $(this);

		// label click focus
		$('label[for=' + item.attr('id') + ']')
			.on('click', function() {
				item.next().find('input').focus();
			});

		if (item.data('options').mode === 'full') {

			var valueField = item.data('options').valueField;
			var labelField = item.data('options').labelField;
			var entity = item.data('entity');
			var options = {
				plugins: (item.data('options').plugins === null ? null : item.data('options').plugins),
				delimiter: item.data('options').delimiter,
				maxItems: item.data('options').maxItems,
				valueField: valueField,
				labelField: labelField,
				searchField: item.data('options').searchField,
				options: ((typeof item.data('options').ajaxURL === 'undefined') ? item.data('entity') :
					entity.filter(function (entity) { console.log(item.val()); return entity.id == item.val() })),
				create: (item.data('options').create ? true : false),
			};

			if (item.attr('placeholder') !== 'undefined')
			{
				options['placeholder'] = item.attr('placeholder');
			}

			if (callback !== undefined) {
				options.render = callback(labelField, valueField);
			}

			if (customOptions !== undefined)
			{
				options = customOptions(options);
			}

		} else {
			var options = {
				sortField: 'text',
				create: (item.data('options').create ? true : false)
			};

			if (customOptions !== undefined)
			{
				options = customOptions(options);
			}

		}

		if (typeof item.data('options').ajaxURL !== 'undefined')
		{
			options = $.extend(options,
					{
						load: function(query, callback) {
							if (!query.length || query.length < 3) return callback();
							$.ajax({
								url: item.data('options').ajaxURL,
								data: {query: query},
								type: 'GET',
								error: function() {
									console.error('AJAX error');
									callback();
								},
								success: function(res) {
									if (res != [])
									{
										options.options = res;
										callback(res);
									}
								}
							});
						}
					}
			);
		}

		item.selectize(options);
	});
}