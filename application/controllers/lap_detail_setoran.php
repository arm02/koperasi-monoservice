<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_detail_setoran extends OPPController {
	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('lap_detail_setoran_m');
	}	

	public function index() {
		$this->load->library("pagination");

		$this->data['judul_browser'] = 'Laporan';
		$this->data['judul_utama'] = 'Laporan';
		$this->data['judul_sub'] = 'Data Detail Setoran';

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
		$config["base_url"] = base_url() . "lap_detail_setoran/index/halaman";
		$jumlah_row = $this->lap_detail_setoran_m->get_jml_data_anggota();
		if(isset($_GET['anggota_id']) && $_GET['anggota_id'] > 0) {
			$jumlah_row = 1;
		}
		$config["total_rows"] = $jumlah_row; // banyak data
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
		$this->data["data_anggota"] = $this->lap_detail_setoran_m->get_data_anggota($config["per_page"], $offset); // panggil seluruh data aanggota
		$this->data["halaman"] = $this->pagination->create_links();
		$this->data["offset"] = $offset;

		$this->data["data_jns_simpanan"] = $this->lap_detail_setoran_m->get_jenis_simpan(); // panggil seluruh data simpanan
		
		$this->data['isi'] = $this->load->view('lap_detail_setoran_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}


	function cetak_laporan() {
		if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$tgl_dari_txt = jin_date_ina($tgl_dari, 'p');
		$tgl_samp_txt = jin_date_ina($tgl_samp, 'p');
		$tgl_periode_txt = $tgl_dari_txt . ' - ' . $tgl_samp_txt;

		$anggota = $this->lap_detail_setoran_m->lap_data_anggota();
		$data_jns_simpanan = $this->lap_detail_setoran_m->get_jenis_simpan();

		if($anggota == FALSE) {
			redirect('lap_detail_setoran');
			exit();
		}
		$this->load->library('Pdf');
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->set_nsi_header(TRUE);
		$pdf->AddPage('L');
		$html = '';
		$html .= '
		<style>
		.h_tengah {text-align: center;}
		.h_kiri {text-align: left;}
		.h_kanan {text-align: right;}
		.txt_judul {font-size: 15pt; font-weight: bold; padding-bottom: 12px;}
		.txt_anggota {font-size: 12pt; padding-bottom: 2px;}
		.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
		</style>
		'.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Data Detail Setoran <br></span>', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'';
		$no =1;
		$batas = 1;
		$nilai_total = 0;
		foreach ($anggota as $row) {
			if($no == 1){
				$html .= ''
				.$pdf->nsi_box($text = '<span class="h_kiri">Periode : '.$tgl_periode_txt.'</span>', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').''
				.$pdf->nsi_box($text = '<span class="h_kiri">Kode : '.strtoupper($row->nama).' '.$row->identitas.'</span>', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
				<table width="100%" cellspacing="0" cellpadding="3" border="1" nobr="true">
				<tr class="header_kolom">
				<th style="width:8%;" > Tgl </th>
				<th style="width:15%;"> Pokok </th>
				<th style="width:15%;"> Wajib </th>
				<th style="width:15%;"> Sukarela </th>
				<th style="width:15%;"> Khusus </th>
				<th style="width:15%;"> Sub Total </th>
				<th style="width:17%;"> Total </th>
				</tr>';
			}
			if($batas == 0) {
				$html .= '
				<tr class="header_kolom" pagebreak="true">
				<th style="width:8%;" > Tgl </th>
				<th style="width:15%;"> Pokok </th>
				<th style="width:15%;"> Wajib </th>
				<th style="width:15%;"> Sukarela </th>
				<th style="width:15%;"> Khusus </th>
				<th style="width:15%;"> Sub Total </th>
				<th style="width:17%;"> Total </th>
				</tr>';
				$batas = 1;
			}
			$batas++;

			// display
			$data_setoran = $this->lap_detail_setoran_m->get_data_setoran($row->id);
			$nilai_total = 0;
			foreach ($data_setoran as $setoran) {
				$nilai_pokok = $setoran->pokok;
				$nilai_wajib = $setoran->wajib;
				$nilai_sukarela = $setoran->sukarela;
				$nilai_khusus = $setoran->khusus;
				$nilai_sub = $nilai_pokok+$nilai_wajib+$nilai_sukarela+$nilai_khusus;
				$html .= '<tr>';
				$html .= '
				<td>'. jin_date_ina(explode(' ', $setoran->tgl)[0], 'p') .'</td>
				<td class="h_kanan">'. number_format($nilai_pokok) .'</td>
				<td class="h_kanan">'. number_format($nilai_wajib) .'</td>
				<td class="h_kanan">'. number_format($nilai_sukarela) .'</td>
				<td class="h_kanan">'. number_format($nilai_khusus) .'</td>
				<td class="h_kanan">'. number_format($nilai_sub) .'</td>';
				$nilai_total += $nilai_sub;
				$html .= '<td class="h_kanan" style="font-weight: bold">'. number_format($nilai_total) .'</td>';
				$html .= '</tr>';
			}
			// end display
		}     
		$html .= '</table>';
		$pdf->nsi_html($html);
		$pdf->Output('lap_detail_setoran'.date('Ymd_His') . '.pdf', 'I');
	} 
}