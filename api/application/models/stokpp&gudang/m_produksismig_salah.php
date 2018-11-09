<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_produksismig extends CI_Model {

	public function get_produksismig($date)
	{
			$db=$this->load->database('default5',true);
			// $sql_terak=$db->query("SELECT TB1.ORG, TB1.RKAP, NVL(TB2.PROGNOSE,0) PROGNOSE, TB3.REALISASI, TB3.LASTDATE FROM (
   //                SELECT ORG, SUM(RKAP_PRODUK) RKAP
   //                FROM ZREPORT_DEMAND_PLANNING 
   //                WHERE KODE_PRODUK = 1 
   //                  AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
   //                GROUP BY ORG
   //              )TB1
   //              LEFT JOIN (
   //                SELECT ORG, SUM(PROG_PRODUK) PROGNOSE
   //                FROM ZREPORT_DEMAND_PLANNING
   //                WHERE KODE_PRODUK = 1
   //                  AND TO_CHAR(TANGGAL,'YYYYMM') = '$date' 
   //                  AND TO_CHAR(TANGGAL,'DD')>TO_CHAR((SELECT MAX(TANGGAL) FROM ZREPORT_REAL_PROD_DEMANDPL WHERE KODE_PRODUK = 1 AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'),'DD') 
   //               GROUP BY ORG
   //              )TB2 ON TB1.ORG = TB2.ORG
   //              LEFT JOIN (
   //                SELECT ORG, SUM(QTY_PROD) REALISASI, MAX(TANGGAL) LASTDATE
   //                FROM ZREPORT_REAL_PROD_DEMANDPL
   //                WHERE KODE_PRODUK = 1
   //                  AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
   //                 GROUP BY ORG
   //              )TB3 ON TB1.ORG = TB3.ORG");
        $sql_terak=$db->query("SELECT TB1.ORG, TB1.RKAP, NVL(TB2.PROGNOSE,0) PROGNOSE, TB3.REALISASI, TB3.LASTDATE FROM (
                  SELECT ORG, SUM(RKAP_PRODUK) RKAP
                  FROM ZREPORT_DEMAND_PLANNING 
                  WHERE KODE_PRODUK = 1 
                    AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                    AND ORG in ('7000', '3000', '4000','6000')
                  GROUP BY ORG
                )TB1
                LEFT JOIN (
                SELECT
                  ORG,
                  SUM (PROG_PRODUK) PROGNOSE
                FROM
                  ZREPORT_DEMAND_PLANNING
                WHERE
                  KODE_PRODUK = 1
                AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                AND ORG = '4000'
                AND TO_CHAR (TANGGAL, 'DD') > TO_CHAR (
                  (
                    SELECT
                      MAX (TANGGAL)
                    FROM
                      ZREPORT_REAL_PROD_DEMANDPL
                    WHERE
                      KODE_PRODUK = 1
                    AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                    AND ORG = '4000'
                  ),
                  'DD'
                )
                GROUP BY
                  ORG
                UNION
                SELECT
                  ORG,
                  SUM (PROG_PRODUK) PROGNOSE
                FROM
                  ZREPORT_DEMAND_PLANNING
                WHERE
                  KODE_PRODUK = 1
                AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                AND ORG = '3000'
                AND TO_CHAR (TANGGAL, 'DD') > TO_CHAR (
                  (
                    SELECT
                      MAX (TANGGAL)
                    FROM
                      ZREPORT_REAL_PROD_DEMANDPL
                    WHERE
                      KODE_PRODUK = 1
                    AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                    AND ORG = '3000'
                  ),
                  'DD'
                )
                GROUP BY
                  ORG
                UNION
                SELECT
                  ORG,
                  SUM (PROG_PRODUK) PROGNOSE
                FROM
                  ZREPORT_DEMAND_PLANNING
                WHERE
                  KODE_PRODUK = 1
                AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                AND ORG = '6000'
                AND TO_CHAR (TANGGAL, 'DD') > TO_CHAR (
                  (
                    SELECT
                      MAX (TANGGAL)
                    FROM
                      ZREPORT_REAL_PROD_DEMANDPL
                    WHERE
                      KODE_PRODUK = 1
                    AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                    AND ORG = '6000'
                  ),
                  'DD'
                )
                GROUP BY
                  ORG
                UNION
                SELECT
                  ORG,
                  SUM (PROG_PRODUK) PROGNOSE
                FROM
                  ZREPORT_DEMAND_PLANNING
                WHERE
                  KODE_PRODUK = 1
                AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                AND ORG = '7000'
                AND TO_CHAR (TANGGAL, 'DD') > TO_CHAR (
                  (
                    SELECT
                      MAX (TANGGAL)
                    FROM
                      ZREPORT_REAL_PROD_DEMANDPL
                    WHERE
                      KODE_PRODUK = 1
                    AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                    AND ORG = '7000'
                  ),
                  'DD'
                )
                GROUP BY
                  ORG

                )TB2 ON TB1.ORG = TB2.ORG
                LEFT JOIN (
                  SELECT ORG, SUM(QTY_PROD) REALISASI, MAX(TANGGAL) LASTDATE
                  FROM ZREPORT_REAL_PROD_DEMANDPL
                  WHERE KODE_PRODUK = 1
                    AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                    AND ORG in ('7000', '3000', '4000','6000')
                   GROUP BY ORG
                )TB3 ON TB1.ORG = TB3.ORG");
			$sql_teraks6000=$db->query("SELECT TB1.ORG, TB1.RKAP, NVL(TB2.PROGNOSE,0) PROGNOSE, TB3.REALISASI, TB3.LASTDATE FROM (
                  SELECT ORG, SUM(RKAP_PRODUK) RKAP
                  FROM ZREPORT_DEMAND_PLANNING 
                  WHERE KODE_PRODUK = 1 
                    AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                    AND ORG = '6000'
                  GROUP BY ORG
                )TB1
                LEFT JOIN (
                  SELECT ORG, SUM(PROG_PRODUK) PROGNOSE
                  FROM ZREPORT_DEMAND_PLANNING
                  WHERE KODE_PRODUK = 1
                    AND ORG = '6000'
                    AND TO_CHAR(TANGGAL,'YYYYMM') = '$date' 
                    AND TO_CHAR(TANGGAL,'DD')>TO_CHAR((SELECT MAX(TANGGAL) FROM ZREPORT_REAL_PROD_DEMANDPL WHERE KODE_PRODUK = 1 AND TO_CHAR(TANGGAL,'YYYYMM') = '$date' AND ORG = '6000'),'DD') 
                  GROUP BY ORG
                )TB2 ON TB1.ORG = TB2.ORG
                LEFT JOIN (
                  SELECT ORG, SUM(QTY_PROD) REALISASI, MAX(TANGGAL) LASTDATE
                  FROM ZREPORT_REAL_PROD_DEMANDPL
                  WHERE KODE_PRODUK = 1
                    AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                    AND ORG = '6000'
                  GROUP BY ORG
                )TB3 ON TB1.ORG = TB3.ORG");
        $smig_vol_prog6000=0;
        $smig_realisasi6000=0;
        $rkapterak6000=0;
			foreach ($sql_teraks6000->result_array() as $rowID) {
				$smig_vol_prog6000=$rowID['PROGNOSE']+$rowID['REALISASI'];
				$smig_realisasi6000=$smig_vol_prog6000-$rowID['RKAP'];
				$rkapterak6000=$rowID['RKAP'];
			}
				$total_prog=0;
				$total_realisasi=0;
				$total_rkap=0;
        $prod_smig = array();
			foreach ($sql_terak->result_array() as $rowID) {
				
				$total_realisasi  +=  (float) $rowID['REALISASI'];
				$total_prog       +=  (float) $rowID['PROGNOSE'];
				$total_rkap       +=  (float) $rowID['RKAP'];
				$smig_vol_prog=$rowID['PROGNOSE']+$rowID['REALISASI'];
				$smig_realisasi=$smig_vol_prog-$rowID['RKAP'];
				$prognose_smig=$smig_vol_prog/$rowID['RKAP']*100;
				$org=$rowID['ORG'];

				$prod_smig['s'.$org]=array('prognose'=>$prognose_smig,
											'vol_prog'=>$smig_vol_prog,
											'realisasi'=>$smig_realisasi);
			}

        $temp_terak['real'] = $total_realisasi;
        $temp_terak['prog'] = $total_prog;
        $temp_terak['rkap'] = $total_rkap;

				$total_volprog=$total_prog+$total_realisasi;
				$total_rkapsmig=$total_volprog-$total_rkap;
				$tot_volprogterak=$total_volprog-$smig_vol_prog6000;
				$tot_rkapterak=$total_rkap-$rkapterak6000;

        $total_prognose = 0;
        if ($tot_rkapterak!=0) {
          # code...
          // $total_prognose=$total_volprog/$tot_rkapterak*100;
          $total_prognose=$total_volprog/$total_rkap*100;
          
        }
				// $prod_total=array('prognose'=>$total_prognose,
				// 	'vol_prog'=>$total_volprog-$smig_vol_prog6000,
				// 	'realisasi'=>$total_rkapsmig-$smig_realisasi6000);
          $prod_total=array('prognose'=>$total_prognose,
          'vol_prog'=>$total_volprog,
          'realisasi'=>$total_rkapsmig);   
      
			


			// semen

				$sql_semen=$db->query("SELECT TB1.ORG, TB1.RKAP, NVL(TB2.PROGNOSE,0) PROGNOSE, TB3.REALISASI, TB3.LASTDATE FROM (
                  SELECT ORG, SUM(RKAP_PRODUK) RKAP
                  FROM ZREPORT_DEMAND_PLANNING 
                  WHERE KODE_PRODUK = 2 
                    AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                    AND ORG in ('7000', '3000', '4000','6000')
                  GROUP BY ORG
                )TB1
                LEFT JOIN (
                 SELECT
                    ORG,
                    SUM (PROG_PRODUK) PROGNOSE
                  FROM
                    ZREPORT_DEMAND_PLANNING
                  WHERE
                    KODE_PRODUK = 2
                  AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                  AND ORG = '4000'
                  AND TO_CHAR (TANGGAL, 'DD') > TO_CHAR (
                    (
                      SELECT
                        MAX (TANGGAL)
                      FROM
                        ZREPORT_REAL_PROD_DEMANDPL
                      WHERE
                        KODE_PRODUK = 2
                      AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                      AND ORG = '4000'
                    ),
                    'DD'
                  )
                  GROUP BY
                    ORG
                  UNION
                    SELECT
                      ORG,
                      SUM (PROG_PRODUK) PROGNOSE
                    FROM
                      ZREPORT_DEMAND_PLANNING
                    WHERE
                      KODE_PRODUK = 2
                    AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                    AND ORG = '3000'
                    AND TO_CHAR (TANGGAL, 'DD') > TO_CHAR (
                      (
                        SELECT
                          MAX (TANGGAL)
                        FROM
                          ZREPORT_REAL_PROD_DEMANDPL
                        WHERE
                          KODE_PRODUK = 2
                        AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                        AND ORG = '3000'
                      ),
                      'DD'
                    )
                    GROUP BY
                      ORG
                    UNION
                      SELECT
                        ORG,
                        SUM (PROG_PRODUK) PROGNOSE
                      FROM
                        ZREPORT_DEMAND_PLANNING
                      WHERE
                        KODE_PRODUK = 2
                      AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                      AND ORG = '6000'
                      AND TO_CHAR (TANGGAL, 'DD') > TO_CHAR (
                        (
                          SELECT
                            MAX (TANGGAL)
                          FROM
                            ZREPORT_REAL_PROD_DEMANDPL
                          WHERE
                            KODE_PRODUK = 2
                          AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                          AND ORG = '6000'
                        ),
                        'DD'
                      )
                      GROUP BY
                        ORG
                      UNION
                        SELECT
                          ORG,
                          SUM (PROG_PRODUK) PROGNOSE
                        FROM
                          ZREPORT_DEMAND_PLANNING
                        WHERE
                          KODE_PRODUK = 2
                        AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                        AND ORG = '7000'
                        AND TO_CHAR (TANGGAL, 'DD') > TO_CHAR (
                          (
                            SELECT
                              MAX (TANGGAL)
                            FROM
                              ZREPORT_REAL_PROD_DEMANDPL
                            WHERE
                              KODE_PRODUK = 2
                            AND TO_CHAR (TANGGAL, 'YYYYMM') = '$date'
                            AND ORG = '7000'
                          ),
                          'DD'
                        )
                        GROUP BY
                          ORG
                )TB2 ON TB1.ORG = TB2.ORG
                LEFT JOIN (
                  SELECT ORG, SUM(QTY_PROD) REALISASI, MAX(TANGGAL) LASTDATE
                  FROM ZREPORT_REAL_PROD_DEMANDPL
                  WHERE KODE_PRODUK = 2
                    AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                    AND ORG in ('7000', '3000', '4000','6000')
                   GROUP BY ORG
                )TB3 ON TB1.ORG = TB3.ORG");
			$sql_semens6000=$db->query("SELECT TB1.ORG, TB1.RKAP, NVL(TB2.PROGNOSE,0) PROGNOSE, TB3.REALISASI, TB3.LASTDATE FROM (
                  SELECT ORG, SUM(RKAP_PRODUK) RKAP
                  FROM ZREPORT_DEMAND_PLANNING 
                  WHERE KODE_PRODUK = 2 
                    AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                    AND ORG = '6000'
                  GROUP BY ORG
                )TB1
                LEFT JOIN (
                  SELECT ORG, SUM(PROG_PRODUK) PROGNOSE
                  FROM ZREPORT_DEMAND_PLANNING
                  WHERE KODE_PRODUK = 2
                    AND ORG = '6000'
                    AND TO_CHAR(TANGGAL,'YYYYMM') = '$date' 
                    AND TO_CHAR(TANGGAL,'DD')>TO_CHAR((SELECT MAX(TANGGAL) FROM ZREPORT_REAL_PROD_DEMANDPL WHERE KODE_PRODUK = 2 AND TO_CHAR(TANGGAL,'YYYYMM') = '$date' AND ORG = '6000'),'DD') 
                  GROUP BY ORG
                )TB2 ON TB1.ORG = TB2.ORG
                LEFT JOIN (
                  SELECT ORG, SUM(QTY_PROD) REALISASI, MAX(TANGGAL) LASTDATE
                  FROM ZREPORT_REAL_PROD_DEMANDPL
                  WHERE KODE_PRODUK = 2
                    AND TO_CHAR(TANGGAL,'YYYYMM') = '$date'
                    AND ORG = '6000'
                  GROUP BY ORG
                )TB3 ON TB1.ORG = TB3.ORG");
        $smig_vol_progsemensemen6000=0;
        $smig_realisasisemensemen6000=0;
        $rkapsemen=0;
			foreach ($sql_semens6000->result_array() as $rowID) {
				$smig_vol_progsemensemen6000=$rowID['PROGNOSE']+$rowID['REALISASI'];
				$smig_realisasisemensemen6000=$smig_vol_progsemensemen6000-$rowID['RKAP'];
				$rkapsemen=$rowID['RKAP'];
			}
				$total_progsemen=0;
				$total_realisasisemen=0;
				$total_rkapsemen=0;
        $prod_smigsemen = array();
			foreach ($sql_semen->result_array() as $rowID) {
				
				$total_realisasisemen   +=  (float) $rowID['REALISASI'];
				$total_progsemen        +=  (float) $rowID['PROGNOSE'];
				$total_rkapsemen        +=  (float) $rowID['RKAP'];
				$smig_vol_progsemen=$rowID['PROGNOSE']+$rowID['REALISASI'];
				$smig_realisasisemen=$smig_vol_progsemen-$rowID['RKAP'];
				$org=$rowID['ORG'];
				$prognose_semen=$smig_vol_progsemen/$rowID['RKAP']*100;

				$prod_smigsemen['s'.$org]=array('prognose'=>$prognose_semen,
												'vol_prog'=>$smig_vol_progsemen,
												'realisasi'=>$smig_realisasisemen);
			}

      $temp_semen['real'] = $total_realisasisemen;
      $temp_semen['prog'] = $total_progsemen;
      $temp_semen['rkap'] = $total_rkapsemen;

				$total_volprogsemen = $total_progsemen+$total_realisasisemen;
				$total_rkapsemensmig= $total_volprogsemen-$total_rkapsemen;
				$tot_prognosesemen  = $total_volprogsemen-$smig_vol_progsemensemen6000;
				$tot_rkap           = $total_rkapsemen-$rkapsemen;
        $total_prognosesemen= 0;
        if ($total_rkapsemen!=0) {
          # code...
        // $total_prognosesemen=$tot_prognosesemen/$tot_rkap*100;
        $total_prognosesemen=$total_volprogsemen/$total_rkapsemen*100;
          
        }
				// $prod_totalsemen=array('prognose'=>$total_prognosesemen,
				// 								'vol_prog'=>$total_volprogsemen-$smig_vol_progsemensemen6000,
				// 								'realisasi'=>$total_rkapsemensmig-$smig_realisasisemensemen6000);
        $prod_totalsemen=array('prognose'=>$total_prognosesemen,
                        'vol_prog'=>$total_volprogsemen,
                        'realisasi'=>$total_rkapsemensmig);    

      // $test['data']['terak'] = $temp_terak;
      // $test['data']['semen'] = $temp_semen;


			
			$test['terak'] = $prod_smig;
			$test['terak']['total'] = $prod_total;
			
			$test['semen'] = $prod_smigsemen;
			$test['semen']['total'] = $prod_totalsemen;
			echo json_encode($test);
//			$data = '{"Terak":'.json_encode($prod_total).json_encode($prod_smig).'},{"Semen":'.json_encode($prod_totalsemen).json_encode($prod_smigsemen).'}';

			// echo str_replace('}{', ',', $data);
	}


  public function get_produksi_monthly($year, $month, $opco, $type){

    $sqlOpco = "AND ORG = '$opco'";
    $sqlSelect = "TB1.ORG,
              NVL (TB1.RKAP, 0) RKAP,
              NVL (TB2.PROGNOSE, 0) PROGNOSE,
              NVL (TB3.REALISASI, 0) REALISASI,
              TO_CHAR (TB1.TANGGAL, 'YYYY-MM-DD') TANGGAL";
    $groupBy = '';

    if ($opco=='smi'||$opco=='SMI') {
      # code...
      $sqlOpco = "AND ORG IN ('7000', '3000', '4000')";
      $sqlSelect = "  
              NVL (SUM(TB1.RKAP), 0) RKAP,
              NVL (SUM(TB2.PROGNOSE), 0) PROGNOSE,
              NVL (SUM(TB3.REALISASI), 0) REALISASI,
              TO_CHAR (TB1.TANGGAL, 'YYYY-MM-DD') TANGGAL
            ";
      $groupBy = 'GROUP BY TB1.TANGGAL';
    }

    $db=$this->load->database('default5',true);
    $sql = "
            SELECT
              $sqlSelect
            FROM
              (
                SELECT
                  ORG,
                  SUM (RKAP_PRODUK) RKAP,
                  TANGGAL
                FROM
                  ZREPORT_DEMAND_PLANNING
                WHERE
                  KODE_PRODUK = $type
                AND TO_CHAR (TANGGAL, 'YYYYMM') = '$year$month'
                $sqlOpco
                GROUP BY
                  ORG, TANGGAL
              ) TB1
            LEFT JOIN (
              SELECT
                ORG,
                SUM (PROG_PRODUK) PROGNOSE,
                TANGGAL
              FROM
                ZREPORT_DEMAND_PLANNING
              WHERE
                KODE_PRODUK = $type
              $sqlOpco
              AND TO_CHAR (TANGGAL, 'YYYYMM') = '$year$month'
              
              GROUP BY
                ORG, TANGGAL
            ) TB2 ON TB1.ORG = TB2.ORG AND TB1.TANGGAL = TB2.TANGGAL
            LEFT JOIN (
              SELECT
                ORG,
                SUM (QTY_PROD) REALISASI,
                TANGGAL
              FROM
                ZREPORT_REAL_PROD_DEMANDPL
              WHERE
                KODE_PRODUK = $type
              AND TO_CHAR (TANGGAL, 'YYYYMM') = '$year$month'
              $sqlOpco
              GROUP BY
                ORG, TANGGAL
            ) TB3 ON TB1.ORG = TB3.ORG AND TB1.TANGGAL = TB3.TANGGAL
            $groupBy
            ORDER BY TB1.TANGGAL
          
            ";


            $result = $db->query($sql);

            return $result->result_array();

  }

}

/* End of file m_produksismig.php */
/* Location: ./application/models/stokpp&gudang/m_produksismig.php */