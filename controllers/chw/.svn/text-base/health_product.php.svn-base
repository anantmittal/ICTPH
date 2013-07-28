<?php
class health_product extends CI_Controller {
	public $form_data = array();
	function add(){

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'name', 'Brand Name', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );


		if (! isset ( $_POST ['name'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'chw/health_product_add' );
		} else {
			$this->load->model ( 'chw/health_product_model', 'product' );
			$product_obj = $this->product->new_record ( $_POST );
//			$product_obj->save ();
			if($product_obj->save ())
			{
    				$this->session->set_userdata('msg', 'Product: '.$product_obj->name.' saved successfully');
				redirect('/chw/search/home');
			}
			else
			{
    				$this->session->set_userdata('msg', 'Product: '.$product_obj->name.' saved unsuccessful');
				$this->load->view ( 'chw/health_product_add');
			}
		}

	}

	function edit_()
	{
		$url = "/chw/health_product/edit/".$_POST['hid_edit'];
		redirect($url);
	}
		
	function edit($product_id = ''){
		if($product_id == '') {
			echo 'product id sent blank';
			return;
		}

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'name', 'Brand Name', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		$this->load->model ( 'chw/health_product_model', 'product' );
		$product_obj = $this->product->find($product_id);
		$this->form_data['product_obj'] = & $product_obj;

		if (! isset ( $_POST ['name'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'chw/health_product_add', $this->form_data);
		} else {
			$product_obj->load_postdata(array('name','generic_name', 'description',
								'form','pack_form','pack_num_dosages','pack_sale_price'));
			if($product_obj->save ())
			{
    				$this->session->set_userdata('msg', 'Product: '.$product_obj->name.' saved successfully');
//    				$this->session->set_userdata('msg', 'Product saved successfully');
				redirect('/chw/search/home');
			}
			else
			{
//    				$this->session->set_userdata('msg', 'Product saved unsuccessful');
    				$this->session->set_userdata('msg', 'Product: '.$product_obj->name.' saved unsuccessful');
				$this->load->view ( 'chw/health_product_add', $this->form_data);
			}
	
		}
	}

	function  lists(){

	}
}

?>
