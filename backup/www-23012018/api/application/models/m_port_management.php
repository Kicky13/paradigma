<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_port_management extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('portm', TRUE);
    }

    public function get_port_mngmnt($date_start, $date_finish)
    {

        $data = $this->db->query("SELECT
		(
			SELECT
				MAX (AD2.ACT_STEP)
			FROM
				ACT_DETAIL AD2
			WHERE
				AD2.ACT_H_ID = AH. ID
		) AS MAXKEGIATAN,
			AH. ID AS PKK,
			S.SHIP_NAME AS NM_KAPAL,
			PA.PORT_NAME AS PEL_ASAL,
			PT.PORT_NAME AS PEL_TUJUAN,
			PS.PORT_NAME AS PEL_SANDAR,
			KD.KD_NAME AS NM_KD,
			AD2.ACT_STEP AS KEGIATAN,
			AH.ACT_ETA AS ETA,
			TO_CHAR (
				AD2.ACT_TIME_START,
				'DD-MONTH-YYYY HH24:MI:ss'
			) AS WAKTU_MULAI,
			TO_CHAR (
				AD2.ACT_TIME_END,
				'DD-MONTH-YYYY HH24:MI:ss'
			) AS WAKTU_SELESAI,
			AH.ACT_CARGO_TOTAL AS MUATAN,
			AD3.STATUS
		FROM
			ACT_HEADER AH
		LEFT JOIN (
			SELECT
				AD.ACT_STEP,
				AD.ACT_H_ID,
				AD.ACT_TIME_START,
				AD.ACT_TIME_END
			FROM
				ACT_DETAIL AD
			WHERE
				IS_DELETED = 0
		) AD2 ON AH. ID = AD2.ACT_H_ID
		LEFT JOIN (
			SELECT
				AD.ACT_H_ID,
				MAX (ACT_STEP) STATUS
			FROM
				ACT_DETAIL AD
			WHERE
				IS_DELETED = 0
			GROUP BY
				AD.ACT_H_ID
		) AD3 ON AH. ID = AD3.ACT_H_ID
		LEFT JOIN PORT PA ON PA. ID = AH.ACT_PORT_FROM
		LEFT JOIN PORT PT ON PT. ID = AH.ACT_PORT_TO
		LEFT JOIN PORT_DOCK_KD KD ON AH.ACT_KD = KD. ID
		LEFT JOIN PORT PS ON AH.ACT_PORT_BERTH = PS. ID
		LEFT JOIN SHIP S ON AH.SHIP_ID = S. ID
		WHERE
			AH.IS_DELETED = 0
		AND AH.ACT_PORT_BERTH IS NOT NULL
		AND AD3.STATUS <> 1
		AND TRUNC (AH.CREATED_AT) BETWEEN TO_DATE (
			'" . date('d/m/Y', strtotime($date_start)) . "',
			'DD/MM/YYYY'
		)
		AND TO_DATE (
			'" . date('d/m/Y', strtotime($date_finish)) . "',
			'DD/MM/YYYY'
		)
		ORDER BY
			AH.ACT_PORT_BERTH,
			AH.ACT_KD,
			AH. ID,
			AD2.ACT_STEP");

        return $data->result();
    }

    public function get_port_final($date_start, $date_finish)
    {

        $data = $this->db->query("SELECT
    (
		SELECT
			MAX (AD2.ACT_STEP)
		FROM
			ACT_DETAIL AD2
		WHERE
			AD2.ACT_H_ID = AH. ID
	) AS MAXKEGIATAN,
	AH. ID AS PKK,
	S.SHIP_NAME AS NM_KAPAL,
	PA.PORT_NAME AS PEL_ASAL,
	PT.PORT_NAME AS PEL_TUJUAN,
	PS.PORT_NAME AS PEL_SANDAR,
	AH.ACT_TYPE,
	AGENT.COMPANY_NAME AS NM_AGEN,
	PBM.COMPANY_NAME AS NM_PBM,
	SP.SHIP_PRODUCT_NAME AS NM_PRODUK,
	KD.KD_NAME AS NM_KD,
	AD2.ACT_STEP AS KEGIATAN,
	TO_CHAR (
		AH.ACT_ETA,
		'DD-MONTH-YYYY HH24:MI:ss'
	) AS ETA,
	TO_CHAR (
		AD2.ACT_TIME_START,
		'DD-MONTH-YYYY HH24:MI:ss'
	) AS WAKTU_MULAI,
	TO_CHAR (
		AD2.ACT_TIME_END,
		'DD-MONTH-YYYY HH24:MI:ss'
	) AS WAKTU_SELESAI,
	AH.ACT_CARGO_TOTAL AS MUATAN,
	AD3.STATUS
        FROM
            ACT_HEADER AH
        LEFT JOIN (
            SELECT
                AD.ACT_STEP,
                AD.ACT_H_ID,
                AD.ACT_TIME_START,
                AD.ACT_TIME_END
            FROM
                ACT_DETAIL AD
            WHERE
                IS_DELETED = 0
        ) AD2 ON AH. ID = AD2.ACT_H_ID
        LEFT JOIN (
            SELECT
                AD.ACT_H_ID,
                MAX (ACT_STEP) STATUS
            FROM
                ACT_DETAIL AD
            WHERE
                IS_DELETED = 0
            GROUP BY
                AD.ACT_H_ID
        ) AD3 ON AH. ID = AD3.ACT_H_ID
        LEFT JOIN PORT PA ON PA. ID = AH.ACT_PORT_FROM
        LEFT JOIN COMPANY AGENT ON AGENT. ID = AH.AGENT_CODE
        LEFT JOIN COMPANY PBM ON PBM. ID = AH.ACT_PBM
        LEFT JOIN SHIP_PRODUCT SP ON SP. ID = AH.ACT_CARGO
        LEFT JOIN PORT PT ON PT. ID = AH.ACT_PORT_TO
        LEFT JOIN PORT_DOCK_KD KD ON AH.ACT_KD = KD. ID
        LEFT JOIN PORT PS ON AH.ACT_PORT_BERTH = PS. ID
        LEFT JOIN SHIP S ON AH.SHIP_ID = S. ID
        WHERE
            AH.IS_DELETED = 0
        AND AH.ACT_PORT_BERTH IS NOT NULL
        AND AD3.STATUS <> 5
        AND TRUNC (AH.CREATED_AT) BETWEEN TO_DATE (
                    '" . date('d/m/Y', strtotime($date_start)) . "',
                    'DD/MM/YYYY'
                )
                AND TO_DATE (
                    '" . date('d/m/Y', strtotime($date_finish)) . "',
                    'DD/MM/YYYY'
                )
        ORDER BY
	AH.ACT_PORT_BERTH,
	(
		SELECT
			MAX (AD2.ACT_STEP)
		FROM
			ACT_DETAIL AD2
		WHERE
			AD2.ACT_H_ID = AH. ID
	) DESC,
	AH. ID,
	AD2.ACT_STEP");

        return $data->result();
    }


    public function get_pkk_prot($id_pkk)
    {

        $data = $this->db->query("SELECT
                      TO_CHAR (WAKTU_MULAI,'DD/MM/YYYY HH:MI') AS WAKTU_MULAI, 
                      TO_CHAR (WAKTU_SELESAI,'DD/MM/YYYY HH:MI') AS WAKTU_SELESAI, JUMLAH, RITASE
                    FROM
                        KPL_ACT_PBM_HDR APH
                    LEFT JOIN KPL_ACT_PBM_DTL APD ON APD.PBM_HDR_ID = APH. ID
                    WHERE
                        APH.ID_PKK IN ($id_pkk)
                    AND APH.DELETE_MARK = 0
                    AND APD.DELETE_MARK = 0
                    ORDER BY
                        APH.ID_PKK,
                        APD.WAKTU_MULAI");
        return $data->result();
    }
}

/* End of file m_cost_structure.php */
/* Location: ./application/models/m_cost_structure.php */