<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/opd/visit/plan_tab.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js";	?>"></script>

<div class="blue_left">
  <div class="blue_right"><div class="blue_middle"><span class="head_box">Medications</span></div></div>
</div>

<div class="blue_body" style="padding:10px;">
  
  <?php
  $this->load->view('common_medical/medication_box');
  ?>
</div>

<div class="bluebtm_left" ><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div><br/>
    
    <!--
    
    <div class="blue_left">
    <div class="blue_right"><div class="blue_middle"><span class="head_box">Lab orders</span></div></div>
  </div>
    
    <div class="blue_body" style="padding:10px;">
    TO ADD
  </div>
    
    <div class="bluebtm_left" ><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div><br/>
    -->
    
    
    <div class="blue_left">
      <div class="blue_right"><div class="blue_middle"><span class="head_box">Referrals</span></div></div>
    </div>
    
    <div class="blue_body" style="padding:10px;">
      <input type="text" size="78" id="referrals" name="referrals"/>
    </div>
    
    <div class="bluebtm_left" ><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div><br/>


    <div class="blue_left">
      <div class="blue_right"><div class="blue_middle"><span class="head_box">CHW Followup</span></div></div>
    </div>
    
    <div class="blue_body" style="padding:10px;">
      Project
      <select name="chw_project" id="chw_project">
	<?php foreach ($projects as $p) { ?>
	<option value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
	<?php } ?>
      </select>
      <input id="chw_followup" type="button" class="submit" value="Create CHW Followup Plan"></input>

      <div id="add_chw_followup" style="display:none;">
		<table border="0" align="center" width="80%">
			<tr>
				<td><b> CHW</b></td>
				<td > 
				<input type="text" id="chw" class="chw" name="chw">
				</td>
			</tr>
			<tr>
				<td><b> Start Date</b></td>
				<td><input name="c_start_date" id="c_start_date" type="text" size="10"
					value="" class="datepicker" />
					</td>
				<td><b> End Date </b></td>
				<td><input type="text" size="10" name="c_end_date" id="c_end_date"
					class="datepicker"></td>
			</tr>
			<tr>
				<td valign="top"><b> Summary</b></td>
				<td colspan="3">
				<textarea rows="3" cols="44" name="c_summary"></textarea>
				</td>
			</tr>
		</table>

      </div>

    </div>
    
    <div class="bluebtm_left" ><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div><br/>

