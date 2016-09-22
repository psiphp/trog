$(document).ready(function () {
    $('*[data-trog-ct-ace-editor]').each(function () {
        var mode = $(this).attr('data-trog-ct-ace-editor-mode');

        var textarea = $(this).find('textarea').get(0);
        var editor = ace.edit(textarea.id + '-editor');
        editor.setTheme("ace/theme/twilight");
        editor.setValue(textarea.value, 1);

        if (mode) {
            editor.session.setMode(mode);
        }

        editor.getSession().on('change', function(){
            textarea.value = editor.getSession().getValue();
        });
    });
});
