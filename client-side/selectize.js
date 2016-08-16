/**
 * Created by petr on 30.3.16.
 */


if ($.fn.selectize === undefined) {
    console.error('Plugin "selectize.js" is missing! Run `bower install selectize` and load it. Or install this plugin (selectzie-for-nette) via bower.');
}

var SelectizeForNette = SelectizeForNette || {};

SelectizeForNette = function(element, customSettings)
{
    if (typeof customSettings !== 'object' && typeof customSettings !== 'undefined') {
        console.error('second parameter must be object or undefined. Type of ' + typeof customSettings + ' given');
    }

    this.element = element;
    this.settings = {};
    this.options = {};

    if (typeof customSettings === 'undefined') {
        this.customOptions;
        this.customRender;
        this.customAjax;

    } else {
        this.customOptions = typeof customSettings.customOptions === 'undefined' ? undefined : customSettings.customOptions;
        this.customRender = typeof customSettings.customRender === 'undefined' ? undefined : customSettings.customRender;
        this.customAjax = typeof customSettings.customAjax === 'undefined' ? undefined : customSettings.customAjax;
    }

    this.init();
};

SelectizeForNette.prototype = {

    constructor: SelectizeForNette,

    init: function()
    {
        var base = this;
        this.setProperties();

        $('label[for=' + this.element.attr('id') + ']')
            .on('click', function() {
                base.element.next().find('input').focus();
            });

        return this;
    },

    setProperties: function()
    {
        this.settings = this.element.data('options');
        var entity = Array.prototype.slice.call(this.element.data('entity'));
        this.options = {
            plugins: (this.settings.plugins === null ? null : this.settings.plugins),
            create: this.settings.create,
            delimiter: this.settings.delimiter,
            maxItems: this.settings.mode === 'select' ? 1 : this.settings.maxItems,
            valueField: this.settings.valueField,
            labelField: this.settings.labelField,
            searchField: this.settings.searchField,
            options: typeof this.settings.ajaxURL === 'undefined' ? entity :
                entity.filter(function (entity) { return entity.id == this.element.val(); })
        };

        if (this.element.attr('placeholder') !== 'undefined')
        {
            this.options['placeholder'] = this.element.attr('placeholder');
        }

        return this;
    },

    create: function()
    {
        var base = this;
        if (typeof this.settings.ajaxURL !== 'undefined') {
            if (typeof this.customAjax !== "undefined") {
                this.options.load = this.customAjax.call(this, this.options, this.settings.ajaxURL);

            } else {
                this.options.load = function(query, callback) {
                    if (!query.length || query.length < 3) return callback();
                    $.ajax({
                        url: base.settings.ajaxURL,
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
            }
        }

        if (typeof this.customOptions !== "undefined") {
            this.customOptions.call(this, this.options);
        }

        if (typeof this.customRender !== "undefined") {
            this.options.render = this.customRender.call(this, this.options);
        }

        this.element.selectize(this.options);
    }

};



function selectize(selector, customSettings)
{
    if (selector === undefined) {
        selector = $('.selectize');
    }

    $( selector ).each(function() {
        if ($(this).data('options') == undefined) {
            return;
        }

        var mySelectize = new SelectizeForNette($(this), customSettings);
        mySelectize.create();
    });
}