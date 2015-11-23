/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    $(".inline").colorbox({inline:true, width:"400px"});

    $(".inline_register").colorbox({inline:true, width:"400px"});
});

$(function () {
    if ($.fn.datepicker) {
        $('[data-provide="datepicker"]').datepicker({
            'language': 'fr'
        });
    }
});

/**
 * Fake put/delete/post deletes on links
 */
$(function () {
    var createLinkMethodForm = function (action, data) {
        var $form = $('<form action="' + action + '" method="POST"></form>');
        for (input in data) {
            if (data.hasOwnProperty(input)) {
                $form.append('<input name="' + input + '" value="' + data[input] + '">');
            }
        }

        return $form;
    };

    // Faking method
    $(document).on('click', '[data-link-method]', function (e) {
        e.preventDefault();
        var $element = $(this);

        var $form = createLinkMethodForm($element.attr('href'), {
            _method: $element.data('link-method')
        }).hide();

        $('body').append($form); // Firefox requires form to be on the page to allow submission
        $form.submit();
    });
});