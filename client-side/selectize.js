try {
	$( ".selectize" ).each(function() {
		if ($(this).data('options').mode === 'full')
		{
			$(this).selectize({
				plugins: ($(this).data('options').plugins === null ? null : $(this).data('options').plugins),
				delimiter: $(this).data('options').delimiter,
				maxItems: $(this).data('options').maxItems,
				valueField: $(this).data('options').valueField,
				labelField: $(this).data('options').labelField,
				searchField: $(this).data('options').searchField,
				options: $(this).data('entity'),
				create: ($(this).data('options').create ? true : false)
			});
		} else {
			$(this).selectize({
				sortField: 'text',
				create: ($(this).data('options').create ? true : false)
			});
		}
	});
} catch(err) { console.log('missing selectize!'); }