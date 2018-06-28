(function($) {
    $.entwine('ss', function($) {
        $('.stylingoptionset input').entwine({
            onmatch: function() {
                if (this.is(':checked')) {
                    this.check();
                } else {
                    this.uncheck();
                }
            },
            getLabel: function() {
                return $('label', this.parent());
            },
            onchange: function(e) {
                var $otherCheckboxes = $('input', this.closest('ul')).not(this);
                if (this.is(':checked')) {
                    $otherCheckboxes.uncheck();
                    this.check();
                } else {
                    $otherCheckboxes.check();
                    this.uncheck();
                }
            },
            check: function() {
                this.parent().addClass('ischecked');
            },
            uncheck: function() {
                this.parent().removeClass('ischecked');
            }
        });
    });
})(jQuery);
