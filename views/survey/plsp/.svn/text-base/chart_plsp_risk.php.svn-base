<html>
    <head>
        <title><?= $page_title ?></title>
        <base href="<?= $this->config->item('base_url') ?>" />
        <script type="text/javascript" src="assets/js/swfobject.js"></script>
        <style type="text/css"> 
            body {
                background-color: #fff;
                margin: 40px;
                font-family: Lucida, Verdana, Sans-serif;
                font-size: 16px;
                color: #4F5155;
            }

            div, h1 {
                margin: 1em 0;
            }

            iframe {
                border: 1px solid silver;
            }

            a {
                color: #003399;
                background-color: transparent;
                font-weight: normal;
            }

            h1 {
                color: #444;
                background-color: transparent;
                font-size: 16px;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
	<?php $this->load->view('survey/plsp/templateheader',array('title'=>'PLSP Error Reports'));?>
        <!--h1><?= $page_title ?></h1-->
        <script type="text/javascript">
            swfobject.embedSWF(
              "assets/swf/open-flash-chart.swf", "pie_chart",
              "<?= $chart_width ?>", "<?= $chart_height ?>",
              "9.0.0", "expressInstall.swf",
              {"get-data":"get_data_pie"}
            );
	swfobject.embedSWF(
              "assets/swf/open-flash-chart.swf", "bar_chart",
              "<?= $chart_width ?>", "<?= $chart_height ?>",
              "9.0.0", "expressInstall.swf",
              {"get-data":"get_data_bar"}
            );
	swfobject.embedSWF(
              "assets/swf/open-flash-chart.swf", "pie_risk_chart",
              "<?= $chart_width ?>", "<?= $chart_height ?>",
              "9.0.0", "expressInstall.swf",
              {"get-data":"get_data_risk_pie"}
            );
	swfobject.embedSWF(
              "assets/swf/open-flash-chart.swf", "bar_risk_chart",
              "<?= $chart_width ?>", "<?= $chart_height ?>",
              "9.0.0", "expressInstall.swf",
              {"get-data":"get_data_risk_bar"}
            );
	var data_pie= <?= $payload_pie?>;
	function get_data_pie()
	{
		// alert( 'reading data 2' );
		//alert(JSON.stringify(data_pie));
		return JSON.stringify(data_pie);
	}
	
	var data_bar= <?= $payload_bar?>;
	function get_data_bar()
	{
		// alert( 'reading data 2' );
		// alert(JSON.stringify(data_2));
		return JSON.stringify(data_bar);
	}
	var data_risk_pie= <?= $payload_risk_pie?>;
	function get_data_risk_pie()
	{
		// alert( 'reading data 2' );
		// alert(JSON.stringify(data_2));
		return JSON.stringify(data_risk_pie);
	}
	
	var data_risk_bar= <?= $payload_risk_bar?>;
	function get_data_risk_bar()
	{
		// alert( 'reading data 2' );
		// alert(JSON.stringify(data_2));
		return JSON.stringify(data_risk_bar);
	}

        </script>
	<center><div>
        <div id="pie_chart"></div>
	<div id="bar_chart"></div>
	</div></center>
	<center><div>
        <div id="pie_risk_chart"></div>
	<div id="bar_risk_chart"></div>
	</div></center>

<?php $this->load->view('common/footer.php'); ?>
    </body>
</html>
