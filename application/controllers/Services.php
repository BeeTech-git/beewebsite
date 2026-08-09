<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/About
	 *	- or -
	 * 		http://example.com/index.php/About/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/projects/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function __construct()
        {
                parent::__construct();
                // Your own constructor code
        }
        
	public function index()
	{
        $data = array();
		$this->load->view('services', $data);
	}
	
	public function detail($slug) {
        $allowed_views = [
            'web-design',
            'ui-ux-design',
            'graphic-design',
            'mobile-app-development',
            'seo-optimization',
            'data-analytics',
            'social-media-management',
            'content-creation',
            'branding'
        ];
    
        if (in_array($slug, $allowed_views)) {
            $this->load->view('services/' . $slug); // Loads e.g., services/web-design.php
        } else {
            show_404(); // If slug doesn't match any of your 9 pages
        }
    }

}
