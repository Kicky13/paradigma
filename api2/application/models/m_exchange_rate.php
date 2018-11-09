<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_exchange_rate extends CI_Model {

  public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default7', TRUE);
    }

    public function exchange(){
$sql = "select DISTINCT
man,
fcurr,
tcurr,
GDATU,
sum(TO_BINARY_FLOAT(UKURS)) VALKURS
from 
EXCHANGE_RATE
WHERE
SUBSTR(GDATU, 7, 4) = '2017'
and substr (GDATU, 4,2) = '02'
AND SUBSTR (GDATU, 0,2) = '17'
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
$sqlusd = "select 
TO_NUMBER(UKURS) VALUSD
FROM
EXCHANGE_RATE
WHERE 
FCURR = 'USD'
AND SUBSTR(GDATU, 7, 4) = '2017'
and substr (GDATU, 4,2) = '02'
AND SUBSTR (GDATU, 0,2) = '17'";

$data_usd = $this->db->query($sqlusd);
        return $data_usd->result_array();
	}

  
}        