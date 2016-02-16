$(document).ready(function() {
    $('#addAttribute').on('click', function(e) {
        // empêche le lien de créer un « # » dans l'URL
        e.preventDefault();

        // ajoute un nouveau formulaire tag (voir le prochain bloc de code)
        addForm($('table.tags'));
    });

    function successAjax(data) {
        $("#js-form-space").html($(data).find('#js-form-space'));
        initFormListener();
        initLinkListener();
        $("input[data-provide='datepicker']").datepicker({'format' : 'dd/mm/yyyy'});
        $("select").chosen();
    }

    function initLinkListener() {
        $('.js-btn-space').click(function() {

            var href = $(this).attr('href');
            var method = $(this).data('link-method');

            $.ajax({
                url: href,
                type: method,
                async: false,
                success: function (data) {
                    successAjax(data);
                },
                cache: false,
                contentType: false,
                processData: false
            });


            return false;
        });
    }


    function initFormListener() {
        $('button[type="submit"]:not(.no-ajax)').click(function(){

            if ($(this).hasClass('js-publish')) {
                return true;
            }

            var form = $(this).closest('form');
            var action = form.attr('action');
            var formData = new FormData(form[0]);

            $.ajax({
                url: action,
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    successAjax(data);
                },
                cache: false,
                contentType: false,
                processData: false
            });

            return false;
        });
    }

    initFormListener();
    initLinkListener();
});
