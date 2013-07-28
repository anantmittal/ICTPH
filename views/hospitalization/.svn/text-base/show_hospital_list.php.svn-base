<?php $this->load->helper('form');
      $this->load->view('common/header');
      $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>
<div id="main">
  <!--Preauth Box End-->
  <div class="hospit_box">
    	<div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"><span class="head_box">Hospital List</span></div></div></div>

          <div class="blue_body">
            <table border="0" cellpadding="2" cellspacing="2" width="100%">
              <tbody><tr class="head">
                <td width="10%">Location</td>
                <td width="9%">Registration number</td>
                <td width="15%">Name</td>
                <td width="17%">Address</td>

                <td width="17%">Type</td>
                <td width="11%">Status</td>
                <td width="15%">Rate list link</td>
                <td width="6%">&nbsp;</td>
              </tr>              

             <?php foreach ($hospital_list as $hospital_row){             	
		  // TODO: link district ID to district table
		  echo "<tr class='grey_bg'><td>$hospital_row->city_or_village</td><td>$hospital_row->registration_number</td><td>$hospital_row->name</td>
              <td>$hospital_row->street_address</td><td>$hospital_row->type</td><td>$hospital_row->status</td><td>";
		  if ($hospital_row->status == 'empanelled') {
		    echo "<a href='".$this->config->item('base_url')."uploads/rate_list_files/$hospital_row->rate_list_file'>$hospital_row->rate_list_file</a>";	
		  }
		  else echo  '&nbsp;';              
		  echo "</td><td><a href='". $this->config->item('base_url')."index.php/hospitalization/hospital_management/edit_hospital/$hospital_row->id'>Edit</a></td></tr>";
		}
             ?>
              
              
            </tbody></table>           
            <div class="form_row">
            <a href="<?php echo $this->config->item('base_url').'index.php/hospitalization/hospital_management/add_hospital'?>"><input name="button" id="button" value="Add Another Hospital" class="submit" type="submit"></a>
          </div>
            

</div>
          <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
    </div>
    
    
<br class="spacer"></div>
<!-- Body End -->
<?php $this->load->view('common/footer'); ?>
