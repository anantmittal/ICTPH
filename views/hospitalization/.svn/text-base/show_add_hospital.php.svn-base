<?php 
$this->load->helper('form');
$this->load->view('common/header');
?>
<title>Add Hospital</title>
<script >
$(document).ready(function(){	
   $("#status").change(function(event){
      if(this.value == 'empanelled')
      	$('#rate_list').show();      
      else
      	if(this.value != 'empanelled')
      	$('#rate_list').hide();        
   });  
   
  $("#add_hospital_form").validate();
});
</script>
</head>
<body>
<?php  $this->load->view('common/header_logo_block');
  $this->load->view('common/header_search');?>
<div id="main">
<div class="hospit_box">
    	<div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"><span class="head_box"> <?php if(isset($action)) echo 'Edit '; else echo 'Add '; ?>Hospital</span></div></div></div>
<form action="" method="POST" id="add_hospital_form" enctype="multipart/form-data">
          <div class="blue_body">
          <?php if(isset($save_error)) {?>
          <label class="error" > <?php echo $save_error; ?> <br> </label> <?php } ?>
            <div class="form_row">
              <div class="form_leftB"> Name</div>
              <div class="form_right">
                <input name="name" type="text" value="<?php if(isset($hosp_obj->name)) echo $hosp_obj->name; else if(isset($_POST['name'])) echo $_POST['name'];?>" class="required"/>
                 <?php echo form_error('name'); ?>
              </div>
            </div>

            <div class="form_row">
              <div class="form_leftB">Registration number</div>
              <div class="form_right">
                <input name="registration_number" type="text" value="<?php if(isset($hosp_obj->registration_number)) echo $hosp_obj->registration_number; else if(isset($_POST['registration_number']))  echo $_POST['registration_number'];?>" class="required"/>
                <?php echo form_error('registration_number'); ?>
              </div>
            </div>
            <div class="form_row" style="height:50px">
              <div class="form_leftB">Street address</div>
              <div class="form_right">
                <textarea name="street_address" rows="4" cols="30" class="combo"><?php if(isset($hosp_obj->street_address)) echo $hosp_obj->street_address; else if (isset($_POST['street_address'])) echo $_POST['street_address']; ?></textarea>                
              </div>
            </div>

<div class="form_row" >
              <div class="form_leftB">City / Village</div>
              <div class="form_right">
                <input type="text" name="city_or_village" value="<?php if(isset($hosp_obj->city_or_village)) echo $hosp_obj->city_or_village; if (isset($_POST['city_or_village'])) echo $_POST['city_or_village'];?>">
              </div>
            </div>

<div class="form_row" >
              <div class="form_leftB">District</div>
              <div class="form_right">
              <?php
                if(isset($hosp_obj->district_id))
                 echo form_dropdown('district_id', $dist_list, $hosp_obj->district_id) ;
                else 
                 echo form_dropdown('district_id', $dist_list) ;
                ?>
              </div>
            </div>

<div class="form_row" >
              <div class="form_leftB">Pin Code</div>
              <div class="form_right">
                <input type="text" name="pin_code" value="<?php if(isset($hosp_obj->pin_code)) echo $hosp_obj->pin_code;  if (isset($_POST['pin_code'])) echo $_POST['pin_code']; ?>" class="required" />
              </div>
            </div>           

            <div class="form_row">
              <div class="form_leftB">Contact Number</div>
              <div class="form_right">
                <input name="contact_number" type="text" value="<?php if(isset($hosp_obj->contact_number)) echo $hosp_obj->contact_number; if (isset($_POST['contact_number'])) echo $_POST['contact_number'];?>" class="required" />
              </div>

            </div>
            <div class="form_row">
              <div class="form_leftB">Contact email</div>
              <div class="form_right">
                <input name="contact_email" type="text" value="<?php if(isset($hosp_obj->contact_email)) echo $hosp_obj->contact_email; if (isset($_POST['contact_email'])) echo $_POST['contact_email'];?>" />
              </div>
            </div>
            <div class="form_row">

              <div class="form_leftB">Type</div>
              <div class="form_right">
              <?php              
              if(isset($hosp_obj->type))
              	echo form_dropdown('type',$this->config->item('hospital_type'), $hosp_obj->type); 
              else
              	echo form_dropdown('type',$this->config->item('hospital_type')); ?>
              </div>
            </div>
            
        <div class="form_row" style="height:50px">
              <div class="form_leftB">Policy types</div>
              <div class="form_right">
               <?php               
              if(isset($hosp_obj->cashless_policy)){              	
              	echo form_dropdown('cashless_policy[]',$this->config->item('cashless_policy_type'),unserialize($hosp_obj->cashless_policy),'multiple = "multiple" size="3" style="width:165px"'); 
              }
              else
              	echo form_dropdown('cashless_policy[]',$this->config->item('cashless_policy_type'),'','multiple = "multiple" size="3" style="width:165px" '); ?>
             </div>
            </div>
            <div class="form_row">
              <div class="form_leftB">status</div>
              <div class="form_right">              
              <?php
              if(isset($hosp_obj->status))
              	echo form_dropdown('status',$this->config->item('hospital_status'), $hosp_obj->status,'id="status"'); 
              else
              	echo form_dropdown('status',$this->config->item('hospital_status'),'','id="status"'); ?>
            <!--<select name="status" id="status">
              <option value="empanelled">Empanelled</option>
              <option value="disempanelled">Disempanelled </option>
              <option value="non_functional">Non_functional</option>
              </select>-->
               </div>
            </div>

            <div class="form_row" id="rate_list" 
            <?php if(isset($hosp_obj->status)) if($hosp_obj->status != 'empanelled' ) echo 'style="display: none;"';?> >
              <div class="form_leftB">Rate List</div>
              <div class="form_right"> 
              <input type="file" name="rate_list"> </div>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <?php if(isset($hosp_obj->rate_list_file)) echo "<a href='{$this->config->item('base_url')}'>
              	{$hosp_obj->rate_list_file}</a><br>&nbsp;&nbsp;&nbsp;&nbsp;  (If you upload new file previous file will get replaced.)";?>
            </div>

            <div class="form_row">
              <div class="form_leftB">&nbsp;</div>
              <div class="form_right">
                <input type="submit" name="submit" id="button" value="Submit" class="submit"/>
              </div>
            </div>            
          </div>
          <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
    </div>
    </form>
    </div>
<br class="spacer" />
</div>

<?php $this->load->view('common/footer'); ?>
