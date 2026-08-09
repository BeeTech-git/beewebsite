<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/Products
	 *	- or -
	 * 		http://example.com/index.php/Products/index
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
		        $this->load->helper('url');
		        $this->load->library("pagination");
        }
        
	public function index()
	{
	    $this->load->model('Header_model'); // whatever you call it

        $config = array();
        $catid = $this->uri->segment(2);
        $config["base_url"] = base_url() . "Products/".$catid."/";
        $data['categories'] =  $this->Header_model->getCategories();
        $config["total_rows"] = $this->Header_model->get_count('products',$catid);
        $config["per_page"] = 12;
        $config["uri_segment"] = 2;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["links"] = $this->pagination->create_links();

        $data['basic_info'] =  $this->Header_model->getBasicInfo();
        $data['category'] =  $this->Header_model->getCategories($catid);
        $data['products']  =  $this->Header_model->getFunctionn('products',$catid,$config["per_page"], $page);
        // echo "<pre>"; print_r($data); exit;
		$this->load->view('product', $data);
	}
}
