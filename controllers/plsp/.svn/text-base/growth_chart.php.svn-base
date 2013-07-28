<?php

/**
 * OFC2 Chart Controller
 * 
 * @package CodeIgniter
 * @author  thomas (at) kbox . ch
 */
class Growth_chart extends CI_Controller {
  
    /**
     * Constructor
     * 
     * @return void
     */
	function __construct()
	{
        parent::__construct();
        $this->load->helper('url_helper');
	}

    /**
     * Default controller function
     * 
     * @return void
     */
	public function index()
	{
        	$this->show_chart('line');
	}

	public function get_growth_chart($age_group, $sex, $metric)
	{
		$this->load->helper('ofc2');
		$this->load->model('survey/plsp/plsp_hwformula_model', 'plsp_hwformula');
		$control = array("c"=>array(24, 120, 6, 12),
				"i"=>array(0, 24, 1, 2),
				"a"=>array(120, 216, 6, 10));
		$colors=array(-3=>"#F778A1", 
				-2=>"#A0CFEC",
				-1=>"#C9BE62",
				0=>"#59E817",
				1=>"#C68E17",
				2=>"#307D7E",
				3=>"#810541");
		$sex_dict=array('m'=>'Boys', 'f'=>'Girls');
		$age_dict=array('i'=>'Infants','c'=>'Children','a'=>'Adolescents');
		$metric_dict=array('h'=>'Height','w'=>'Weight','b'=>'BMI');

		$title_text=$metric_dict[$metric]."-for-Age Chart for ".$age_dict[$age_group]." (".$sex_dict[$sex].")";
		$title = new title( $title_text );
		$chart = new open_flash_chart();
		$chart->set_title( $title );
		$max_y=0;
		$min_y=0;
		$ctr = $control[$age_group];
		if($recs=$this->plsp_hwformula->get_all_values($age_group, $sex, $metric))
		{
			foreach($recs as $row)
			{
				$one_line=array();
				for($n=$ctr[0]; $n<=$ctr[1]; $n=$n+$ctr[2])
				{
					$val=(($n*$row->x_3+$row->x_2)*$n+$row->x_1)*$n+$row->c;
					$one_line[]=new scatter_value( $n, $val );$val;
					$min_y=(($val<$min_y)||($min_y==0))?$val:$min_y;
					$max_y=$val>$max_y?$val:$max_y;
				}
				$d = new hollow_dot();
				$d->size(2)->halo_size(0)->colour('#3D5C56');

				$line = new scatter_line( $colors[$row->line_type], 3 );
				$line->set_key($row->line_type,12);
				$line->set_default_dot_style($d);
				$line->set_values( $one_line );
				$line->set_width( 1);
				$line->set_colour( $colors[$row->line_type]);
				$chart->add_element( $line);
			}
		}
		$y = new y_axis();
		$y->set_range( (int)($min_y*0.8), (int)($max_y*1.2), (int)(($max_y-$min_y)/10) );
		$chart->set_y_axis( $y );

		$x = new x_axis();
		$x->set_range( $ctr[0], $ctr[1]);
		$x->steps($ctr[3]);
		$chart->set_x_axis( $x );

		$data = array(
				    'chart_height'  => 400,
				    'chart_width'   => '74%',
				    'page_title'    => ucwords($title_text),
				    'payload_callback' => $chart->toPrettyString()
				 );

		$this->load->view('survey/plsp/growth_chart', $data);
	}

  
}
