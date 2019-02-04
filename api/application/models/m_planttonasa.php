<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_planttonasa extends CI_Model {

    public function get_statefeed() {
        $myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tonasa%202\/3.CM1_TNS2_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.CM1_TNS3_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.FM1_TNS2_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.FM1_TNS3_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL1_TNS2_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL1_TNS3_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.RM1_TNS2_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.RM1_TNS3_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.FM1_TNS2_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.FM1_TNS3_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL1_TNS2_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL1_TNS3_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.RM1_TNS2_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.RM1_TNS3_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.CM_TNS2_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL_TNS2_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL_TNS3_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.CM_TNS3_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.CM1_TNS4_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.CM2_TNS4_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.FM1_TNS4_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.FM2_TNS4_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.KL_TNS4_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.RM1_TNS4_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.RM2_TNS4_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.CM1_TNS4_MOTOR%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.CM2_TNS4_MOTOR%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.FM1_TNS4_MOTOR%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.FM2_TNS4_MOTOR%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.KL_TNS4_MOTOR%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.RM1_TNS4_MOTOR%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.RM2_TNS4_MOTOR%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.CM_TNS5_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.FM1_TNS5_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.FM2_TNS5_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.KL_TNS5_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.RM_TNS5_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.CM_TNS5_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.FM1_TNS5_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.FM2_TNS5_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.KL_TNS5_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.RM_TNS5_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.KL_TNS4_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.KL_TNS5_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.RM_TNS2_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.RM_TNS3_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.RM_TNS4_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.RM_TNS5_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($myUrl);
    }

    public function get_silo() {
        $myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tonasa%205.Silo_Meter_51%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.Silo_Meter_52%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.Silo_Meter_53%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.Silo_Tonage_51%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.Silo_Tonage_52%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.Silo_Tonage_53%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.Silo_41_Percent%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.Silo_42_Percent%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.Silo_43_Percent%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.Silo1_Meter_Isi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.Silo2_Meter_Isi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.Silo3_Meter_Isi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.Silo4_Meter_Isi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($myUrl);
    }
    
    public function get_emission() {
        $myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tonasa%202\/3.KL_TNS2_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL_TNS3_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.RM_TNS2_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.RM_TNS3_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.KL_TNS4_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.RM_TNS4_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.KL_TNS5_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.RM_TNS5_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL3_LA_FLOW_STACK%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL3_NOx%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL3_Partikulat%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL3_SOx%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL2_LA_FLOW_STACK%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL2_NOx%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL2_NOx2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL2_Partikulat%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL2_SOx%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.KL_TNS5_LA_FLOW_STACK%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.KL_TNS5_Partikulat%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.KL_TNS5_SO2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.KL_TNS5_NO%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.KL_TNS4_LA_FLOW_STACK%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.KL_TNS4_Partikulat%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.KL_TNS4_NOx%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.KL_TNS4_SOx%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG1_LA_FLOW_STACK%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG1_Partikulat%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG1_NOx%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG1_SOx%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG2_LA_FLOW_STACK%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG2_Partikulat%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG2_NOx%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG2_SOx%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($myUrl);
    }
    // <editor-fold defaultstate="collapsed" desc="BTG Realtime">

    public function get_btg_pwrmon() {
        $myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A%5B{%22name%22%3A%22BTG_HARBOR.Harbor%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_HARBOR.TL_Cus%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_HARBOR.TOTAL_HARBOR%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_PLN.Tonasa_23_HVSG07%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_PLN.Tonasa_23_Q0_KILN_CM%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_PLN.Tonasa_3_Q1_FMRM%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_PLN.Tonasa_4_HVSG07%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_PLN.Tonasa_5_580HV03%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_PLN.TOTAL_PLN%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_PLN_Other.PLN_Tonasa_2_3_Q0_HVSG07%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_PLN_Other.PLN_Tonasa_23_Q0_KILN_CM%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_PLN_Other.PLN_Tonasa_4_HVSG07_Q1%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_PLN_Other.PLN_Tonasa_5_580HV03%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_PLN_Other.Tonasa_3_Q1_FM_RM%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_PLTU_TNS23.Tonasa_3_Q1%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_PLTU_TNS23.Tonasa_4_SS3_AH5%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_PLTU_TNS23.TOTAL_PLTU%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_PLTU_TNS4.Tonasa_4_HVSG01%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_PLTU_TNS4.Tonasa_4_HVSG02%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_PLTU_TNS4.TOTAL_PLTU%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_SELF_USED.PLTU_A%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_SELF_USED.PLTU_B%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_SELF_USED.PLTU_C%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_SELF_USED.PLTU_D%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_SELF_USED.TOTAL_PLTU%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_TOTAL_UNIT.PLTU_A%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_TOTAL_UNIT.PLTU_B%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_TOTAL_UNIT.PLTU_C%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_TOTAL_UNIT.PLTU_D%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_TOTAL_UNIT.TOTAL_PLTU%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_TRANSMISI.Tonasa_4_HVSG01%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_TRANSMISI.Tonasa_4_HVSG02%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_TRANSMISI.Tonasa_5_580HV01%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_TRANSMISI.Tonasa_5_580HV02%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_TRANSMISI.TOTAL_LOSS%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_TRANSMISI.TOTAL_TRANS%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%5D%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($myUrl);
    }
    
    public function get_btg_power() {
        $myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A%5B{%22name%22%3A%22BTG_LS_POWER.ER51MV02_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.ER51MV03_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.ER54MV05_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.ER55AMV05_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.ER55AMV06_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.ER56MV05_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.ER58BMV06_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.ER58BMV12_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.Q03_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.Q04_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.Q05_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.Q10_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.Q11_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.Q12_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.Q13_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.Q18_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.Q20_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.Q21_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.Q22_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.Q26_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.SG2-F07_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.SG3-F02_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.SG4A-MV03_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.SG4-F07_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.SG4-F08_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.SG4-F15_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.SG6-F05_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.SG7-F05_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.SG8_F2_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.SG8_F3_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_POWER.SS52MV02_Power%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%5D%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($myUrl);
    }
    
    public function get_btg_pltu() {
        $myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A%5B{%22name%22%3A%22BTG_DTL_PLTU.BTG1A_Actual%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG1A_Mode%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG1A_Spin%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG1A_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG1B_Actual%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG1B_Mode%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG1B_Spin%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG1B_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG2C_Actual%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG2C_Mode%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG2C_Spin%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG2C_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG2D_Actual%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG2D_Mode%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG2D_Spin%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_DTL_PLTU.BTG2D_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%5D%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($myUrl);
    }
    
    public function get_btg_status() {
        $myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A%5B{%22name%22%3A%22BTG_LS_STATUS.ER51MV02_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.ER51MV03_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.ER54MV05_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.ER55AMV05_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.ER55AMV06_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.ER56MV05_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.ER58BMV06_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.ER58BMV12_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.Q03_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.Q04_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.Q05_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.Q10_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.Q11_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.Q12_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.Q13_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.Q18_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.Q20_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.Q21_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.Q22_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.Q26_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.SG2-F07_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.SG3-F02_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.SG4A-MV03_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.SG4-F07_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.SG4-F08_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.SG4-F15_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.SG6-F05_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.SG7-F05_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.SG8_F2_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.SG8_F3_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_STATUS.SS52MV02_Status%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%5D%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($myUrl);
    }
    
    public function get_btg_pwrdby() {
        $myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A%5B{%22name%22%3A%22BTG_LS_SOURCE.ER51MV02_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.ER51MV03_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.ER54MV05_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.ER55AMV05_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.ER55AMV06_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.ER56MV05_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.ER58BMV06_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.ER58BMV12_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.Q03_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.Q04_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.Q05_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.Q10_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.Q11_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.Q12_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.Q13_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.Q18_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.Q20_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.Q21_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.Q22_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.Q26_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.SG2-F07_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.SG3-F02_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.SG4A-MV03_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.SG4-F07_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.SG4-F08_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.SG4-F15_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.SG6-F05_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.SG7-F05_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.SG8_F2_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.SG8_F3_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22BTG_LS_SOURCE.SS52MV02_Source%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%5D%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($myUrl);
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Production">
    public function get_prodjop() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);
        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }
        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        $query = $db->query("SELECT
                SUM (RM2_PROD) AS RM2_PROD,
                SUM (RM2_JOP) AS RM2_JOP,
                SUM (RM3_PROD) AS RM3_PROD,
                SUM (RM3_JOP) AS RM3_JOP,
                SUM (RM41_PROD) AS RM41_PROD,
                SUM (RM41_JOP) AS RM41_JOP,
                SUM (RM42_PROD) AS RM42_PROD,
                SUM (RM42_JOP) AS RM42_JOP,
                SUM (RM5_PROD) AS RM5_PROD,
                SUM (RM5_JOP) AS RM5_JOP,
                SUM (KL2_PROD) AS KL2_PROD,
                SUM (KL2_JOP) AS KL2_JOP,
                SUM (KL3_PROD) AS KL3_PROD,
                SUM (KL3_JOP) AS KL3_JOP,
                SUM (KL4_PROD) AS KL4_PROD,
                SUM (KL4_JOP) AS KL4_JOP,
                SUM (KL5_PROD) AS KL5_PROD,
                SUM (FM2_PROD) AS FM2_PROD,
                SUM (FM2_JOP) AS FM2_JOP,
                SUM (FM3_PROD) AS FM3_PROD,
                SUM (FM3_JOP) AS FM3_JOP,
                SUM (FM41_PROD) AS FM41_PROD,
                SUM (FM41_JOP) AS FM41_JOP,
                SUM (FM42_PROD) AS FM42_PROD,
                SUM (FM42_JOP) AS FM42_JOP,
                SUM (FM51_PROD) AS FM51_PROD,
                SUM (FM51_JOP) AS FM51_JOP,
                SUM (FM52_PROD) AS FM52_PROD,
                SUM (FM52_JOP) AS FM52_JOP,
                SUM (KL5_JOP) AS KL5_JOP
            FROM
                PIS_ST_PRODDAILY
            WHERE
                TO_CHAR (DATE_PROD, 'YYYY-MM') LIKE '$tahun-$bulan'");

        foreach ($query->result_array() as $rowID) {
            $rm2_prod = $rowID['RM2_PROD'];
            $rm2_jop = $rowID['RM2_JOP'];
            $rm3_prod = $rowID['RM3_PROD'];
            $rm3_jop = $rowID['RM3_JOP'];
            $rm41_prod = $rowID['RM41_PROD'];
            $rm41_jop = $rowID['RM41_JOP'];
            $rm42_prod = $rowID['RM42_PROD'];
            $rm42_jop = $rowID['RM42_JOP'];
            $rm5_prod = $rowID['RM5_PROD'];
            $rm5_jop = $rowID['RM5_JOP'];
            $kl2_prod = $rowID['KL2_PROD'];
            $kl2_jop = $rowID['KL2_JOP'];
            $kl3_prod = $rowID['KL3_PROD'];
            $kl3_jop = $rowID['KL3_JOP'];
            $kl4_prod = $rowID['KL4_PROD'];
            $kl4_jop = $rowID['KL4_JOP'];
            $kl5_prod = $rowID['KL5_PROD'];
            $fm2_prod = $rowID['FM2_PROD'];
            $fm2_jop = $rowID['FM2_JOP'];
            $fm3_prod = $rowID['FM3_PROD'];
            $fm3_jop = $rowID['FM3_JOP'];
            $fm41_prod = $rowID['FM41_PROD'];
            $fm41_jop = $rowID['FM41_JOP'];
            $fm42_prod = $rowID['FM42_PROD'];
            $fm42_jop = $rowID['FM42_JOP'];
            $fm51_prod = $rowID['FM51_PROD'];
            $fm51_jop = $rowID['FM51_JOP'];
            $fm52_prod = $rowID['FM52_PROD'];
            $fm52_jop = $rowID['FM52_JOP'];
            $kl5_jop = $rowID['KL5_JOP'];
        }

        $data = array('pabrik' => 'Tonasa',
            'rm2_prod' => number_format($rm2_prod, 2, ".", ""),
            'rm2_jop' => number_format($rm2_jop, 2, ".", ""),
            'rm3_prod' => number_format($rm3_prod, 2, ".", ""),
            'rm3_jop' => number_format($rm3_jop, 2, ".", ""),
            'rm41_prod' => number_format($rm41_prod, 2, ".", ""),
            'rm41_jop' => number_format($rm41_jop, 2, ".", ""),
            'rm42_prod' => number_format($rm42_prod, 2, ".", ""),
            'rm42_jop' => number_format($rm42_jop, 2, ".", ""),
            'rm5_prod' => number_format($rm5_prod, 2, ".", ""),
            'rm5_jop' => number_format($rm5_jop, 2, ".", ""),
            'kl2_prod' => number_format($kl2_prod, 2, ".", ""),
            'kl2_jop' => number_format($kl2_jop, 2, ".", ""),
            'kl3_prod' => number_format($kl3_prod, 2, ".", ""),
            'kl3_jop' => number_format($kl3_jop, 2, ".", ""),
            'kl4_prod' => number_format($kl4_prod, 2, ".", ""),
            'kl4_jop' => number_format($kl4_jop, 2, ".", ""),
            'kl5_prod' => number_format($kl5_prod, 2, ".", ""),
            'fm2_prod' => number_format($fm2_prod, 2, ".", ""),
            'fm2_jop' => number_format($fm2_jop, 2, ".", ""),
            'fm3_prod' => number_format($fm3_prod, 2, ".", ""),
            'fm3_jop' => number_format($fm3_jop, 2, ".", ""),
            'fm41_prod' => number_format($fm41_prod, 2, ".", ""),
            'fm41_jop' => number_format($fm41_jop, 2, ".", ""),
            'fm42_prod' => number_format($fm42_prod, 2, ".", ""),
            'fm42_jop' => number_format($fm42_jop, 2, ".", ""),
            'fm51_prod' => number_format($fm51_prod, 2, ".", ""),
            'fm51_jop' => number_format($fm51_jop, 2, ".", ""),
            'fm52_prod' => number_format($fm52_prod, 2, ".", ""),
            'fm52_jop' => number_format($fm52_jop, 2, ".", ""),
            'kl5_jop' => number_format($kl5_jop, 2, ".", "")
        );

        echo json_encode($data);
    }

    public function get_totaltahun() {
        $db = $this->load->database('oramso', true);
        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }
        if(strlen($bulan)<2){
            $month = '0'.$bulan;
        } else {
            $month = $bulan;
        }
        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }
        
        if (empty($_GET['bulan']) && empty($_GET['tahun'])){
            $sql = "SELECT
                                    SUM (RM2_PROD) + SUM (RM3_PROD) + SUM (RM41_PROD) + SUM (RM42_PROD) + SUM (RM5_PROD) AS rawmill,
                                    SUM (KL2_PROD) + SUM (KL3_PROD) + SUM (KL4_PROD) + SUM (KL5_PROD) AS kiln,
                                    SUM (FM2_PROD) + SUM (FM3_PROD) + SUM (FM41_PROD) + SUM (FM42_PROD) + SUM (FM51_PROD) + SUM (FM52_PROD) AS finishmill
                            FROM
                                    PIS_ST_PRODMONTH
                            WHERE
                                    MONTH_PROD LIKE '%" . $tahun . "%'";
        } else  {
            $sql = "SELECT
                                    SUM (RM2_PROD) + SUM (RM3_PROD) + SUM (RM41_PROD) + SUM (RM42_PROD) + SUM (RM5_PROD) AS rawmill,
                                    SUM (KL2_PROD) + SUM (KL3_PROD) + SUM (KL4_PROD) + SUM (KL5_PROD) AS kiln,
                                    SUM (FM2_PROD) + SUM (FM3_PROD) + SUM (FM41_PROD) + SUM (FM42_PROD) + SUM (FM51_PROD) + SUM (FM52_PROD) AS finishmill
                            FROM
                                    PIS_ST_PRODMONTH
                            WHERE
                                    MONTH_PROD LIKE '" . $tahun . "-" . $month . "'";
        }
        $query = $db->query($sql);

        foreach ($query->result_array() as $rowID) {
            $rm = number_format($rowID['RAWMILL'], 2, ".", "");
            $kl = number_format($rowID['KILN'], 2, ".", "");
            $fm = number_format($rowID['FINISHMILL'], 2, ".", "");
        }

        $data = array('pabrik' => 'Tonasa',
            'rawmill' => $rm,
            'kiln' => $kl,
            'finishmill' => $fm
        );

        echo json_encode($data);
    }
    
    public function get_upto() {
        $db = $this->load->database('oramso', true);
        
        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        $query = $db->query("SELECT
                                    SUM (RM2_PROD) + SUM (RM3_PROD) + SUM (RM41_PROD) + SUM (RM42_PROD) + SUM (RM5_PROD) AS rawmill,
                                    SUM (KL2_PROD) + SUM (KL3_PROD) + SUM (KL4_PROD) + SUM (KL5_PROD) AS kiln,
                                    SUM (FM2_PROD) + SUM (FM3_PROD) + SUM (FM41_PROD) + SUM (FM42_PROD) + SUM (FM51_PROD) + SUM (FM52_PROD) AS finishmill
                            FROM
                                    PIS_ST_PRODMONTH
                            WHERE
                                    MONTH_PROD LIKE '%" . $tahun . "%'");

        foreach ($query->result_array() as $rowID) {
            $rm = number_format($rowID['RAWMILL'], 2, ".", "");
            $kl = number_format($rowID['KILN'], 2, ".", "");
            $fm = number_format($rowID['FINISHMILL'], 2, ".", "");
        }

        $data = array('pabrik' => 'Tonasa',
            'rawmill' => $rm,
            'kiln' => $kl,
            'finishmill' => $fm
        );

        echo json_encode($data);
    }

    public function get_proddaily() {
        $db = $this->load->database('oramso', true);
        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }
        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        $query = $db->query("SELECT
                                    *
                            FROM
                                    V_PIS_ST_PLANT
                            WHERE
                                    TO_CHAR (OPDATE, 'YYYY-MM') = '" . $tahun . "-" . $bulan . "'
                            ORDER BY
                                    OPDATE ASC");

        foreach ($query->result_array() as $rowID) {
            $runHours [$rowID['TAGID']][] = $rowID['RUNHOURS'];
            $idJson [$rowID['TAGID']] = array('tagid' => $rowID['TAGID'],
                'name' => $rowID['TEXT'],
                'pabrik' => $rowID['PABRIK']
            );

            $seqTgl = date('d', strtotime($rowID['OPDATE']));
            if ($seqTgl != 0 or ! empty($seqTgl)) {
                $prod[$rowID['TAGID']][$seqTgl] = array(
                    'rate' => number_format($rowID['RATE'], 0, ",", "."),
                    'prod' => number_format($rowID['PROD'], 0, ",", "."));
            }
            $toprod[$rowID['TAGID']][] = number_format($rowID['PROD'], 0, ",", ".");
        }

        foreach ($idJson as $alpha) {
            $runHours_x[$alpha['tagid']] = array("plant" => $alpha['pabrik'],
                "name" => $alpha['name'],
                "tagid" => $alpha['tagid'],
                "runhours" => array_sum($runHours [$alpha['tagid']]),
                "tproduksi" => array_sum($toprod[$alpha['tagid']]),
                "produksi" => $prod[$alpha['tagid']],
            );
        }
        echo json_encode($runHours_x);
    }

    public function get_prodmonth() {
        $db = $this->load->database('oramso', true);
        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }
        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        $query = $db->query("SELECT
                                    TAHUN,
                                    BULAN,
                                    CEMENT,
                                    CLINKER
                            FROM
                                    PIS_RKAP_TOTAL
                            WHERE
                                    COMPANY = 4000
                            AND TAHUN = '" . $tahun . "'");

        foreach ($query->result_array() as $rowID) {
            $bln = $rowID['BULAN'];
            $panjang = strlen($bln);
            if ($panjang == 1) {
                $blnku = '0' . $bln;
            } else {
                $blnku = $bln;
            }
            $thn = $rowID['TAHUN'];
            $month = $thn . '-' . $blnku;
            $rkap_cement = $rowID['CEMENT'];
            $rkap_clinker = $rowID['CLINKER'];

            $rkap[$month] = array(
                "rkap_cement" => $rkap_cement,
                "rkap_clinker" => $rkap_clinker
            );
        }

        $query_data = $db->query("SELECT
                                        MONTH_PROD,
                                        RM2_PROD,
                                        RM3_PROD,
                                        RM41_PROD,
                                        RM41_JOP,
                                        RM42_PROD,
                                        RM5_PROD,
                                        KL2_PROD,
                                        KL3_PROD,
                                        KL4_PROD,
                                        KL5_PROD,
                                        FM2_PROD,
                                        FM3_PROD,
                                        FM41_PROD,
                                        FM42_PROD,
                                        FM51_PROD,
                                        FM52_PROD
                                FROM
                                        PIS_ST_PRODMONTH
                                WHERE MONTH_PROD LIKE '$tahun-%'
                                ORDER BY
                                        MONTH_PROD");

        foreach ($query_data->result_array() as $rowID) {
            $month = $rowID['MONTH_PROD'];

            $rm2 = $rowID['RM2_PROD'];
            $rm3 = $rowID['RM3_PROD'];
            $rm4 = $rowID['RM41_PROD'] + $rowID['RM42_PROD'];
            $rm5 = $rowID['RM5_PROD'];

            $kl2 = $rowID['KL2_PROD'];
            $kl3 = $rowID['KL3_PROD'];
            $kl4 = $rowID['KL4_PROD'];
            $kl5 = $rowID['KL5_PROD'];

            $fm_tns2 = $rowID['FM2_PROD'];
            $fm_tns3 = $rowID['FM3_PROD'];
            $fm_tns4 = $rowID['FM41_PROD'] + $rowID['FM42_PROD'];
            $fm_tns5 = $rowID['FM51_PROD'] + $rowID['FM52_PROD'];

            $to_prod[$month] = array(
                "rm2" => number_format($rm2, 2, ".", ""),
                "rm3" => number_format($rm3, 2, ".", ""),
                "rm4" => number_format($rm4, 2, ".", ""),
                "rm5" => number_format($rm5, 2, ".", ""),
                "kl2" => number_format($kl2, 2, ".", ""),
                "kl3" => number_format($kl3, 2, ".", ""),
                "kl4" => number_format($kl4, 2, ".", ""),
                "kl5" => number_format($kl5, 2, ".", ""),
                "fm_tns2" => number_format($fm_tns2, 2, ".", ""),
                "fm_tns3" => number_format($fm_tns3, 2, ".", ""),
                "fm_tns4" => number_format($fm_tns4, 2, ".", ""),
                "fm_tns5" => number_format($fm_tns5, 2, ".", "")
            );
        }

        $myJSON = array(
            "rkap" => $rkap,
            "prod" => $to_prod
        );
        echo '{"7000":' . json_encode($myJSON) . '}';
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="PM Dashboard">
    function get_pm_dash() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);
        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }
        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        $query = $db->query("SELECT
                                    TAHUN,
                                    PLANT,
                                    CATEGORY,
                                    ROUND ((AVG(DATA_INPUT)), 0) AS PERSEN
                            FROM
                                    MSO_PM_PERFORMANCE
                            WHERE
                                    COMPANY = 4000
                            AND TAHUN = $tahun
                            AND BULAN = '$bulan'
                            GROUP BY
                                    TAHUN,
                                    PLANT,
                                    CATEGORY
                            ORDER BY
                                    PLANT");
        foreach ($query->result_array() as $rowID) {
            $category = $rowID['CATEGORY'];
            $plant = $rowID['PLANT'];
            $percent = $rowID['PERSEN'];
            $tahun = $rowID['TAHUN'];

            $jml[$plant][$category] = array(
                'tahun' => $tahun,
                'persen' => $percent
            );
        }

        echo json_encode($jml);
    }

    function get_pm_detail() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);
        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }
        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }
        if (!empty($_GET['plant'])) {
            $plant = $_GET['plant'];
        } else {
            $plant = 'tns2';
        }

        $query = $db->query("SELECT
                                    CATEGORY,
                                    EQUIPMENT,
                                    ROUND (DATA_INPUT, 0) AS DATA_INPUT
                            FROM
                                    MSO_PM_PERFORMANCE
                            WHERE
                                    COMPANY = 4000
                            AND TAHUN = $tahun
                            AND BULAN = '$bulan'
                            AND PLANT = '$plant'");
        foreach ($query->result_array() as $rowID) {
            $category = $rowID['CATEGORY'];
            $data = $rowID['DATA_INPUT'];
            $equipment = $rowID['EQUIPMENT'];

            $jml[$category][$equipment] = array(
                'data' => $data
            );
        }

        echo '{"' . $plant . '":' . json_encode($jml) . '}';
    }

    function get_pm_note() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);
        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }
        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }
        if (!empty($_GET['plant'])) {
            $plant = $_GET['plant'];
        } else {
            $plant = 'tns2';
        }

        $query = $db->query("SELECT
                                    *
                            FROM
                                    MSO_PM_PERFORMANCE_NOTES
                            WHERE
                                    MONTH_PROD = '$tahun-$bulan'
                            AND PLANT = '$plant'
                            ORDER BY
                                    AREA");
        foreach ($query->result_array() as $rowID) {
            $plant = $rowID['PLANT'];
            $opco = $rowID['OPCO'];
            $area = $rowID['AREA'];
            $problem_id = $rowID['PROBLEM_ID'];
            $tgl = $rowID['TGL'];
            $equipment = $rowID['EQUIPMENT'];
            $problem_desc = $rowID['PROBLEM_DESC'];
            $duration = $rowID['DURATION'];
            $frequency = $rowID['FREQUENCY'];


            $jml[$area][$problem_id] = array(
                'plant' => $plant,
                'opco' => $opco,
                'tgl' => $tgl,
                'equipment' => $equipment,
                'problem_desc' => $problem_desc,
                'duration' => $duration,
                'frequency' => $frequency
            );
        }

        echo json_encode($jml);
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="OEE">
    function get_oee() {
        $oee = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22TonasaOEE.Tns5_Kiln_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns5_Kiln_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns5_Kiln_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns5_FM1_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns5_FM1_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns5_FM1_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns5_FM2_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns5_FM2_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns5_FM2_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns4_Kiln_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns4_Kiln_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns4_Kiln_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns4_FM1_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns4_FM1_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns4_FM1_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns4_FM2_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns4_FM2_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns4_FM2_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns3_Kiln_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns3_Kiln_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns3_Kiln_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns3_FM1_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns3_FM1_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns3_FM1_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns2_Kiln_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns2_Kiln_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns2_Kiln_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns2_FM1_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns2_FM1_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TonasaOEE.Tns2_FM1_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($oee);
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Electrical Parameter">
    function get_electical_mainsub() {
        
    }

    function get_electical_sub() {
        $myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tonasa%205.521CR01M01_E01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.521CR01M01_J01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.582ER51Q02_E01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.582ER51Q02_J01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.582ER52ALV01Q01_E01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.582ER52ALV01Q01_J01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.582ER53Q02_E01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.582ER53Q02_J01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.582ER54Q02_E01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.582ER54Q02_J01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.582ER55Q02_E01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.582ER55Q02_J01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.582ER56Q02_E01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.582ER56Q02_J01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.582ER57Q02_E01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.582ER57Q02_J01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.582ER58B1Q02_E01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.582ER58B1Q02_J01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.582ER58B2Q02_E01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.582ER58B2Q02_J01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($myUrl);
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Prod Today & Yesterday">
    function get_data_prod() {
        $myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tonasa%205.CEMENT1_JOP_TODAY%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.CEMENT1_JOP_YESTERDAY%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.CEMENT1_PROD_TODAY%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.CEMENT1_PROD_YESTERDAY%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.CEMENT2_JOP_TODAY%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.CEMENT2_JOP_YESTERDAY%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.CEMENT2_PROD_TODAY%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.CEMENT2_PROD_YESTERDAY%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.CLINKER_JOP_TODAY%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.CLINKER_JOP_YESTERDAY%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.CLINKER_PROD_TODAY%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.CLINKER_PROD_YESTERDAY%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.STOP_CNT_CEMENT1_TODAY%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.STOP_CNT_CEMENT1_YESTERDAY%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.STOP_CNT_CEMENT2_TODAY%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.STOP_CNT_CEMENT2_YESTERDAY%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.STOP_CNT_CLINKER_TODAY%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.STOP_CNT_CLINKER_YESTERDAY%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($myUrl);
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="QCX">
    function qm_cement() {
        $myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tonasa%205.QCX_CM1_OPC_BLAINE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCX_CM1_OPC_FCAO%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCX_CM1_OPC_SIV45%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCX_CM1_OPC_SO3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCX_CM1_PCC_BLAINE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCX_CM1_PCC_FCAO%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCX_CM1_PCC_SIV45%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCX_CM1_PCC_SO3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCX_CM2_OPC_BLAINE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCX_CM2_OPC_FCAO%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCX_CM2_OPC_SIV45%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCX_CM2_OPC_SO3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCX_CM2_PCC_BLAINE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCX_CM2_PCC_FCAO%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCX_CM2_PCC_SIV45%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCX_CM2_PCC_SO3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($myUrl);
    }
    
    function qm_clinker() {
        $myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tonasa%205.QCXEXCLK_Al2O3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCXEXCLK_AlM%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCXEXCLK_C2S%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCXEXCLK_C3S%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCXEXCLK_C4AF%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCXEXCLK_CaO%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCXEXCLK_Cl%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCXEXCLK_FCaO%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCXEXCLK_Fe2O3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCXEXCLK_K2O%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCXEXCLK_LSF%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCXEXCLK_MgO%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCXEXCLK_Na2O%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCXEXCLK_SiM%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCXEXCLK_SiO2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.QCXEXCLK_SO3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($myUrl);
    }
    // </editor-fold>


}
