<?php
include (APPPATH.'libraries/JTree.php');
class Visit_document_configuration extends CI_Controller {
	public function Visit_document_configuration() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('ignitedrecord/ignitedrecord');
		$this->load->model('chw/opd_diagnosis_model', 'opd_diagnosis');//by sachin
		$this->load->model('chw/chief_complaint_model', 'chief_complaint');
		$this->load->model('chw/review_of_system_model', 'review_of_system');//by sachin
		$this->load->model('chw/physical_exam_model', 'physical_exam');//by sachin
		$this->load->model('chw/protocol_information_model', 'protocol_information');//by sachin
		$this->load->helper('url');
		$this->load->helper('geo');
		$this->load->helper('form');
	}
	
	
	public function diagnosis($action=null){
		if (!$_POST) {
			return $this->load_diagnosis();
		}
		if($action == "add"){
			return $this->add_diagnosis();
		}else if($action == "delete"){
			return $this->delete_diagnosis();
		}else if($action == "add_system"){
			return $this->add_system();
		}else if($action == "remove_system"){
			return $this->delete_system();
		}else{
			return $this->load_diagnosis();
		}
	}
	
	private function load_diagnosis($failure_message = null,$sucess_message = null){
		$diagnosis_list = $this->opd_diagnosis->find_all();
		$data['diagnosis_list']=$diagnosis_list;
		$distnict_system = array();
		foreach($diagnosis_list  as $diagnosis){
			$distnict_system[$diagnosis->system_name] = ucwords($diagnosis->system_name);
		}
		
		asort($distnict_system);
		$data['distnict_system']=$distnict_system;//gives distinct systems
		$data['error_server'] = $failure_message;
		$data['success_message'] = $sucess_message;
		$this->load->view('admin/add_diagnosis', $data);
		return;
	}
	
	
	private function add_diagnosis(){
		$system_name = $_POST['system_name'];
		$system_name = strtolower($system_name); //converting to small letter
		$added_value = $_POST['added_value'];
		$this->db->trans_begin();
		$has_value = "false";
		$has_duplicate_values = "fasle";
		$duplicate_values = "";
		foreach ($added_value as $value) {
			$value=trim($value);
			if(!empty($value)){
				$value=strtolower($value);
				$has_value = "true";
				$duplicate_value = $this->opd_diagnosis->check_duplicate($value,$system_name);
				if (isset($duplicate_value) && $duplicate_value != '') {
					$has_duplicate_values = "true";
					if($duplicate_values != ""){
						$duplicate_values = $duplicate_values.",";
					}
					$duplicate_values = $duplicate_values.ucwords($value);
					continue;			
				}
				if (!$this->opd_diagnosis->save_value($value,$system_name))	{
					$msg = ucwords($value) ." exists under ".ucwords($system_name);
					return $this->load_diagnosis($msg);
				}			
			}
		}
		if($has_value == "false"){
			$msg = "Atleast one diagnosis value is required to add under " .ucwords($system_name);
			return $this->load_diagnosis($msg);
		}
		$this->db->trans_commit();
		if($has_duplicate_values == "true"){
			$msg = "$duplicate_values exists under $system_name";
			return $this->load_diagnosis($msg);
		}		
		$msg = "Value(s) added successfully under ".ucwords($system_name);
		return $this->load_diagnosis('',$msg);
	}
	
	private function delete_diagnosis(){
		$system_name = $_POST['system_name'];
		$system_name = strtolower($system_name); //converting to small letter
		$added_value = array();
		if(isset($_POST['delete_diagonsis'])){
			$added_value = $_POST['delete_diagonsis'];
		}
		$values_needs_to_delete = array();
		$i = 0;
		foreach ($added_value as $value) {
			if(!empty($value)){
				$value = strtolower($value); //converting to small letter
				$values_needs_to_delete[$i] = '"'.$value.'"';
				$i++;
			}
		}
		if(sizeof($values_needs_to_delete) === 0){
			$msg = "Please select atleast one diagnosis value to delete";
			return $this->load_diagnosis($msg);
		}
		$where = "value IN (".implode(",", $values_needs_to_delete).") AND system_name = \"$system_name\"";
		$this->db->trans_begin();
		$this->db->where($where);
		$this->db->delete('opd_diagnosis'); 
		$this->db->trans_commit();
		$msg = "Value(s) deleted successfully under " .ucwords($system_name);
		return $this->load_diagnosis('',$msg);
	}
	
	private function add_system(){ 
		$system_name_entered= $_POST['added_system'];
		
		//To check if system name already exists
		$system_name_check = $this->opd_diagnosis->where('system_name', $system_name_entered, true)->find();
		if($system_name_check!=null){
			$msg="System name ".ucwords($system_name_entered)." already exists ";
			return $this->load_diagnosis($msg);
		}
		$this->db->trans_begin();
		$saved_value = $this->opd_diagnosis->save_system(strtolower($system_name_entered));
		$this->db->trans_commit();
		$msg = 'System name ' . ucwords($system_name_entered) . ' has been successfully added';
		return $this->load_diagnosis('',$msg);
	}
	
	private function delete_system(){
		$systems_selected = array();
		$deleted_systems = array();
		$systems_to_delete = array();
		if(isset($_POST['delete_system'])){
			$systems_selected = $_POST['delete_system'];
		}
		$i = 0;
		foreach ($systems_selected as $value) {
			if(!empty($value)){
				$value = strtolower($value); //converting to small letter
				$systems_to_delete[$i] = '"'.$value.'"';
				$deleted_systems[$i] = ucwords($value);
				$i++;
			}
		}
		if(sizeof($systems_to_delete) === 0){
			$msg = "Please select atleast one System to delete";
			return $this->load_diagnosis($msg);
		}
		$where = "system_name IN (".implode(",", $systems_to_delete).")";
		$this->db->trans_begin();
		$this->db->where($where);
		$this->db->delete('opd_diagnosis'); 
		$this->db->trans_commit();
		$msg = "System ".implode(",", $deleted_systems). " deleted successfully  " ;
		return $this->load_diagnosis('',$msg);
		
	}
	
	public function ros($action=null){
		if (!$_POST) {
			return $this->load_ros();
		}
		if($action == "add"){
			return $this->add_ros();
		}else if($action == "add_root_element"){
			return $this->add_ros_root_node();
		}else if($action == "delete"){
			return $this->delete_ros();
		}else{
			return $this->load_ros();
		}
		
	}
	
	private function load_ros($failure_message = null,$sucess_message = null){
		$review_of_system_categories=$this->review_of_system->find_all();
  		$jtr = new JTree();
		//iterate building the tree
		foreach($review_of_system_categories as $category) {
	    	$uid = $jtr->createNode($category->value,$category->type,$category->id,$category->details);
	    	$parent_id = null;
	    	if(!empty($category->parent_id)) {
	       		$parent_id = $category->parent_id;
	    	}
	   		$jtr->addChild($parent_id, $uid);
		}
 		$data['review_of_system_tree'] = $jtr;
 		$data['error_server'] = $failure_message;
		$data['success_message'] = $sucess_message;
		$this->load->view('admin/add_ros', $data);
	}
	
	//To add root parent
	private function add_ros_root_node(){
		$parent_name = $_POST['newRootParent'];
		$parent_name = strtolower($parent_name); //converting to small letter
		$parent_type = 'RADIO';
		$add_ros_row = $this->review_of_system->where('value', $parent_name, true)->find();
		if($add_ros_row!=null){
			$msg=ucwords($parent_name)." already exists ";
			return $this->load_ros($msg);
		}
		$this->db->trans_begin();
		$saved_value = $this->review_of_system->save_root_value($parent_name,$parent_type);
		$this->db->trans_commit();
		$msg = 'Root element ' . ucwords($saved_value->value) . ' has been successfully added';
		return $this->load_ros('',$msg);
	}
	
	private function add_ros(){
		$child_name = $_POST['newChildElement'];
		$child_name = strtolower($child_name); //converting to small letter
		$child_type = $_POST['node_type'];
		$node_id = $_POST['nodeId'];
		$node_name = $_POST['nodeName'];
		$select_values=$_POST['commaSeparatedValues'];
		//echo $child_name." ".$child_type." ".$select_values;
		//return;
		//Special case for Radio button we have ony options no name.
		if($child_type == 'RADIO'){
			$child_name = $select_values;
		}
		$add_ros_row = $this->review_of_system->where('parent_id', $node_id, true)->where('value', $child_name, true)->find();
		if($add_ros_row!=null){
			$msg=ucwords($child_name).' already exists under '.ucwords($node_name);
			return $this->load_ros($msg);
		}
		$this->db->trans_begin();
		$saved_value = $this->review_of_system->save_value($child_name,$child_type,$node_id,$select_values);
		$this->db->trans_commit();
		$msg = 'Value ' . ucwords($saved_value->value) .' has been successfully added under '.ucwords($node_name);
		return $this->load_ros('',$msg);
	}
	
	//delete ros entry
	private function delete_ros(){
		$node_id = $_POST['nodeId'];
		$node_name = $_POST['nodeName'];
		$parent_id = $_POST['parentId'];
		$this->db->trans_begin();
		
		//TODO This delte logic needs to be changed to recurrsive logic as we do in other places
		
		if($parent_id == ""){
			$ros_record = $this->review_of_system->find_by('id',$node_id);
		}else{
			$ros_record = $this->review_of_system->where('parent_id', $parent_id, true)->where('value', $node_name, true)->find();
		}
		$this->db->where('id', $ros_record->id);
		$this->db->delete('review_of_systems');
		
		$ros_rec_list=$this->review_of_system->where('parent_id', $node_id, true)->find_all();
		if(isset($ros_rec_list) && sizeof($ros_rec_list) != 0 ){
			$this->recursive_delete_ros($node_id);
		}
		
		$this->db->trans_commit();
		$msg = 'Value ' .ucwords($node_name) .' has been successfully deleted';
		return $this->load_ros('',$msg);		
	}
	
	private function recursive_delete_ros($node_id){
		$recursive_val=$this->review_of_system->where('parent_id', $node_id, true)->find_all();
		if(isset($recursive_val) && sizeof($recursive_val) != 0 ){
			foreach($recursive_val as $val){
				$this->db->where('id', $val->id);
				$this->db->delete('review_of_systems');
				$recursive_child_val=$this->review_of_system->where('parent_id', $val->id, true)->find_all();
				if(isset($recursive_child_val) && sizeof($recursive_child_val) != 0 ){
					$this->recursive_delete_ros($val->id);
				}
			}
		}
	}
	
	// physial exam
	public function physical_exam($action=null){
		if (!$_POST) {
			return $this->load_physical_exam();
		}
		if($action == "add"){
			return $this->add_physical_exam();
		}else if($action == "add_root_element"){
			return $this->add_physical_exam_root_node();
		}else if($action == "delete"){
			return $this->delete_physical_exam();
		}else{
			return $this->load_physical_exam();
		}
		
	}
	
	private function load_physical_exam($failure_message = null,$sucess_message = null){
		$physical_exam_categories=$this->physical_exam->find_all();
  		$jt = new JTree();
		foreach($physical_exam_categories as $category) {
		    $uid = $jt->createNode($category->value,$category->type,$category->id,$category->details);
		    $parent_id = null;
		    if(!empty($category->parent_id)) {
		        $parent_id = $category->parent_id;
		    }
		    $jt->addChild($parent_id, $uid);
		}
 		$data['physical_exam_tree'] = $jt;
 		$data['error_server'] = $failure_message;
		$data['success_message'] = $sucess_message;
		$this->load->view('admin/add_physical_exam', $data);
	}
	
	
	private function add_physical_exam(){
		$child_name = $_POST['newChildElement'];
		$child_name = strtolower($child_name); //converting to small letter
		$child_type = $_POST['node_type'];
		$node_id = $_POST['nodeId'];
		$node_name = $_POST['nodeName'];
		$select_values=$_POST['commaSeparatedValues'];
		//Special case for Radio button we have ony options no name.
		if($child_type == 'RADIO'){
			$child_name = $select_values;
		}
		$add_physical_exam_row = $this->physical_exam->where('parent_id', $node_id, true)->where('value', $child_name, true)->find();
		if($add_physical_exam_row!=null){
			$msg=ucwords($child_name).' already exists under parent:'.ucwords($node_name);
			return $this->load_physical_exam($msg);
		}
		$this->db->trans_begin();
		$saved_value = $this->physical_exam->save_value($child_name,$child_type,$node_id,$select_values);
		$this->db->trans_commit();
		$msg = 'Value ' . ucwords($saved_value->value) .' has been successfully added under '.ucwords($node_name);
		return $this->load_physical_exam('',$msg);
	}
	
 	private function add_physical_exam_root_node(){
		$parent_name = $_POST['newRootParent'];
		$parent_name = strtolower($parent_name); //converting to small letter
		$parent_type = 'RADIO';
		$add_physical_exam_row = $this->physical_exam->where('value', $parent_name, true)->find();
		if($add_physical_exam_row!=null){
			$msg=ucwords($parent_name)." already exists ";
			return $this->load_physical_exam($msg);
		}else{
			$this->db->trans_begin();
			$saved_value = $this->physical_exam->save_root_value($parent_name,$parent_type);
			$this->db->trans_commit();
			$msg = 'Root element ' . ucwords($saved_value->value) . ' has been successfully added';
			return $this->load_physical_exam('',$msg);
		}
	}
	//delete physical exam entry
	private function delete_physical_exam(){
		$node_id = $_POST['nodeId'];
		$node_name = $_POST['nodeName'];
		$parent_id = $_POST['parentId'];	
		$this->db->trans_begin();
		//TODO This delte logic needs to be changed to recurrsive logic as we do in other places
		
		if($parent_id == ""){
			$physical_exam_rec = $this->physical_exam->find_by('id',$node_id);
		}else{
			$physical_exam_rec = $this->physical_exam->where('parent_id', $parent_id, true)->where('value', $node_name, true)->find();
		}
		$this->db->where('id', $physical_exam_rec->id);
		$this->db->delete('physical_exams');
		
		$physical_exam_rec_list=$this->physical_exam->where('parent_id', $node_id, true)->find_all();
		if(isset($physical_exam_rec_list) && sizeof($physical_exam_rec_list) != 0 ){
			$this->recursive_delete_physical_exam($node_id);
		}
		
		$this->db->trans_commit();
		$msg = 'Value ' . ucwords($node_name) .' has been successfully deleted';
		return $this->load_physical_exam('',$msg);		
	}
	
	private function recursive_delete_physical_exam($node_id){
		//see for multiple columns
		$recursive_val=$this->physical_exam->where('parent_id', $node_id, true)->find_all();
		if(isset($recursive_val) && sizeof($recursive_val) != 0 ){
			foreach($recursive_val as $val){
				$this->db->where('id', $val->id);
				$this->db->delete('physical_exams');
				$recursive_child_val=$this->physical_exam->where('parent_id', $val->id, true)->find_all();
				if(isset($recursive_child_val) && sizeof($recursive_child_val) != 0 ){
					$this->recursive_delete_physical_exam($val->id);
				}
			}
		}
	}
	
	//protocol information
	public function protocol_information($action=null){
		if (!$_POST) {
			return $this->load_protocol_information();
		}
		if($action == "add"){
			return $this->add_protocol_information();
		}else if($action == "add_root_element"){
			return $this->add_protocol_information_root_node();
		}else if($action == "delete"){
			return $this->delete_protocol_information();
		}else{
			return $this->load_protocol_information();
		}
	}
	
	private function load_protocol_information($failure_message = null,$sucess_message = null){
		$protocol_information_categories=$this->protocol_information->find_all();
	    $jtp = new JTree();
	    foreach($protocol_information_categories as $category){
	    	$uid = $jtp->createNode($category->value,$category->type,$category->id,$category->details);
	    	$parentId = null;
	    	if(!empty($category->parent_id)){
	    		$parentId = $category->parent_id;
	    	}
	    	$jtp->addChild($parentId, $uid);
	    }
	    $data['protocol_information_tree'] = $jtp;
 		$data['error_server'] = $failure_message;
		$data['success_message'] = $sucess_message;
		$this->load->view('admin/add_protocol_information', $data);
	}
	
	private function add_protocol_information(){
		$child_name = $_POST['newChildElement'];
		$child_name = strtolower($child_name); 
		$child_type = $_POST['node_type'];
		$node_id = $_POST['nodeId'];
		$node_name = $_POST['nodeName'];
		$select_values=$_POST['commaSeparatedValues'];
		//Special case for Radio button we have ony options no name.
		if($child_type == 'RADIO'){
			$child_name = $select_values;
		}
		$add_protocol_information_row = $this->protocol_information->where('parent_id', $node_id, true)->where('value', $child_name, true)->find();
		if($add_protocol_information_row!=null){
			$msg=ucwords($child_name).' already exists under parent:'.ucwords($node_name);
			return $this->load_protocol_information($msg);
		}
		$this->db->trans_begin();
		$saved_value = $this->protocol_information->save_value($child_name,$child_type,$node_id,$select_values);
		$this->db->trans_commit();
		$msg = 'Value ' . ucwords($saved_value->value) .' has been successfully added under '.ucwords($node_name);
		return $this->load_protocol_information('',$msg);
	}
	
 	private function add_protocol_information_root_node(){
		$parent_name = $_POST['newRootParent'];
		$parent_name = strtolower($parent_name); //converting to small letter
		$parent_type = 'RADIO';
		$add_protocol_information_row = $this->protocol_information->where('value', $parent_name, true)->find();
		if($add_protocol_information_row!=null){
			$msg=ucwords($parent_name)." already exists ";
			return $this->load_protocol_information($msg);
		}else{
			$this->db->trans_begin();
			$saved_value = $this->protocol_information->save_root_value($parent_name,$parent_type);
			$this->db->trans_commit();
			$msg = 'Root element ' . ucwords($saved_value->value) . ' has been successfully added';
			return $this->load_protocol_information('',$msg);
		}
	}
	private function delete_protocol_information(){
		$node_id = $_POST['nodeId'];
		$node_name = $_POST['nodeName'];
		$parent_id = $_POST['parentId'];	
		$this->db->trans_begin();
		//TODO This delte logic needs to be changed to recurrsive logic as we do in other places
		
		if($parent_id == ""){
			$protocol_information_rec = $this->protocol_information->find_by('id',$node_id);
		}else{
			$protocol_information_rec = $this->protocol_information->where('parent_id', $parent_id, true)->where('value', $node_name, true)->find();
		}
		$this->db->where('id', $protocol_information_rec->id);
		$this->db->delete('protocol_informations');
		
		$protocol_information_rec_list=$this->protocol_information->where('parent_id', $node_id, true)->find_all();
		if(isset($protocol_information_rec_list) && sizeof($protocol_information_rec_list) != 0 ){
			$this->recursive_delete_protocol_information($node_id);
		}
		$this->db->trans_commit();
		$msg = 'Value ' . ucwords($node_name) .' has been successfully deleted';
		return $this->load_protocol_information('',$msg);
				
	}
	
	private function recursive_delete_protocol_information($node_id){
		//see for multiple columns
		$recursive_val=$this->protocol_information->where('parent_id', $node_id, true)->find_all();
		if(isset($recursive_val) && sizeof($recursive_val) != 0 ){
			foreach($recursive_val as $val){
				$this->db->where('id', $val->id);
				$this->db->delete('protocol_informations');
				$recursive_child_val=$this->protocol_information->where('parent_id', $val->id, true)->find_all();
				if(isset($recursive_child_val) && sizeof($recursive_child_val) != 0 ){
					$this->recursive_delete_protocol_information($val->id);
				}
			}
		}
	}
	
	public function chief_complaint($action=null){
		if (!$_POST) {
			return $this->load_chief_complaint();
		}
		if($action == "add"){
			return $this->add_chief_complaint();
		}else if($action == "delete"){
			return $this->delete_chief_complaint();
		}else{
			return $this->load_chief_complaint();
		}
	}
	
	private function load_chief_complaint($failure_message = null,$sucess_message = null){
		$chief_complaint_list = $this->chief_complaint->order_by('value')->find_all();
		$data['chief_complaint_list']=$chief_complaint_list;
		/*$distnict_system = array();
		foreach($chief_complaint_list  as $chief_complaint){
			$distnict_system[$chief_complaint->value] = ucwords($chief_complaint->value);
		}
		asort($distnict_system);
		$data['distnict_system']=$distnict_system;//gives distinct systems
		*/
		$data['error_server'] = $failure_message;
		$data['success_message'] = $sucess_message;
		$this->load->view('admin/chief_complaint', $data);
		return;
	}
	
	
	private function add_chief_complaint(){
		$added_value = $_POST['added_value'];
		$this->db->trans_begin();
		$has_value = "false";
		$has_duplicate_values = "fasle";
		$duplicate_values = "";
		$values_saved = array();
		foreach ($added_value as $value) {
			$value=trim($value);
			if(!empty($value)){
				$value=strtolower($value);
				$has_value = "true";
				$duplicate_value = $this->chief_complaint->check_duplicate($value);
				if (isset($duplicate_value) && $duplicate_value != '') {
					$has_duplicate_values = "true";
					if($duplicate_values != ""){
						$duplicate_values = $duplicate_values.",";
					}
					$duplicate_values = $duplicate_values.ucwords($value);
					continue;			
				}
				if($this->chief_complaint->save_value($value))	{
					array_push($values_saved,ucwords($value));
				}		
			}
		}
		if($has_value == "false"){
			$msg = "Atleast one diagnosis value is required to add under " ;
			return $this->load_chief_complaint($msg);
		}
		$this->db->trans_commit();
		if($has_duplicate_values == "true"){
			$msg = "$duplicate_values exists";
			return $this->load_chief_complaint($msg);
		}		
		$msg = implode(",",$values_saved) ." Value(s) added successfully ";
		return $this->load_chief_complaint('',$msg);
	}
	
	private function delete_chief_complaint(){
		$added_value = array();
		$deleted_values = array();
		if(isset($_POST['delete_diagonsis'])){
			$added_value = $_POST['delete_diagonsis'];
		}
		$values_needs_to_delete = array();
		$i = 0;
		foreach ($added_value as $value) {
			if(!empty($value)){
				$value = strtolower($value); //converting to small letter
				$values_needs_to_delete[$i] = '"'.$value.'"';
				$deleted_values[$i] = ucwords($value);
				$i++;
			}
		}
		if(sizeof($values_needs_to_delete) === 0){
			$msg = "Please select atleast one chief compliant value to delete";
			return $this->load_chief_complaint($msg);
		}
		$where = "value IN (".implode(",", $values_needs_to_delete).")";
		$this->db->trans_begin();
		$this->db->where($where);
		$this->db->delete('chief_complaints'); 
		$this->db->trans_commit();
		$msg = implode(",", $deleted_values). " Value(s) deleted successfully  " ;
		return $this->load_chief_complaint('',$msg);
	}
}