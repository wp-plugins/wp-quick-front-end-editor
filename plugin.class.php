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
		
	</style>
	<button style="position: fixed;top: 1px;left: 35%;z-index: 999000;" class="btn btn-sm btn-default activep"> <i class="fa fa-pencil"></i> Enable WP Quick Front Editor </button>
	<button style="position: fixed;top: 1px;left: 35%;z-index: 999000;" class="btn btn-sm btn-danger deactive"> <i class="fa fa-shield"></i> Disable WP Quick Front Editor</button>
	  <div class="btn-group fea-btn">
			<button  class="add btn btn-sm btn-primary"><i class="fa fa-picture-o"></i> Add Feature Image</button>
			<button  class="fea btn btn-sm btn-success"> <i class="fa fa-picture-o"></i> Change Feature Image</button>
			<button  class="remo btn btn-sm btn-danger"><i class="fa fa-times"></i> Remove Feature Image</button>
		</div>
		<div class="btn-group">
        <a class="btn btn-sm btn-default" title="Insert picture (or just drag & drop)" id="upload-btn"><i class="fa fa-file-image-o"></i> Add Image</a>
        
      </div>
    <div >
    	<div id="edit" class="eneditor">
    		
    	
      '.$content.'
      </div>
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
			wp_enqueue_style( 'floaral-css', plugins_url( 'css/froala_editor.min.css', __FILE__ ));
			wp_enqueue_style( 'floaral-style', plugins_url( 'css/froala_style.min.css', __FILE__ ));
			wp_enqueue_style( 'floaral-theme', plugins_url( 'css/royal.min.css', __FILE__ ));
			wp_enqueue_style( 'font-awesome', plugins_url( 'font-awesome/css/font-awesome.min.css', __FILE__ ),array('bootstrap-css'));
			// wp_enqueue_script( 'hotkeys-js', plugins_url( 'js/jquery.hotkeys.js', __FILE__ ),array('jquery'));
			wp_enqueue_script( 'bootstrap-wysiwyg', plugins_url( 'js/froala_editor.min.js', __FILE__ ),array('jquery'));
			wp_enqueue_script( 'tables-js', plugins_url( 'js/tables.min.js', __FILE__ ));
			wp_enqueue_script( 'lists-js', plugins_url( 'js/lists.min.js', __FILE__ ));
			wp_enqueue_script( 'video-js', plugins_url( 'js/video.min.js', __FILE__ ));
			wp_enqueue_script( 'la-custom-js', plugins_url( 'js/script.js', __FILE__ ),array('jquery','bootstrap-wysiwyg'));
			wp_localize_script( 'la-custom-js', 'laAjax', array( 'url' => admin_url( 'admin-ajax.php' )));
			wp_enqueue_media( );
			}
		}

	}
 ?>