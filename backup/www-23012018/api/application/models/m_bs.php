<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_bs extends CI_Model {
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
        $db = $this->load->database('default3', true);
        $sql = "
        SELECT
            CONSOLIDATION.COMPANY,
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
        GROUP BY CONSOLIDATION.COMPANY
        ";
         // echo "$sql <br> <br>";
        $result = $db->query($sql);

        // echo "queryOracle => $queryOracle ->";

        // echo $queryOracle['JUMLAH'];
        
        $result_row = $result->result();

        // echo "execute => $result ->";
        echo json_encode($result_row);

        if(isset($result_row)){
            return $result_row;
        }

        //echo "fetch => ".$fetch[0];

        return 0;

        }
    function plus_like_gl4($glaccount1, $glaccount2, $glaccount3,$glaccount4, $company, $category, $date){
        $db = $this->load->database('default3', true);
        $sql = "
        SELECT
            CONSOLIDATION.COMPANY,
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
         GROUP BY CONSOLIDATION.COMPANY
        ";
         // echo "$sql <br> <br>";
        $result = $db->query($sql);

        // echo "queryOracle => $queryOracle ->";

        // echo $queryOracle['JUMLAH'];
        
        $result_row = $result->result();

        // echo "execute => $result ->";

        if(isset($result_row)){
            return $result_row;
        }

        //echo "fetch => ".$fetch[0];

        return 0;

        }

    function plus_gl5_in($glaccount1, $glaccount2, $glaccount3,$glaccount4,$glaccount5,$glaccount6, $company, $category, $date){
        $db = $this->load->database('default3', true);
        $sql = "
        SELECT
         CONSOLIDATION.COMPANY,
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
         GROUP BY CONSOLIDATION.COMPANY
        ";
         // echo "$sql <br> <br>";
        $result = $db->query($sql);

        // echo "queryOracle => $queryOracle ->";

        // echo $queryOracle['JUMLAH'];
        
        $result_row = $result->result();

        // echo "execute => $result ->";

        if(isset($result_row)){
            return $result_row;
        }

        //echo "fetch => ".$fetch[0];

        return 0;

        }

    function plus_like_gl3($glaccount1, $glaccount2, $glaccount3, $company, $category, $date){

        $db = $this->load->database('default3', true);
        $sql = "
        SELECT
         CONSOLIDATION.COMPANY,
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
        AND CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount2%'
            AND CONSOLIDATION.COMPANY IN $company
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
        AND CONSOLIDATION.GL_ACCOUNT LIKE '$glaccount3%'
           AND  CONSOLIDATION.COMPANY IN $company
        AND CONSOLIDATION.FISCAL_YEAR_PERIOD = '$date'
        AND CONSOLIDATION.CURRENCY = 'LC'
        AND CONSOLIDATION.FLOW = 'CLOSING'
        AND CONSOLIDATION.AUDITTRAIL = 'INPUT'
        AND CONSOLIDATION.CATEGORY = 'ACT'
         GROUP BY CONSOLIDATION.COMPANY
        ";

        
         // echo "$sql <br> <br>";
        $result = $db->query($sql);

        // echo "queryOracle => $queryOracle ->";

        // echo $queryOracle['JUMLAH'];
        
        $result_row = $result->result();

        // echo "execute => $result ->";

        if(isset($result_row)){
            return $result_row;
        }

        //echo "fetch => ".$fetch[0];

        return 0;

        }
    function plus_like_gl($glaccount1, $glaccount2, $company, $category, $date){

        $db = $this->load->database('default3', true);
        $sql = "
        SELECT
         CONSOLIDATION.COMPANY,
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
         GROUP BY CONSOLIDATION.COMPANY
        ";

        
         // echo "$sql <br> <br>";
        $result = $db->query($sql);

        // echo "queryOracle => $queryOracle ->";

        // echo $queryOracle['JUMLAH'];
        
        $result_row = $result->result();

        // echo "execute => $result ->";

        if(isset($result_row)){
            return $result_row;
        }

        return 0;

        }

    function min_like_gl_in($glaccount1,$glaccount2, $company, $category, $date){
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
         GROUP BY CONSOLIDATION.COMPANY
        ";
         // echo "$sql <br> <br>";
        $result = $db->query($sql);

        // echo "queryOracle => $queryOracle ->";

        // echo $queryOracle['JUMLAH'];
        
        $result_row = $result->result();

        // echo "execute => $result ->";

        if(isset($result_row)){
            return $result_row;
        }

        //echo "fetch => ".$fetch[0];

        return 0;

        }
    function in_gl($glaccount, $company, $category, $date){
        $db = $this->load->database('default3', true);
        $sql = "
        SELECT
         CONSOLIDATION.COMPANY,
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
         GROUP BY CONSOLIDATION.COMPANY
        ";
         // echo "$sql <br> <br>";
        $result = $db->query($sql);

        // echo "queryOracle => $queryOracle ->";

        // echo $queryOracle['JUMLAH'];
        
        $result_row = $result->result();

        // echo "execute => $result ->";

        if(isset($result_row)){
            return $result_row;
        }

        //echo "fetch => ".$fetch[0];

        return 0;

        }

    function min_like_gl($glaccount1,$glaccount2, $company, $category, $date){
        $db = $this->load->database('default3', true);
        $sql = "
        SELECT
         CONSOLIDATION.COMPANY,
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
         GROUP BY CONSOLIDATION.COMPANY
        

        ";
        $result = $db->query($sql);
        
        $result_row = $result->result();

        if(isset($result_row)){
            return $result_row;
        }

        return 0;

        }

}

