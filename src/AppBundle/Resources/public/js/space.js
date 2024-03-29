$(document).ready(function() {
    $('#addAttribute').on('click', function(e) {
        // empêche le lien de créer un « # » dans l'URL
        e.preventDefault();

        // ajoute un nouveau formulaire tag (voir le prochain bloc de code)
        addForm($('table.tags'));
    });

    function successAjax(data, saving) {
        $("#js-form-space").replaceWith($(data).find('#js-form-space'));
        initFormListener();
        initLinkListener();
        //$("input[data-provide='datepicker']").datepicker({'format' : 'dd/mm/yyyy', 'language': 'fr'});
        $("select").attr("data-placeholder", "Sélectionnez une option");
        $("select").chosen();

        if (saving && $("#js-form-space .has-error").length < 1) {
            $.colorbox({html:$('#saveBox').html().replace('%%savemsg%%', saving)});
        }
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
        var name = document.getElementById('appbundle_space_name');

        $('button[type="submit"]:not(.no-ajax), input[type="submit"]:not(.no-ajax)').click(function(e){
            if (name.checkValidity() == false) {
                window.scroll(name.scrollTop, name.scrollLeft)
                name.focus()
                name.parentElement.classList.add('has-error')
                e.preventDefault()
                return false
            }

            var saving = false;

            if ($(this).hasClass('js-publish')) {
                return true;
            }

            if ($(this).hasClass('save')) {
                saving = $(this).data('save') ? $(this).data('save') : true;
            }

            var form = $(this).closest('form');
            var action = form.attr('action');
            var formData = new FormData(form[0]);

            var previewing = $(this).attr('name') == 'appbundle_space[preview]';

            if (previewing) {
              formData.append('appbundle_space[preview]', null);
            }

            $.ajax({
                url: action,
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    if (previewing)
                      return window.open(data);

                    successAjax(data, saving);
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
