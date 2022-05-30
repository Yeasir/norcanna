<?php

function print_die($var){
	echo "<pre>";
	var_dump($var);
	die();
}

require_once trailingslashit(__DIR__) . 'twilio.php';

function norcanna_change_upload_path(){
	return trailingslashit( WP_CONTENT_DIR ) . 'uploads/image/';
}
function norcanna_change_upload_url(){
	return trailingslashit(content_url()) . 'uploads/image/';
}

function original_resize( $uploadedfile, $width=500, $height=500, $imgRESIZE=true ){
	$image_editor = wp_get_image_editor( $uploadedfile );
	if ( ! is_wp_error( $image_editor ) ) {
		if($imgRESIZE == true){
			$w_RESIZE = $width;
			$h_RESIZE = $height;
			$file_info = pathinfo($uploadedfile);
			$dir = trailingslashit($file_info['dirname']);
			$file_name = $file_info['basename'];
			$ext = $file_info['extension'];
			$file_name_without_ext = str_replace('.'.$ext, '', $file_name);
			$new_name = $dir . $file_name_without_ext . '-thumb'. '.' . $ext;

			$sizeORIG = $image_editor->get_size();

			if( ( isset( $sizeORIG['width'] ) && $sizeORIG['width'] > $w_RESIZE ) || ( isset( $sizeORIG['height'] ) && $sizeORIG['height'] > $h_RESIZE ) ) {
				$image_editor->resize( $w_RESIZE, $h_RESIZE, false );
				$image_editor->set_quality(80);
				$image_editor->save( $new_name );
			}
		}
	}
}

//add_action('init', 'norcanna_process_id_image_upload');
add_action('wp_ajax_nopriv_id_image_upload', 'norcanna_process_id_image_upload');
add_action('wp_ajax_id_image_upload', 'norcanna_process_id_image_upload');
function norcanna_process_id_image_upload(){
	if(!empty($_POST['action']) && $_POST['action'] === 'id_image_upload'  && !empty($_FILES)){

//		define('DOING_AJAX', true);
		$response = array(
			'type' => 'error'
		);
		add_filter( 'pre_option_upload_path', 'norcanna_change_upload_path');
		add_filter( 'pre_option_upload_path', 'norcanna_change_upload_url');

		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}

		$uploadedfile = $_FILES['image'];
		$upload_overrides = array( 'test_form' => false );
		$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );


		if ( $movefile && ! isset( $movefile['error'] ) ) {
			original_resize($movefile['file'], 100, 100);
			$response['type'] = 'success';
			$response['data'] = $movefile;
		} else {
			$response['msg'] = $movefile['error'];
		}
		remove_filter( 'pre_option_upload_path', 'norcanna_change_upload_path');
		remove_filter( 'pre_option_upload_path', 'norcanna_change_upload_url');
		wp_send_json( $response );
	}
}




add_action('template_redirect', function (){
	if(isset($_GET['msg'])){
		$data = array(
			'to' => '+8801711040736',
			'body' => 'I am testing.',
			'from' => true,
		);
		$twl = new Twilio_Integration(false, $data);
		var_dump($twl->sendMessage());

		die();
	}
});
