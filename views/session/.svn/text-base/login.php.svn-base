<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Login </title>

<style>
body{
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#666666;
	margin:0px;
	padding:0px;
}
.maindiv
{
width:550px;
margin:auto;
border:#000000 1px solid;
}
.mainhead{background-color : #aaaaaa;}
.tablehead{background-color : #d7d7d7;}
.row{   background-color : #e7e7e7;}
.data_table tr{
	font-size:11px;
	height:25px;
	background-color:#e8e8e8;
}

.largeselect {   width:200px; }

</style>
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/site.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php $this->load->view('common/header_logo_block');
?>

<!--Main Page-->
<div id="main">

  <div class="hospit_box">

<div class="green_left"><div class="green_right">
    	  <div class="green_middle"><span class="head_box">Login</span></div></div></div>
          <div class="green_body">

<form method="POST" action="<?php echo $this->config->item('base_url').'index.php/session/session/login'?>">

<table width="600" border="0" align="center" cellpadding="0" cellspacing="2" class="data_table">
    <tr align=center>
     <td colspan=2><b><u>This Application Should be Viewed in Firefox 3.6.x</u></b></td>
    </tr>
    <tr>
    <td width="46%">Username</td>
    <td width="54%"><input type="text" name="username"/></td>
    </tr>
    <tr>
    <td width="46%">Password</td>
    <td width="54%"><input type="password" name="password"/></td>
    </tr>
  </tr>
</table>
<div width="600" align="center">
	<?php 
	    if(isset($error_server) && $error_server!=''){
	    	echo "<label class=\"error\" id=\"label_server_error\"> $error_server </label> ";
	    }			    
	?>
</div>		

<br/>
<table align="center" >
<tr>
<td width="50%" align="center">
<td width="50%" align="center"><input type="submit" value="submit" name="submit" class="submit"/></td>
 </tr>
</table>
    
</form>
    <br class="spacer" /></div>
    <div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
    </div></div>
</div>
<!--Body Ends-->

<?php $this->load->view('common/footer.php'); ?>
