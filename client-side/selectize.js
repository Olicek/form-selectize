
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
		if (item.data('options').mode === 'full') {

			var valueField = item.data('options').valueField;
			var labelField = item.data('options').labelField;
			var options = {
				plugins: (item.data('options').plugins === null ? null : item.data('options').plugins),
				delimiter: item.data('options').delimiter,
				maxItems: item.data('options').maxItems,
				valueField: valueField,
				labelField: labelField,
				searchField: item.data('options').searchField,
				options: item.data('entity'),
				create: (item.data('options').create ? true : false),
			};

			if (callback !== undefined) {
				options.render = callback(labelField, valueField);
			}

			if (customOptions !== undefined)
			{
				options = customOptions(options);
			}

			item.selectize(options);
		} else {
			var options = {
				sortField: 'text',
				create: (item.data('options').create ? true : false)
			};

			if (customOptions !== undefined)
			{
				options = customOptions(options);
			}

			item.selectize(options);
		}
	});
}