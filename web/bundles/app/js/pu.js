/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    $(".inline").colorbox({inline:true, width:"400px"});

    $(".inline_register").colorbox({inline:true, width:"400px"});
});

//$(function () {
//    if ($.fn.datepicker) {
//        $('[data-provide="datepicker"]').datepicker({
//            'language': 'fr'
//        });
//    }
//});

/**
 * Fake put/delete/post deletes on links
 */
$(function () {
    var createLinkMethodForm = function (action, data) {
        var $form = $('<form action="' + action + '" method="POST"></form>');
        for (var input in data) {
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

$(function () {
    $('[data-checkbox-toggle]').each(function () {
        var $element = $(this);
        var selector = $element.data('checkbox-toggle');
        var $target = $(selector);

        if ($element.is(':checked')) {
            $target.show();
        } else {
            $target.hide();
        }

        $element.on('change', function () {
            if ($(this).is(':checked')) {
                $target.show();
            } else {
                $target.hide();
            }
        });
    });
});

$(function () {
    var recalculate_size_price = function ($container, basePrice) {
        var $input = $container.find('input');
        var $monthPrice = $container.find('[data-model="monthPrice"]');
        var $yearPrice = $container.find('[data-model="yearPrice"]');
        var value = parseInt($input.val());

        if (value > 0) {
            $monthPrice.text(value * basePrice);
            $yearPrice.text(value * basePrice * 12);
        } else {
            $monthPrice.text('-');
            $yearPrice.text('-');
        }
    };

    $('[data-size-calculator]').each(function () {
        var $element = $(this);
        var basePrice = $element.data('size-calculator');

        recalculate_size_price($element, basePrice);

        $element.on('change', 'input', function (e) {
           e.preventDefault();
           recalculate_size_price($element, basePrice);
        });
    });
});



$(function(){
  var sizePhotoListItem = function() {
    var $images = $('.photo-list .photo-item .image');
    $images.each(function(){
      $(this).css({height: $(this).width() * 0.75});
    });
  };
  $(window).on('resize', sizePhotoListItem);
  sizePhotoListItem();
});


var idCardRequired = $('.file-infos.idcard-file input[type=file]').attr('required');
var kbisRequired = $('.file-infos.kbis-file input[type=file]').attr('required');

var toggleIdFiles = function(){
    if ($('#project_owner_companyStatus').val() == 'Association') {
        $('.idcard-file').show();
        $('.kbis-file').hide();
        $('.file-infos.idcard-file').show().find('input[type=file]').attr('required', idCardRequired);
        $('.file-infos.kbis-file').hide().find('input[type=file]').attr('required', false);
    } else {
        $('.idcard-file').hide();
        $('.kbis-file').show();
        $('.file-infos.idcard-file').hide().find('input[type=file]').attr('required', false);
        $('.file-infos.kbis-file').show().find('input[type=file]').attr('required', kbisRequired);
    }
};

$(function () {
  var kbisPresent = $('.required-files .kbis-file i')
  var idPresent = $('.required-files .idcard-file i')
  var kbisFile = document.getElementById('appbundle_application_projectHolder_kbis_file') || document.getElementById('project_owner_kbis_file')
  var idFile = document.getElementById('appbundle_application_projectHolder_idcard_file') || document.getElementById('project_owner_idcard_file')
  var inputText = 'Document justifiant la création de la structure'
  var kbisClearFile = document.getElementById('kbis_file_clear')
  var idClearFile = document.getElementById('id_file_clear')

  hasKbisFileStored = (typeof hasKbisFileStored !== undefined) ? true : false
  hasIdFileStored = (typeof hasIdFileStored !== undefined) ? true : false

  if (! kbisFile || ! idFile) {
    return false
  }

  var hasFileRequired = function (input) {
    if (input == idFile && hasIdFileStored) {
      return false
    }

    if (input == kbisFile && hasKbisFileStored) {
      return false
    }

    switch (input) {
      case idFile:
        icon = idPresent
        clear = idClearFile
        break
      case kbisFile:
      default:
        icon = kbisPresent
        clear = kbisClearFile
    }

    var span = input.parentElement
    while (span.previousElementSibling == null || span.previousElementSibling.tagName != "SPAN") {
      span = span.parentElement
    }

    if (input.files.length > 0) {
      icon.removeClass('fa-times')
      icon.addClass('fa-check')
      span.previousElementSibling.textContent = input.files[0].name
      clear.style.display = 'inline-block'
    } else {
      icon.removeClass('fa-check')
      icon.addClass('fa-times')
      span.previousElementSibling.textContent = inputText
      clear.style.display = 'none'
    }
  }

  kbisFile.addEventListener('change', function() {
    hasKbisFileStored = false
    hasFileRequired(this)
  })
  idFile.addEventListener('change', function() {
    hasIdFileStored = false
    hasFileRequired(this)
  })
  hasFileRequired(kbisFile)
  hasFileRequired(idFile)

  idClearFile.addEventListener('click', function () {
    idFile.files = new ClipboardEvent("").clipboardData.files || new DataTransfer().files
    idFile.dispatchEvent(new Event('change'))
  });
  kbisClearFile.addEventListener('click', function () {
    kbisFile.files = new ClipboardEvent("").clipboardData.files || new DataTransfer().files
    kbisFile.dispatchEvent(new Event('change'))
  });
})

$(function(){
  $('#project_owner_companyStatus').change(toggleIdFiles);
  toggleIdFiles();
});

// $(function(){
//   $('#appbundle_application_save, #appbundle_application_save_file').click(function(e){
//     e.preventDefault();
//     // $(this).parents('form').attr('no-validate', 'true').submit();
//   });
// });

$(function(){
  $(document).on('focus', '.form-group.has-error input', function(){
    $(this).parents('.form-group.has-error').removeClass('has-error').find('.help-block').detach();
  });
});

$(function(){
  $(document).on('change', 'label.custom-file-input input[type="file"]', function(){
     var filename = $(this)[0].files.length ? $(this)[0].files[0].name : "";
     if (filename) {
       $(this).parents('label.custom-file-input').before('<span>'+filename+'</span>');
     }
  });
});