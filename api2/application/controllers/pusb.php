<?php
header('Access-Control-Allow-Origin: *');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class pusb extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('m_pusb','',true);
    }

 public function strategi($param){
  $result = $this->m_pusb->get_reg_expansion_proj($param);

  foreach ($result as $key => $value) {
  $nama=$value['ProjectName'];
  $persen=$value['Progress'];
  $kode=$value['ID'];

echo $nama.'
		  <div class="progress" style="margin-bottom:1px">
		<a href="pusb_detail.html?id_proj='.$kode.'"> <div class="progress-bar progress-bar-striped active" role="progressbar"
		  aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:'.$persen.'%">
			'.$persen.'%
		  </div></a>
	  </div>';
  }	

}

public function baseline($id_proj){
    $param = array();
	$bln=array('JAN'=>01,'FEB'=>02,'MAR'=>03,'APR'=>04,'MAY'=>05,'JUN'=>06,'JUL'=>07,'AUG'=>08,'SEP'=>09,'OCT'=>10,'NOV'=>11,'DEC'=>12);
	$bln_back=array(1=>'JAN',2=>'FEB',3=>'MAR',4=>'APR',5=>'MAY',6=>'JUN',7=>'JUL',8=>'AUG',9=>'SEP',10=>'OCT',11=>'NOV',12=>'DEC');
	
    $result = $this->m_pusb->get_baseline_srat_end($id_proj);
    $result2 = $this->m_pusb->get_baseline($id_proj);
	 $cek_hasil=count($result2);
	if($cek_hasil>0)
	{
		foreach ($result as $key => $value) {
			$tgl_start=$value['tgl_start'];
			$tgl_end= $value['tgl_end'];
		}
		$jumlah_baseline=count($result2);
		foreach ($result2 as $key => $value2) {
			$Deliverable[]=$value2['ActivityName'];
			$StartDatePlan=explode('-',$value2['StartDatePlan']);
			$EndDatePlan=explode('-',$value2['EndDatePlan']);
			
			$thn_mulai[]= $StartDatePlan[2];
			$thn_selesai[]= $EndDatePlan[2];
			
			$tgl_mulai[]= $bln[$StartDatePlan[1]].$StartDatePlan[2];
			$tgl_selesai[]=$bln[$EndDatePlan[1]].$EndDatePlan[2];
			
		}
		
		$start_date=$tgl_start;
		$end_date=$tgl_end;
		$pot_start=explode('-',$start_date);
		$pot_end=explode('-',$end_date);
		$thn_start=$pot_start[2];
		$thn_end=$pot_end[2];
		$bln_start=$pot_start[1];
		$bln_end=$pot_end[1];
		$ang_bln_start=$bln[$bln_start];
		$ang_bln_end=$bln[$bln_end];
		$jumlah_tahun=$thn_end-$thn_start;


		if($jumlah_tahun==0){
			for($i=$ang_bln_start;$i<=$ang_bln_end;$i++)
			{
				$bln_tpl[]=$bln_back[$i];
				$thn_tpl[]=$thn_start;
				$bulanthn[]=$i.$thn_start;
			}
		}
		if($jumlah_tahun==1){
			for($i=$ang_bln_start;$i<=12;$i++)
			{

				$bln_tpl[]=$bln_back[$i];
				$thn_tpl[]=$thn_start;
				$bulanthn[]=$i.$thn_start;
				
			}
			for($i=01;$i<=$ang_bln_end;$i++)
			{
				$bulanthn[]=$i.$thn_end;
				$bln_tpl[]=$bln_back[$i];		
				$thn_tpl[]=$thn_end;
			}
		}
		$jumlah_bulan=count($bln_tpl);
		echo '
		<div class="table-responsive" >    
	  <table class="table" >
			  <tr>
				<td bgcolor="#4169E1" style="color: white; ">TIME LINE</td>
				';
				
				for($i=0;$i<$jumlah_bulan;$i++)
				{
					echo "<td bgcolor='#4169E1' style='color: white; '>".$bln_tpl[$i]."-".$thn_tpl[$i]."</td>";
				}
				
		echo'	  </tr>';
			 
			 
			 for($ii=0;$ii<$jumlah_baseline;$ii++)
			 {
				echo '<tr>
						<td >'.$Deliverable[$ii].'</td>';
						
				for($i=0;$i<$jumlah_bulan;$i++)
				{
				$dataprog_m=$tgl_mulai[$ii];
				$dataprog_s=$tgl_selesai[$ii];
				if ($bulanthn[$i]>=$dataprog_m and $bulanthn[$i]<=$dataprog_s) $cek="bgcolor='#80C8FE'"; else $cek=" style='border:1px solid silver'";
					echo "<td  ".$cek."></td>";
				
				}
				
				echo '</tr>';
			 }
			 echo '</table></div>';
	}
}


public function detail_project($id_proj){
  $param = array();
  $result = $this->m_pusb->get_detail_project($id_proj);
  $result2 = $this->m_pusb->detail_project($id_proj);
  $result3 = $this->m_pusb->team_leader($id_proj);
  $result4 = $this->m_pusb->consultant($id_proj);
  $result5 = $this->m_pusb->team_member($id_proj);
 
 
  foreach ($result as $key => $value) {
  $name=$value['ProjectName'];
  $ScopProject=$value['ScopProject'];
  $Priority=$value['Priority'];
  $Capex=$value['Capex'];
  $OwnershipTarget=$value['OwnershipTarget'];
  $Consultant_name=$value['Consultant_name'];

  }
  
  foreach ($result3 as $key => $value3) {
  $leader=$value3['EmployeeName'];

  }
  
  foreach ($result5 as $key => $value5) {
  //$leader=$value3['EmployeeName'];
 $emp_name[]=$value5['EmployeeName'];
 $rolename[]=$value5['ProjectRoleName'];
  }
 
$jml_team=count($result5);
  
 
  
  
echo '<table class="table table-striped">
		  <tr>
			<td>CODE PROJECT</td>
			<td>'.$name.'</td>
		  </tr>
		  <tr>
			<td>SCOPE OF PROJECT</td>
			<td>'.$ScopProject.'</td>
		  </tr>
		  <tr>
			<td>PRIORITY</td>
			<td>'.$Priority.'</td>
		  </tr>
		   <tr>
			<td>TARGET</td>
			<td></td>
		  </tr>
		   <tr>
			<td>TEAM LEADER</td>
			<td>'.$leader.'</td>
		  </tr>
		   <tr>
			<td>ESTIMATED CAPEX</td>
			<td>'.$Capex.'</td>
		  </tr>
		   <tr>
			<td>OWNERSHIP</td>
			<td>'.$OwnershipTarget.'</td>
		  </tr>
		   <tr>
			<td>CONSULTANT</td>
			<td>'.$Consultant_name.'</td>
		  </tr>
		   <tr>
			<td>TEAM PROJECT</td>
			<td></td>
		  </tr>
		  
		 ';
		 
		for($i=0;$i<$jml_team;$i++)
		{
			echo
			'
			<tr>
			<td style="padding-left:20px">'.$rolename[$i].'</td>
			<td>'.$emp_name[$i].'</td>
		  </tr>
			'
			;
			
		}

echo '		 
		
		   <tr>
			<td>PROGRESS PROJECT</td>
			<td></td>
		  </tr>
		   <tr>
			<td style="padding-left:20px">Update</td>
			<td></td>
		  </tr>
		   <tr>
			<td style="padding-left:20px">Status</td>
			<td></td>
		  </tr>
		   <tr>
			<td style="padding-left:20px">Handycap</td>
			<td></td>
		  </tr>
		   <tr>
			<td style="padding-left:20px">Next Steps</td>
			<td></td>
		  </tr>
	  </table>';
}

	
public function project1(){
		$param = array();
  $result = $this->m_pusb->get_cm($param);  
  $result2 = $this->m_pusb->get_re($param);  
  $result3 = $this->m_pusb->get_ab($param);  
   
  $json=array();
  
 
  foreach ($result as $key => $value) {;
  $json['persen_1']=$value['progress'];
  $json['kode_1']=$value['ID_Strategy'];
  $json['jumlah_1']=$value['jumlah'];
  }
  
  foreach ($result2 as $key => $value) {;
  $json['persen_2']=$value['progress'];
  $json['kode_2']=$value['ID_Strategy'];
  $json['jumlah_2']=$value['jumlah'];
  }
  
  foreach ($result3 as $key => $value) {;
  $json['persen_3']=$value['progress'];
  $json['kode_3']=$value['ID_Strategy'];
  $json['jumlah_3']=$value['jumlah'];
  }
	 echo json_encode($json);

	 }
	
	public function project(){
		$param = array();
  $result = $this->m_pusb->get_project_perstrategi($param);
  
  foreach ($result as $key => $value) {

		$json[] = array(
			
			'persen' => $value['progress'],
			'kode' => $value['ID_Strategy'],
			'jumlah' => $value['jumlah'],
			
			);
			
	}
	 echo json_encode($json);
	}
}