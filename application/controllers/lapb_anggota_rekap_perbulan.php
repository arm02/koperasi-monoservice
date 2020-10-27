<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lapb_anggota_rekap_perbulan extends OperatorController {

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
		$this->data['judul_sub'] = 'Data Simpanan';

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

		$config = array();
		$config["base_url"] = base_url() . "lapb_anggota_rekap_keseluruhan/index/halaman";
		$config["total_rows"] = $this->lap_simpanan_m->get_jml_data_simpan(); // banyak data
		$config["per_page"] = 10;
		$config["uri_segment"] = 4;
		$config['use_page_numbers'] = TRUE;

		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';

		$config['first_link'] = '&laquo; First';
		$config['first_tag_open'] = '<li class="prev page">';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = 'Last &raquo;';
		$config['last_tag_open'] = '<li class="next page">';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = 'Next &rarr;';
		$config['next_tag_open'] = '<li class="next page">';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = '&larr; Previous';
		$config['prev_tag_open'] = '<li class="prev page">';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active"><a href="">';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li class="page">';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		$offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		if($offset > 0) {
			$offset = ($offset * $config['per_page']) - $config['per_page'];
		}
		$this->data["data_jns_simpanan"] = $this->lap_simpanan_m->get_data_jenis_simpan($config["per_page"], $offset); // panggil seluruh data aanggota
		$this->data["halaman"] = $this->pagination->create_links();
		$this->data["offset"] = $offset;
		
		$this->data['isi'] = $this->load->view('laporan/laporan_anggota/rekap_perbulan', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}

	function cetak() {
		$simpanan = array(
			array(
				"nama" => 'Alimin',
				"pokok" => 1000000,
				"wajib" => 14322341,
				"simpanan" => 14322341,
				"khusus" => 14322341,
			),
			array(
				"nama" => 'Endin',
				"pokok" => 1000000,
				"wajib" => 14322341,
				"simpanan" => 14322341,
				"khusus" => 14322341,
			),
			array(
				"nama" => '	Empat Siti Fatimah',
				"pokok" => 1000000,
				"wajib" => 14322341,
				"simpanan" => 14322341,
				"khusus" => 14322341,
			),
		);
		if($simpanan == FALSE) {
			echo 'DATA KOSONG';
			//redirect('lap_simpanan');
			exit();
		}

		if($_REQUEST['bulan'] != null) {
			$bulan = $_REQUEST['bulan'];
		} else {
			$bulan = date('F');
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
		'.$pdf->nsi_box($text = '<span class="txt_judul">Rekapitulasi Simpanan Anggota Periode Bulan '.$bulan.' </span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';
		$html.='<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="vertical-align: middle; text-align:center"> No. </th>
			<th style="vertical-align: middle; text-align:center"> Nama </th>
			<th style="vertical-align: middle; text-align:center"> Pokok  </th>
			<th style="vertical-align: middle; text-align:center"> Wajib  </th>
			<th style="vertical-align: middle; text-align:center"> Sukarela  </th>
			<th style="vertical-align: middle; text-align:center"> Khusus  </th>
			<th style="vertical-align: middle; text-align:center"> Jumlah  </th>
		</tr>';

		$no = 1;
		$simpanan_arr = array();
		$simpanan_row_total = 0; 
		$simpanan_total = 0; 
		$penarikan_total = 0;; 
		$jumlah = 0;
		foreach ($simpanan as $jenis) {
			$jumlah = $jenis['pokok'] + $jenis['wajib'] + $jenis['simpanan'] + $jenis['khusus'] ;

			$html .= '
			<tr>
				<td class="h_tengah">'.$no++.'</td>
				<td>'. $jenis['nama'].'</td>
				<td class="h_kanan">'. number_format($jenis['pokok']).'</td>
				<td class="h_kanan">'. number_format($jenis['wajib']).'</td>
				<td class="h_kanan">'. number_format($jenis['simpanan']).'</td>
				<td class="h_kanan">'. number_format($jenis['khusus']).'</td>
				<td class="h_kanan">'. number_format($jumlah).'</td>
			</tr>';
		}
		$html .= '</table>';
		$pdf->nsi_html($html);
		$pdf->Output('lap_simpan'.date('Ymd_His') . '.pdf', 'I');
	}
}