<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_pusb extends CI_Model {
	
	
function get_baseline_srat_end($param){
	$db = $this->load->database('default8',true);
        $stp="'01-JAN-70'";
		$sql = ' select min("StartDatePlan") as "tgl_start", max("EndDatePlan") as "tgl_end" from "Baseline" where   "StartDatePlan"<>'.$stp.' and "ID_Project"='.$param;
				
		$result = $db->query($sql);


		return $result->result_array();
		// return 'data';
}

	
function get_baseline($param){
	$db = $this->load->database('default8',true);
       $stp="'01-JAN-70'";
		$sql = ' select * from "Baseline"
			join "Activity" on "Baseline"."ID_Activity"="Activity"."ID"
		where   "StartDatePlan"<>'.$stp.' and  "ID_Project"='.$param;
				
		$result = $db->query($sql);


		return $result->result_array();
		// return 'data';
}

	function get_cm($param){
		$db = $this->load->database('default8',true);
       
		$sql = '  select "ID_Strategy",
CASE WHEN count("ID_Strategy") is  not null THEN count("ID_Strategy") when count("ID_Strategy") is null Then 0  END as "jumlah",
CASE WHEN sum("progress") is  not null THEN sum("progress") when sum("progress") is null Then 0  END as "progress"
					from(
					select  "ID","ID_Strategy" ,"ProjectName","Bobot","Bobot_total","Progress" as "real" ,round("Bobot_total"*"Progress"/100,2) as "progress" from 
					(
					select "ID","ID_Strategy" ,"ProjectName","Bobot",
					"Bobot"/(select sum("Bobot") from "Project" PR2 where PR2."ID_Strategy"=PR1."ID_Strategy")*100 as "Bobot_total",
					(
						select "progress" from 
						(
						select "ID_Project",sum("Progress") as "progress"
						from (
						select "ID","ID_Project","Bobot" as "BOBOT_B","PersenBobot" as PersenBobot_BP,"Real",round(("Bobot"/"PersenBobot"*100),2) as "B*BP",round(("Bobot"/"PersenBobot"*100)*"Real"/100,2) as "Progress" from 
						(
						select "ID","ID_Project","Bobot",
						(
						select "ProgressPresentage" from (
						select "ProgressPresentage", "ID_Baseline" from "BaselineProgress" BSP1
						where  "ID"=(select max("ID") from "BaselineProgress" BSP2 where "BSP1"."ID"="BSP2"."ID")
						) AA where AA."ID_Baseline"="BSN1"."ID" and ROWNUM=1
						)
						as "Real",
						(select sum("Bobot") from "Baseline" BSN2 where BSN2."ID_Project"=BSN1."ID_Project"
						) as "PersenBobot"
						from "Baseline" BSN1
						)TB1
						) TB2 group by "ID_Project"
						) TB3 where TB3."ID_Project"="PR1"."ID"
					) as "Progress"
					from  "Project" PR1
					)TB4
					)TB5 where TB5."ID_Strategy" in (539)

					group by "ID_Strategy"

				';
				
		$result = $db->query($sql);


		return $result->result_array();
		// return 'data';
	}	
	
	function get_re($param){
		$db = $this->load->database('default8',true);
       
		$sql = '  select "ID_Strategy",
CASE WHEN count("ID_Strategy") is  not null THEN count("ID_Strategy") when count("ID_Strategy") is null Then 0  END as "jumlah",
CASE WHEN sum("progress") is  not null THEN sum("progress") when sum("progress") is null Then 0  END as "progress"
					from(
					select  "ID","ID_Strategy" ,"ProjectName","Bobot","Bobot_total","Progress" as "real" ,round("Bobot_total"*"Progress"/100,2) as "progress" from 
					(
					select "ID","ID_Strategy" ,"ProjectName","Bobot",
					"Bobot"/(select sum("Bobot") from "Project" PR2 where PR2."ID_Strategy"=PR1."ID_Strategy")*100 as "Bobot_total",
					(
						select "progress" from 
						(
						select "ID_Project",sum("Progress") as "progress"
						from (
						select "ID","ID_Project","Bobot" as "BOBOT_B","PersenBobot" as PersenBobot_BP,"Real",round(("Bobot"/"PersenBobot"*100),2) as "B*BP",round(("Bobot"/"PersenBobot"*100)*"Real"/100,2) as "Progress" from 
						(
						select "ID","ID_Project","Bobot",
						(
						select "ProgressPresentage" from (
						select "ProgressPresentage", "ID_Baseline" from "BaselineProgress" BSP1
						where  "ID"=(select max("ID") from "BaselineProgress" BSP2 where "BSP1"."ID"="BSP2"."ID")
						) AA where AA."ID_Baseline"="BSN1"."ID" and ROWNUM=1
						)
						as "Real",
						(select sum("Bobot") from "Baseline" BSN2 where BSN2."ID_Project"=BSN1."ID_Project"
						) as "PersenBobot"
						from "Baseline" BSN1
						)TB1
						) TB2 group by "ID_Project"
						) TB3 where TB3."ID_Project"="PR1"."ID"
					) as "Progress"
					from  "Project" PR1
					)TB4
					)TB5 where TB5."ID_Strategy" in (589)

					group by "ID_Strategy"

				';
				
		$result = $db->query($sql);


		return $result->result_array();
		// return 'data';
	}	
	
	function get_ab($param){
		$db = $this->load->database('default8',true);
       
		$sql = '  select "ID_Strategy",
CASE WHEN count("ID_Strategy") is  not null THEN count("ID_Strategy") when count("ID_Strategy") is null Then 0  END as "jumlah",
CASE WHEN sum("progress") is  not null THEN sum("progress") when sum("progress") is null Then 0  END as "progress"
					from(
					select  "ID","ID_Strategy" ,"ProjectName","Bobot","Bobot_total","Progress" as "real" ,round("Bobot_total"*"Progress"/100,2) as "progress" from 
					(
					select "ID","ID_Strategy" ,"ProjectName","Bobot",
					"Bobot"/(select sum("Bobot") from "Project" PR2 where PR2."ID_Strategy"=PR1."ID_Strategy")*100 as "Bobot_total",
					(
						select "progress" from 
						(
						select "ID_Project",sum("Progress") as "progress"
						from (
						select "ID","ID_Project","Bobot" as "BOBOT_B","PersenBobot" as PersenBobot_BP,"Real",round(("Bobot"/"PersenBobot"*100),2) as "B*BP",round(("Bobot"/"PersenBobot"*100)*"Real"/100,2) as "Progress" from 
						(
						select "ID","ID_Project","Bobot",
						(
						select "ProgressPresentage" from (
						select "ProgressPresentage", "ID_Baseline" from "BaselineProgress" BSP1
						where  "ID"=(select max("ID") from "BaselineProgress" BSP2 where "BSP1"."ID"="BSP2"."ID")
						) AA where AA."ID_Baseline"="BSN1"."ID" and ROWNUM=1
						)
						as "Real",
						(select sum("Bobot") from "Baseline" BSN2 where BSN2."ID_Project"=BSN1."ID_Project"
						) as "PersenBobot"
						from "Baseline" BSN1
						)TB1
						) TB2 group by "ID_Project"
						) TB3 where TB3."ID_Project"="PR1"."ID"
					) as "Progress"
					from  "Project" PR1
					)TB4
					)TB5 where TB5."ID_Strategy" in (590)

					group by "ID_Strategy"

				';
				
		$result = $db->query($sql);


		return $result->result_array();
		// return 'data';
	}	

	function get_reg_expansion_proj_lama($param){
		$db = $this->load->database('default8',true);
       
		$sql = '    select "ID","ProjectName","Bobot" as "Persen" from "Project"
				';
		$result = $db->query($sql);


		return $result->result_array();
		// return 'data';
	}
	
	function get_reg_expansion_proj($param){
		$db = $this->load->database('default8',true);
       
		$sql = 'select "ID","ProjectName", 
(
    select "progress" from 
    (
    select "ID_Project",sum("Progress") as "progress"
    from (
    select "ID","ID_Project","Bobot" as "BOBOT_B","PersenBobot" as PersenBobot_BP,"Real",round(("Bobot"/"PersenBobot"*100),2) as "B*BP",round(("Bobot"/"PersenBobot"*100)*"Real"/100,2) as "Progress" from 
    (
    select "ID","ID_Project","Bobot",
    (
    select "ProgressPresentage" from (
    select "ProgressPresentage", "ID_Baseline" from "BaselineProgress" BSP1
    where  "ID"=(select max("ID") from "BaselineProgress" BSP2 where "BSP1"."ID"="BSP2"."ID")
    ) AA where AA."ID_Baseline"="BSN1"."ID" and ROWNUM=1
    )
    as "Real",
    (select sum("Bobot") from "Baseline" BSN2 where BSN2."ID_Project"=BSN1."ID_Project"
    ) as "PersenBobot"
    from "Baseline" BSN1
    )TB1
    ) TB2 group by "ID_Project"
    ) TB3 where TB3."ID_Project"="Project"."ID"
) as "Progress"

from  "Project"  where "ID_Strategy"='.$param;

		$result = $db->query($sql);


		return $result->result_array();
		// return 'data';
	}
	
	function get_project_perstrategi1($param){
		$db = $this->load->database('default8',true);
       
		$sql = '   select "ID" ,SUM("TOTAL") as persen,"StrategyName",count("ID") as jumlah from
					(
					select b."ID",b."StrategyName", (a."Bobot"/100*100) as total from "Project" a
					LEFT  JOIN "Strategy" b
					ON a."ID_Strategy"=b."ID"

					) oke
					group by oke."ID","StrategyName" 
				';
		$result = $db->query($sql);


		return $result->result_array();
		// return 'data';
	}
	
	function detail_project($param){
		$db = $this->load->database('default8',true);
       
		$sql = '  SELECT * FROM "Project" JOIN "ProjectType" ON "ProjectType"."ID" = "Project"."ID_ProjectType" JOIN "Strategy" ON "Strategy"."ID" = "Project"."ID_Strategy" JOIN "Department" ON "Department"."ID" = "Project"."ID_Dept" 
		WHERE "Project"."ID" ='.$param;
		$result = $db->query($sql);


		return $result->result_array();
		// return 'data';
	}
	function team_leader($param){
		$db = $this->load->database('default8',true);
       
		$sql = ' SELECT "Team"."ID", "Team"."ID_Employee", "Team"."ID_ProjectRole", "Team"."ID_Project", "Employee"."EmployeeName" FROM "Team" JOIN "Employee" ON "Team"."ID_Employee" = "Employee"."ID" 
		WHERE "ID_Project" ='.$param.' AND "ID_ProjectRole" =422 ';
		$result = $db->query($sql);


		return $result->result_array();
		// return 'data';
	}
	function consultant($param){
		$db = $this->load->database('default8',true);
       
		$sql = '
		SELECT "Consultant"."ConsultantName" FROM "Consultant" JOIN "Consultant_Project" ON "Consultant"."ID" = "Consultant_Project"."ID_Consultant" WHERE "ID_Project" ='.$param;
		
		$result = $db->query($sql);


		return $result->result_array();
		// return 'data';
	}
	function team_member($param){
		$db = $this->load->database('default8',true);
       
		$sql = '
		SELECT "Employee"."EmployeeName", "ProjectRole"."ProjectRoleName" FROM "Employee" JOIN "Team" ON "Employee"."ID" = "Team"."ID_Employee" JOIN "ProjectRole" ON "ProjectRole"."ID" = "Team"."ID_ProjectRole" WHERE "ID_Project" ='.$param;
		
		$result = $db->query($sql);


		return $result->result_array();
		// return 'data';
	}
	
	function get_project_perstrategi($param){
		$db = $this->load->database('default8',true);
       
		$sql = '  select "ID_Strategy",count("ID_Strategy") as "jumlah",sum("progress") as "progress"
					from(
					select  "ID","ID_Strategy" ,"ProjectName","Bobot","Bobot_total","Progress" as "real" ,round("Bobot_total"*"Progress"/100,2) as "progress" from 
					(
					select "ID","ID_Strategy" ,"ProjectName","Bobot",
					"Bobot"/(select sum("Bobot") from "Project" PR2 where PR2."ID_Strategy"=PR1."ID_Strategy")*100 as "Bobot_total",
					(
						select "progress" from 
						(
						select "ID_Project",sum("Progress") as "progress"
						from (
						select "ID","ID_Project","Bobot" as "BOBOT_B","PersenBobot" as PersenBobot_BP,"Real",round(("Bobot"/"PersenBobot"*100),2) as "B*BP",round(("Bobot"/"PersenBobot"*100)*"Real"/100,2) as "Progress" from 
						(
						select "ID","ID_Project","Bobot",
						(
						select "ProgressPresentage" from (
						select "ProgressPresentage", "ID_Baseline" from "BaselineProgress" BSP1
						where  "ID"=(select max("ID") from "BaselineProgress" BSP2 where "BSP1"."ID"="BSP2"."ID")
						) AA where AA."ID_Baseline"="BSN1"."ID" and ROWNUM=1
						)
						as "Real",
						(select sum("Bobot") from "Baseline" BSN2 where BSN2."ID_Project"=BSN1."ID_Project"
						) as "PersenBobot"
						from "Baseline" BSN1
						)TB1
						) TB2 group by "ID_Project"
						) TB3 where TB3."ID_Project"="PR1"."ID"
					) as "Progress"
					from  "Project" PR1
					)TB4
					)TB5 where TB5."ID_Strategy" in (539,589,590)

					group by "ID_Strategy"

				';
		$result = $db->query($sql);


		return $result->result_array();
		// return 'data';
	}
	
	function get_detail_project($param){
		$db = $this->load->database('default8',true);
       
		//$sql = '  select * from "Project" where "ID"='.$param;
	/*	$sql = ' select * from
				(
				select * from "Project"  a
				join "Consultant_Project"  b
				on b."ID_Project"=a.ID

				join "Consultant" c
				on b."ID_Consultant"= c."ID"

				 where a."ID"='.$param.'
				) tb1
				'
				;
				*/
				
		$sql='
		select PR.*,
		(select "ConsultantName" from "Consultant_Project" CP
		join "Consultant" CS
		ON CP."ID_Consultant"=CS."ID"
		Where CP."ID_Project"=PR."ID" AND ROWNUM=1
		)"Consultant_name"
		from "Project" PR  where PR."ID"='.$param.'
		';
		$result = $db->query($sql);


		return $result->result_array();
		// return 'data';
	}

}

