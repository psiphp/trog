$(document).ready(function () {
    $('*[data-trog-ct-resource-selector]').each(function () {
        var title = $(this).attr('data-title');
        var url = $(this).attr('href');
        var browser = $(this).attr('data-browser');

        $(this).on('click', function (event) {
            event.preventDefault();
            var panel = $(
                '<div class="ui modal">' + 
                    '<div class="header">' +
                        title +
                    '</div>' +
            '<div class="browser">' + 
                    '</div>' + 
                    '<div class="actions">' + 
                        '<div class="select ui positive right labeled icon  button">Select <span class="resource-path"></span><i class="checkmark icon"></i></div>' +
                    '</div>' +
                '</div>');

            var browserEl = panel.find('.browser');
            var selectEl = panel.find('.select');

            selectEl.on('click', function () {
                console.log($(this).attr('data-path'));
                console.log($(this).attr('data-repository'));
            });

            var update = function () {
                browserEl.find('a').on('click', function (event) {
                    event.preventDefault();
                    var url = $(this).attr('href');
                    $.get(url, function (data) {
                        browserEl.html(data);
                        update();
                    });
                });

                browserEl.find('a.browser-item').on('click', function (event) {
                    var path = $(this).attr('data-path');
                    selectEl.attr('data-path', path);
                    selectEl.attr('data-repository', $(this).attr('data-repository'));
                    selectEl.find('.resource-path').html(path);
                });
            };

            $.get(url, function (data) {
                browserEl.html(data)
                update();
                panel.modal('show');
            });
        });
    });
});
