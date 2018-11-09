<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

	}

	public function cmtuban34()
	{
		$this->load->model('m_cmtuban34');
		$this->m_cmtuban34->get_cmtuban34();
	}

	public function feedtuban34()
	{
		$this->load->model('m_feedtuban34');
		$this->m_feedtuban34->get_feedtuban34();
	}
	public function fmtuban34()
	{
		$this->load->model('m_fmtuban34');
		$this->m_fmtuban34->get_fmtuban34();
	}

	public function klin3all()
	{
		$this->load->model('m_klin3all');
		$this->m_klin3all->get_klin3all();
	}

	public function klin4all()
	{
		$this->load->model('m_klin4all');
		$this->m_klin4all->get_klin4all();
	}

	public function rmtuban34()
	{
		$this->load->model('m_rmtuban34');
		$this->m_rmtuban34->get_rmtuban34();
	}

	public function addtuban34()
	{
		$this->load->model('m_addtuban34');
		$this->m_addtuban34->get_addtuban34();
	}

	public function balance_sheet()
	{
		$this->load->model('m_balance_sheet');
		$this->m_balance_sheet->get_balance_sheet();
	}

	public function bpccementprod()
	{
		$this->load->model('m_bpccementprod');
		$this->m_bpccementprod->get_bpccementprod();
	}

	public function bpcclinkerprod()
	{
		$this->load->model('m_bpcclinkerprod');
		$this->m_bpcclinkerprod->get_bpcclinkerprod();
	}

	public function bpcplrsingle()
	{
		$this->load->model('m_bpcplrsingle');
		$this->m_bpcplrsingle->get_bpcplrsingle();
	}

	public function bpcpltrend()
	{
		$this->load->model('m_bpcpltrend');
		$this->m_bpcpltrend->get_bpcpltrend();
	}

	public function detailstockmaterial()
	{
		$this->load->model('m_detailstockmaterial');
		$this->m_detailstockmaterial->get_detailstockmaterial();
	}

	public function feedcm34()
	{
		$this->load->model('m_feedcm34');
		$this->m_feedcm34->get_feedcm34();
	}

	public function feedfm34()
	{
		$this->load->model('m_feedfm34');
		$this->m_feedfm34->get_feedfm34();
	}

	public function feedfmtns23()
	{
		$this->load->model('m_feedfmtns23');
		$this->m_feedfmtns23->get_feedfmtns23();
	}

	public function feedkl34()
	{
		$this->load->model('m_feedkl34');
		$this->m_feedkl34->get_feedkl34();
	}

	public function feedkltns23()
	{
		$this->load->model('m_feedkltns23');
		$this->m_feedkltns23->get_feedkltns23();
	}

	public function feedrm34()
	{
		$this->load->model('m_feedrm34');
		$this->m_feedrm34->get_feedrm34();
	}

	public function feedrmtns23()
	{
		$this->load->model('m_feedrmtns23');
		$this->m_feedrmtns23->get_feedrmtns23();
	}

	public function ficodatadistributor()
	{
		$this->load->model('m_ficodatadistributor');
		$this->m_ficodatadistributor->get_ficodatadistributor();
	}

	public function ficodatagen()
	{
		$this->load->model('m_ficodatagen');
		$this->m_ficodatagen->get_ficodatagen();
	}

	public function ficodatagendetail()
	{
		$this->load->model('m_ficodatagendetail');
		$this->m_ficodatagendetail->get_ficodatagendetail();
	}

	public function ficodatavendor()
	{
		$this->load->model('m_ficodatavendor');
		$this->m_ficodatavendor->get_ficodatavendor();
	}

	public function generatejsonep()
	{
		$this->load->model('m_generatejsonep');
		$this->m_generatejsonep->get_generatejsonep();
	}

	public function generatejsonep34()
	{
		$this->load->model('m_generatejsonep34');
		$this->m_generatejsonep34->get_generatejsonep34();
	}

	public function generatejsonmaintenance()
	{
		$this->load->model('m_generatejsonmaintenance');
		$this->m_generatejsonmaintenance->get_generatejsonmaintenance();
	}

	public function generatejsonmm()
	{
		$this->load->model('m_generatejsonmm');
		$this->m_generatejsonmm->get_generatejsonmm();
	}

	public function generatejsonmm2()
	{
		$this->load->model('m_generatejsonmm2');
		$this->m_generatejsonmm2->get_generatejsonmm2();
	}

	public function generatejsonplant()
	{
		$this->load->model('m_generatejsonplant');
		$this->m_generatejsonplant->get_generatejsonplant();
	}

	public function generatejsonplant34()
	{
		$this->load->model('m_generatejsonplant34');
		$this->m_generatejsonplant34->get_generatejsonplant34();
	}

	public function generatejsonplantpadang()
	{
		$this->load->model('m_generatejsonplantpadang');
		$this->m_generatejsonplantpadang->get_generatejsonplantpadang();
	}

	public function generatejsonplanttonasa23()
	{
		$this->load->model('m_generatejsonplanttonasa23');
		$this->m_generatejsonplanttonasa23->get_generatejsonplanttonasa23();
	}

	public function generatejsonprodmonth()
	{
		$this->load->model('m_generatejsonprodmonth');
		$this->m_generatejsonprodmonth->get_generatejsonprodmonth();
	}

	public function generatejsonprodmonthpadang()
	{
		$this->load->model('m_generatejsonprodmonthpadang');
		$this->m_generatejsonprodmonthpadang->get_generatejsonprodmonthpadang();
	}

	public function generatejsonprodmonthtlcc()
	{
		$this->load->model('m_generatejsonprodmonthtlcc');
		$this->m_generatejsonprodmonthtlcc->get_generatejsonprodmonthtlcc();
	}

	public function generatejsonprodmonthtonasa()
	{
		$this->load->model('m_generatejsonprodmonthtonasa');
		$this->m_generatejsonprodmonthtonasa->get_generatejsonprodmonthtonasa();
	}

	public function generatejsonproduksi()
	{
		$this->load->model('m_generatejsonproduksi');
		$this->m_generatejsonproduksi->get_generatejsonproduksi();
	}

	public function generatejsonproduksipadang()
	{
		$this->load->model('m_generatejsonproduksipadang');
		$this->m_generatejsonproduksipadang->get_generatejsonproduksipadang();
	}

	public function generatejsonproduksitlcc()
	{
		$this->load->model('m_generatejsonproduksitlcc');
		$this->m_generatejsonproduksitlcc->get_generatejsonproduksitlcc();
	}

	public function generatejsonproduksitonasa()
	{
		$this->load->model('m_generatejsonproduksitonasa');
		$this->m_generatejsonproduksitonasa->get_generatejsonproduksitonasa();
	}

	public function generatejsontotalhours()
	{
		$this->load->model('m_generatejsontotalhours');
		$this->m_generatejsontotalhours->get_generatejsontotalhours();
	}

	public function generatejsontotalhourspadang()
	{
		$this->load->model('m_generatejsontotalhourspadang');
		$this->m_generatejsontotalhourspadang->get_generatejsontotalhourspadang();
	}

	public function generatejsontotalhourstlcc()
	{
		$this->load->model('m_generatejsontotalhourstlcc');
		$this->m_generatejsontotalhourstlcc->get_generatejsontotalhourstlcc();
	}

	public function generatejsontotalhourstonasa()
	{
		$this->load->model('m_generatejsontotalhourstonasa');
		$this->m_generatejsontotalhourstonasa->get_generatejsontotalhourstonasa();
	}

	public function generatejsontotaltahun()
	{
		$this->load->model('m_generatejsontotaltahun');
		$this->m_generatejsontotaltahun->get_generatejsontotaltahun();
	}

	public function generatejsontotaltahunpadang()
	{
		$this->load->model('m_generatejsontotaltahunpadang');
		$this->m_generatejsontotaltahunpadang->get_generatejsontotaltahunpadang();
	}

	public function generatejsontotaltahuntlcc()
	{
		$this->load->model('m_generatejsontotaltahuntlcc');
		$this->m_generatejsontotaltahuntlcc->get_generatejsontotaltahuntlcc();
	}

	public function generatejsontotaltahuntonasa()
	{
		$this->load->model('m_generatejsontotaltahuntonasa');
		$this->m_generatejsontotaltahuntonasa->get_generatejsontotaltahuntonasa();
	}

	public function generaterkapsg()
	{
		$this->load->model('m_generaterkapsg');
		$this->m_generaterkapsg->get_generaterkapsg();
	}

	public function generaterkaptahun()
	{
		$this->load->model('m_generaterkaptahun');
		$this->m_generaterkaptahun->get_generaterkaptahun();
	}

	public function kinerjasaham()
	{
		$this->load->model('m_kinerjasaham');
		$this->m_kinerjasaham->get_kinerjasaham();
	}

	public function marketsharerkap()
	{
		$this->load->model('m_marketsharerkap');
		$this->m_marketsharerkap->get_marketsharerkap();
	}

	public function msnasional()
	{
		$this->load->model('m_msnasional');
		$this->m_msnasional->get_msnasional();
	}

	public function peercomparison()
	{
		$this->load->model('m_peercomparison');
		$this->m_peercomparison->get_peercomparison();
	}

	public function scodatadetail()
	{
		$this->load->model('m_scodatadetail');
		$this->m_scodatadetail->get_scodatadetail();
	}

	public function scodatagen()
	{
		$this->load->model('m_scodatagen');
		$this->m_scodatagen->get_scodatagen();
	}

	public function scoopcogen()
	{
		$this->load->model('m_scoopcogen');
		$this->m_scoopcogen->get_scoopcogen();
	}

	public function scoopcogendetail()
	{
		$this->load->model('m_scoopcogendetail');
		$this->m_scoopcogendetail->get_scoopcogendetail();
	}

	public function sddaily()
	{
		$this->load->model('m_sddaily');
		$this->m_sddaily->get_sddaily();
	}

	public function sdrkap_realdaily()
	{
		$this->load->model('m_sdrkap_realdaily');
		$this->m_sdrkap_realdaily->get_sdrkap_realdaily();
	}

	public function sdrkap_revdaily()
	{
		$this->load->model('m_sdrkap_revdaily');
		$this->m_sdrkap_revdaily->get_sdrkap_revdaily();
	}

	public function sdrkaprev()
	{
		$this->load->model('m_sdrkaprev');
		$this->m_sdrkaprev->get_sdrkaprev();
	}

	public function stmrevvolprice()
	{
		$this->load->model('m_stmrevvolprice');
		$this->m_stmrevvolprice->get_stmrevvolprice();
	}

	public function stmrevvolprice3000()
	{
		$this->load->model('m_stmrevvolprice3000');
		$this->m_stmrevvolprice3000->get_stmrevvolprice3000();
	}

	public function stmrevvolprice4000()
	{
		$this->load->model('m_stmrevvolprice4000');
		$this->m_stmrevvolprice4000->get_stmrevvolprice4000();
	}

	public function stockmaterial()
	{
		$this->load->model('m_stockmaterial');
		$this->m_stockmaterial->get_stockmaterial();
	}

	public function stokterak()
	{	
		$bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
		$tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);

		$bulan = $bulan;
      	$tahun_bulan = $tahun;

      	// echo $bulan;
      	// echo $tahun_bulan;
      	
      	// if ($bulan < 10) {
       //    	$bulan = '0'.$bulan;
       //   }

      	if ($bulan=='00') {
          	$bulan = '12';
          	$tahun_bulan =  $tahun_bulan -1;
      	}

		$tgl2=$tahun.$bulan;
		// echo $tgl2;
		$this->load->model('m_stokterak');
		$this->m_stokterak->get_stokterak($tgl2);
	}

	public function stockterakdetail()
	{
		$this->load->model('m_stockterakdetail');
		$this->m_stockterakdetail->get_stockterakdetail();
	}

	public function stocksemendetail()
	{
		$this->load->model('m_stocksemendetail');
		$this->m_stocksemendetail->get_stocksemendetail();
	}

	public function stockpp()
	{
		$this->load->model('m_stockpp');
		$this->m_stockpp->get_stockpp();
	}

	public function stokklinkerperopco()
	{
		$this->load->model('m_stokklinkerperopco');
		$this->m_stokklinkerperopco->get_stokklinkerperopco();
	}


}

/* End of file api.php */
/* Location: ./application/controllers/api.php */