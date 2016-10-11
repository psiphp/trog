$(document).ready(function () {

    var bindEditor = function (el) {
        var mode = $(this).attr('data-trog-ct-ace-editor-mode');

        var textarea = $(el).find('textarea').get(0);
        var editor = ace.edit(textarea.id + '-editor');
        editor.setTheme("ace/theme/twilight");
        editor.setValue(textarea.value, 1);

        if (mode) {
            editor.session.setMode(mode);
        }

        editor.getSession().on('change', function(){
            textarea.value = editor.getSession().getValue();
        });
    }

    $(this).on('collection-form-add', function(e, el) {
        if (el.children(':first').attr('data-trog-ct-ace-editor') === undefined) {
            return;
        }
        bindEditor(el);
    });

    $('*[data-trog-ct-ace-editor]').each(function (a, el) {
        bindEditor(el);
    });
});
