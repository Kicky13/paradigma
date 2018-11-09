<?php
header('Access-Control-Allow-Origin: *');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Project extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('m_project','',true);
        $this->load->model('m_project_dash','',true);
        $this->load->model('m_project_kpi','',true);
    }

    public function index(){
    	$param = array();
      $result = $this->m_project->get_project($param);
      $json = array();
      $tag = 0;
      foreach ($result as $key => $value) {
      		$tag ++;
      		$year1 = date("Y", strtotime($value['Baseline_Start']));
      		$month1 = date("m", strtotime($value['Baseline_Start']));
      		$day1 = date("d", strtotime($value['Baseline_Start']));

      		$year2 = date("Y", strtotime($value['Baseline_Finish']));
      		$month2 = date("m", strtotime($value['Baseline_Finish']));
      		$day2 = date("d", strtotime($value['Baseline_Finish']));

      		$json[$tag] = array(
      			'project_name' => $value['Project_Name'],
      			'investation_number' => $value['Investation_Number'],
      			'project_budget' => $value['Total_Project_Budget'],
      			'PIC' => $value['PIC_Project'],
      			'lokasi' => $value['Lokasi_Kota'],
      			'completion' => $value['Completion'],
      			// 'project_start' => date("d/m/Y", strtotime((string) $value['Baseline_Start'])),
      			// 'project_finish' => date("d/m/Y", strtotime((string) $value['Baseline_Finish'])),
      			'project_start' => $value['Baseline_Start'],
      			'project_finish' => $value['Baseline_Finish'],

      			'kpi' => $value['KPI'],
            'status' => array(
                'schedule_in_project' => $value['Schedule_In_Progress'],
                'spi' => $value['SPI'],
                'cpi' => $value['CPI'],
                'eac' => $value['EAC'],
                'commited' => $value['Commitment'],
                'remn_budget' => $value['Remn_Order'],
                'cash_out' => $value['Cash_Out'],
                'plan' => $value['PF_PLAN'],
                'real' => $value['PF_REAL'],
                'created' => $value['Created']
              ),
      			// 'issue' => array(
      			// 		'status' => $value['Issue_Status'],
		      	// 		'title' => $value['Title'],
		      	// 		'date' =>	$value['Due_Date'],
		      	// 		// 'date' =>date("d/m/y", strtotime($value['Due_Date'])),
		      	// 		'priority' => $value['Priority'],
		      	// 		'category' => $value['Category']
		      	// 		)

      			

      			);
      }
      echo json_encode($json);

    }
    public function status(){
      $param = array();
      $param['project'] = (empty($_GET['proj']) ? '' : $_GET['proj']);
      // echo $param['project'];
      $result = $this->m_project->get_project_stat($param);
      $json = array();
      $tag = 0;
      foreach ($result as $key => $value) {
          $tag ++;
          $year1 = date("Y", strtotime($value['Baseline_Start']));
          $month1 = date("m", strtotime($value['Baseline_Start']));
          $day1 = date("d", strtotime($value['Baseline_Start']));

          $year2 = date("Y", strtotime($value['Baseline_Finish']));
          $month2 = date("m", strtotime($value['Baseline_Finish']));
          $day2 = date("d", strtotime($value['Baseline_Finish']));

          $json[$tag] = array(
            'project_name' => $value['Title'],
            'investation_number' => $value['Investation_Number'],
            'project_budget' => $value['Total_Project_Budget'],
            'PIC' => $value['PIC_Project'],
            'lokasi' => $value['Lokasi_Kota'],
            'completion' => $value['Completion'],
            // 'project_start' => date("d/m/Y", strtotime((string) $value['Baseline_Start'])),
            // 'project_finish' => date("d/m/Y", strtotime((string) $value['Baseline_Finish'])),
            'project_start' => $value['Baseline_Start'],
            'project_finish' => $value['Baseline_Finish'],

            // 'kpi' => $value['KPI'],
            'status' => array(
                'Schedule_In_Progress' => $value['Schedule_In_Progress'],
                'spi' => $value['SPI'],
                'cpi' => $value['CPI'],
                'eac' => $value['EAC'],
                'commited' => $value['COMMIT'],
                'remn_budget' => $value['Remn_Order'],
                'cash_out' => $value['CASH_OUT'],
                'plan' => $value['PF_PLAN'],
                'real' => $value['PF_REAL'],
                'created' => $value['CREATED']
              ),
            'issue' => array(
                'status' => $value['Issue_Status'],
                'title' => $value['NAME_OF_ISSUE'],
                'date' => $value['Due_Date'],
                // 'date' =>date("d/m/y", strtotime($value['Due_Date'])),
                'priority' => $value['Priority'],
                'category' => $value['Category']
                )

            

            );
      }
      echo json_encode($json);

    }
    
    public function dashboard(){
      $param = array();
      $result = $this->m_project->get_project($param);
      $json = array();
      $tag = 0;
      foreach ($result as $key => $value) {
          $tag ++;
          $year1 = date("Y", strtotime($value['Baseline_Start']));
          $month1 = date("m", strtotime($value['Baseline_Start']));
          $day1 = date("d", strtotime($value['Baseline_Start']));

          $year2 = date("Y", strtotime($value['Baseline_Finish']));
          $month2 = date("m", strtotime($value['Baseline_Finish']));
          $day2 = date("d", strtotime($value['Baseline_Finish']));
          $pic = $value['PIC_Project'];
          $json[$pic][$tag] = array(
             'project_name' => $value['Project_Name'],
             'investation_number' => $value['Investation_Number'],
            'project_budget' => $value['Total_Project_Budget'],
            // 'PIC' => $value['PIC_Project'],
             'lokasi' => $value['Lokasi_Kota'],
             'completion' => $value['Completion'],
             'project_start' => date("d/m/Y", strtotime((string) $value['Baseline_Start'])),
             'project_finish' => date("d/m/Y", strtotime((string) $value['Baseline_Finish'])),
            // 'project_start' => $value['Baseline_Start'],
            // 'project_finish' => $value['Baseline_Finish'],

             'kpi' => $value['KPI'],
             //'real' => $value['PF_REAL'],
             'status' => array(
                 'schedule_in_project' => $value['Schedule_In_Progress'],
                 'spi' => $value['SPI'],
                 'cpi' => $value['CPI'],
                 'eac' => $value['EAC'],
                 'commited' => $value['Commitment'],
                 'remn_budget' => $value['Remn_Order'],
                 'cash_out' => $value['Cash_Out'],
                 'plan' => $value['PF_PLAN'],
                 'real' => $value['PF_REAL'],
                 'created' => $value['Created']
               ),
             'issue' => array(
                'status' => $value['Issue_Status'],
                'title' => $value['Title'],
                'date' => $value['Due_Date'],
                'date' =>date("d/m/y", strtotime($value['Due_Date'])),
                'priority' => $value['Priority'],
                'category' => $value['Category']
                )

            

            );
      }
      echo json_encode($json);

    }


    public function kpi(){
      $param = array();
      $result = $this->m_project_kpi->get_project_kpi($param);
      $json = array();
      $tag = 0;
      

      foreach ($result as $key => $value) {

          $pic = $value['Period'];
          $json[$pic]= array(
            'periode' => $value['Period'],
            'kpi_of' => $value['KPI_OF'],
            'kpi_until' => $value['KPI_UNTIL']
            );
      }
      echo json_encode($json);

    }

    public function test()
    {
      //$this->m_project_dash->get_project();
      $this->db = $this->load->database('default7',true);
    $pic='';
    $sql=$this->db->query('SELECT
                  "PIC_Project"
                    FROM PAR4DIGMA.PROJECT_NAME
                    GROUP BY "PIC_Project"');
    foreach ($sql->result_array() as $a) {
      $sql1= $this->db->query("SELECT TB1.*,TB2.* FROM(SELECT
                                   \"Project_Name\",
                                      \"PF_Real\"
                              FROM PAR4DIGMA.PROJECT_STATUS
                             WHERE \"Created\" IS NOT NULL)TB1
        INNER JOIN
          (SELECT \"Title\",
                  \"PIC_Project\",
                     \"Total_Project_Budget\"
                    FROM PAR4DIGMA.PROJECT_NAME
              WHERE \"PIC_Project\" IS NOT NULL)TB2
        ON TB1.\"Project_Name\"=TB2.\"Title\" WHERE TB2.\"PIC_Project\"='{$a['PIC_Project']}'");
        foreach ($sql1->result_array() as $p) {
            // $array[]=array('PIC_Project'=>$p['PIC_Project'],
            //                 'Total_Project_Budget'=>$p['Total_Project_Budget']);
            // //echo json_encode($array);
          $pic+=$p['Total_Project_Budget'];
          
        }
        //$array1[$a['PIC_Project']]=array($pic);
        //echo json_encode($array1);
        echo $pic;
     }
        //echo print_r(explode(delimiter, string))
    }
    
    
}