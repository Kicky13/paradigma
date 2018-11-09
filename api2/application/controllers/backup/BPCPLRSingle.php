<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BPCPLRSingle extends CI_Controller {

	public function index()
	{
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

			$bulan_before = $bulan - 1;
		$db=$this->load->database('default3',true);
		$q_pnjln=$db->query("SELECT
						(
							(
								SELECT
									SUM (AMOUNT) -- PENJUALAN
								FROM
									CONSOLIDATION
								WHERE
									AUDITTRAIL = 'PL_CONS'
								AND CATEGORY = 'ACT'
								AND COSTCENTER_COMPONENT = 'NO_CC'
								AND DOCUMENT_TYPE = 'NO_DOC'
								AND FLOW = 'CLOSING'
								AND GL_ACCOUNT = 'PL_VLP'
								AND COMPANY = '7000'
								AND INTERCO = 'I_NONE'
								AND CURRENCY = 'LC'
								AND SCOPE = 'NON_GROUP'
								AND FISCAL_YEAR_PERIOD = '2016.05'
							) - (
								SELECT
									SUM (AMOUNT) -- PENJUALAN
								FROM
									CONSOLIDATION
								WHERE
									AUDITTRAIL = 'PL_CONS'
								AND CATEGORY = 'ACT'
								AND COSTCENTER_COMPONENT = 'NO_CC'
								AND DOCUMENT_TYPE = 'NO_DOC'
								AND FLOW = 'CLOSING'
								AND GL_ACCOUNT = 'PL_VLP'
								AND COMPANY = '7000'
								AND INTERCO = 'I_NONE'
								AND CURRENCY = 'LC'
								AND SCOPE = 'NON_GROUP'
								AND FISCAL_YEAR_PERIOD = '2016.04'
							)
						) AS PNJLN
					FROM
						DUAL");

		foreach ($q_pnjln->result_array() as $rowID) {
			 $PNJLN = $rowID['PNJLN'];
		}

		$q_hpb=$db->query("SELECT
					(
						(
							SELECT
								SUM (AMOUNT) -- HASIL PENJUALAN BRUTO
							FROM
								CONSOLIDATION
							WHERE
								AUDITTRAIL = 'PL_CONS'
							AND CATEGORY = 'ACT'
							AND COSTCENTER_COMPONENT = 'NO_CC'
							AND DOCUMENT_TYPE = 'NO_DOC'
							AND FLOW = 'CLOSING'
							AND GL_ACCOUNT = 'PL_HPB'
							AND COMPANY = '7000'
							AND INTERCO = 'I_NONE'
							AND CURRENCY = 'LC'
							AND SCOPE = 'NON_GROUP'
							AND FISCAL_YEAR_PERIOD = '2016.05'
						) - (
							SELECT
								SUM (AMOUNT) -- HASIL PENJUALAN BRUTO
							FROM
								CONSOLIDATION
							WHERE
								AUDITTRAIL = 'PL_CONS'
							AND CATEGORY = 'ACT'
							AND COSTCENTER_COMPONENT = 'NO_CC'
							AND DOCUMENT_TYPE = 'NO_DOC'
							AND FLOW = 'CLOSING'
							AND GL_ACCOUNT = 'PL_HPB'
							AND COMPANY = '7000'
							AND INTERCO = 'I_NONE'
							AND CURRENCY = 'LC'
							AND SCOPE = 'NON_GROUP'
							AND FISCAL_YEAR_PERIOD = '2016.04'
						)
					) AS PL_HPB
				FROM
					DUAL");
		foreach ($q_hpb->result_array() as $rowID) {
			$PL_HPB = $rowID['PL_HPB'];
		}

		$q_oa=$db->query("SELECT
						(
							(
								SELECT
									SUM (AMOUNT) -- ONGKOS ANGKUT
								FROM
									CONSOLIDATION
								WHERE
									AUDITTRAIL = 'PL_CONS'
								AND CATEGORY = 'ACT'
								AND COSTCENTER_COMPONENT = 'NO_CC'
								AND DOCUMENT_TYPE = 'NO_DOC'
								AND FLOW = 'CLOSING'
								AND GL_ACCOUNT = 'PL_OA'
								AND COMPANY = '7000'
								AND INTERCO = 'I_NONE'
								AND CURRENCY = 'LC'
								AND SCOPE = 'NON_GROUP'
								AND FISCAL_YEAR_PERIOD = '2016.05'
							) - (
								SELECT
									SUM (AMOUNT) -- ONGKOS ANGKUT
								FROM
									CONSOLIDATION
								WHERE
									AUDITTRAIL = 'PL_CONS'
								AND CATEGORY = 'ACT'
								AND COSTCENTER_COMPONENT = 'NO_CC'
								AND DOCUMENT_TYPE = 'NO_DOC'
								AND FLOW = 'CLOSING'
								AND GL_ACCOUNT = 'PL_OA'
								AND COMPANY = '7000'
								AND INTERCO = 'I_NONE'
								AND CURRENCY = 'LC'
								AND SCOPE = 'NON_GROUP'
								AND FISCAL_YEAR_PERIOD = '2016.04'
							)
						) AS PL_OA
					FROM
						DUAL");
		foreach ($q_oa->result_array() as $rowID) {
			 $PL_OA = $rowID['PL_OA'];
		}

		$q_hpn=$db->query("SELECT
					(
						(
							SELECT
								SUM (AMOUNT) -- HASIL PENJUALAN
							FROM
								CONSOLIDATION
							WHERE
								AUDITTRAIL = 'PL_CONS'
							AND CATEGORY = 'ACT'
							AND COSTCENTER_COMPONENT = 'NO_CC'
							AND DOCUMENT_TYPE = 'NO_DOC'
							AND FLOW = 'CLOSING'
							AND GL_ACCOUNT = 'PL_HPN'
							AND COMPANY = '7000'
							AND INTERCO = 'I_NONE'
							AND CURRENCY = 'LC'
							AND SCOPE = 'NON_GROUP'
							AND FISCAL_YEAR_PERIOD = '2016.05'
						) - (
							SELECT
								SUM (AMOUNT) -- HASIL PENJUALAN
							FROM
								CONSOLIDATION
							WHERE
								AUDITTRAIL = 'PL_CONS'
							AND CATEGORY = 'ACT'
							AND COSTCENTER_COMPONENT = 'NO_CC'
							AND DOCUMENT_TYPE = 'NO_DOC'
							AND FLOW = 'CLOSING'
							AND GL_ACCOUNT = 'PL_HPN'
							AND COMPANY = '7000'
							AND INTERCO = 'I_NONE'
							AND CURRENCY = 'LC'
							AND SCOPE = 'NON_GROUP'
							AND FISCAL_YEAR_PERIOD = '2016.04'
						)
					) AS PL_HPN
				FROM
					DUAL");
		foreach ($q_hpn->result_array as $rowID) {
			 $PL_HPN = $rowID['PL_HPN'];
		}

		$q_bpp = $db->query("SELECT
				(
					(
						SELECT
							SUM (AMOUNT) -- BEBAN POKOK PENJUALAN
						FROM
							CONSOLIDATION
						WHERE
							AUDITTRAIL = 'PL_CONS'
						AND CATEGORY = 'ACT'
						AND COSTCENTER_COMPONENT = 'NO_CC'
						AND DOCUMENT_TYPE = 'NO_DOC'
						AND FLOW = 'CLOSING'
						AND GL_ACCOUNT = 'PL_BPP'
						AND COMPANY = '7000'
						AND INTERCO = 'I_NONE'
						AND CURRENCY = 'LC'
						AND SCOPE = 'NON_GROUP'
						AND FISCAL_YEAR_PERIOD = '2016.05'
					) - (
						SELECT
							SUM (AMOUNT) -- BEBAN POKOK PENJUALAN
						FROM
							CONSOLIDATION
						WHERE
							AUDITTRAIL = 'PL_CONS'
						AND CATEGORY = 'ACT'
						AND COSTCENTER_COMPONENT = 'NO_CC'
						AND DOCUMENT_TYPE = 'NO_DOC'
						AND FLOW = 'CLOSING'
						AND GL_ACCOUNT = 'PL_BPP'
						AND COMPANY = '7000'
						AND INTERCO = 'I_NONE'
						AND CURRENCY = 'LC'
						AND SCOPE = 'NON_GROUP'
						AND FISCAL_YEAR_PERIOD = '2016.04'
					)
				) AS PL_BPP
			FROM
				DUAL");
			foreach ($q_bpp->result_array() as $rowID) {
			    $PL_BPP = $rowID['PL_BPP'];
			}

			$q_lk = $db->query("SELECT
									(
										(
											SELECT
												SUM (AMOUNT) -- BEBAN POKOK PENJUALAN
											FROM
												CONSOLIDATION
											WHERE
												AUDITTRAIL = 'PL_CONS'
											AND CATEGORY = 'ACT'
											AND COSTCENTER_COMPONENT = 'NO_CC'
											AND DOCUMENT_TYPE = 'NO_DOC'
											AND FLOW = 'CLOSING'
											AND GL_ACCOUNT = 'PL_LK'
											AND COMPANY = '7000'
											AND INTERCO = 'I_NONE'
											AND CURRENCY = 'LC'
											AND SCOPE = 'NON_GROUP'
											AND FISCAL_YEAR_PERIOD = '2016.05'
										) - (
											SELECT
												SUM (AMOUNT) -- BEBAN POKOK PENJUALAN
											FROM
												CONSOLIDATION
											WHERE
												AUDITTRAIL = 'PL_CONS'
											AND CATEGORY = 'ACT'
											AND COSTCENTER_COMPONENT = 'NO_CC'
											AND DOCUMENT_TYPE = 'NO_DOC'
											AND FLOW = 'CLOSING'
											AND GL_ACCOUNT = 'PL_LK'
											AND COMPANY = '7000'
											AND INTERCO = 'I_NONE'
											AND CURRENCY = 'LC'
											AND SCOPE = 'NON_GROUP'
											AND FISCAL_YEAR_PERIOD = '2016.04'
										)
									) AS PL_LK
								FROM
									DUAL");
								foreach ($q_lk->result_array() as $rowID) {
									$PL_LK = $rowID['PL_LK'];
								}

					$q_bua = $db->query("SELECT
								(
									(
										SELECT
											SUM (AMOUNT) 
										FROM
											CONSOLIDATION
										WHERE
											AUDITTRAIL = 'PL_CONS'
										AND CATEGORY = 'ACT'
										AND COSTCENTER_COMPONENT = 'NO_CC'
										AND DOCUMENT_TYPE = 'NO_DOC'
										AND FLOW = 'CLOSING'
										AND GL_ACCOUNT = 'PL_LK'
										AND COMPANY = '7000'
										AND INTERCO = 'I_NONE'
										AND CURRENCY = 'LC'
										AND SCOPE = 'NON_GROUP'
										AND FISCAL_YEAR_PERIOD = '2016.05'
									) - (
										SELECT
											SUM (AMOUNT) 
										FROM
											CONSOLIDATION
										WHERE
											AUDITTRAIL = 'PL_CONS'
										AND CATEGORY = 'ACT'
										AND COSTCENTER_COMPONENT = 'NO_CC'
										AND DOCUMENT_TYPE = 'NO_DOC'
										AND FLOW = 'CLOSING'
										AND GL_ACCOUNT = 'PL_LK'
										AND COMPANY = '7000'
										AND INTERCO = 'I_NONE'
										AND CURRENCY = 'LC'
										AND SCOPE = 'NON_GROUP'
										AND FISCAL_YEAR_PERIOD = '2016.04'
									)
								) AS PL_BUA
							FROM
								DUAL");
				foreach ($q_bua->result_array() as $rowID) {
							    $PL_BUA = $rowID['PL_BUA'];
							}

			$q_bpe = $db->query("SELECT
							(
								(
									SELECT
										SUM (AMOUNT) 
									FROM
										CONSOLIDATION
									WHERE
										AUDITTRAIL = 'PL_CONS'
									AND CATEGORY = 'ACT'
									AND COSTCENTER_COMPONENT = 'NO_CC'
									AND DOCUMENT_TYPE = 'NO_DOC'
									AND FLOW = 'CLOSING'
									AND GL_ACCOUNT = 'PL_BPE'
									AND COMPANY = '7000'
									AND INTERCO = 'I_NONE'
									AND CURRENCY = 'LC'
									AND SCOPE = 'NON_GROUP'
									AND FISCAL_YEAR_PERIOD = '2016.05'
								) - (
									SELECT
										SUM (AMOUNT) 
									FROM
										CONSOLIDATION
									WHERE
										AUDITTRAIL = 'PL_CONS'
									AND CATEGORY = 'ACT'
									AND COSTCENTER_COMPONENT = 'NO_CC'
									AND DOCUMENT_TYPE = 'NO_DOC'
									AND FLOW = 'CLOSING'
									AND GL_ACCOUNT = 'PL_BPE'
									AND COMPANY = '7000'
									AND INTERCO = 'I_NONE'
									AND CURRENCY = 'LC'
									AND SCOPE = 'NON_GROUP'
									AND FISCAL_YEAR_PERIOD = '2016.04'
								)
							) AS PL_BPE
						FROM
							DUAL");
						foreach ($q_bpe->result_array() as $rowID) {
						    $PL_BPE = $rowID['PL_BPE'];
						}

			$q_lu = $db->query("SELECT
								(
									(
										SELECT
											SUM (AMOUNT) 
										FROM
											CONSOLIDATION
										WHERE
											AUDITTRAIL = 'PL_CONS'
										AND CATEGORY = 'ACT'
										AND COSTCENTER_COMPONENT = 'NO_CC'
										AND DOCUMENT_TYPE = 'NO_DOC'
										AND FLOW = 'CLOSING'
										AND GL_ACCOUNT = 'PL_LU'
										AND COMPANY = '7000'
										AND INTERCO = 'I_NONE'
										AND CURRENCY = 'LC'
										AND SCOPE = 'NON_GROUP'
										AND FISCAL_YEAR_PERIOD = '2016.05'
									) - (
										SELECT
											SUM (AMOUNT) 
										FROM
											CONSOLIDATION
										WHERE
											AUDITTRAIL = 'PL_CONS'
										AND CATEGORY = 'ACT'
										AND COSTCENTER_COMPONENT = 'NO_CC'
										AND DOCUMENT_TYPE = 'NO_DOC'
										AND FLOW = 'CLOSING'
										AND GL_ACCOUNT = 'PL_LU'
										AND COMPANY = '7000'
										AND INTERCO = 'I_NONE'
										AND CURRENCY = 'LC'
										AND SCOPE = 'NON_GROUP'
										AND FISCAL_YEAR_PERIOD = '2016.04'
									)
								) AS PL_LU
							FROM
								DUAL");
							foreach ($q_lu->result_array() as $rowID) {
							    $PL_LU = $rowID['PL_LU'];
							}

			$q_e = $db->query("SELECT
							(
								(
									SELECT
										SUM (AMOUNT) 
									FROM
										CONSOLIDATION
									WHERE
										AUDITTRAIL = 'PL_CONS'
									AND CATEGORY = 'ACT'
									AND COSTCENTER_COMPONENT = 'NO_CC'
									AND DOCUMENT_TYPE = 'NO_DOC'
									AND FLOW = 'CLOSING'
									AND GL_ACCOUNT = 'PL_E'
									AND COMPANY = '7000'
									AND INTERCO = 'I_NONE'
									AND CURRENCY = 'LC'
									AND SCOPE = 'NON_GROUP'
									AND FISCAL_YEAR_PERIOD = '2016.05'
								) - (
									SELECT
										SUM (AMOUNT) 
									FROM
										CONSOLIDATION
									WHERE
										AUDITTRAIL = 'PL_CONS'
									AND CATEGORY = 'ACT'
									AND COSTCENTER_COMPONENT = 'NO_CC'
									AND DOCUMENT_TYPE = 'NO_DOC'
									AND FLOW = 'CLOSING'
									AND GL_ACCOUNT = 'PL_E'
									AND COMPANY = '7000'
									AND INTERCO = 'I_NONE'
									AND CURRENCY = 'LC'
									AND SCOPE = 'NON_GROUP'
									AND FISCAL_YEAR_PERIOD = '2016.04'
								)
							) AS PL_E
						FROM
							DUAL");
						foreach ($q_e->result_array() as $rowID) {
						    $PL_E = $rowID['PL_E'];
						}

		$q_bp = $db->query("SELECT
						(
							(
								SELECT
									SUM (AMOUNT) 
								FROM
									CONSOLIDATION
								WHERE
									AUDITTRAIL = 'PL_CONS'
								AND CATEGORY = 'ACT'
								AND COSTCENTER_COMPONENT = 'NO_CC'
								AND DOCUMENT_TYPE = 'NO_DOC'
								AND FLOW = 'CLOSING'
								AND GL_ACCOUNT = 'PL_BP'
								AND COMPANY = '7000'
								AND INTERCO = 'I_NONE'
								AND CURRENCY = 'LC'
								AND SCOPE = 'NON_GROUP'
								AND FISCAL_YEAR_PERIOD = '2016.05'
							) - (
								SELECT
									SUM (AMOUNT) 
								FROM
									CONSOLIDATION
								WHERE
									AUDITTRAIL = 'PL_CONS'
								AND CATEGORY = 'ACT'
								AND COSTCENTER_COMPONENT = 'NO_CC'
								AND DOCUMENT_TYPE = 'NO_DOC'
								AND FLOW = 'CLOSING'
								AND GL_ACCOUNT = 'PL_BP'
								AND COMPANY = '7000'
								AND INTERCO = 'I_NONE'
								AND CURRENCY = 'LC'
								AND SCOPE = 'NON_GROUP'
								AND FISCAL_YEAR_PERIOD = '2016.04'
							)
						) AS PL_BP
					FROM
						DUAL");
						foreach ($q_bp->result_array() as $rowID) {
						    $PL_BP = $rowID['PL_BP'];
						}
			$q_lrsk = $db->query("SELECT
								(
									(
										SELECT
											SUM (AMOUNT) 
										FROM
											CONSOLIDATION
										WHERE
											AUDITTRAIL = 'PL_CONS'
										AND CATEGORY = 'ACT'
										AND COSTCENTER_COMPONENT = 'NO_CC'
										AND DOCUMENT_TYPE = 'NO_DOC'
										AND FLOW = 'CLOSING'
										AND GL_ACCOUNT = 'PL_LRSK'
										AND COMPANY = '7000'
										AND INTERCO = 'I_NONE'
										AND CURRENCY = 'LC'
										AND SCOPE = 'NON_GROUP'
										AND FISCAL_YEAR_PERIOD = '2016.05'
									) - (
										SELECT
											SUM (AMOUNT) 
										FROM
											CONSOLIDATION
										WHERE
											AUDITTRAIL = 'PL_CONS'
										AND CATEGORY = 'ACT'
										AND COSTCENTER_COMPONENT = 'NO_CC'
										AND DOCUMENT_TYPE = 'NO_DOC'
										AND FLOW = 'CLOSING'
										AND GL_ACCOUNT = 'PL_LRSK'
										AND COMPANY = '7000'
										AND INTERCO = 'I_NONE'
										AND CURRENCY = 'LC'
										AND SCOPE = 'NON_GROUP'
										AND FISCAL_YEAR_PERIOD = '2016.04'
									)
								) AS PL_LRSK
							FROM
								DUAL");
							foreach ($q_lrsk->result_array() as $rowID) {
							    $PL_LRSK = $rowID['PL_LRSK'];
							}
			$q_pll = $db->query("SELECT
							(
								(
									SELECT
										SUM (AMOUNT) 
									FROM
										CONSOLIDATION
									WHERE
										AUDITTRAIL = 'PL_CONS'
									AND CATEGORY = 'ACT'
									AND COSTCENTER_COMPONENT = 'NO_CC'
									AND DOCUMENT_TYPE = 'NO_DOC'
									AND FLOW = 'CLOSING'
									AND GL_ACCOUNT = 'PL_PLL'
									AND COMPANY = '7000'
									AND INTERCO = 'I_NONE'
									AND CURRENCY = 'LC'
									AND SCOPE = 'NON_GROUP'
									AND FISCAL_YEAR_PERIOD = '2016.05'
								) - (
									SELECT
										SUM (AMOUNT) 
									FROM
										CONSOLIDATION
									WHERE
										AUDITTRAIL = 'PL_CONS'
									AND CATEGORY = 'ACT'
									AND COSTCENTER_COMPONENT = 'NO_CC'
									AND DOCUMENT_TYPE = 'NO_DOC'
									AND FLOW = 'CLOSING'
									AND GL_ACCOUNT = 'PL_PLL'
									AND COMPANY = '7000'
									AND INTERCO = 'I_NONE'
									AND CURRENCY = 'LC'
									AND SCOPE = 'NON_GROUP'
									AND FISCAL_YEAR_PERIOD = '2016.04'
								)
							) AS PL_PLL
						FROM
							DUAL");
						foreach ($q_pll->result_array() as $rowID) {
						    $PL_PLL = $rowID['PL_PLL'];
						}

			$q_lsp = $db->query("SELECT
							(
								(
									SELECT
										SUM (AMOUNT) 
									FROM
										CONSOLIDATION
									WHERE
										AUDITTRAIL = 'PL_CONS'
									AND CATEGORY = 'ACT'
									AND COSTCENTER_COMPONENT = 'NO_CC'
									AND DOCUMENT_TYPE = 'NO_DOC'
									AND FLOW = 'CLOSING'
									AND GL_ACCOUNT = 'PL_LSP'
									AND COMPANY = '7000'
									AND INTERCO = 'I_NONE'
									AND CURRENCY = 'LC'
									AND SCOPE = 'NON_GROUP'
									AND FISCAL_YEAR_PERIOD = '2016.05'
								) - (
									SELECT
										SUM (AMOUNT) 
									FROM
										CONSOLIDATION
									WHERE
										AUDITTRAIL = 'PL_CONS'
									AND CATEGORY = 'ACT'
									AND COSTCENTER_COMPONENT = 'NO_CC'
									AND DOCUMENT_TYPE = 'NO_DOC'
									AND FLOW = 'CLOSING'
									AND GL_ACCOUNT = 'PL_LSP'
									AND COMPANY = '7000'
									AND INTERCO = 'I_NONE'
									AND CURRENCY = 'LC'
									AND SCOPE = 'NON_GROUP'
									AND FISCAL_YEAR_PERIOD = '2016.04'
								)
							) AS PL_LSP
						FROM
							DUAL");
						foreach ($q_lsp->result_array() as $rowID) {
						    $PL_LSP = $rowID['PL_LSP'];
						}

		//======================================= UPTO ==================================//
				$query_pnjln = $db->query("SELECT
					SUM (AMOUNT) AS PNJLN
				FROM
					CONSOLIDATION
				WHERE
					AUDITTRAIL = 'PL_CONS'
				AND CATEGORY = 'ACT'
				AND COSTCENTER_COMPONENT = 'NO_CC'
				AND DOCUMENT_TYPE = 'NO_DOC'
				AND FLOW = 'CLOSING'
				AND GL_ACCOUNT = 'PL_VLP'
				AND COMPANY = '7000'
				AND INTERCO = 'I_NONE'
				AND CURRENCY = 'LC'
				AND SCOPE = 'NON_GROUP'
				AND FISCAL_YEAR_PERIOD = '2016.05'");

				foreach ($query_pnjln->result_array() as $rowID) {
				    $UPTO_PNJLN = $rowID['PNJLN'];
				}

				$query_hpb = $db->query("SELECT
					SUM (AMOUNT) AS PL_HPB
				FROM
					CONSOLIDATION
				WHERE
					AUDITTRAIL = 'PL_CONS'
				AND CATEGORY = 'ACT'
				AND COSTCENTER_COMPONENT = 'NO_CC'
				AND DOCUMENT_TYPE = 'NO_DOC'
				AND FLOW = 'CLOSING'
				AND GL_ACCOUNT = 'PL_HPB'
				AND COMPANY = '7000'
				AND INTERCO = 'I_NONE'
				AND CURRENCY = 'LC'
				AND SCOPE = 'NON_GROUP'
				AND FISCAL_YEAR_PERIOD = '2016.05'");

				foreach ($query_hpb->result_array() as $rowID) {
				    $UPTO_HPB = $rowID['PL_HPB'];
				}

				$query_oa = $db->query("SELECT
					SUM (AMOUNT) AS PL_OA
				FROM
					CONSOLIDATION
				WHERE
					AUDITTRAIL = 'PL_CONS'
				AND CATEGORY = 'ACT'
				AND COSTCENTER_COMPONENT = 'NO_CC'
				AND DOCUMENT_TYPE = 'NO_DOC'
				AND FLOW = 'CLOSING'
				AND GL_ACCOUNT = 'PL_OA'
				AND COMPANY = '7000'
				AND INTERCO = 'I_NONE'
				AND CURRENCY = 'LC'
				AND SCOPE = 'NON_GROUP'
				AND FISCAL_YEAR_PERIOD = '2016.05'");

				foreach ($query_oa->result_array() as $rowID) {
				    $UPTO_OA = $rowID['PL_OA'];
				}

				$query_hpn = $db->query("SELECT
					SUM (AMOUNT) AS PL_HPN
				FROM
					CONSOLIDATION
				WHERE
					AUDITTRAIL = 'PL_CONS'
				AND CATEGORY = 'ACT'
				AND COSTCENTER_COMPONENT = 'NO_CC'
				AND DOCUMENT_TYPE = 'NO_DOC'
				AND FLOW = 'CLOSING'
				AND GL_ACCOUNT = 'PL_HPN'
				AND COMPANY = '7000'
				AND INTERCO = 'I_NONE'
				AND CURRENCY = 'LC'
				AND SCOPE = 'NON_GROUP'
				AND FISCAL_YEAR_PERIOD = '2016.05'");

				foreach ($query_hpn->result_array() as $rowID) {
				    $UPTO_HPN = $rowID['PL_HPN'];
				}

				$query_bpp = $db->query("SELECT
					SUM (AMOUNT) AS PL_BPP
				FROM
					CONSOLIDATION
				WHERE
					AUDITTRAIL = 'PL_CONS'
				AND CATEGORY = 'ACT'
				AND COSTCENTER_COMPONENT = 'NO_CC'
				AND DOCUMENT_TYPE = 'NO_DOC'
				AND FLOW = 'CLOSING'
				AND GL_ACCOUNT = 'PL_BPP'
				AND COMPANY = '7000'
				AND INTERCO = 'I_NONE'
				AND CURRENCY = 'LC'
				AND SCOPE = 'NON_GROUP'
				AND FISCAL_YEAR_PERIOD = '2016.05'");

				foreach ($query_bpp->result_array() as $rowID) {
				    $UPTO_BPP = $rowID['PL_BPP'];
				}

				$query_lk = $db->query("SELECT
					SUM (AMOUNT) AS PL_LK
				FROM
					CONSOLIDATION
				WHERE
					AUDITTRAIL = 'PL_CONS'
				AND CATEGORY = 'ACT'
				AND COSTCENTER_COMPONENT = 'NO_CC'
				AND DOCUMENT_TYPE = 'NO_DOC'
				AND FLOW = 'CLOSING'
				AND GL_ACCOUNT = 'PL_LK'
				AND COMPANY = '7000'
				AND INTERCO = 'I_NONE'
				AND CURRENCY = 'LC'
				AND SCOPE = 'NON_GROUP'
				AND FISCAL_YEAR_PERIOD = '2016.05'");

				foreach ($query_lk->result_array() as $rowID) {
				    $UPTO_LK = $rowID['PL_LK'];
				}

				$query_bua = $db->query("SELECT
					SUM (AMOUNT) AS PL_BUA
				FROM
					CONSOLIDATION
				WHERE
					AUDITTRAIL = 'PL_CONS'
				AND CATEGORY = 'ACT'
				AND COSTCENTER_COMPONENT = 'NO_CC'
				AND DOCUMENT_TYPE = 'NO_DOC'
				AND FLOW = 'CLOSING'
				AND GL_ACCOUNT = 'PL_BUA'
				AND COMPANY = '7000'
				AND INTERCO = 'I_NONE'
				AND CURRENCY = 'LC'
				AND SCOPE = 'NON_GROUP'
				AND FISCAL_YEAR_PERIOD = '2016.05'");

				foreach ($query_bua->result_array() as $rowID) {
				    $UPTO_BUA = $rowID['PL_BUA'];
				}

				$query_bpe = $db->query("SELECT
					SUM (AMOUNT) AS PL_BPE
				FROM
					CONSOLIDATION
				WHERE
					AUDITTRAIL = 'PL_CONS'
				AND CATEGORY = 'ACT'
				AND COSTCENTER_COMPONENT = 'NO_CC'
				AND DOCUMENT_TYPE = 'NO_DOC'
				AND FLOW = 'CLOSING'
				AND GL_ACCOUNT = 'PL_BPE'
				AND COMPANY = '7000'
				AND INTERCO = 'I_NONE'
				AND CURRENCY = 'LC'
				AND SCOPE = 'NON_GROUP'
				AND FISCAL_YEAR_PERIOD = '2016.05'");

				foreach ($query_bpe->result_array() as $rowID) {
				    $UPTO_BPE = $rowID['PL_BPE'];
				}

				$query_lu = $db->query("SELECT
					SUM (AMOUNT) AS PL_LU
				FROM
					CONSOLIDATION
				WHERE
					AUDITTRAIL = 'PL_CONS'
				AND CATEGORY = 'ACT'
				AND COSTCENTER_COMPONENT = 'NO_CC'
				AND DOCUMENT_TYPE = 'NO_DOC'
				AND FLOW = 'CLOSING'
				AND GL_ACCOUNT = 'PL_LU'
				AND COMPANY = '7000'
				AND INTERCO = 'I_NONE'
				AND CURRENCY = 'LC'
				AND SCOPE = 'NON_GROUP'
				AND FISCAL_YEAR_PERIOD = '2016.05'");

				foreach ($query_lu->result_array() as $rowID) {
				    $UPTO_LU = $rowID['PL_LU'];
				}

				$query_e = $db->query("SELECT
					SUM (AMOUNT) AS PL_E
				FROM
					CONSOLIDATION
				WHERE
					AUDITTRAIL = 'PL_CONS'
				AND CATEGORY = 'ACT'
				AND COSTCENTER_COMPONENT = 'NO_CC'
				AND DOCUMENT_TYPE = 'NO_DOC'
				AND FLOW = 'CLOSING'
				AND GL_ACCOUNT = 'PL_E'
				AND COMPANY = '7000'
				AND INTERCO = 'I_NONE'
				AND CURRENCY = 'LC'
				AND SCOPE = 'NON_GROUP'
				AND FISCAL_YEAR_PERIOD = '2016.05'");

				foreach ($query_e->result_array() as $rowID) {
				    $UPTO_E = $rowID['PL_E'];
				}

				$query_bp = $db->query("SELECT
					SUM (AMOUNT) AS PL_BP
				FROM
					CONSOLIDATION
				WHERE
					AUDITTRAIL = 'PL_CONS'
				AND CATEGORY = 'ACT'
				AND COSTCENTER_COMPONENT = 'NO_CC'
				AND DOCUMENT_TYPE = 'NO_DOC'
				AND FLOW = 'CLOSING'
				AND GL_ACCOUNT = 'PL_BP'
				AND COMPANY = '7000'
				AND INTERCO = 'I_NONE'
				AND CURRENCY = 'LC'
				AND SCOPE = 'NON_GROUP'
				AND FISCAL_YEAR_PERIOD = '2016.05'");

				foreach ($query_bp->result_array() as $rowID) {
				    $UPTO_BP = $rowID['PL_BP'];
				}

				$query_lrsk = $db->query("SELECT
					SUM (AMOUNT) AS PL_LRSK
				FROM
					CONSOLIDATION
				WHERE
					AUDITTRAIL = 'PL_CONS'
				AND CATEGORY = 'ACT'
				AND COSTCENTER_COMPONENT = 'NO_CC'
				AND DOCUMENT_TYPE = 'NO_DOC'
				AND FLOW = 'CLOSING'
				AND GL_ACCOUNT = 'PL_LRSK'
				AND COMPANY = '7000'
				AND INTERCO = 'I_NONE'
				AND CURRENCY = 'LC'
				AND SCOPE = 'NON_GROUP'
				AND FISCAL_YEAR_PERIOD = '2016.05'");

				foreach ($query_lrsk->result_array() as $rowID) {
				    $UPTO_LRSK = $rowID['PL_LRSK'];
				}

				$query_pll = $db->query("SELECT
					SUM (AMOUNT) AS PL_PLL
				FROM
					CONSOLIDATION
				WHERE
					AUDITTRAIL = 'PL_CONS'
				AND CATEGORY = 'ACT'
				AND COSTCENTER_COMPONENT = 'NO_CC'
				AND DOCUMENT_TYPE = 'NO_DOC'
				AND FLOW = 'CLOSING'
				AND GL_ACCOUNT = 'PL_PLL'
				AND COMPANY = '7000'
				AND INTERCO = 'I_NONE'
				AND CURRENCY = 'LC'
				AND SCOPE = 'NON_GROUP'
				AND FISCAL_YEAR_PERIOD = '2016.05'");

				foreach ($query_pll->result_array() as $rowID) {
				    $UPTO_PLL = $rowID['PL_PLL'];
				}

				$query_lsp = $db->query("SELECT
					SUM (AMOUNT) AS PL_LSP
				FROM
					CONSOLIDATION
				WHERE
					AUDITTRAIL = 'PL_CONS'
				AND CATEGORY = 'ACT'
				AND COSTCENTER_COMPONENT = 'NO_CC'
				AND DOCUMENT_TYPE = 'NO_DOC'
				AND FLOW = 'CLOSING'
				AND GL_ACCOUNT = 'PL_LSP'
				AND COMPANY = '7000'
				AND INTERCO = 'I_NONE'
				AND CURRENCY = 'LC'
				AND SCOPE = 'NON_GROUP'
				AND FISCAL_YEAR_PERIOD = '2016.05'");

				foreach ($query_lsp->result_array() as $rowID) {
				    $UPTO_LSP = $rowID['PL_LSP'];
				}
		//======================================= CREATE JSON STRUCTURE ==================================//
			$curr_rp1 = array(
			    'hpb' => ($PL_HPB / $PNJLN) * 100,
			    'oa' => ($PL_OA / $PNJLN) * 100,
			    'hpn' => ($PL_HPN / $PNJLN) * 100,
			    'bpp' => ($PL_BPP / $PNJLN) * 100,
			    'lk' => ($PL_LK / $PNJLN) * 100,
			    'bua' => ($PL_BUA / $PNJLN) * 100,
			    'bpe' => ($PL_BPE / $PNJLN) * 100,
			    'lu' => ($PL_LU / $PNJLN) * 100,
			    'e' => ($PL_E / $PNJLN) * 100,
			    'bp' => ($PL_BP / $PNJLN) * 100,
			    'lrsk' => ($PL_LRSK / $PNJLN) * 100,
			    'pll' => ($PL_PLL / $PNJLN) * 100,
			    'lsp' => ($PL_LSP / $PNJLN) * 100
			);

			$upto_rp1 = array(
			    'hpb' => ($UPTO_HPB / $UPTO_PNJLN) * 100,
			    'oa' => ($UPTO_OA / $UPTO_PNJLN) * 100,
			    'hpn' => ($UPTO_HPN / $UPTO_PNJLN) * 100,
			    'bpp' => ($UPTO_BPP / $UPTO_PNJLN) * 100,
			    'lk' => ($UPTO_LK / $UPTO_PNJLN) * 100,
			    'bua' => ($UPTO_BUA / $UPTO_PNJLN) * 100,
			    'bpe' => ($UPTO_BPE / $UPTO_PNJLN) * 100,
			    'lu' => ($UPTO_LU / $UPTO_PNJLN) * 100,
			    'e' => ($UPTO_E / $UPTO_PNJLN) * 100,
			    'bp' => ($UPTO_BP / $UPTO_PNJLN) * 100,
			    'lrsk' => ($UPTO_LRSK / $UPTO_PNJLN) * 100,
			    'pll' => ($UPTO_PLL / $UPTO_PNJLN) * 100,
			    'lsp' => ($UPTO_LSP / $UPTO_PNJLN) * 100
			);

			$curr = array(
			    'penjualan' => $PNJLN,
			    'hpb' => $PL_HPB,
			    'oa' => $PL_OA,
			    'hpn' => $PL_HPN,
			    'bpp' => $PL_BPP,
			    'lk' => $PL_LK,
			    'mlk' => (($PL_LK / $PL_HPN) * 100),
			    'bua' => $PL_BUA,
			    'bpe' => $PL_BPE,
			    'lu' => $PL_LU,
			    'mlu' => (($PL_LU / $PL_HPN) * 100),
			    'e' => $PL_E,
			    'me' => (($PL_E / $PL_HPN) * 100),
			    'bp' => $PL_BP,
			    'lrsk' => $PL_LRSK,
			    'pll' => $PL_PLL,
			    'lsp' => $PL_LSP,
			    'mlsp' => (($PL_LSP / $PL_HPN) * 100)
			);

			$upto = array(
			    'penjualan' => $UPTO_PNJLN,
			    'hpb' => $UPTO_HPB,
			    'oa' => $UPTO_OA,
			    'hpn' => $UPTO_HPN,
			    'bpp' => $UPTO_BPP,
			    'lk' => $UPTO_LK,
			    'mlk' => (($UPTO_LK / $UPTO_HPN) * 100),
			    'bua' => $UPTO_BUA,
			    'bpe' => $UPTO_BPE,
			    'lu' => $UPTO_LU,
			    'mlu' => (($UPTO_LU / $UPTO_HPN) * 100),
			    'e' => $UPTO_E,
			    'me' => (($UPTO_E / $UPTO_HPN) * 100),
			    'bp' => $UPTO_BP,
			    'lrsk' => $UPTO_LRSK,
			    'pll' => $UPTO_PLL,
			    'lsp' => $UPTO_LSP,
			    'mlsp' => (($UPTO_LSP / $UPTO_HPN) * 100)
			);

			$bpc_data = array(
			    'current' => $curr,
			    'current_rp1' => $curr_rp1,
			    'upto' => $upto,
			    'upto_rp1' => $upto_rp1
			);
			echo '{"7000":' . json_encode($bpc_data) . '}';

	}

}

/* End of file BPCPLRSingle.php */
/* Location: ./application/controllers/BPCPLRSingle.php */