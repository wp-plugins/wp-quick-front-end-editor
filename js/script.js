  jQuery(function($) {
    $('#upload-btn,.fea-btn').hide();
    $('#la-title').attr('contenteditable', 'false'); 
    $('.deactive,.hid').hide();
    $('#la-save').hide();

    


    $('.activep').click(function(event) {


      // $('.f-basic').addClass('froala-wrapper ');
        $('#edit').editable({
        inlineMode: false, theme: 'royal'
        });
        $('[data-cmd="insertImage"]').remove(); 
    $(this).hide();
    $('.deactive').show();
    $('#la-title').attr('contenteditable', 'true');
    $('#la-save').show();
    $('.froala-editor').css('border-top', 'solid 5px #252525');
    $('.fea-btn,.hid,#upload-btn,.bttn-wrapper').show();
    });

    $('.deactive').click(function(event) {
      $('.bttn-wrapper,.fea-btn,.hid').hide();
      // $('.f-basic').removeClass('froala-wrapper ');
      $(this).hide();
    $('.deactive,#upload-btn').hide();
    $('#la-title').attr('contenteditable', 'false');
    $('.activep').show();
    // $('.froala-wrapper div').attr('contenteditable', 'false');
    $('#la-save').hide();
    $('.froala-editor').css('border-top', 'none');

    // $('.froala-view').removeAttr('class').removeAttr('contenteditable').replace('span');
    // var cnt = $(".froala-view").contents();
    // $(".froala-view").replaceWith(cnt);
    // var yourDiv = $(".froala-view");
    // var yourSpan = $('<span class="froala-view froala-element not-msie f-basic" style="outline: 0px;" spellcheck="false" dir="auto"></span>');
    // yourDiv.before(yourSpan);
    // yourSpan.append(yourDiv.children());
    // yourDiv.remove();
    });

   

    $('#upload-btn').click(function(e) {
      e.preventDefault();
      var image = wp.media({
        title: 'Upload Image',

        multiple: false
      }).open()
        .on('select', function(e) {

          var uploaded_image = image.state().get('selection').first();

   
          var image_url = uploaded_image.toJSON().url;

          $(".froala-view").prepend('<img src="' + image_url + '">');


        });
    });

    $('.fea-btn').on("click", ".fea", function(e) {
      e.preventDefault();
      var image = wp.media({
        title: 'Upload Image',

        multiple: false
      }).open()
        .on('select', function(e) { 

          var uploaded_image = image.state().get('selection').first();

          var image_url = uploaded_image.toJSON().url;
          var imageid = uploaded_image.toJSON().id;

          $(".wp-post-image").attr("src", image_url);
          $(".wp-post-image").attr("id", imageid);



        });

    });

    $('.fea-btn').on("click", ".add", function(e) {
      e.preventDefault();
      var image = wp.media({
        title: 'Upload Image',

        multiple: false
      }).open()
        .on('select', function(e) {

          var uploaded_image = image.state().get('selection').first();

          var image_url = uploaded_image.toJSON().url;
          var imageid = uploaded_image.toJSON().id;
          $(".post-fea").append('<img style="width:100%;" src="' + image_url + '" id="' + imageid + '" class="wp-post-image">');

        });

    });



    $('.fea-btn ').on('click', '.remo', function(event) {
      event.preventDefault();
      // $('.wp-post-image').remove();
      $('.wp-post-image').remove();

    });

     jQuery('.loader').hide();
    $('#la-save').click(function(event) {
      jQuery('.loader').show();
      event.preventDefault();
      var title = $('#la-title').html();
      var content = $('.froala-view').html();
      var image = $('.wp-post-image').attr('src');
      var data = {
        action: 'save_content_front',
        content: content,
        title: title,
        imageid: $(".wp-post-image").attr("id"),
        id: $('#la-id').data('laid'),
      };
      console.log(data);
      $.post(laAjax.url, data, function(resp) {
        console.log(resp);
        jQuery('.loader').hide();
      });
    });
  });