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
	<?php $this->load->view('survey/plsp/templateheader',array('title'=>'Line reports'));?>
        <!--h1><?= $page_title ?></h1-->
        <script type="text/javascript">
            swfobject.embedSWF(
              "assets/swf/open-flash-chart.swf", "line_chart",
              "<?= $chart_width ?>", "<?= $chart_height ?>",
              "9.0.0", "expressInstall.swf",
              {"get-data":"get_data_line"}
            );
	
	var data_line= <?= $payload_callback?>;
	function get_data_line()
	{
		return JSON.stringify(data_line);
	}
	
	

        </script>
	<center><div>
        <div id="line_chart"></div>
	</div></center>

<?php $this->load->view('common/footer.php'); ?>
    </body>
</html>
