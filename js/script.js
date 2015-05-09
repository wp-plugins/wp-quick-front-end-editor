  jQuery(function($){
    function initToolbarBootstrapBindings() {
      var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
      $.each(fonts, function (idx, fontName) {
          fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
      });
      $('a[title]').tooltip({container:'body'});
    	$('.dropdown-menu input').click(function() {return false;})
		    .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
        .keydown('esc', function () {this.value='';$(this).change();});

      $('[data-role=magic-overlay]').each(function () { 
        var overlay = $(this), target = $(overlay.data('target')); 
        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
      });
      if ("onwebkitspeechchange"  in document.createElement("input")) {
        var editorOffset = $('#editor').offset();
        $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editor').innerWidth()-35});
      } else {
        $('#voiceBtn').hide();
      }
	};
	function showErrorAlert (reason, detail) {
		var msg='';
		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
		else {
			console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
	};
    initToolbarBootstrapBindings();  
	$('#editor').wysiwyg({ fileUploadError: showErrorAlert} );
    window.prettyPrint && prettyPrint();



      jQuery('.loader').hide();
    $('#la-save').click(function(event) {
       jQuery('.loader').show();
    	event.preventDefault();
    var title = $('#la-title').html();
    var content = $('#editor').html();
    var data = {
    	action : 'save_content_front',
    	content : content,
      title : title,
    	id: $('#la-id').data('laid'),
    }
   		$.post(laAjax.url, data, function(resp) {
   			console.log(resp);
         jQuery('.loader').hide();
   		});
    });

      $('#upload-btn').click(function(e) {
    e.preventDefault();
    var image = wp.media({ 
      title: 'Upload Image',
      // mutiple: true if you want to upload multiple files at once
      multiple: false
    }).open()
    .on('select', function(e){
      // This will return the selected image from the Media Uploader, the result is an object
      var uploaded_image = image.state().get('selection').first();
      // We convert uploaded_image to a JSON object to make accessing it easier
      // Output to the console uploaded_image
      console.log(uploaded_image);
      var image_url = uploaded_image.toJSON().url;
      // Let's assign the url value to the input field
      // $('#image_url').val(image_url);
      // $("#image_url").attr("src",image_url);
      $("#editor").prepend('<img src="'+image_url+'">')
      // $(".wp-post-image").attr("src",image_url);

    });
  });
    
  });