<?php 	
	/**
	* Plugin Main Class
	*/
	class LA_Front_Edit
	{
		
		function __construct()
		{
			add_filter( 'the_title', array($this,'editable_title'));
			add_filter( 'the_content', array($this,'editable_content'));
			add_action( 'wp_enqueue_scripts', array($this,'add_scripts'));
			add_action( 'wp_ajax_save_content_front', array($this, 'save_content_front') );
		}

		function editable_title($title){
			 if (current_user_can('manage_options') && in_the_loop()){
            	$title = '<span contenteditable="true" id="la-title">'.$title.'</span> <span class="text-muted hid bg-info" style="font-size: 12px;display: inline;">Click title to change</span>';
       		 }
        	return $title;
		}


		function save_content_front(){ 

			extract($_REQUEST);
			set_post_thumbnail( $id, $imageid );
			delete_post_thumbnail( $id, $imageid );
			set_post_thumbnail( $id, $imageid );
			// if (function_exists('add_theme_support')) {
	  // 			add_theme_support('post-thumbnails');
	  // 			set_post_thumbnail_size(150,150);
			// 	}
			
			  $my_post = array(
			      'ID'           => $id,
			      'post_title' => $title,
			      'post_content' => $content,
			  );

			  wp_update_post( $my_post );
			  

			die(0);
		}

		function editable_content($content){
			 if (current_user_can('manage_options') && in_the_loop()){
			 	global $post;

    		
    $content ='
	<style>
		.editor {
		  max-height: 550px;
		  height: 350px;
		  background-color: white;
		  border-collapse: separate;
		  border: 1px solid rgb(204, 204, 204);
		  padding: 4px;
		  box-sizing: content-box;
		  -webkit-box-shadow: rgba(0, 0, 0, 0.0745098) 0px 1px 1px 0px inset;
		  box-shadow: rgba(0, 0, 0, 0.0745098) 0px 1px 1px 0px inset;
		  border-top-right-radius: 3px;
		  border-bottom-right-radius: 3px;
		  border-bottom-left-radius: 3px;
		  border-top-left-radius: 3px;
		  overflow: scroll;
  		  outline: none;
  		  resize : vertical;
		}
		
	</style>
    <div class="btn-toolbar" data-role="editor-toolbar" data-target=".editor">
      <div class="btn-group">
        <a class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
          <ul class="dropdown-menu">
          </ul>
        </div>
      <div class="btn-group">
        <a class="btn btn-sm btn-default dropdo
	<button style="position: fixed;top: 1px;left: 35%;z-index: 999000;" class="btn btn-sm btn-default activep"> <i class="fa fa-pencil"></i> Enable WP Quick Front Editor </button>
	<button style="position: fixed;top: 1px;left: 35%;z-index: 999000;" class="btn btn-sm btn-danger deactive"> <i class="fa fa-shield"></i> Disable WP Quick Front Editor</button>
wn-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
          <ul class="dropdown-menu">
          <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
          <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
          <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
          </ul>
      </div>
      <div class="btn-group">
        <a class="btn btn-sm btn-default" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
        <a class="btn btn-sm btn-default" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
        <a class="btn btn-sm btn-default" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
        <a class="btn btn-sm btn-default" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
      </div>
      <div class="btn-group">
        <a class="btn btn-sm btn-default" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
        <a class="btn btn-sm btn-default" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
        <a class="btn btn-sm btn-default" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-indent"></i></a>
        <a class="btn btn-sm btn-default" data-edit="indent" title="Indent (Tab)"><i class="fa fa-dedent"></i></a>
      </div>
      <div class="btn-group">
        <a class="btn btn-sm btn-default" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
        <a class="btn btn-sm btn-default" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
        <a class="btn btn-sm btn-default" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
        <a class="btn btn-sm btn-default" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
      </div>
      <div class="btn-group">
		  <a class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
		    <div class="dropdown-menu input-append">
			    <input class="form-control" placeholder="URL" type="text" data-edit="createLink"/>
			    <button type="button">Add</button>
        	</div>
        <a class="btn btn-sm btn-default" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-scissors"></i></a>

      </div>
      
      <div class="btn-group">
        <a class="btn btn-sm btn-default" title="Insert picture (or just drag & drop)" id="upload-btn"><i class="fa fa-file-image-o"></i> Upload Image</a>
        
      </div>
      <div class="btn-group">
        <a class="btn btn-sm btn-default" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
        <a class="btn btn-sm btn-default" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
      </div>
      <div class="btn-group fea-btn">
		<button  class="add btn btn-sm btn-primary"><i class="fa fa-picture-o"></i> Add Feature Image</button>
		<button  class="fea btn btn-sm btn-success"> <i class="fa fa-picture-o"></i> Change Feature Image</button>
		<button  class="remo btn btn-sm btn-danger"><i class="fa fa-times"></i> Remove Feature Image</button>
	</div>
    </div>

    <div class="editor eneditor" >
      '.$content.'
    </div> <br>
<div>
 <img class="pull-right loader" src="'.plugins_url( "images/ajax-loader.gif", __FILE__  ).'" style="margin-left: 5px;"><button class="btn btn-primary pull-right" id="la-save">Save Changes</button> <span id="la-id" data-laid="'.$post->ID.'"></span>
</div>

 ';
	   	
       		 }
        	
		return $content;
		}
		function add_scripts(){
			if (current_user_can('manage_options')){
				
			wp_enqueue_style( 'bootstrap-css', plugins_url( 'css/bootstrap.min.css', __FILE__ ));
			wp_enqueue_style( 'font-awesome', plugins_url( 'font-awesome/css/font-awesome.min.css', __FILE__ ),array('bootstrap-css'));
			wp_enqueue_script( 'bootstrap-js', plugins_url( 'js/bootstrap.min.js', __FILE__ ),array('jquery'));
			wp_enqueue_script( 'hotkeys-js', plugins_url( 'js/jquery.hotkeys.js', __FILE__ ),array('jquery'));
			wp_enqueue_script( 'bootstrap-wysiwyg', plugins_url( 'js/bootstrap-wysiwyg.js', __FILE__ ),array('jquery','bootstrap-js'));
			wp_enqueue_script( 'la-custom-js', plugins_url( 'js/script.js', __FILE__ ),array('jquery','bootstrap-js','bootstrap-wysiwyg'));
			wp_localize_script( 'la-custom-js', 'laAjax', array( 'url' => admin_url( 'admin-ajax.php' )));
			wp_enqueue_media( );
			}
		}

	}
 ?>