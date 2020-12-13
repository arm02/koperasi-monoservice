<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_summary_kas extends OperatorController {
public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('lap_summary_kas_m');
	}	

	public function index() {
		$this->load->library("pagination");

		$this->data['judul_browser'] = 'Laporan';
		$this->data['judul_utama'] = 'Laporan';
		$this->data['judul_sub'] = 'Summary Kas';

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
		$config["base_url"] = base_url() . "lap_summary_kas/index/halaman";
		$jumlah_row = $this->lap_summary_kas_m->get_jml_data_anggota();
		if(isset($_GET['anggota_id']) && $_GET['anggota_id'] > 0) {
			$jumlah_row = 1;
		}
		$config["total_rows"] = $jumlah_row; // banyak data
		$config["per_page"] = 20;
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
		$this->data["data_anggota"] = $this->lap_summary_kas_m->get_data_anggota($config["per_page"], $offset); // panggil seluruh data aanggota
		$this->data["halaman"] = $this->pagination->create_links();
		$this->data["offset"] = $offset;

		$this->data["data_jns_simpanan"] = $this->lap_summary_kas_m->get_jenis_simpan(); // panggil seluruh data aanggota
		
		$this->data['isi'] = $this->load->view('lap_summary_kas_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}

	function cetak() {
		$anggota = $this->lap_summary_kas_m->lap_data_anggota();
		if($anggota == FALSE) {
			//redirect('lap_summary_kas');
			echo 'DATA KOSONG';
			exit();
		}

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

		$data_jns_simpanan = $this->lap_summary_kas_m->get_jenis_simpan();

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
			.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
		</style>
		'.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Summary Kas Periode '.$tgl_periode_txt.'<br></span>', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
			<table width="100%" cellspacing="0" cellpadding="3" border="1">
				<tr class="header_kolom">
					<th style="width:5%; vertical-align: middle" rowspan="2"> No. </th>
					<th style="width:20%; vertical-align: middle" rowspan="2"> ID Anggota </th>
					<th style="width:25%; vertical-align: middle" rowspan="2"> Nama Anggota </th>
					<th style="width:40%; vertical-align: middle" colspan="4" rowspan="1"> Simpanan </th>
					<th style="width:10%; vertical-align: middle" rowspan="2"> Total </th>
				</tr>
				<tr class="header_kolom">';

				foreach ($data_jns_simpanan as $jenis) {
					$jns_arr = explode(' ', $jenis->jns_simpan);

					$html .= '
					<th style="width: 10%;"> '.$jns_arr[1].'</th>';
				}

				$html .= '</tr>';
		$no =1;
		$batas = 1;
		foreach ($anggota as $row) {
			if($batas == 0) {
				$html .= '				
				<tr class="header_kolom">
					<th style="width:5%;" rowspan="2"> No. </th>
					<th style="width:20%;" rowspan="2"> ID Anggota </th>
					<th style="width:25%;" rowspan="2"> Nama Anggota </th>
					<th style="width:40%;" colspan="4" rowspan="1"> Simpanan </th>
					<th style="width:10%;" rowspan="2"> Total </th>
				</tr>
				<tr class="header_kolom">';

				foreach ($data_jns_simpanan as $jenis) {
					$jns_arr = explode(' ', $jenis->jns_simpan);

					$html .= '
					<th style="width: 10%;"> '.$jns_arr[1].'</th>';
				}

				$html .= '</tr>';
            	$batas = 1;
			}
			$batas++;

			$html .= '
			<tr nobr="true">
				<td class="h_tengah">'.$no++.' </td>
				<td class="h_tengah">'.$row->identitas.'</td>
				<td class="h_kiri">'.strtoupper($row->nama).'</td>';

				$nilai_total = 0;
				for ($i=0; $i < count($data_jns_simpanan); $i++) {
					$nilai_s = $this->lap_summary_kas_m->get_jml_simpanan($data_jns_simpanan[$i]->id, $row->id);
					
					$html .= '
					<td class="h_kanan"> '.number_format($nilai_s->jml_total).'</td>';

					$nilai_total += $nilai_s->jml_total;
				}

			$html .= '<td class="h_kanan" style="font-weight: bold">'.number_format($nilai_total).'</td>
			</tr>'; 
		}
		$html .= '</table>';
		$pdf->nsi_html($html);
		$pdf->Output('lap_summary_kas'.date('Ymd_His') . '.pdf', 'I');
	} 
}