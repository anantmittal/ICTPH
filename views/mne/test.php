<!DOCTYPE html>
<html>
<head>
<link type="text/css" href="<?php echo $this->config->item("base_url")."assets/css/jquery-ui-1.7.2.custom.css" ?>" rel="stylesheet" />
<script type="text/javascript"
src='<?php echo $this->config->item("base_url")."assets/js/jquery-1.3.2.js"; ?>'>
</script>
<script type="text/javascript"
src='<?php echo $this->config->item("base_url")."assets/js/jquery-ui.js "; ?>'>
</script>

 <script type="text/javascript"
src='<?php echo $this->config->item("base_url")."assets/js/jquery-ui-tabs.js "; ?>'>
</script>
<script type="text/javascript">
$(document).ready(function(){
    $("#tabs").tabs();
});
  </script>
</head>
<body style="font-size:62.5%;">


<div id="tabs">
    <ul>
        <li><a href="#fragment-1"><span>One</span></a></li>
        <li><a href="#fragment-2"><span>Two</span></a></li>

    </ul>
    <div id="fragment-1">
        <p>First tab is active by default:</p>
        <pre><code>$('#example').tabs();</code></pre>
    </div>
    <div id="fragment-2">
        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
    </div>

</div>




</body>
</html>
