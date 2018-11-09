<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_exchange_rate extends CI_Model {

  public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default7', TRUE);
    }

    public function exchange(){
    $d='05';
    $m=date('m');
    $Y=date('Y');
    $sql = "SELECT DISTINCT
    man,
    fcurr,
    tcurr,
    GDATU,
    sum(TO_BINARY_FLOAT(UKURS)) VALKURS
    from 
    EXCHANGE_RATE
    WHERE
    SUBSTR(GDATU, 7, 4) = '$Y'
    and substr (GDATU, 4,2) = '$m'
    AND SUBSTR (GDATU, 0,2) = '$d'
    GROUP BY
    MAN,
    FCURR,
    GDATU,
    TCURR
    ORDER BY
    GDATU ASC";		
		
$data = $this->db->query($sql);
        return $data->result();
		//echo "test";
	
    }
	public function exchange_usd(){
$d='05';
$m=date('m');
$Y=date('Y');
$sqlusd = "select 
TO_NUMBER(UKURS) VALUSD
FROM
EXCHANGE_RATE
WHERE 
FCURR = 'USD'
AND SUBSTR(GDATU, 7, 4) = '$Y'
and substr (GDATU, 4,2) = '$m'
AND SUBSTR (GDATU, 0,2) = '$d'";

$data_usd = $this->db->query($sqlusd);
        return $data_usd->result_array();
	}
  
}        