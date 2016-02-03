$(document).ready(function() {
    $('#addAttribute').on('click', function(e) {
        // empêche le lien de créer un « # » dans l'URL
        e.preventDefault();

        // ajoute un nouveau formulaire tag (voir le prochain bloc de code)
        addForm($('table.tags'));
    });

    function initFormListener() {
        $("form").submit(function(){

            var action = $(this).attr('action');
            var formData = new FormData($(this)[0]);

            $.ajax({
                url: action,
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    $("#js-form-space").html($(data).find('#js-form-space'));
                    initFormListener();
                    $("input[data-provide='datepicker']").datepicker({'format' : 'dd/mm/yyyy'});
                    $("select").chosen();
                },
                cache: false,
                contentType: false,
                processData: false
            });

            return false;
        });
    }

    initFormListener();
});
