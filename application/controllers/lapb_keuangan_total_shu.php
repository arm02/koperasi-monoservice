<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lapb_keuangan_total_shu extends OperatorController {

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
		$this->data['judul_sub'] = 'Data Total SHU';

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
		
		$this->data['isi'] = $this->load->view('laporan/laporan_keuangan/total_shu', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}

	function cetak() {
		$simpanan = array(
			array(
				"nama" => 'Alimin',
				"simpanan" => 550000,
				"pinjaman" => 550000,
			),
		);
		if($simpanan == FALSE) {
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
		'.$pdf->nsi_box($text = '<span class="txt_judul">Rincian Berdasarkan Simpanan Dan Pinjaman Tahun Buku '.$_REQUEST['tahun'].' </span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';
		$html.='<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="width:5%; vertical-align: middle; text-align:center" rowspan="2"> No. </th>
			<th style="width:25%; vertical-align: middle; text-align:center" rowspan="2"> Nama </th>
			<th style="width:40%; vertical-align: middle; text-align:center" colspan="2"> SHU Berdasarkan  </th>
			<th style="width:30%; vertical-align: middle; text-align:center" rowspan="2"> Jumlah  </th>
		</tr>
		<tr class="header_kolom">
			<th style="width:20%; vertical-align: middle; text-align:center"> Simpanan  </th>
			<th style="width:20%; vertical-align: middle; text-align:center"> Pinjaman  </th>
		</tr>';

		$no = 1;
		$simpanan_arr = array();

		$jumlah_simpanan = 0;
		$jumlah_pinjaman = 0;
		$total_jumlah = 0;

		foreach ($simpanan as $value) {
			$jumlah = $value['simpanan'] + $value['pinjaman'];
			$jumlah_simpanan += $value['simpanan'];
			$jumlah_pinjaman += $value['pinjaman'];
			$total_jumlah += $jumlah;

			$html .= '
			<tr>
				<td class="h_tengah">'.$no++.'</td>
				<td>'. $value['nama'].'</td>
				<td class="h_kanan">'. number_format($value['simpanan']).'</td>
				<td class="h_kanan">'. number_format($value['pinjaman']).'</td>
				<td class="h_kanan">'. number_format($jumlah).'</td>
			</tr>';
		}
		$html .= '
		<tr class="header_kolom">
			<td colspan="2" class="h_tengah"><strong>Jumlah Total</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_simpanan).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_pinjaman).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($total_jumlah).'</strong></td>
		</tr>';
		$html .= '</table>';
		$pdf->nsi_html($html);
		$pdf->Output('lap_simpan'.date('Ymd_His') . '.pdf', 'I');
	}
}