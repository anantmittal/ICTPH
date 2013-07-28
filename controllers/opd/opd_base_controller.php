<?php

  // TODO Expand this OPD Base controller for any OPD module common
  // functionality. If nothing emerges, we will revert back to the
  // Base_controller
//require_once(APPPATH.'controllers/base_controller.php');

class Opd_base_controller extends CI_Controller {
  protected function OPD_base_controller() {
    parent::__construct();
  }

  // TODO - fill in with real validation checks
  public function validate_id($id, $id_type) {
    return true;
  }

  function is_obgyn_eligible($person) {
    return (($person->gender == 'F') && ($person->age > 13));
  }

  function is_ped_eligible($person) {
    return ($person->age <= 15);
  }  
}
