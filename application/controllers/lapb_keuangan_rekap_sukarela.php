<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lapb_keuangan_rekap_sukarela extends OperatorController {

	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('lap_simpanan_m');
	}	

	public function index() {
		$this->load->library("pagination");

		$this->data['judul_browser'] = 'Laporan';
		$this->data['judul_utama'] = 'Laporan';
		$this->data['judul_sub'] = 'Data Rekap Sukarela';

		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';

		#include tanggal
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';

			#include seach
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';

		$this->data['isi'] = $this->load->view('laporan/laporan_keuangan/rekap_sukarela', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}


	function ajax_list() {
		$saldo1 = date("Y",strtotime("-1 year"));
		$saldo2 = date("Y",strtotime("-2 year"));
		/*Default request pager params dari jeasyUI*/
		$offset = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$limit  = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$tgl_dari = isset($_POST['tgl_dari']) ? $_POST['tgl_dari'] : '';
		$tgl_samp = isset($_POST['tgl_samp']) ? $_POST['tgl_samp'] : '';
		
		$search = array(
			'tgl_dari' => $tgl_dari,
			'tgl_samp' => $tgl_samp
		);
		$offset = ($offset-1)*$limit;
		$data   = $this->lap_simpanan_m->lap_keuangan_rekap_sukarela($offset,$limit,$search);
		$i	= 0;
		$rows   = array();
		if($data){
			foreach ($data["rows"] as $r) {
				//array keys ini = attribute 'field' di view nya

				$rows[$i]['id_anggota'] = $r['id_anggota'];
				$rows[$i]['no'] = $i+1;
				$rows[$i]['nama_anggota'] = $r['nama_anggota'];
				$rows[$i]['januari'] = 'Rp.'. number_format($r['januari']);
				$rows[$i]['februari'] = 'Rp.'. number_format($r['februari']);
				$rows[$i]['maret'] = 'Rp.'. number_format($r['maret']);
				$rows[$i]['april'] = 'Rp.'. number_format($r['april']);
				$rows[$i]['mei'] = 'Rp.'. number_format($r['mei']);
				$rows[$i]['juni'] = 'Rp.'. number_format($r['juni']);
				$rows[$i]['juli'] = 'Rp.'. number_format($r['juli']);
				$rows[$i]['agustus'] = 'Rp.'. number_format($r['agustus']);
				$rows[$i]['september'] = 'Rp.'. number_format($r['september']);
				$rows[$i]['oktober'] = 'Rp.'. number_format($r['oktober']);
				$rows[$i]['november'] = 'Rp.'. number_format($r['november']);
				$rows[$i]['desember'] = 'Rp.'. number_format($r['desember']);
				$rows[$i]['jumlah'] = 'Rp.'. number_format($r['jumlah']);
				$rows[$i]['saldo18'] = 'Rp.'. number_format($r["saldo".$saldo2.""]);
				$rows[$i]['saldo19'] = 'Rp.'. number_format($r["saldo".$saldo1.""]);
				// $rows[$i]['nota'] = '<p></p><p>
				// <a href="'.site_url('cetak_simpanan').'/cetak/' . $r->id . '"  title="Cetak Bukti Transaksi" target="_blank"> <i class="glyphicon glyphicon-print"></i> Nota </a></p>';
				$i++;
			}
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('total'=>$data['count'],'rows'=>$rows);
		echo json_encode($result); //return nya json
	}

	function cetak() {
		$bulan = array("januari","februari","maret","april","mei","juni","juli","agustus","september","oktober","november","desember");
		$tgl_dari = isset($_REQUEST['tgl_dari']) ? $_REQUEST['tgl_dari'] : '';
		$tgl_samp = isset($_REQUEST['tgl_samp']) ? $_REQUEST['tgl_samp'] : '';
		$q = array(
			'tgl_dari' => $tgl_dari, 
			'tgl_samp' => $tgl_samp, 
		);
		$data   = $this->lap_simpanan_m->lap_rekap_anggota_pokok(200,200,$q);
		if($data == FALSE) {
			echo 'DATA KOSONG';
			//redirect('lap_simpanan');
			exit();
		}
		$this->load->library('Pdf');

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->set_nsi_header(TRUE);
		$pdf->AddPage('P');
		$html = '
		<style>
			.h_tengah {text-align: center;}
			.h_kiri {text-align: left;}
			.h_kanan {text-align: right;}
			.txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 15px;}
			.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
		</style>
		'.$pdf->nsi_box($text = '<span class="txt_judul">Rekapitulasi Simpanan Sukarela Koperasi </span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';
		$html.='<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="vertical-align: middle; text-align:center"> No. </th>
			<th style="vertical-align: middle; text-align:center">Nama </th>
			<th style="vertical-align: middle; text-align:center"> Januari  </th>
			<th style="vertical-align: middle; text-align:center"> Februari  </th>
			<th style="vertical-align: middle; text-align:center"> Maret  </th>
			<th style="vertical-align: middle; text-align:center"> April  </th>
			<th style="vertical-align: middle; text-align:center"> Mei  </th>
			<th style="vertical-align: middle; text-align:center"> Juni  </th>
			<th style="vertical-align: middle; text-align:center"> Juli  </th>
			<th style="vertical-align: middle; text-align:center"> Agustus  </th>
			<th style="vertical-align: middle; text-align:center"> September  </th>
			<th style="vertical-align: middle; text-align:center"> Oktober  </th>
			<th style="vertical-align: middle; text-align:center"> November  </th>
			<th style="vertical-align: middle; text-align:center"> Desember  </th>
			<th style="vertical-align: middle; text-align:center"> Saldo 18  </th>
			<th style="vertical-align: middle; text-align:center"> Saldo 19  </th>
		</tr>';

		$no = 1;
		$jumlah = 0;
		foreach ($data["rows"] as $key => $value) {
			foreach ($bulan as $month) {
				$jumlah = $jumlah + $value[$month];
			}

			$html .= '
			<tr>
				<td class="h_tengah">'.$no++.'</td>
				<td>'. $value['nama'].'</td>
				<td class="h_kanan"> Rp.'. number_format($value['januari']).'</td>
				<td class="h_kanan"> Rp.'. number_format($value['februari']).'</td>
				<td class="h_kanan"> Rp.'. number_format($value['maret']).'</td>
				<td class="h_kanan"> Rp.'. number_format($value['april']).'</td>
				<td class="h_kanan"> Rp.'. number_format($value['mei']).'</td>
				<td class="h_kanan"> Rp.'. number_format($value['juni']).'</td>
				<td class="h_kanan"> Rp.'. number_format($value['juli']).'</td>
				<td class="h_kanan"> Rp.'. number_format($value['agustus']).'</td>
				<td class="h_kanan"> Rp.'. number_format($value['september']).'</td>
				<td class="h_kanan"> Rp.'. number_format($value['oktober']).'</td>
				<td class="h_kanan"> Rp.'. number_format($value['november']).'</td>
				<td class="h_kanan"> Rp.'. number_format($value['desember']).'</td>
				<td class="h_kanan"> Rp.'. number_format($jumlah).'</td>
				<td class="h_kanan"> Rp.'. number_format($value['saldo18']).'</td>
				<td class="h_kanan"> Rp.'. number_format($value['saldo19']).'</td>
			</tr>';
		}
		$html .= '
		<tr class="header_kolom">
			<td colspan="2" class="h_tengah"><strong>Jumlah </strong></td>
			<td class="h_kanan"><strong> Rp.'.number_format($jumlah).'</strong></td>
			<td class="h_kanan"><strong> Rp.'.number_format($jumlah).'</strong></td>
			<td class="h_kanan"><strong> Rp.'.number_format($jumlah).'</strong></td>
			<td class="h_kanan"><strong> Rp.'.number_format($jumlah).'</strong></td>
			<td class="h_kanan"><strong> Rp.'.number_format($jumlah).'</strong></td>
			<td class="h_kanan"><strong> Rp.'.number_format($jumlah).'</strong></td>
			<td class="h_kanan"><strong> Rp.'.number_format($jumlah).'</strong></td>
			<td class="h_kanan"><strong> Rp.'.number_format($jumlah).'</strong></td>
			<td class="h_kanan"><strong> Rp.'.number_format($jumlah).'</strong></td>
			<td class="h_kanan"><strong> Rp.'.number_format($jumlah).'</strong></td>
			<td class="h_kanan"><strong> Rp.'.number_format($jumlah).'</strong></td>
			<td class="h_kanan"><strong> Rp.'.number_format($jumlah).'</strong></td>
			<td class="h_kanan"><strong> Rp.'.number_format($jumlah).'</strong></td>
			<td class="h_kanan"><strong> Rp.'.number_format($jumlah).'</strong></td>
			<td class="h_kanan"><strong> Rp.'.number_format($jumlah).'</strong></td>
		</tr>';
		$html .= '</table>';
		$pdf->nsi_html($html);
		$pdf->Output('lap_simpan'.date('Ymd_His') . '.pdf', 'I');
	}
}