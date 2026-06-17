/**
 * Customizer Sortable Control — drag-and-drop block ordering.
 */
(function($) {
    $(document).ready(function() {
        // Make sortable lists sortable
        $(document).on('mouseover', '.ald-blog-sortable', function() {
            if (!$(this).hasClass('ui-sortable')) {
                $(this).sortable({
                    placeholder: 'ui-state-highlight',
                    update: function(event, ui) {
                        var $list = $(this);
                        var $hidden = $list.next('input[type="hidden"]');
                        var order = [];
                        $list.find('li').each(function() {
                            var key = $(this).data('key');
                            if (key) order.push(key);
                        });
                        $hidden.val(JSON.stringify(order)).trigger('change');
                    }
                });
            }
        });

        // Sync checkbox state into hidden input on change
        $(document).on('change', '.ald-blog-sortable input[type="checkbox"]', function() {
            var $li = $(this).closest('li');
            var $list = $li.closest('.ald-blog-sortable');
            var $hidden = $list.next('input[type="hidden"]');
            var order = [];
            $list.find('li').each(function() {
                var key = $(this).data('key');
                if (key) order.push(key);
            });
            $hidden.val(JSON.stringify(order)).trigger('change');
        });
    });
})(jQuery);
