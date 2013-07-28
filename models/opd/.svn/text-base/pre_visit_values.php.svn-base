<?php
class pre_visit_values extends CI_Model{
	private $_temperature;
	private $_pulse;
	private $_respiratory_rate;
	private $_bp_systolic;
	private $_bp_diastolic;
	private $_weight;
	private $_height;
	private $_waist;
	private $_hip;
	private $_head;
	private $_upper_arm;
	private $_vision_right;
	private $_vision_left;
	private $_near_vision;
	private $_cataract;
	private $_date;
	private $_vision_exam_consent;
	private $_via_vili_consent;
	
	public function __construct() {
	}
	
	public function form_pisp_object($pisp){
		$object = new pre_visit_values();
		if(isset($pisp['systole'])){
			$object->_bp_systolic= $pisp['systole'];
		}
		if(isset($pisp['diastole'])){
			$object->_bp_diastolic = $pisp['diastole'];
		}
		if(isset($pisp['weight'])){
			$object->_weight = $pisp['weight'];
		}
		if(isset($pisp['height'])){
			$object->_height = $pisp['height'];
		}
		if(isset($pisp['wc'])){
			$object->_waist = $pisp['wc'];
		}
		if(isset($pisp['hc'])){
			$object->_hip = $pisp['hc'];
		}
		if(isset($pisp['va_distance_r'])){
			$object->_vision_right = $pisp['va_distance_r'];
		}
		if(isset($pisp['va_distance_l'])){
			$object->_vision_left = $pisp['va_distance_l'];
		}
		if(isset($pisp['va_near'])){
			$object->_near_vision = $pisp['va_near'];
		}
		if(isset($pisp['va_cataract'])){
			$object->_cataract = $pisp['va_cataract'];
		}
		if(isset($pisp['date'])){
			$object->_date = $pisp['date'];
		}
		if(isset($pisp['via_vili_consent'])){
			$object->_via_vili_consent = $pisp['via_vili_consent'];
		}
		if(isset($pisp['vision_exam_consent'])){
			
			$object->_vision_exam_consent = $pisp['vision_exam_consent'];
		}
		return $object;
	}
	
	
	public function form_preconsultation_object($preconsultation,$pre_consultation_date,$visit_visuals_rec){
		$object = new pre_visit_values();
		$object->_temperature = $preconsultation->temperature_f;
		$object->_pulse = $preconsultation->pulse;
		$object->_respiratory_rate = $preconsultation->respiratory_rate;
		//$object->_bp_systolic = $preconsultation->bp_systolic;
		//$object->_bp_diastolic = $preconsultation->bp_diastolic;
		$object->_weight = $preconsultation->weight_kg;
		$object->_height = $preconsultation->height_cm;
		$object->_waist = $preconsultation->waist_cm;
		$object->_hip = $preconsultation->hip_cm;
		$object->_head = $preconsultation->head_circumference_cm;
		$object->_upper_arm = $preconsultation->arm_circumference_cm;
		$object->_date = $pre_consultation_date;
		$object->_vision_right = $visit_visuals_rec->va_distance_r;
		$object->_vision_left = $visit_visuals_rec->va_distance_l;
		$object->_near_vision = $visit_visuals_rec->va_near;
		$object->_cataract = $visit_visuals_rec->va_cataract;
		$object->_vision_exam_consent = $visit_visuals_rec->vision_exam_consent;
		return $object;
	}
	
	public function form_blank_object(){
		$object = new pre_visit_values();
		$object->_temperature = "";
		$object->_pulse = "";
		$object->_respiratory_rate = "";
		$object->_bp_systolic = "";
		$object->_bp_diastolic = "";
		$object->_weight = "";
		$object->_height = "";
		$object->_waist = "";
		$object->_hip = "";
		$object->_head = "";
		$object->_upper_arm = "";
		$object->_date = "";
		return $object;
	}
	// getters of all instance variables
		
	public function getTemperature(){
		return $this->_temperature;
	}
	
	public function getPulse(){
		return $this->_pulse;
	}
	
	public function getRespiratoryRate(){
		return $this->_respiratory_rate;
	}
	
	public function getBpSystolic(){
		return $this->_bp_systolic;
	}
	
	public function getBpDiastolic(){
		return $this->_bp_diastolic;
	}
	
	public function getWeight(){
		return $this->_weight;
	}
	
	public function getHeight(){
		return $this->_height;
	}
	
	public function getWaist(){
		return $this->_waist;
	}
	
	public function getHip(){
		return $this->_hip;
	}
	
	public function getHead(){
		return $this->_head;
	}	
	
	public function getUpperArm(){
		return $this->_upper_arm;
	}
	
	public function getVisionRight(){
		return $this->_vision_right;
	}
	
	public function getVisionLeft(){
		return $this->_vision_left;
	}
	
	public function getNearVision(){
		return $this->_near_vision;
	}
	
	public function getCataract(){
		return $this->_cataract;
	}
	
	public function getDate(){
		return $this->_date;
	}
	public function getViaViliConsent(){
		return $this->_via_vili_consent;
		
	}
	public function getVisionExamConsent(){
		return $this->_vision_exam_consent;
	}
}

 