// [[classes to enable],[ids to enable]],[[classes to disable][ids to disable]]
var femaleCtrls =[["pregnancy","genderfemale"],[],["gendermale"],[]];
var maleCtrls =[["gendermale"],[],["pregnancy","genderfemale"],[]];
var otherGenderCtrls =[["pregnancy","genderfemale","gendermale"],[],[],[]];

var acuteids=["acuteacute_abilityaffected","acuteacute_carelocation","acuteacute_persists"];
var freproductive=["reproductive_femaleacute_abilityaffected","reproductive_femaleacute_carelocation","reproductive_femaleacute_persists"];
var mreproductive=["reproductive_maleacute_abilityaffected","reproductive_maleacute_carelocation","reproductive_maleacute_persists"];
var personalillness=["personal_illnesspisp_chronic_surgery","personal_illnesspisp_chronic_nonsurgical"];
var marriedfields = ["reproductivemenopause", "reproductivemiscarriage","reproductivecontraception_use"];
var menopausefields = ["reproductivepregnant"];
var pregnantfields=["reproductiveantenatal","wc","hc"];
var abortionfields=["reproductivemiscarriage_count"];
var chewingfields=["smokingtobacco_current"];
var smokingeverfields=["smokingsmoking_current"];
var smokingcurrentfields=["smokingsmoking_start_hr","smokingsmoking_tempt","smokingcigarette_quit","smokingsmoking_count","smokingsmoking_frequency","smokingsmoking_ill"];
var alcoholeverfields=["alcoholalcohol_current"];
var alcoholcurrentfields=["alcoholalcohol_volume","alcoholalcohol_recollect","alcoholalcohol_duty_fail","alcoholalcohol_concern"];
var viavilifields = ["via_vili_consent"];

//Adolescent fields
var adolescentPregnantYes =[[],["times_pregnancy"],[],[]];
var adolescentPregnantNo =[[],[],[],["times_pregnancy"]];
var adolescentNeverMarriedYes = [[],[],[],["pregnancy","times_pregnancy"]];
var adolescentNeverMarriedNo = [[],["pregnancy"],[],[]];

//Infant fields
var infantIllnessfields = ["infant_illnessillness_treated"];

var start_time_js = Math.round(new Date().getTime() / 1000);

function age_requirement()
{	
	var dob2 = document.getElementById('dob').value;
	var date = document.getElementById('datepicker').value;
	var gender2 = document.getElementById('gender').value;
	var age = date.slice(6)- dob2.slice(6);
	
	
	if(gender2 == "f")
	{	
		
		var via_vili = document.getElementById('via_vili_consent0');
		if(age < 30 || age > 65)
		{
			
			
			via_vili.setAttribute('disabled','disabled');
			//onEnableDisable(indexToggle(0,viavilifields,3));
		}
		else
			{
				via_vili.removeAttribute('disabled');
			}
			//onEnableDisable(indexToggle(0,viavilifields,1));
	}
	
	else
		{
		
		}
		//onEnableDisable(indexToggle(0,viavilifields,3))

}
	
function indexToggle(ind, basearr,pos)
{
	var indexedarr = [];
	for(var ctr=0; ctr<basearr.length; ctr++)
	{
		indexedarr.push(basearr[ctr]+ind);
	}
	var totalarr=[];
	for(var ctr=0; ctr<4;ctr++)
	{
		if(ctr==pos)
		{
			totalarr.push(indexedarr);
		}
		else
		{
			totalarr.push([]);
		}
	}
	return totalarr;
}
function OnEnableDisable(enableDisableMap){
	//first enable
	for(var ind=0;ind<4;ind++)
	{
		for(var c=0; c<enableDisableMap[ind].length;c++)
		{	
			var ctrllist=[];
			if(ind==1 || ind==3)
			{
				var ectrl=document.getElementById(enableDisableMap[ind][c]); 
				ctrllist=[ectrl]
			}	
			if(ind==0 || ind==2)
			{
				var ectrls=getElementsByClass(enableDisableMap[ind][c]); 
				ctrllist=ectrls;
				
			}
			for (var ec0=0;ec0<ctrllist.length;ec0++)
			{
				if(ind<=1)
				{
					ctrllist[ec0].removeAttribute('disabled');
				}
				else if(ind>=2)
				{
					ctrllist[ec0].setAttribute('disabled','disabled');
				}
			}		
		}
	}
	
}

function getElementsByClass( searchClass, domNode, tagName) { 
	if (domNode == null) domNode = document;
	if (tagName == null) tagName = '*';
	var el = new Array();
	var tags = domNode.getElementsByTagName(tagName);
	var tcl = " "+searchClass+" ";
	for(i=0,j=0; i<tags.length; i++) { 
		var test = " " + tags[i].className + " ";
		if (test.indexOf(tcl) != -1) 
			el[j++] = tags[i];
	} 
	return el;
} 

function checkform ( form )
{
  	var validate_functions={'name':required, 'svg':required,'adult_id':required, 'date_interview':required,'dob':required,'height':checkHeight,'weight':checkWeight, 'wc':checkWC, 'hc':checkHC};
	var b = true;
	// ** START **
	for(var ctrl in validate_functions)
	{
		var ret=validate_functions[ctrl](form[ctrl].value.replace(/^\s+|\s+$/g, ''));		
		if(ret[1]==false)
		{
			alert(ret[0]);
			form[ctrl].focus();
			form[ctrl].style.backgroundColor = '#ff5555';
			return false;
		}
	}
	$('#end_time').val(Math.round(new Date().getTime() / 1000));
	$('#start_time').val(start_time_js); // new line to keep time on the client side 
	
	return b ;
}

function checkformAdolescent ( form )
{
  	var validate_functions={'name':required, 'svg':required,'caregiver_id':required, 'adolescent_id':required, 'date_interview':required,'dob':required,'height':checkHeight,'weight':checkWeight};
	var b = true;
	// ** START **
	for(var ctrl in validate_functions)
	{
		var ret=validate_functions[ctrl](form[ctrl].value.replace(/^\s+|\s+$/g, ''));		
		if(ret[1]==false)
		{
			alert(ret[0]);
			form[ctrl].focus();
			return false;
		}
	}
	$('#end_time').val(Math.round(new Date().getTime() / 1000));
	$('#start_time').val(start_time_js); // new line to keep time on the client side 
	return b ;
}

function checkformChild ( form )
{
  	var validate_functions={'date_interview':required, 'svg':required,'caregiver_id':required, 'child_id':required, 'dob':required,'height':checkHeightChild,'weight':checkWeightChild};
	var b = true;
	// ** START **
	for(var ctrl in validate_functions)
	{
		var ret=validate_functions[ctrl](form[ctrl].value.replace(/^\s+|\s+$/g, ''));		
		if(ret[1]==false)
		{
			alert(ret[0]);
			form[ctrl].focus();
			return false;
		}
	}
	$('#end_time').val(Math.round(new Date().getTime() / 1000));
	$('#start_time').val(start_time_js); // new line to keep time on the client side 
	return b ;
}
function checkformInfant ( form )
{
  	var validate_functions={'date_visit':required, 'nurse':required,'caregiver_id':required, 'infant_id':required, 'caregiver_birth':required,'infant_dob':required,'birth_weight':checkBirthWeightInfant,'infant_height':checkHeightInfant,'infant_weight':checkWeightInfant, 
'infant_upperarm':checkMuac, 'infant_hb':checkHbVal};
	// ** START **
	for(var ctrl in validate_functions)
	{
		var ret=validate_functions[ctrl](form[ctrl].value.replace(/^\s+|\s+$/g, ''));		
		if(ret[1]==false)
		{
			alert(ret[0]);
			form[ctrl].focus();
			return false;
		}
	}
	$('#end_time').val(Math.round(new Date().getTime() / 1000));
	$('#start_time').val(start_time_js); // new line to keep time on the client side 
	return true ;
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
//All the validate functions have the following signature
//input: Value in the edit control
//outut: tuple with the following convention ["Message to be displayed", true/false which indicates the result of the validation]
function checkBP(bpVal)
{
	var strMsg="";
	if(bpVal=="")
	{
		strMsg = "Please enter BP";
		return [strMsg,false];
	}
	var sd = bpVal.split('/');
	if(sd.length!=2)
	{
		return ["Invalid BP format",false];
	}
	var sys = parseInt(sd[0]);
	var dia = parseInt(sd[1]);
	if(sys<60 || sys > 300 || dia<30 || dia>150)
		return ["Please check the BP value",false];
	return ["Success",true];
}

function checkWC(wcVal)
{
	if(wcVal=="")
	{
		strMsg = "Please enter Waist Circumference";
		return [strMsg,false];
	}
	wcVal = parseInt(wcVal);
	if(wcVal<40 || wcVal >140)
		return ["Please enter waist circumference in cms",false];
	return ["Success",true];
}

function checkHC(hcVal)
{
	if(hcVal=="")
	{
		strMsg = "Please enter Hip Circumference";
		return [strMsg,false];
	}
	hcVal = parseInt(hcVal);
	if(hcVal<40 || hcVal >150)
		return ["Please enter hip circumference in cms",false];
	return ["Success",true];
}

function checkHeight(hVal)
{
	if(hVal=="")
	{
		strMsg = "Please enter Height in cms";
		return [strMsg,false];
	}
	hVal = parseInt(hVal);
	if(hVal<100 || hVal >250)
		return ["Please enter valid height in cms",false];
	return ["Success",true];
}
function checkWeight(wVal)
{
	if(wVal=="")
	{
		strMsg = "Please enter Weight in kgs";
		return [strMsg,false];
	}
	wVal = parseInt(wVal);
	if(wVal<23 || wVal >140)
		return ["Please enter valid weight in kgs",false];
	return ["Success",true];
}

function checkHeightInfant(hVal)
{
	if(hVal=="")
	{
		strMsg = "Please enter Height in cms";
		return [strMsg,false];
	}
	hVal = parseInt(hVal);
	if(hVal<40 || hVal >65)
		return ["Please enter valid height in cms",false];
	return ["Success",true];
}
function checkWeightInfant(wVal)
{
	if(wVal=="")
	{
		strMsg = "Please enter Weight in kgs";
		return [strMsg,false];
	}
	wVal = parseInt(wVal);
	if(wVal<5 || wVal >22)
		return ["Please enter valid weight in kgs",false];
	return ["Success",true];
}
function checkHeightChild(hVal)
{
	if(hVal=="")
	{
		strMsg = "Please enter Height in cms";
		return [strMsg,false];
	}
	hVal = parseInt(hVal);
	if(hVal<50 || hVal >190)
		return ["Please enter valid height in cms",false];
	return ["Success",true];
}
function checkWeightChild(wVal)
{
	if(wVal=="")
	{
		strMsg = "Please enter Weight in kgs";
		return [strMsg,false];
	}
	wVal = parseInt(wVal);
	if(wVal<5 || wVal >80)
		return ["Please enter valid weight in kgs",false];
	return ["Success",true];
}

function checkBirthWeightInfant(wVal)
{
	if(wVal=="")
	{
		strMsg = "Please enter Birth Weight in kgs";
		return [strMsg,false];
	}
	wVal = parseInt(wVal);
	if(wVal<1 || wVal >8)
		return ["Please enter valid weight in kgs",false];
	return ["Success",true];
}

function checkHbVal(hbVal)
{
	if(hbVal=="")
	{
		strMsg = "Please enter Haemoglobin value in g/dL";
		return [strMsg,false];
	}
	hbVal = parseInt(hbVal);
	if(hbVal<1 || hbVal >18)
		return ["Please enter valid Haemoglobin in g/dL",false];
	return ["Success",true];
}

function checkMuac(mVal)
{
	if(mVal=="")
	{
		strMsg = "Please enter MUAC in cms";
		return [strMsg,false];
	}
	mVal = parseInt(mVal);
	if(mVal<1 || mVal >20)
		return ["Please enter valid MUAC in cms",false];
	return ["Success",true];
}
