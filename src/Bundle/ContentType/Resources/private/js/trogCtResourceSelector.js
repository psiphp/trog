$(document).ready(function () {
    bindSelector = function (el) {
        var title = $(el).attr('data-title');
        var url = $(el).find('a').attr('href');
        var previewUrl = $(el).attr('data-preview-url');

        var browser = $(el).attr('data-browser');
        var repositoryInputId = $(el).attr('data-input-repository');
        var pathInputId = $(el).attr('data-input-path');
        var identifierInputId = $(el).attr('data-input-identifier');
        var repositoryEl = $().find('#' + repositoryInputId);
        var pathEl = $(el).find('#' + pathInputId);
        var identifierEl = $(el).find('#' + identifierInputId);
        var previewEl = $(el).find('.preview');

        $(el).find('a').on('click', function (event) {
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
                var path = $(this).attr('data-path');
                var repository = $(this).attr('data-repository');
                var identifier = $(this).attr('data-identifier');
                var classFqn = encodeURI($(this).attr('data-class'));

                if (pathEl) {
                    pathEl.val(path);
                }

                if (repositoryEl) {
                    repositoryEl.val(repository);
                }

                if (identifierEl) {
                    identifierEl.val(identifier);
                }

                var url = previewUrl.replace('__class__', classFqn);
                url = url.replace('__repository__', repository)
                url = url.replace('__identifier__', identifier)
                url = url.replace('__path__', path)

                $.get(url, function (data) {
                    previewEl.html(data);
                });
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
                    selectEl.attr('data-class', $(this).attr('data-class'));
                    selectEl.attr('data-identifier', $(this).attr('data-identifier'));
                    selectEl.find('.resource-path').html(path);
                });
            };

            $.get(url, function (data) {
                browserEl.html(data)
                update();
                panel.modal('show');
                panel.modal('refresh');
            });
        });
    };
    $(this).on('collection-form-add', function(e, el) {
        if (el.children(':first').attr('data-trog-ct-resource-selector') === undefined) {
            return;
        }

        bindSelector(el.children(':first'));
    });

    $('*[data-trog-ct-resource-selector]').each(function (i, el) {
        bindSelector(el);
    });
});
