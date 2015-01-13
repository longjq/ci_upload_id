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
	public function index()
	{

	

		$this->load->library('image_lib');
		$config['image_library'] = 'gd2';
		$config['source_image'] = 'assets/ad_1.jpg';
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 500;
		$config['height'] = 400;
		$this->image_lib->initialize($config); 
		if (!$this->image_lib->resize()) {
 		   echo $this->image_lib->display_errors();
		}
		$arr_img1 = getimagesize('assets/ad_1_thumb.jpg');
		$this->image_lib->clear();

		$this->load->library('image_lib');
		$config['image_library'] = 'gd2';
		$config['source_image'] = 'assets/ad_2.jpg';
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 500;
		$config['height'] = 400;
		$this->image_lib->initialize($config); 
		if (!$this->image_lib->resize()) {
 		   echo $this->image_lib->display_errors();
		}
		$arr_img2 = getimagesize('assets/ad_2_thumb.jpg');
		$this->image_lib->clear();
		
		$config['image_library'] = 'gd2';
		$config['source_image'] = 'assets/bg.jpg';
		$config['wm_type'] = 'overlay';
		$config['create_thumb'] = TRUE;
		//$config['width'] = 450;
		$config['wm_overlay_path'] = 'assets/ad_1_thumb.jpg';
		$config['wm_opacity'] = 100;
		$this->image_lib->initialize($config); 
		$this->image_lib->watermark();

		$this->image_lib->clear();

		$config['image_library'] = 'gd2';
		$config['source_image'] = 'assets/bg_thumb.jpg';
		$config['wm_type'] = 'overlay';
		$config['create_thumb'] = TRUE;
		$config['wm_vrt_offset'] = $arr_img2[1]+20;
		$config['wm_overlay_path'] = 'assets/ad_2_thumb.jpg';
		$config['wm_opacity'] = 100;
		$this->image_lib->initialize($config); 
		$this->image_lib->watermark();
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */