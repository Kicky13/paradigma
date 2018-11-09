<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_balance extends CI_Model {
    public $TBGL = 0;
    public $TBGL4 = 0;
    public $TBGL5 = 0;
    public $TBGL3 = 0;
    public $TBGLIN = 0;
    public $TBMIN = 0;
    public $TBINGL = 0;
    public $TBLGL = 0; 

    public $db;
    function __construct() {
        parent::__construct();
        $db = $this->load->database('default3',true);
    }

    function get_allBy($now, $last, $past, $company){

        $db = $this->load->database('default3', true);
        $sql = "SELECT
                    CONSOLIDATION.AMOUNT,
                    CONSOLIDATION.GL_ACCOUNT,
                    CONSOLIDATION.COMPANY,
                    CONSOLIDATION.CURRENCY,
                    CONSOLIDATION.CATEGORY,
                    CONSOLIDATION.AUDITTRAIL,
                    CONSOLIDATION.FISCAL_YEAR_PERIOD
                FROM
                    CONSOLIDATION
                WHERE
                    CONSOLIDATION.FISCAL_YEAR_PERIOD IN (
                        '2016.05',
                        '2016.04',
                        '2015.12'
                    )
                AND COMPANY IN (
                    '7000',
                    '4000',
                    '3000',
                    '6000'
                )
                AND CONSOLIDATION.CURRENCY = 'LC'
                AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
                AND CONSOLIDATION.CATEGORY = 'ACT'";

        $result = $db->query($sql);

        return $result->result();
    }



    function get_value_gl($glaccount, $company, $category, $date){
        $this->TBGL++;
        $db = $this->load->database('default3', true);
        $sql = "
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN $company
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
        ";
         // echo "($sql) TBGL$this->TBGL,";
        $result = $db->query($sql);

        // echo "queryOracle => $queryOracle ->";

        // echo $queryOracle['JUMLAH'];
        
        $result_row = $result->row();

        // echo "execute => $result ->";

        if(isset($result_row)){
            return $result_row->JUMLAH;
        }

        //echo "fetch => ".$fetch[0];

        return 0;

        }
    function plus_like_gl4($glaccount1, $glaccount2, $glaccount3,$glaccount4, $company, $category, $date){
        $this->TBGL4++;
        $db = $this->load->database('default3', true);
        $sql = "
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount1%'
            AND CONSOLIDATION.COMPANY IN $company
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount2%'
            AND CONSOLIDATION.COMPANY IN $company
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount3%'
            AND CONSOLIDATION.COMPANY IN $company
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount4%'
        AND CONSOLIDATION.COMPANY IN $company
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ";
         // echo "($sql) TBGL4$this->TBGL4,";
        $result = $db->query($sql);

        // echo "queryOracle => $queryOracle ->";

        // echo $queryOracle['JUMLAH'];
        
        $result_row = $result->row();

        // echo "execute => $result ->";

        if(isset($result_row)){
            return $result_row->JUMLAH;
        }

        //echo "fetch => ".$fetch[0];

        return 0;

        }

    function plus_gl5_in($glaccount1, $glaccount2, $glaccount3,$glaccount4,$glaccount5,$glaccount6, $company, $category, $date){
        $this->TBGL5 ++;
        $db = $this->load->database('default3', true);
        $sql = "
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount1%'
            AND CONSOLIDATION.COMPANY IN $company
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount2%'
            AND CONSOLIDATION.COMPANY IN $company
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount3%'
            AND CONSOLIDATION.COMPANY IN $company
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount4%'
            AND CONSOLIDATION.COMPANY IN $company
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount5%'
            AND CONSOLIDATION.COMPANY IN $company
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT IN ('$glaccount6[0]', '$glaccount6[1]', '$glaccount6[2]', '$glaccount6[3]', '$glaccount6[4]', '$glaccount6[5]')
        AND CONSOLIDATION.COMPANY IN $company
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ";
         // echo "($sql) TBGL5$this->TBGL5,";
        $result = $db->query($sql);

        // echo "queryOracle => $queryOracle ->";

        // echo $queryOracle['JUMLAH'];
        
        $result_row = $result->row();

        // echo "execute => $result ->";

        if(isset($result_row)){
            return $result_row->JUMLAH;
        }

        //echo "fetch => ".$fetch[0];

        return 0;

        }

    function plus_like_gl3($glaccount1, $glaccount2, $glaccount3, $company, $category, $date){
        $this->TBGL3++;
        $db = $this->load->database('default3', true);
        $sql = "
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
                CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount1%'
            AND CONSOLIDATION.COMPANY IN $company
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount2%'
            AND CONSOLIDATION.COMPANY IN $company
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount3%'
           AND  CONSOLIDATION.COMPANY IN $company
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ";

        
         // echo "($sql) TBGL3$this->TBGL3,";
        $result = $db->query($sql);

        // echo "queryOracle => $queryOracle ->";

        // echo $queryOracle['JUMLAH'];
        
        $result_row = $result->row();

        // echo "execute => $result ->";

        if(isset($result_row)){
            return $result_row->JUMLAH;
        }

        //echo "fetch => ".$fetch[0];

        return 0;

        }
    function plus_like_gl($glaccount1, $glaccount2, $company, $category, $date){
        $this->TBLGL++;
        $db = $this->load->database('default3', true);
        $sql = "
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount1%'
        AND CONSOLIDATION.COMPANY IN $company
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount2%'
           AND  CONSOLIDATION.COMPANY IN $company
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ";

        
         // echo "($sql) TBPLGL$this->TBLGL,";
        $result = $db->query($sql);

        // echo "queryOracle => $queryOracle ->";

        // echo $queryOracle['JUMLAH'];
        
        $result_row = $result->row();

        // echo "execute => $result ->";

        if(isset($result_row)){
            return $result_row->JUMLAH;
        }

        return 0;

        }

    function min_like_gl_in($glaccount1,$glaccount2, $company, $category, $date){
        $this->TBGLIN++;
        $db = $this->load->database('default3', true);
        $sql = "
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.COMPANY IN $company
        AND CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount1%'
        AND CONSOLIDATION.GL_ACCOUNT NOT IN ('$glaccount2[0]', '$glaccount2[1]', '$glaccount2[2]', '$glaccount2[3]', '$glaccount2[4]', '$glaccount2[5]')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ";
         // echo "($sql) TBGLIN$this->TBGLIN,";
        $result = $db->query($sql);

        // echo "queryOracle => $queryOracle ->";

        // echo $queryOracle['JUMLAH'];
        
        $result_row = $result->row();

        // echo "execute => $result ->";

        if(isset($result_row)){
            return $result_row->JUMLAH;
        }

        //echo "fetch => ".$fetch[0];

        return 0;

        }
    function in_gl($glaccount, $company, $category, $date){
        $this->TBINGL++;
        $db = $this->load->database('default3', true);
        $sql = "
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.COMPANY IN $company
        AND CONSOLIDATION.GL_ACCOUNT IN ('$glaccount[0]', '$glaccount[1]', '$glaccount[2]', '$glaccount[3]')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ";
         // echo "($sql ) TBINGL$this->TBINGL,";
        $result = $db->query($sql);

        // echo "queryOracle => $queryOracle ->";

        // echo $queryOracle['JUMLAH'];
        
        $result_row = $result->row();

        // echo "execute => $result ->";

        if(isset($result_row)){
            return $result_row->JUMLAH;
        }

        //echo "fetch => ".$fetch[0];

        return 0;

        }

    function min_like_gl($glaccount1,$glaccount2, $company, $category, $date){
        $this->TBMIN ++;
        $db = $this->load->database('default3', true);
        $sql = "
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
         CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount1%'
        AND CONSOLIDATION.GL_ACCOUNT NOT LIKE '$glaccount2%'
        AND CONSOLIDATION.COMPANY IN $company
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
        

        ";
          // echo "($sql) TBMIN$this->TBMIN,";
        $result = $db->query($sql);
        
        $result_row = $result->row();

        if(isset($result_row)){
            return $result_row->JUMLAH;
        }

        return 0;

        }

    function ratio($company, $date){
        $db = $this->load->database('default3', true);
        $sql = "
                SELECT
                    HPBVAL,
                    OAVAL,
                    (HPBVAL + OAVAL) AS HP,
                    EBITDAVAL,
                    (EBITDAVAL /(HPBVAL + OAVAL)) * 100 AS MARGIN_EBITDA,
                    BPPVAL,
                    (HPBVAL + OAVAL + BPPVAL) AS LABA_KOTOR,
                    BUAVAL,
                    BPEVAL,
                    (HPBVAL + OAVAL + BPPVAL)+BUAVAL+BPEVAL AS LABA_USAHA,
                    BPVAL,
                    LRSKVAL,
                    PLLVAL,
                    ((HPBVAL + OAVAL + BPPVAL)+BUAVAL+BPEVAL) + LRSKVAL + PLLVAL + BPVAL AS LABA_SEBELUM_PAJAK

                FROM
                    (
                        SELECT
                            SUM(AMOUNT) AS HPBVAL
                        FROM
                            CONSOLIDATION
                        WHERE
                            AUDITTRAIL = 'PL_CONS'
                        AND CATEGORY = 'ACT'
                        AND COSTCENTER_COMPONENT = 'NO_CC'
                        AND DOCUMENT_TYPE = 'NO_DOC'
                        AND FLOW = 'CLOSING'
                        AND GL_ACCOUNT = 'PL_HPB'
                        AND COMPANY IN $company
                        AND INTERCO = 'I_NONE'
                        AND CURRENCY = 'LC'
                        AND SCOPE = 'NON_GROUP'
                        AND FISCAL_YEAR_PERIOD LIKE '$date'
                    ) HPB,
                    (
                        SELECT
                            SUM(AMOUNT) AS OAVAL
                        FROM
                            CONSOLIDATION
                        WHERE
                            AUDITTRAIL = 'PL_CONS'
                        AND CATEGORY = 'ACT'
                        AND COSTCENTER_COMPONENT = 'NO_CC'
                        AND DOCUMENT_TYPE = 'NO_DOC'
                        AND FLOW = 'CLOSING'
                        AND GL_ACCOUNT = 'PL_OA'
                        AND COMPANY IN $company
                        AND INTERCO = 'I_NONE'
                        AND CURRENCY = 'LC'
                        AND SCOPE = 'NON_GROUP'
                        AND FISCAL_YEAR_PERIOD LIKE '$date'
                    ) OA,
                    (
                        SELECT
                            SUM(AMOUNT) AS EBITDAVAL
                        FROM
                            CONSOLIDATION
                        WHERE
                            AUDITTRAIL = 'PL_CONS'
                        AND CATEGORY = 'ACT'
                        AND COSTCENTER_COMPONENT = 'NO_CC'
                        AND DOCUMENT_TYPE = 'NO_DOC'
                        AND FLOW = 'CLOSING'
                        AND GL_ACCOUNT = 'PL_E'
                        AND COMPANY IN $company
                        AND INTERCO = 'I_NONE'
                        AND CURRENCY = 'LC'
                        AND SCOPE = 'NON_GROUP'
                        AND FISCAL_YEAR_PERIOD LIKE '$date'
                    ) EBITDA,
                    (
                        SELECT
                            SUM(AMOUNT) AS BPPVAL
                        FROM
                            CONSOLIDATION
                        WHERE
                            AUDITTRAIL = 'PL_CONS'
                        AND CATEGORY = 'ACT'
                        AND COSTCENTER_COMPONENT = 'NO_CC'
                        AND DOCUMENT_TYPE = 'NO_DOC'
                        AND FLOW = 'CLOSING'
                        AND GL_ACCOUNT = 'PL_BPP'
                        AND COMPANY IN $company
                        AND INTERCO = 'I_NONE'
                        AND CURRENCY = 'LC'
                        AND SCOPE = 'NON_GROUP'
                        AND FISCAL_YEAR_PERIOD LIKE '$date'
                    ) BPP,
                    (
                        SELECT
                            SUM(AMOUNT) AS BUAVAL
                        FROM
                            CONSOLIDATION
                        WHERE
                            AUDITTRAIL = 'PL_CONS'
                        AND CATEGORY = 'ACT'
                        AND COSTCENTER_COMPONENT = 'NO_CC'
                        AND DOCUMENT_TYPE = 'NO_DOC'
                        AND FLOW = 'CLOSING'
                        AND GL_ACCOUNT = 'PL_BUA'
                        AND COMPANY IN $company
                        AND INTERCO = 'I_NONE'
                        AND CURRENCY = 'LC'
                        AND SCOPE = 'NON_GROUP'
                        AND FISCAL_YEAR_PERIOD LIKE '$date'
                    ) BUA,
                (
                        SELECT
                            SUM(AMOUNT) AS BPEVAL
                        FROM
                            CONSOLIDATION
                        WHERE
                            AUDITTRAIL = 'PL_CONS'
                        AND CATEGORY = 'ACT'
                        AND COSTCENTER_COMPONENT = 'NO_CC'
                        AND DOCUMENT_TYPE = 'NO_DOC'
                        AND FLOW = 'CLOSING'
                        AND GL_ACCOUNT = 'PL_BPE'
                        AND COMPANY IN $company
                        AND INTERCO = 'I_NONE'
                        AND CURRENCY = 'LC'
                        AND SCOPE = 'NON_GROUP'
                        AND FISCAL_YEAR_PERIOD LIKE '$date'
                    ) BPE,
                (
                        SELECT
                            SUM(AMOUNT) AS BPVAL
                        FROM
                            CONSOLIDATION
                        WHERE
                            AUDITTRAIL = 'PL_CONS'
                        AND CATEGORY = 'ACT'
                        AND COSTCENTER_COMPONENT = 'NO_CC'
                        AND DOCUMENT_TYPE = 'NO_DOC'
                        AND FLOW = 'CLOSING'
                        AND GL_ACCOUNT = 'PL_BP'
                        AND COMPANY IN $company
                        AND INTERCO = 'I_NONE'
                        AND CURRENCY = 'LC'
                        AND SCOPE = 'NON_GROUP'
                        AND FISCAL_YEAR_PERIOD LIKE '$date'
                    ) BP,
                (
                        SELECT
                            SUM(AMOUNT) AS LRSKVAL
                        FROM
                            CONSOLIDATION
                        WHERE
                            AUDITTRAIL = 'PL_CONS'
                        AND CATEGORY = 'ACT'
                        AND COSTCENTER_COMPONENT = 'NO_CC'
                        AND DOCUMENT_TYPE = 'NO_DOC'
                        AND FLOW = 'CLOSING'
                        AND GL_ACCOUNT = 'PL_LRSK'
                        AND COMPANY IN $company
                        AND INTERCO = 'I_NONE'
                        AND CURRENCY = 'LC'
                        AND SCOPE = 'NON_GROUP'
                        AND FISCAL_YEAR_PERIOD LIKE '$date'
                    ) LRSK,
                (
                        SELECT
                            SUM(AMOUNT) AS PLLVAL
                        FROM
                            CONSOLIDATION
                        WHERE
                            AUDITTRAIL = 'PL_CONS'
                        AND CATEGORY = 'ACT'
                        AND COSTCENTER_COMPONENT = 'NO_CC'
                        AND DOCUMENT_TYPE = 'NO_DOC'
                        AND FLOW = 'CLOSING'
                        AND GL_ACCOUNT = 'PL_PLL'
                        AND COMPANY IN $company
                        AND INTERCO = 'I_NONE'
                        AND CURRENCY = 'LC'
                        AND SCOPE = 'NON_GROUP'
                        AND FISCAL_YEAR_PERIOD LIKE '$date'
                    ) PLL";
          // echo "($sql ) TBINGL$this->TBINGL,";
        $result = $db->query($sql);

        // echo "queryOracle => $queryOracle ->";

        // echo $queryOracle['JUMLAH'];
        
        $result_row = $result->row_array();

        // echo "execute => $result ->";

        if(isset($result_row)){
            return $result_row;
        }

        //echo "fetch => ".$fetch[0];

        return 0;
    }
    function getOneQuery(){

        $db = $this->load->database('default3', true);

        $sql = "
        SELECT TBPLGL11.JUMLAH as JUMLAH FROM (
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
         CONSOLIDATION.GL_ACCOUNT LIKE '111%'
        AND CONSOLIDATION.GL_ACCOUNT NOT LIKE '1119%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        

        ) TBMIN1,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
         CONSOLIDATION.GL_ACCOUNT LIKE '111%'
        AND CONSOLIDATION.GL_ACCOUNT NOT LIKE '1119%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        

        ) TBMIN2,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
         CONSOLIDATION.GL_ACCOUNT LIKE '111%'
        AND CONSOLIDATION.GL_ACCOUNT NOT LIKE '1119%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        

        ) TBMIN3,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '1119%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL1,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '1119%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL2,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '1119%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL3,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.GL_ACCOUNT IN ('11200000', '14210000', '14120003', '14120005')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
         ) TBINGL1,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.GL_ACCOUNT IN ('11200000', '14210000', '14120003', '14120005')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
         ) TBINGL2,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.GL_ACCOUNT IN ('11200000', '14210000', '14120003', '14120005')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
         ) TBINGL3,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '114%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL4,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '114%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL5,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '114%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL6,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '1152%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1154%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1155%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1156%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1157%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT IN ('11510001', '11510003', '11510098', '11510099', '11590001', '11910001')
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL51,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '1152%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1154%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1155%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1156%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1157%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT IN ('11510001', '11510003', '11510098', '11510099', '11590001', '11910001')
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL52,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '1152%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1154%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1155%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1156%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1157%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT IN ('11510001', '11510003', '11510098', '11510099', '11590001', '11910001')
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL53,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '116%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL7,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '116%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL8,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '116%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL9,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '118%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1210%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL1,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '118%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1210%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL2,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '118%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1210%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL3,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '117%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL10,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '117%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL11,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '117%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL12,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '131%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL13,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '131%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL14,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '131%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL15,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '141%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL16,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '14120003%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '14120005%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL4,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '141%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL17,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '14120003%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '14120005%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL5,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '141%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL18,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '14120003%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '14120005%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL6,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '151%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL19,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '151%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL20,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '151%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL21,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '1611%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL22,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '1611%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL23,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '1611%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL24,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '1612%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '16210001%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL7,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '1612%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '16210001%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL8,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '1612%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '16210001%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL9,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '1613%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '16210002%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1622%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1623%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL41,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '1613%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '16210002%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1622%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1623%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL42,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '1613%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '16210002%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1622%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1623%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL43,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '1614%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '16210003%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '16210004%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '16210006%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL44,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '1614%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '16210003%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '16210004%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '16210006%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL45,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '1614%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '16210003%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '16210004%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '16210006%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL46,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '1615%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '16210005%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL10,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '1615%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '16210005%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL11,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '1615%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '16210005%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL12,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '163%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '164%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL13,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '163%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '164%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL14,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '163%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '164%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL15,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '169%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1617%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL16,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '169%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1617%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL17,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '169%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '1617%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL18,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '185%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL25,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '185%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL26,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '185%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL27,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '181%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL28,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '181%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL29,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '181%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL30,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '171%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '172%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL19,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '171%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '172%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL20,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '171%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '172%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL21,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '182%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '183%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '184%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '189%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL47,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '182%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '183%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '184%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '189%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL48,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '182%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '183%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '184%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '189%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL49,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '211%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL31,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '211%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL32,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '211%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL33,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '212%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '213%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL22,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '212%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '213%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL23,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '212%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '213%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL24,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.GL_ACCOUNT LIKE '214%'
        AND CONSOLIDATION.GL_ACCOUNT NOT IN ('21421011', '21421012', '21421013', '21421014', '21421015', '21421016')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGLIN1,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.GL_ACCOUNT LIKE '214%'
        AND CONSOLIDATION.GL_ACCOUNT NOT IN ('21421011', '21421012', '21421013', '21421014', '21421015', '21421016')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGLIN2,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.GL_ACCOUNT LIKE '214%'
        AND CONSOLIDATION.GL_ACCOUNT NOT IN ('21421011', '21421012', '21421013', '21421014', '21421015', '21421016')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGLIN3,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '216%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL34,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '216%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL35,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '216%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL36,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '215%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL37,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '215%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL38,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '215%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL39,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.GL_ACCOUNT IN ('21421011', '21421012', '21421013', '21421014')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
         ) TBINGL4,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.GL_ACCOUNT IN ('21421011', '21421012', '21421013', '21421014')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
         ) TBINGL5,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.GL_ACCOUNT IN ('21421011', '21421012', '21421013', '21421014')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
         ) TBINGL6,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '2171%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL40,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '2171%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL41,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '2171%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL42,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '2172%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL43,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '2172%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL44,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '2172%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL45,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
                CONSOLIDATION.GL_ACCOUNT LIKE '2173%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '2174%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '2175%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL31,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
                CONSOLIDATION.GL_ACCOUNT LIKE '2173%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '2174%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '2175%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL32,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
                CONSOLIDATION.GL_ACCOUNT LIKE '2173%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '2174%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '2175%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL33,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '2176%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL46,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '2176%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL47,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '2176%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL48,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '23%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL49,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '23%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL50,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '23%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL51,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '2542%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '25900001%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '25900002%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '25900008%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL410,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '2542%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '25900001%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '25900002%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '25900008%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL411,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '2542%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '25900001%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '25900002%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '25900008%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL412,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '251%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL52,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '251%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL53,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '251%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL54,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '252%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL55,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '252%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL56,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '252%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL57,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
                CONSOLIDATION.GL_ACCOUNT LIKE '2173%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '2174%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '2175%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL34,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
                CONSOLIDATION.GL_ACCOUNT LIKE '2173%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '2174%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '2175%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL35,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
                CONSOLIDATION.GL_ACCOUNT LIKE '2173%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '2174%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '2175%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL36,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '256%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL58,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '256%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL59,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '256%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL60,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '25900005%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '25900009%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL25,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '25900005%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '25900009%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL26,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.GL_ACCOUNT LIKE '25900005%'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '25900009%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBPLGL27,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
                CONSOLIDATION.GL_ACCOUNT LIKE '253%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '254%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '259%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL37,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
                CONSOLIDATION.GL_ACCOUNT LIKE '253%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '254%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '259%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL38,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
                CONSOLIDATION.GL_ACCOUNT LIKE '253%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '254%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '259%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL39,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '25900004%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL61,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '25900004%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL62,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '25900004%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL63,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '31%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL64,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '31%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL65,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '31%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL66,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '32%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL67,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '32%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL68,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '32%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL69,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
                CONSOLIDATION.GL_ACCOUNT LIKE '390%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '331%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '332%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL310,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
                CONSOLIDATION.GL_ACCOUNT LIKE '390%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '331%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '332%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL311,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
                CONSOLIDATION.GL_ACCOUNT LIKE '390%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '331%'
            AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        OR CONSOLIDATION.GL_ACCOUNT LIKE '332%'
           AND  CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        ) TBGL312,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '3411%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL70,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '3411%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL71,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '3411%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL72,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '37%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.05'
        ) TBGL73,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '37%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2016.04'
        ) TBGL74,(
        SELECT
            SUM(CONSOLIDATION.AMOUNT) AS JUMLAH
        FROM
            CONSOLIDATION
        WHERE
            CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.COMPANY IN ('7000', '2000')
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '37%'
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '2015.12'
        ) TBGL75";

         $result = $db->query($sql);
        
        $result_row = $result->row();

        if(isset($result_row)){
            return $result_row->JUMLAH;
        }

        return 0;


    }


}

