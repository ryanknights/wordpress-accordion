(function (window, document, $)
{
    function Accordion (el, options)
    {
        this.el  = el;
        this.$el = $(el);
        this.options = $.extend({}, this.defaultOptions, options, this.$el.data());

        this._init();
    }

    Accordion.prototype.defaultOptions =
    {   
        initial     : 1, // false =  no initial 
        speed       : 750,
        collapsible : true,
        keepOpen    : true
    };

    Accordion.prototype._init = function ()
    {
        this._setup();
        this._events();
    };

    Accordion.prototype._setup = function ()
    {  
        this.titles = this.$el.children('h3');
        this.panels = this.$el.children('section');

        if (this.options.initial !== false)
        {
            this.panels.eq(this.options.initial - 1).addClass('active').show().siblings('section').hide();
            this.titles.eq(this.options.initial - 1).addClass('active');
        }
    };

    Accordion.prototype._events = function ()
    {    
        var self = this;

        this.titles.on('click', function (event)
        {   
            event.preventDefault();

            var title = $(this);

            if (!title.hasClass('active'))
            {   
                title.addClass('active').next('section').stop(true, false).slideDown(self.options.speed).addClass('active');

                if (!self.options.keepOpen)
                {   
                    title.siblings('h3.active').removeClass('active');
                    title.next('section').siblings('section.active').stop(true, false).slideUp(self.options.speed).removeClass('active');
                }               
            }
            else if (title.hasClass('active') && self.options.collapsible)
            {
                title.removeClass('active').next('section').removeClass('active').stop(true, false).slideUp(self.options.speed);
            }
        });
    };

    function Plugin (options)
    {
        return this.each(function ()
        {
            var el = $(this);

            if (!el.data('tms-accordion'))
            {
                el.data('tms-accordion', new Accordion(this, options));
            }
        });
    }

    $.fn.tmsAccordion = Plugin;

    $(document).ready(function ()
    {
    	$('[data-tms-accordion]').tmsAccordion();
    });

}(window, document, jQuery));