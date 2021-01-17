<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lapb_koperasi_pinjaman_perbulan extends OperatorController {

	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('m_lap_koperasi_piutang');
	}	

	public function index() {
		$this->load->library("pagination");

		$this->data['judul_browser'] = 'Laporan';
		$this->data['judul_utama'] = 'Laporan';
		$this->data['judul_sub'] = 'Pinjaman Perbulan';

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
		
		// print_r(json_encode($this->m_lap_koperasi_piutang->get_pinjaman_perbulan(12,2020)));
		// exit();
		$this->data['isi'] = $this->load->view('laporan/laporan_koperasi/pinjaman_perbulan', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}

	function ajax_list() {
		$bulan_txt = array("januari","februari","maret","april","mei","juni","juli","agustus","september","oktober","november","desember");
		/*Default request pager params dari jeasyUI*/
		$tahun = isset($_POST['tahun']) ? $_POST['tahun'] : date("Y");
		$bulan = isset($_POST['bulan']) ? $_POST['bulan'] : date("n");

		$data   = $this->m_lap_koperasi_piutang->get_pinjaman_perbulan($bulan,$tahun);
		// print_r(json_encode($data));
		// exit();
		$rows   = array(
			array(
				'uraian_1' => 'Saldo Bulan '.ucfirst($bulan_txt[$data['month_before'] - 1]). ' ' . $data['year_before'],
				'jasa'  => 'Rp. '. number_format($data['jasa_saldo_bulan_sebelum']),
			),
			array(
				'uraian_1' => 'Terima Dari Bendahara',
				'jumlah_1'  => 'Rp. '. number_format($data['dari_bendahara']),
			),
			array(
				'uraian_1' => 'Tagihan Konsumtif',
				'pokok'  => 'Rp. '. number_format($data['tagihan_konsumtif']),
				'jasa' => 'Rp. '. number_format($data['jasa_tagihan_konsumtif']),
				'jumlah_1'  => 'Rp. '. number_format($data['tagihan_konsumtif'] + $data['jasa_tagihan_konsumtif']),
				'uraian_2' => 'Pinjaman Konsumtif',
				'jumlah_2'  => 'Rp. '. number_format($data['pinjaman_konsumtif']),
			),
			array(
				'uraian_1' => 'Tagihan Berjangka',
				'pokok'  => 'Rp. '. number_format($data['tagihan_berjangka']),
				'jasa' => 'Rp. '. number_format($data['jasa_tagihan_berjangka']),
				'jumlah_1'  => 'Rp. '. number_format($data['tagihan_berjangka'] + $data['jasa_tagihan_berjangka']),
				'uraian_2' => 'Pinjaman Berjangka',
				'jumlah_2'  => 'Rp. '. number_format($data['pinjaman_berjangka']),
			),
			array(
				'uraian_1' => 'Tagihan Barang',
				'pokok'  => 'Rp. '. number_format($data['tagihan_barang']),
				'jasa' => 'Rp. '. number_format($data['jasa_tagihan_barang']),
				'jumlah_1'  => 'Rp. '. number_format($data['tagihan_barang'] + $data['jasa_tagihan_barang']),
				'uraian_2' => 'Pinjaman Barang',
				'jumlah_2'  => 'Rp. '. number_format($data['pinjaman_barang']),
			),
			array(
				'uraian_1' => 'Pelunasan Berjangka',
				'pokok'  => 'Rp. '. number_format($data['pelunasan_berjangka']),
				'jumlah_1'  => 'Rp. '. number_format($data['pelunasan_berjangka']),
			),
			array(
				'uraian_1' => 'Pelunasan Barang',
				'pokok'  => 'Rp. '. number_format($data['pelunasan_barang']),
				'jumlah_1'  => 'Rp. '. number_format($data['pelunasan_barang']),
			),
			array(
				'uraian_1' => 'Provisi',
				'jumlah_1'  => 'Rp. '. number_format($data['total_provisi']),
			),
			array(
				'uraian_1' => 'Total',
				'pokok'  => 'Rp. '. number_format($data['total_pokok']),
				'jasa' => 'Rp. '. number_format($data['total_jasa']),
				'jumlah_1'  => 'Rp. '. number_format($data['total_pokok'] + $data['total_jasa']),
				'uraian_2' => 'Total',
				'jumlah_2'  => 'Rp. '. number_format($data['pinjaman_konsumtif'] + $data['pinjaman_berjangka'] + $data['pinjaman_barang']),
			),
			array(
				'uraian_1' => 'Saldo '.ucfirst($bulan_txt[$bulan - 1]). ' ' . $tahun,
				'jumlah_1'  => 'Rp. '. number_format($data['saldo_bulan_sekarang']),
				'jumlah_2'  => 'Rp. '. number_format($data['total_pinjaman']),
			),
		);
		//keys total & rows wajib bagi jEasyUI
		$result = array('rows'=>$rows);
		echo json_encode($result); //return nya json
	}

	function cetak() {
		date_default_timezone_set('Asia/Jakarta');
		$bulan_txt = array("januari","februari","maret","april","mei","juni","juli","agustus","september","oktober","november","desember");
		/*Default request pager params dari jeasyUI*/
		$tahun = isset($_REQUEST['tahun']) ? $_REQUEST['tahun'] : date("Y");
		$bulan = isset($_REQUEST['bulan']) ? $_REQUEST['bulan'] : date("n");

		$data   = $this->m_lap_koperasi_piutang->get_pinjaman_perbulan($bulan,$tahun);
		$rows   = array(
			array(
				'uraian_1' => 'Saldo Bulan '.ucfirst($bulan_txt[$data['month_before'] - 1]). ' ' . $data['year_before'],
				'jasa'  => 'Rp. '. number_format($data['jasa_saldo_bulan_sebelum']),
			),
			array(
				'uraian_1' => 'Terima Dari Bendahara',
				'jumlah_1'  => 'Rp. '. number_format($data['dari_bendahara']),
			),
			array(
				'uraian_1' => 'Tagihan Konsumtif',
				'pokok'  => 'Rp. '. number_format($data['tagihan_konsumtif']),
				'jasa' => 'Rp. '. number_format($data['jasa_tagihan_konsumtif']),
				'jumlah_1'  => 'Rp. '. number_format($data['tagihan_konsumtif'] + $data['jasa_tagihan_konsumtif']),
				'uraian_2' => 'Pinjaman Konsumtif',
				'jumlah_2'  => 'Rp. '. number_format($data['pinjaman_konsumtif']),
			),
			array(
				'uraian_1' => 'Tagihan Berjangka',
				'pokok'  => 'Rp. '. number_format($data['tagihan_berjangka']),
				'jasa' => 'Rp. '. number_format($data['jasa_tagihan_berjangka']),
				'jumlah_1'  => 'Rp. '. number_format($data['tagihan_berjangka'] + $data['jasa_tagihan_berjangka']),
				'uraian_2' => 'Pinjaman Berjangka',
				'jumlah_2'  => 'Rp. '. number_format($data['pinjaman_berjangka']),
			),
			array(
				'uraian_1' => 'Tagihan Barang',
				'pokok'  => 'Rp. '. number_format($data['tagihan_barang']),
				'jasa' => 'Rp. '. number_format($data['jasa_tagihan_barang']),
				'jumlah_1'  => 'Rp. '. number_format($data['tagihan_barang'] + $data['jasa_tagihan_barang']),
				'uraian_2' => 'Pinjaman Barang',
				'jumlah_2'  => 'Rp. '. number_format($data['pinjaman_barang']),
			),
			array(
				'uraian_1' => 'Pelunasan Berjangka',
				'pokok'  => 'Rp. '. number_format($data['pelunasan_berjangka']),
				'jumlah_1'  => 'Rp. '. number_format($data['pelunasan_berjangka']),
			),
			array(
				'uraian_1' => 'Pelunasan Barang',
				'pokok'  => 'Rp. '. number_format($data['pelunasan_barang']),
				'jumlah_1'  => 'Rp. '. number_format($data['pelunasan_barang']),
			),
			array(
				'uraian_1' => 'Provisi',
				'jumlah_1'  => 'Rp. '. number_format($data['total_provisi']),
			),
			array(
				'uraian_1' => 'Total',
				'pokok'  => 'Rp. '. number_format($data['total_pokok']),
				'jasa' => 'Rp. '. number_format($data['total_jasa']),
				'jumlah_1'  => 'Rp. '. number_format($data['total_pokok'] + $data['total_jasa']),
				'uraian_2' => 'Total',
				'jumlah_2'  => 'Rp. '. number_format($data['pinjaman_konsumtif'] + $data['pinjaman_berjangka'] + $data['pinjaman_barang']),
			),
			array(
				'uraian_1' => 'Saldo '.ucfirst($bulan_txt[$bulan - 1]). ' ' . $tahun,
				'jumlah_1'  => 'Rp. '. number_format($data['saldo_bulan_sekarang']),
				'jumlah_2'  => 'Rp. '. number_format($data['total_pinjaman']),
			),
		);

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
		'.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Bagian Pinjaman Bulan '.ucfirst($bulan_txt[$bulan - 1]).' </span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';
		$html.='<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="vertical-align: middle; text-align:center"> </th>
			<th style="vertical-align: middle; text-align:center"> Pokok </th>
			<th style="vertical-align: middle; text-align:center"> Jasa  </th>
			<th style="vertical-align: middle; text-align:center"> Jumlah  </th>
			<th style="vertical-align: middle; text-align:center"> Uraian  </th>
			<th style="vertical-align: middle; text-align:center"> Jumlah  </th>
		</tr>';

		foreach ($rows as $value) {
			$uraian_1 = isset($value['uraian_1']) ? $value['uraian_1'] : '';
			$pokok = isset($value['pokok']) ? $value['pokok'] : '';
			$jasa = isset($value['jasa']) ? $value['jasa'] : '';
			$jumlah_1 = isset($value['jumlah_1']) ? $value['jumlah_1'] : '';
			$uraian_2 = isset($value['uraian_2']) ? $value['uraian_2'] : '';
			$jumlah_2 = isset($value['jumlah_2']) ? $value['jumlah_2'] : '';
			// print_r(json_encode($pokok));
			// exit();
			$html .= '
			<tr>
				<td>'. $uraian_1 .'</td>
				<td class="h_kanan">' . $pokok .'</td>
				<td class="h_kanan">' . $jasa .'</td>
				<td class="h_kanan">' . $jumlah_1 .'</td>
				<td class="h_kanan">'. $uraian_2 .'</td>
				<td class="h_kanan">' . $jumlah_2 .'</td>
			</tr>';
		}
		$html .= '</table>';

		$pdf->nsi_html($html);
		$pdf->Output('lap_koperasi_pinjaman_bulan_'.$bulan_txt[$bulan - 1].'_'.date('Ymd_His') . '.pdf', 'I');
	}
}