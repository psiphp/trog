jQuery.fn.trogResourceBrowser = function (options) {

    var options = $.extend({
        update_path: '/'
    }, options);

    var operations = [];
    var originalIndex = 0;

    $('.sortable').sortable({
        'disabled': true,
        'start': function (event, ui) {
            originalIndex = ui.item.index();
        },
        'stop': function (event, ui) {
            operations.push({
                'type': 'reorder',
                'path': ui.item.attr('item-path'),
                'position': ui.item.index()
            });
        }
    });

    $('.resourcebrowser').disableSelection();
    $('.moving').hide();

    $('#browser_move_button').on('click', function (el) {
        $('.browsing').hide();
        $('.moving').show();
        $('.sortable').sortable('enable');
    });

    $('#moving_cancel_button').on('click', function (el) {
        $('.moving').hide();
        $('.browsing').show();
        $('.sortable').sortable('cancel');
        $('.sortable').sortable('disable');
    });

    $('#moving_save_button').on('click', function (el) {
        buttonEl = $(this);
        buttonEl.addClass('loading');

        $.ajax(options.update_path, {
            method: 'PUT',
            data: {operations: operations},
            dataType: 'json',
            success: function (data, status) {
                $('.moving').hide();
                $('.browsing').show();
                buttonEl.removeClass('loading');

                operations = [];
            }
        });

    });

	$('.ui.dropdown')
	  .dropdown()
	;
};
