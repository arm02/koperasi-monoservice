<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lapb_anggota_rekap_keseluruhan extends OperatorController {

	public function __construct() {
		parent::__construct();	
		$this->load->model('general_m');
		$this->load->model('lap_simpanan_m');
		$this->load->helper('fungsi');
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

		$datas = $this->lap_simpanan_m->lap_rekap_seluruh_anggota();
		$this->data["data_jns_simpanan"] = $this->lap_simpanan_m->get_data_jenis_simpan($config["per_page"], $offset); // panggil seluruh data aanggota
		$this->data["halaman"] = $this->pagination->create_links();
		$this->data["offset"] = $offset;
		
		$this->data['isi'] = $this->load->view('laporan/laporan_anggota/rekap_keseluruhan', $this->data, TRUE);
		// $this->load->view('themes/layout_utama_v', $this->data);
		print_r($datas);

	}

	function cetak() {
		$simpanan = array(
			array(
				"nama" => 'Alimin',
				"pokok" => 1000000,
				"wajib" => 14322341,
				"sukarela" => 14322341,
				"khusus" => 14322341,
				"yang_diambil" => 14322341,
				"saldo_disimpan" => 14322341,
			),
			array(
				"nama" => 'Endin',
				"pokok" => 1000000,
				"wajib" => 14322341,
				"sukarela" => 14322341,
				"khusus" => 14322341,
				"yang_diambil" => 14322341,
				"saldo_disimpan" => 14322341,
			),
			array(
				"nama" => '	Empat Siti Fatimah',
				"pokok" => 1000000,
				"wajib" => 14322341,
				"sukarela" => 14322341,
				"khusus" => 14322341,
				"yang_diambil" => 14322341,
				"saldo_disimpan" => 14322341,
			),
		);
		if($simpanan == FALSE) {
			echo 'DATA KOSONG';
			//redirect('lap_simpanan');
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
		'.$pdf->nsi_box($text = '<span class="txt_judul">Rekapitulasi Simpanan Anggota Periode '.$tgl_periode_txt.' </span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';
		$html.='<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="width:5%; vertical-align: middle; text-align:center" rowspan="2"> No. </th>
			<th style="width:10%; vertical-align: middle; text-align:center" rowspan="2">Nama </th>
			<th style="width:40%; vertical-align: middle; text-align:center" colspan="4"> Simpanan  </th>
			<th style="width:15%; vertical-align: middle; text-align:center" rowspan="2"> Jumlah  </th>
			<th style="width:15%; vertical-align: middle; text-align:center" rowspan="2"> Yang Diambil  </th>
			<th style="width:15%; vertical-align: middle; text-align:center" rowspan="2"> Saldo Disimpan  </th>
		</tr>
		<tr class="header_kolom">
			<th style="width: 10%;vertical-align: middle; text-align:center"> Pokok  </th>
			<th style="width: 10%;vertical-align: middle; text-align:center"> Wajib  </th>
			<th style="width: 10%;vertical-align: middle; text-align:center"> Sukarela  </th>
			<th style="width: 10%;vertical-align: middle; text-align:center"> Khusus  </th>
		</tr>';

		$no = 1;
		$simpanan_arr = array();
		$jumlah_pokok = 0; 
		$jumlah_wajib = 0; 
		$jumlah_sukarela = 0; 
		$jumlah_khusus = 0; 
		$jumlah_yang_diambil = 0; 
		$jumlah_saldo_disimpan = 0; 
		$total_jumlah = 0;
		foreach ($simpanan as $jenis) {
			$jumlah = $jenis['pokok'] + $jenis['wajib'] + $jenis['sukarela'] + $jenis['khusus'] ;

			$jumlah_pokok += $jenis['pokok'];
			$jumlah_wajib += $jenis['wajib'];
			$jumlah_sukarela += $jenis['sukarela'];
			$jumlah_khusus += $jenis['khusus'];
			$jumlah_yang_diambil += $jenis['yang_diambil'];
			$jumlah_saldo_disimpan += $jenis['saldo_disimpan'];
			$total_jumlah += $jumlah;

			$html .= '
			<tr>
				<td class="h_tengah">'.$no++.'</td>
				<td>'. $jenis['nama'].'</td>
				<td class="h_kanan">'. number_format($jenis['pokok']).'</td>
				<td class="h_kanan">'. number_format($jenis['wajib']).'</td>
				<td class="h_kanan">'. number_format($jenis['sukarela']).'</td>
				<td class="h_kanan">'. number_format($jenis['khusus']).'</td>
				<td class="h_kanan">'. number_format($jumlah).'</td>
				<td class="h_kanan">'. number_format($jenis['yang_diambil']).'</td>
				<td class="h_kanan">'. number_format($jenis['saldo_disimpan']).'</td>
			</tr>';
		}
		$html .= '
		<tr class="header_kolom">
			<td colspan="2" class="h_tengah"><strong>Jumlah </strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_pokok).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_wajib).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_sukarela).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_khusus).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($total_jumlah).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_yang_diambil).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_saldo_disimpan).'</strong></td>
		</tr>';
		$html .= '</table>';
		$pdf->nsi_html($html);
		$pdf->Output('lap_simpan'.date('Ymd_His') . '.pdf', 'I');
	}
}