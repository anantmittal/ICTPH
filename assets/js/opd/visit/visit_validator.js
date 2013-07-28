// [[classes to enable],[ids to enable]],[[classes to disable][ids to disable]]
var is_hew_login;
function checkvisitform ( form , hew_login)
{
	is_hew_login = hew_login;
  	var validate_functions={'temperature_f':checkTemp, 'pulse':checkPulse, 'respiratory_rate':checkRrVal, 'bp_systolic':checkSystolic, 'bp_diastolic':checkDiastolic, 'weight_kg':required, 'height_cm':required, 'waist_cm':checkWc , 'hip_cm':checkHc , 'dist_sph_r':checkDistSpherical, 'dist_cyl_r':checkDistCylindrical,'dist_axial_r':checkDistAxial, 'dist_sph_l':checkDistSpherical,'dist_cyl_l':checkDistCylindrical,'dist_axial_l':checkDistAxial,'near_sph_r':checkNearVisionSpherical,'near_cyl_r':checkNearVisionCylindrical,'near_axial_r':checkNearVisionAxial,'near_sph_l':checkNearVisionSpherical,'near_cyl_l':checkNearVisionCylindrical,'near_axial_l':checkNearVisionAxial};
	var b = true;
	// ** START **
	for(var ctrl in validate_functions)
	{
		var ret=validate_functions[ctrl](form[ctrl].value.replace(/^\s+|\s+$/g, ''));		
		if(ret[1]==false)
		{
			alert(ret[0]);
			if(hew_login)
				$("#tabs").tabs('select', 1);
			else
				$("#tabs").tabs('select', 2);
			form[ctrl].focus();
			form[ctrl].style.borderColor = '#ff5555';
			return false;
		}
	}
	
	var wt = $('#weight_kg').val();
	var ht_mt = $('#height_cm').val()/100;
	var bmi = Math.round(wt/(ht_mt*ht_mt)*100)/100;
	if(bmi<10 || bmi >50)
	{
		
		alert('Invalid BMI. Please check values for height and weight');
		if(hew_login)
			$("#tabs").tabs('select', 1);
		else
			$("#tabs").tabs('select', 2);
		form['weight_kg'].focus();
		return false;
	}
	//Code for lab tab tests empty value validation
	var number_of_tests=$('#tests_number').val();
	
	for(var i=1;i<=number_of_tests;i++){
		if($('#tests_'+i+'_status_done').val()=='Done'  && $('#tests_'+i+'_status_done').attr("checked")){
			if($.trim($('#tests_'+i+'_result').val())==''){
				alert('Please enter Strip Test values');
				$("#tabs").tabs('select', 3);
				$('#tests_'+i+'_result').focus();
				$('.error').hide();
				//$('#tests_'+i+'_result').style.borderColor = '#ff5555';
				return false;
			}
			/*if($('#tests_'+i+'_result').attr("checked")){
				alert('Plz check suitable radio button');
				$("#tabs").tabs('select', 3);
				return false;
			}*/
		}
	}
	
	//Code for empty bar code validation for tests 
	var start_test_no=$('#test_start_number').val();
	var end_test_no=$('#test_end_number').val();
	var bar_code_no=$('#bar_code_number').val();

	for(var j=parseInt(start_test_no);j<=parseInt(end_test_no);j++){
		if($('#tests_'+j+'_status_done').val()=='Done'  && $('#tests_'+j+'_status_done').attr("checked")){
			var returnValue=false;
			for(var barId=0;barId<bar_code_no;barId++){
				if($.trim($('#barcode_'+barId).val())!=''){
					returnValue=true;
				}
			}
			if(returnValue==false){
				alert('Please enter Bar Code value for Test');
				$("#tabs").tabs('select', 3);
				$('#barcode_0').focus();
				//$('#tests_'+i+'_result').style.borderColor = '#ff5555';
				return false;
			}
		}
	}
	
	
	if(followUpIsInFuture()){
		alert("Follow up date should be in future");
		$("#tabs").tabs('select', 4);
		return false;
	}
	
	if($('#cost_items_total').text() == ""){
		alert("Please load the billing details by clicking on Load Data button");
		$("#tabs").tabs('select', 6);
		return false;
	}
	
	return b ;
}

function followUpIsInFuture(){
	var retVal = false;
	var date = new Date();
	$("input:text[name^='followup_protocol_date']").each(function() {
		var value =  $(this).val();
		if($.trim(value) === ""){
			retVal = true;
			return retVal;
		}
		
		if(value != "" && value != "DD/MM/YYYY"){
			if(!valid_date(value)){
				retVal = true;
				return retVal;
			}
			var parts = value.match(/(\d+)/g);
			if(parts === null){
				retVal = true;
			}else{
				var alteredDate = new Date(parts[2], parts[1]-1, parts[0]);
				if(alteredDate.getTime() < date.getTime() ){
					retVal = true;
				}
			}
		}
    });
	return retVal;
}

function valid_date(input){
	var parts = input.match(/(\d+)/g);
	if(parts.length < 3){
		return false;
	}
	return true;
}

//Common validate function just to ensure that the field is not blank
function required(val)
{
	var strMsg="";
	if(val == "")
	{
		return ["Field cannot be blank", false];
	}
	return ["Success",true];
}
function currentlyPregnant(){
	var isPregnant = $('input[@name="pregnant"]:checked').val();
	if(isPregnant!="N" && isPregnant!="Y")
		return true;					// if true then validate waist
	else if(isPregnant=="N")
		return true;
	else
		return false;					// if false then don't validate waist
	
}

function checkWc(wcVal)
{
	if(ageofindividual<=18)
		return ["Success",true];
	
	//if(!currentlyPregnant())
		//return;
	var isPregnant = $('input:[name=pregnant]:checked').val();
	//alert('Is pregnant='+isPregnant);
	if(isPregnant!="Y" ){
		if(wcVal=="")
		{
			strMsg = "Please enter Waist circumference in centimeters";
			return [strMsg,false];
		}
		wcVal = parseInt(wcVal);
		if(wcVal<40 || wcVal >140){
			return ["Please enter valid Waist circumference value",false];
		}
		return ["Success",true];
	}else{
		return ["Success",true];
	}
}
function checkHc(hcVal)
{
	var isPregnant = $('input:[name=pregnant]:checked').val();
	if(isPregnant!="Y" ){
		if(ageofindividual<=18)
			return ["Success",true];
		if(hcVal==""){
			strMsg = "Please enter hip circumference in centimeters";
			return [strMsg,false];
		}
		hcVal = parseInt(hcVal);
		if(hcVal<40 || hcVal >150){
			return ["Please enter valid hip circumference value",false];
		}
		return ["Success",true];
	}else{
		return ["Success",true];
	}
}
//All the validate functions have the following signature
//input: Value in the edit control
//outut: tuple with the following convention ["Message to be displayed", true/false which indicates the result of the validation]

function checkTemp(tVal)
{
	if(is_hew_login){
		tVal = parseInt(tVal);
		if(tVal<90 || tVal >110)
			return ["Please enter valid temperature in degree F",false];
		return ["Success",true];
	}
	if(tVal=="")
	{
		strMsg = "Please enter temperature";
		return [strMsg,false];
	}
	tVal = parseInt(tVal);
	if(tVal<90 || tVal >110)
		return ["Please enter valid temperature in degree F",false];
	return ["Success",true];
}

function checkPulse(pVal)
{
	if(is_hew_login){
		pVal = parseInt(pVal);
		if(pVal<30 || pVal >230)
			return ["Please enter valid pulse rate",false];
		return ["Success",true];
	}
	
	if(pVal=="")
	{
		strMsg = "Please enter Pulse rate";
		return [strMsg,false];
	}
	pVal = parseInt(pVal);
	if(pVal<30 || pVal >230)
		return ["Please enter valid pulse rate",false];
	return ["Success",true];
}



function checkRrVal(rrVal)
{
	if(is_hew_login){
		rrVal = parseInt(rrVal);
		if(rrVal<1 || rrVal >50)
			return ["Please enter valid respiratory rate",false];
		return ["Success",true];
	}
	
	if(rrVal=="")
	{
		strMsg = "Please enter Respiratory rate";
		return [strMsg,false];
	}
	rrVal = parseInt(rrVal);
	if(rrVal<1 || rrVal >50)
		return ["Please enter valid respiratory rate",false];
	return ["Success",true];
}

function checkSystolic(bpVal)
{
	if(is_hew_login)
	{
		if(ageofindividual<=18)
			return ["Success",true];
		
		bpVal = parseInt(bpVal);
		if(bpVal<60 || bpVal >300)
			return ["Please enter valid BP (Systolic) value",false];
		return ["Success",true];
	}
	if(ageofindividual<=18)
		return ["Success",true];
	if(bpVal=="")
	{
		strMsg = "Please enter BP (Systolic) value";
		return [strMsg,false];
	}
	bpVal = parseInt(bpVal);
	if(bpVal<60 || bpVal >300)
		return ["Please enter valid BP (Systolic) value",false];
	return ["Success",true];
	
}

function checkDiastolic(bpVal)
{
	if(is_hew_login)
	{
		if(ageofindividual<=18)
			return ["Success",true];
		
		bpVal = parseInt(bpVal);
		if(bpVal<30 || bpVal >150)
			return ["Please enter valid BP (Diastolic) value",false];
		return ["Success",true];
	}
	
	if(ageofindividual<=18)
		return ["Success",true];
	if(bpVal=="")
	{
		strMsg = "Please enter BP (Diastolic) value";
		return [strMsg,false];
	}
	bpVal = parseInt(bpVal);
	if(bpVal<30 || bpVal >150)
		return ["Please enter valid BP (Diastolic) value",false];
	return ["Success",true];
}

function checkDistSpherical(rVal)
{	
	if(is_hew_login){
		if(rVal < 0){
			rVal = rVal * -1;
		}
		if( rVal != '' ){
			if(rVal<0 || rVal >10 ||(rVal%0.25)!=0){
				return ["Please enter valid spherical value in Distance vision",false];
			}
		}
		return ["Success",true];
	}
	
	if(rVal < 0){
		rVal = rVal * -1;
	}
	if( rVal != '' ){
		if(rVal<0 || rVal >10 ||(rVal%0.25)!=0){
			return ["Please enter valid spherical value in Distance vision",false];
		}
	}
	return ["Success",true];
}

function checkDistCylindrical(rVal)
{	
	if(is_hew_login){
		if(rVal < 0){
			rVal = rVal * -1;
		}
		if( rVal != '' ){
			if(rVal<0 || rVal >6 ||(rVal%0.25)!=0){
				return ["Please enter valid cylindrical value in Distance vision",false];
			}
		}
		return ["Success",true];
	}
	
	if(rVal < 0){
		rVal = rVal * -1;
	}
	if( rVal != '' ){
		if(rVal<0 || rVal >6 ||(rVal%0.25)!=0){
			return ["Please enter valid cylindrical value in Distance vision",false];
		}
	}
	return ["Success",true];
}

function checkDistAxial(rVal)
{
	if(is_hew_login){
		if( rVal != '' ){
			if(rVal<0 || rVal >180 ||(rVal%5)!=0){
				return ["Please enter valid axial value in Distance vision",false];
			}
		}
		return ["Success",true];
	}
	if( rVal != '' ){
		if(rVal<0 || rVal >180 ||(rVal%5)!=0){
			return ["Please enter valid axial value in Distance vision",false];
		}
	}
	return ["Success",true];
}

function checkNearVisionSpherical(rVal)
{
	if(is_hew_login){
		if( rVal != '' ){
			if(rVal<0 || rVal >10 ||(rVal%0.25)!=0){
				return ["Please enter valid spherical value in Near vision",false];
			}
		}
		return ["Success",true];
	}
	
	if( rVal != '' ){
		if(rVal<0 || rVal >10 ||(rVal%0.25)!=0){
			return ["Please enter valid spherical value in Near vision",false];
		}
	}
	return ["Success",true];
}

function checkNearVisionCylindrical(rVal)
{	
	if(is_hew_login){
		if(rVal < 0){
			rVal = rVal * -1;
		}
		if( rVal != '' ){
			if(rVal<0 || rVal >6 ||(rVal%0.25)!=0){
				return ["Please enter valid cylindrical value in Near vision",false];
			}
		}
		return ["Success",true];
	}
	
	if(rVal < 0){
		rVal = rVal * -1;
	}
	if( rVal != '' ){
		if(rVal<0 || rVal >6 ||(rVal%0.25)!=0){
			return ["Please enter valid cylindrical value in Near vision",false];
		}
	}
	return ["Success",true];
}

function checkNearVisionAxial(rVal)
{
	if(is_hew_login){
		if( rVal != '' ){
			if(rVal<0 || rVal >180 ||(rVal%5)!=0){
				return ["Please enter valid axial value in Near vision",false];
			}
		}
		return ["Success",true];
	}

	if( rVal != '' ){
		if(rVal<0 || rVal >180 ||(rVal%5)!=0){
			return ["Please enter valid axial value in Near vision",false];
		}
	}
	return ["Success",true];
}
