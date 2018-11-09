<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_balancemv extends CI_Model {

    protected $db;
    
    function __construct() {
        parent::__construct();
        $db = $this->load->database('default3',true);
    }

    function get_balance($com, $cat, $date){
        $db = $this->load->database('default3',true);
        
        $fiscal = $date;
        $company = $com;


        $sql = "
            SELECT 
            DIS, SUM(JUMLAH) AS JUMLAH 
            FROM MV_BALANCE_REPORT 
            WHERE 
            FISCAL_YEAR_PERIOD = '$fiscal' 
            AND COMPANY IN $company 
            AND CATEGORY = '$cat'

            GROUP BY DIS
            UNION ALL
            SELECT 
            DIS, SUM(JUMLAH) AS JUMLAH 
            FROM MV_BALANCE_REPORT_KA
            WHERE 
            FISCAL_YEAR_PERIOD = '$fiscal' 
            AND COMPANY IN $company 
            AND CATEGORY = '$cat'
            GROUP BY DIS

        ";
        // echo "$sql";
        $data = $db->query($sql);
        
        return $data->result_array();
    }

    function get_monthly($startdate, $enddate, $company, $cat){
        $db = $this->load->database('default3',true);

        $sql = "
           SELECT
                *
            FROM
                (
                    SELECT
                        DIS,
                        \"SUM\" (JUMLAH) AS JUMLAH,
                        \"TO_DATE\" (
                            FISCAL_YEAR_PERIOD,
                            'yyyy.mm'
                        ) AS TANGGAL
                    FROM
                        MV_BALANCE_REPORT
                    WHERE
                        COMPANY IN $company
                    AND \"CATEGORY\" = '$cat'
                    GROUP BY
                        DIS,
                        FISCAL_YEAR_PERIOD
                    UNION
                        SELECT
                            DIS,
                            SUM (JUMLAH) AS JUMLAH,
                            TO_DATE (
                                FISCAL_YEAR_PERIOD,
                                'yyyy.mm'
                            ) AS TANGGAL
                        FROM
                            MV_BALANCE_REPORT_KA
                        WHERE
                            COMPANY IN $company
                        AND \"CATEGORY\" = '$cat'
                        GROUP BY
                            DIS,
                            FISCAL_YEAR_PERIOD
                )
            WHERE
                TANGGAL BETWEEN \"TO_DATE\" ('$startdate', 'yyyy.mm')
            AND \"TO_DATE\" ('$enddate', 'yyyy.mm')
            ORDER BY
                TANGGAL ASC

        ";

        // echo $sql;
        $data = $db->query($sql);
        
        return $data->result_array();
    }

    function get_balance2($com, $cat, $date){
        $db = $this->load->database('default3',true);
        
        $fiscal = $date;
        $company = '7000';


        $sql = "
            SELECT
                *
            FROM
                (
                    SELECT DISTINCT
                        DIS,
                        FISCAL_YEAR_PERIOD,
                        SUM (JUMLAH) AS JUMLAH
                    FROM
                        MV_BALANCE_REPORT
                    WHERE
                        FISCAL_YEAR_PERIOD = '2016.11'
                    OR FISCAL_YEAR_PERIOD = '2015.12'
                    OR FISCAL_YEAR_PERIOD = '2016.10'
                    GROUP BY
                        DIS,
                        FISCAL_YEAR_PERIOD
                    UNION
                        SELECT DISTINCT
                            DIS,
                            FISCAL_YEAR_PERIOD,
                            SUM (JUMLAH) AS JUMLAH
                        FROM
                            MV_BALANCE_REPORT_KA
                        WHERE
                            FISCAL_YEAR_PERIOD = '2016.11'
                        OR FISCAL_YEAR_PERIOD = '2015.12'
                        OR FISCAL_YEAR_PERIOD = '2016.10'
                        GROUP BY
                            DIS,
                            FISCAL_YEAR_PERIOD
                )
            ORDER BY
                FISCAL_YEAR_PERIOD
        ";
        $data = $db->query($sql);
        
        return $data->result_array();
    }

    function get_ratio($com, $year, $month){

        $paramSelect = " (TB1.JUMLAH - TB2.JUMLAH) AS JUMLAH";
        $year2 = $year;

        $last_month = substr(('0'.($month-1)), -2);
        if ($last_month=='00') {
            $last_month = '12';
            $year2 =  $year2 -1;
            $paramSelect = "TB1.JUMLAH AS JUMLAH";
        }

        $date = "$year.$month";
        $date_prev = "$year2.$last_month";

        $db = $this->load->database('default3',true);
        $sql = "
           SELECT
                TB1.TITLE,
               $paramSelect
            FROM
                (
                    SELECT
                        TITLE,
                        SUM (VAL) JUMLAH
                    FROM
                        MV_LABA_RUGI_V1
                    WHERE
                        TITLE IN (
                                'PL_PLL',
                                'PL_LRSK',
                                'PL_BP',
                                'PL_BPE',
                                
                                'PL_BPP',
                                
                                'PL_HPB',
                                'PL_DEP'
                        )
                    AND FISCAL_YEAR_PERIOD IN ('$date')
                    AND COMPANY IN $com
                    AND \"CATEGORY\" = 'ACT'
                    GROUP BY
                        TITLE
                ) TB1
            LEFT JOIN (
                SELECT
                    TITLE,
                    NVL(SUM (VAL),0) JUMLAH
                FROM
                    MV_LABA_RUGI_V1
                WHERE
                    TITLE IN (
                        'PL_PLL',
                        'PL_LRSK',
                        'PL_BP',
                        'PL_BPE',
                        
                        'PL_BPP',
                        
                        'PL_HPB',
                        'PL_DEP'
                    )
                AND FISCAL_YEAR_PERIOD IN ('$date_prev')
                AND COMPANY IN $com
                AND \"CATEGORY\" = 'ACT'
                GROUP BY
                    TITLE
            ) TB2 ON TB1.TITLE = TB2.TITLE
            UNION
                SELECT
                    TITLE,
                    SUM (VAL) AS JUMLAH
                FROM
                    MV_LABA_RUGI_V1
                WHERE
                    TITLE IN ('PL_VLP','PL_OA','PL_BUA')
                AND \"CATEGORY\" = 'ACT'
                AND COMPANY IN $com
                AND FISCAL_YEAR_PERIOD IN ('$date')
                GROUP BY
                    TITLE
        ";
        // echo "$sql";
        $data = $db->query($sql);
        
        return $data->result_array();

    }

    function get_data_ratio($com, $category, $date){


        $db = $this->load->database('default3',true);
        $sql = "
            SELECT
                TITLE,
                SUM (VAL) JUMLAH
            FROM
                MV_LABA_RUGI_V1
            WHERE
                FISCAL_YEAR_PERIOD IN ('$date')
            AND COMPANY IN $com
            AND \"CATEGORY\" = '$category'
            GROUP BY
                TITLE
        ";
        // echo "$sql";
        $data = $db->query($sql);
        
        return $data->result_array();

    }


}

