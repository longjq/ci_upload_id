<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	/**
	 * 缩放图片
	 */
	function resize_img($source_image){
		$this->image_lib->clear();
		$config['image_library'] = 'gd2';
		$config['source_image'] = $source_image;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 500;
		$config['height'] = 400;
		$this->image_lib->initialize($config); 
		if (!$this->image_lib->resize()) {
 		   return $this->image_lib->display_errors();
		}
		
		$path_file = pathinfo(basename($source_image));
	
		$arr_img = getimagesize('assets/'.$path_file['filename'].'_thumb.'.$path_file['extension']);
		$arr_img['path'] = 'assets/'.$path_file['filename'].'_thumb.'.$path_file['extension'];
		
		return $arr_img;
	}
	
	/**
	 * 两张图合并
	 */
	function make_img($source_image,$add_img,$is_padding){
		$this->image_lib->clear();

		$config['image_library'] = 'gd2';
		
		$config['wm_type'] = 'overlay';
		$config['create_thumb'] = TRUE;
		$config['wm_overlay_path'] = $add_img['path'];
		$config['wm_opacity'] = 100;
		
		$path_file = pathinfo(basename($source_image));
		if($is_padding){
			
			$config['source_image'] = 'assets/'.$path_file['filename'].'_thumb.'.$path_file['extension'];
			$config['wm_vrt_offset'] = $add_img[1]+20;

			$this->image_lib->initialize($config); 
			$this->image_lib->watermark();
			
			unlink($config['source_image']);
		}else{
			$config['wm_vrt_offset'] = 0;
			$config['source_image'] = $source_image;

			$this->image_lib->initialize($config); 
			$this->image_lib->watermark();

			
		}
		
		unlink($config['wm_overlay_path']);
	}

	public function file_func(){
		if ($_FILES["file"]["error"] > 0)
		 {
		  	echo "Error: " . $_FILES["file"]["error"] . "<br />";
		}
		else
		 {
		 	print_r($_FILES);
			
			  echo "Upload: " . $_FILES["file"]["name"] . "<br />";
			  echo "Type: " . $_FILES["file"]["type"] . "<br />";
			  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
			  echo "Stored in: " . $_FILES["file"]["tmp_name"];
			  
			  move_uploaded_file($_FILES["file"]["tmp_name"],"upload/" . $_FILES["file"]["name"]);
      		echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
	  
	  		
		 }
	}
	
	public function index()
	{
		
		$this->load->view('demo.php');



		// $this->load->library('image_lib');

		// $arr_img1 = $this->resize_img('assets/ad_1.jpg');
		// $arr_img2 = $this->resize_img('assets/ad_2.jpg');

		
		// $this->make_img('assets/bg.jpg',$arr_img1,false);
		// $this->make_img('assets/bg.jpg',$arr_img2,true);


		// $this->load->library('image_lib');
		// $config['image_library'] = 'gd2';
		// $config['source_image'] = 'assets/ad_1.jpg';
		// $config['create_thumb'] = TRUE;
		// $config['maintain_ratio'] = TRUE;
		// $config['width'] = 500;
		// $config['height'] = 400;
		// $this->image_lib->initialize($config); 
		// if (!$this->image_lib->resize()) {
 	// 	   echo $this->image_lib->display_errors();
		// }
		// $arr_img1 = getimagesize('assets/ad_1_thumb.jpg');
		// $this->image_lib->clear();

		// $this->load->library('image_lib');
		// $config['image_library'] = 'gd2';
		// $config['source_image'] = 'assets/ad_2.jpg';
		// $config['create_thumb'] = TRUE;
		// $config['maintain_ratio'] = TRUE;
		// $config['width'] = 500;
		// $config['height'] = 400;
		// $this->image_lib->initialize($config); 
		// if (!$this->image_lib->resize()) {
 	// 	   echo $this->image_lib->display_errors();
		// }
		// $arr_img2 = getimagesize('assets/ad_2_thumb.jpg');
		// $this->image_lib->clear();
		
		// $config['image_library'] = 'gd2';
		// $config['source_image'] = 'assets/bg.jpg';
		// $config['wm_type'] = 'overlay';
		// $config['create_thumb'] = TRUE;
		// //$config['width'] = 450;
		// $config['wm_overlay_path'] = 'assets/ad_1_thumb.jpg';
		// $config['wm_opacity'] = 100;
		// $this->image_lib->initialize($config); 
		// $this->image_lib->watermark();

		// $this->image_lib->clear();

		// $config['image_library'] = 'gd2';
		// $config['source_image'] = 'assets/bg_thumb.jpg';
		// $config['wm_type'] = 'overlay';
		// $config['create_thumb'] = TRUE;
		// $config['wm_vrt_offset'] = $arr_img2[1]+20;
		// $config['wm_overlay_path'] = 'assets/ad_2_thumb.jpg';
		// $config['wm_opacity'] = 100;
		// $this->image_lib->initialize($config); 
		// $this->image_lib->watermark();
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */