
JavaScript settings
===================

Basic default functions are available by `selectize();`. It use css class `selectize`. If more selectzie entities  with diferent
functions are required, you can set class/id name `selectize('.author-selectize');`.


## Additional options

This plugin supports 3 additional setting options.

* customOptions: contains whole [options] (https://github.com/selectize/selectize.js/blob/master/docs/usage.md#options). Return void
    * Example: `customOptions: function (options) {}`
* customRender: contains whole options too. Return [render] (https://github.com/selectize/selectize.js/blob/master/docs/usage.md#rendering)
    * Example: `customRender: function (options) {return {}}`
* customAjax: contains whole options and url address from PHP `ajaxURL`. Return callback [load] (https://github.com/selectize/selectize.js/blob/master/docs/usage.md#callbacks)
    * Example: `customAjax: function (options, url) {return function (query, callback) {}}`

## Example:



    var settings = {
        customOptions: function (options) {
            options.onOptionAdd = function(value) {
                console.log('Show when new option is add to the list.');
            };
        },
        customAjax: function (options, url) {
            return function(query, callback) {
                if (!query.length || query.length < 2) return callback();
                $.ajax({
                    url: url,
                    data: {query: query},
                    type: 'GET',
                    error: function() {
                        console.error('AJAX error');
                        callback();
                    },
                    success: function(res) {
                        if (res.length)
                        {
                            callback(res);
                        }
                    }
                });
            };
        },
        customRender: function (options) {
            return {
                item: function(item, escape) {
                    return '<div>' + escape(item[options.labelField])
                        + (item[options.valueField] !== undefined ? ' <span class="label label-info">ID: ' + escape(item[options.valueField]) + '</span> ' : '')
                        + '</div>';
                },
                option: function(item, escape) {
                    var label = item[options.labelField];
                    return '<div>'
                        + '<span>' + escape(label) + '</span> '
                        + (item[options.valueField] !== undefined ? '<span class="label label-info">ID: ' + escape(item[options.valueField]) + '</span> ': '')
                        + '</div>';
                }
            }
        }
    };

    selectize('.custom-selectize', settings);
