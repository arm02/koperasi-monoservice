<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lapb_keuangan_rugi_laba extends OperatorController {

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
		$this->data['judul_sub'] = 'Data Rugi Laba';

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
		$config["base_url"] = base_url() . "lapb_keuangan_rugi_laba/index/halaman";
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
		
		$this->data['isi'] = $this->load->view('laporan/laporan_keuangan/rugi_laba', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}

	function cetak() {
		$bulan = array("januari","februari","maret","april","mei","juni","juli","agustus","september","oktober","november","desember");
		$simpanan = array(
			array(
				"bulan" => 0,
				"konsumtif_pokok" => 1000000,
				"konsumtif_jasa" => 14322341,
				"berjangka_pokok" => 1000000,
				"berjangka_jasa" => 14322341,
				"barang_pokok" => 1000000,
				"barang_jasa" => 14322341,
				"pelunasan" => array(
					"konsumtif_pokok" => 0,
					"konsumtif_jasa" => 0,
					"berjangka_pokok" => 1000000,
					"berjangka_jasa" => 14322341,
					"barang_pokok" => 1000000,
					"barang_jasa" => 14322341,
				)
			),
			array(
				"bulan" => 1,
				"konsumtif_pokok" => 1000000,
				"konsumtif_jasa" => 14322341,
				"berjangka_pokok" => 1000000,
				"berjangka_jasa" => 14322341,
				"barang_pokok" => 1000000,
				"barang_jasa" => 14322341,
				"pelunasan" => array(
					"konsumtif_pokok" => 0,
					"konsumtif_jasa" => 0,
					"berjangka_pokok" => 1000000,
					"berjangka_jasa" => 14322341,
					"barang_pokok" => 1000000,
					"barang_jasa" => 14322341,
				)
			),
			array(
				"bulan" => 2,
				"konsumtif_pokok" => 1000000,
				"konsumtif_jasa" => 14322341,
				"berjangka_pokok" => 1000000,
				"berjangka_jasa" => 14322341,
				"barang_pokok" => 1000000,
				"barang_jasa" => 14322341,
				"pelunasan" => array(
					"konsumtif_pokok" => 0,
					"konsumtif_jasa" => 0,
					"berjangka_pokok" => 1000000,
					"berjangka_jasa" => 14322341,
					"barang_pokok" => 1000000,
					"barang_jasa" => 14322341,
				)
			),
			array(
				"bulan" => 3,
				"konsumtif_pokok" => 1000000,
				"konsumtif_jasa" => 14322341,
				"berjangka_pokok" => 1000000,
				"berjangka_jasa" => 14322341,
				"barang_pokok" => 1000000,
				"barang_jasa" => 14322341,
				"pelunasan" => array(
					"konsumtif_pokok" => 0,
					"konsumtif_jasa" => 0,
					"berjangka_pokok" => 1000000,
					"berjangka_jasa" => 14322341,
					"barang_pokok" => 1000000,
					"barang_jasa" => 14322341,
				)
			),
			array(
				"bulan" => 4,
				"konsumtif_pokok" => 1000000,
				"konsumtif_jasa" => 14322341,
				"berjangka_pokok" => 1000000,
				"berjangka_jasa" => 14322341,
				"barang_pokok" => 1000000,
				"barang_jasa" => 14322341,
				"pelunasan" => array(
					"konsumtif_pokok" => 0,
					"konsumtif_jasa" => 0,
					"berjangka_pokok" => 1000000,
					"berjangka_jasa" => 14322341,
					"barang_pokok" => 1000000,
					"barang_jasa" => 14322341,
				)
			),
			array(
				"bulan" => 5,
				"konsumtif_pokok" => 1000000,
				"konsumtif_jasa" => 14322341,
				"berjangka_pokok" => 1000000,
				"berjangka_jasa" => 14322341,
				"barang_pokok" => 1000000,
				"barang_jasa" => 14322341,
				"pelunasan" => array(
					"konsumtif_pokok" => 0,
					"konsumtif_jasa" => 0,
					"berjangka_pokok" => 1000000,
					"berjangka_jasa" => 14322341,
					"barang_pokok" => 1000000,
					"barang_jasa" => 14322341,
				)
			),
			array(
				"bulan" => 6,
				"konsumtif_pokok" => 1000000,
				"konsumtif_jasa" => 14322341,
				"berjangka_pokok" => 1000000,
				"berjangka_jasa" => 14322341,
				"barang_pokok" => 1000000,
				"barang_jasa" => 14322341,
				"pelunasan" => array(
					"konsumtif_pokok" => 0,
					"konsumtif_jasa" => 0,
					"berjangka_pokok" => 1000000,
					"berjangka_jasa" => 14322341,
					"barang_pokok" => 1000000,
					"barang_jasa" => 14322341,
				)
			),
			array(
				"bulan" => 7,
				"konsumtif_pokok" => 1000000,
				"konsumtif_jasa" => 14322341,
				"berjangka_pokok" => 1000000,
				"berjangka_jasa" => 14322341,
				"barang_pokok" => 1000000,
				"barang_jasa" => 14322341,
				"pelunasan" => array(
					"konsumtif_pokok" => 0,
					"konsumtif_jasa" => 0,
					"berjangka_pokok" => 1000000,
					"berjangka_jasa" => 14322341,
					"barang_pokok" => 1000000,
					"barang_jasa" => 14322341,
				)
			),
			array(
				"bulan" => 8,
				"konsumtif_pokok" => 1000000,
				"konsumtif_jasa" => 14322341,
				"berjangka_pokok" => 1000000,
				"berjangka_jasa" => 14322341,
				"barang_pokok" => 1000000,
				"barang_jasa" => 14322341,
				"pelunasan" => array(
					"konsumtif_pokok" => 0,
					"konsumtif_jasa" => 0,
					"berjangka_pokok" => 1000000,
					"berjangka_jasa" => 14322341,
					"barang_pokok" => 1000000,
					"barang_jasa" => 14322341,
				)
			),
			array(
				"bulan" => 9,
				"konsumtif_pokok" => 1000000,
				"konsumtif_jasa" => 14322341,
				"berjangka_pokok" => 1000000,
				"berjangka_jasa" => 14322341,
				"barang_pokok" => 1000000,
				"barang_jasa" => 14322341,
				"pelunasan" => array(
					"konsumtif_pokok" => 0,
					"konsumtif_jasa" => 0,
					"berjangka_pokok" => 1000000,
					"berjangka_jasa" => 14322341,
					"barang_pokok" => 1000000,
					"barang_jasa" => 14322341,
				)
			),
			array(
				"bulan" => 10,
				"konsumtif_pokok" => 1000000,
				"konsumtif_jasa" => 14322341,
				"berjangka_pokok" => 1000000,
				"berjangka_jasa" => 14322341,
				"barang_pokok" => 1000000,
				"barang_jasa" => 14322341,
				"pelunasan" => array(
					"konsumtif_pokok" => 0,
					"konsumtif_jasa" => 0,
					"berjangka_pokok" => 1000000,
					"berjangka_jasa" => 14322341,
					"barang_pokok" => 1000000,
					"barang_jasa" => 14322341,
				)
			),
			array(
				"bulan" => 11,
				"konsumtif_pokok" => 1000000,
				"konsumtif_jasa" => 14322341,
				"berjangka_pokok" => 1000000,
				"berjangka_jasa" => 14322341,
				"barang_pokok" => 1000000,
				"barang_jasa" => 14322341,
				"pelunasan" => array(
					"konsumtif_pokok" => 0,
					"konsumtif_jasa" => 0,
					"berjangka_pokok" => 1000000,
					"berjangka_jasa" => 14322341,
					"barang_pokok" => 1000000,
					"barang_jasa" => 14322341,
				)
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
		'.$pdf->nsi_box($text = '<span class="txt_judul">Rekapitulasi Tagihan Tahun '.$_REQUEST['tahun'].' </span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';
		$html.='<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="width:5%; vertical-align: middle; text-align:center" rowspan="2"> No. </th>
			<th style="width:15%; vertical-align: middle; text-align:center" rowspan="2">Bulan </th>
			<th style="width:20%; vertical-align: middle; text-align:center" colspan="2"> Konsumtif  </th>
			<th style="width:20%; vertical-align: middle; text-align:center" colspan="2"> Berjangka  </th>
			<th style="width:20%; vertical-align: middle; text-align:center" colspan="2"> Barang  </th>
			<th style="width:20%; vertical-align: middle; text-align:center" rowspan="2"> Jumlah  </th>
		</tr>
		<tr class="header_kolom">
			<th style="width:10%; vertical-align: middle; text-align:center"> Pokok  </th>
			<th style="width:10%; vertical-align: middle; text-align:center"> Jasa  </th>

			<th style="width:10%; vertical-align: middle; text-align:center"> Pokok  </th>
			<th style="width:10%; vertical-align: middle; text-align:center"> Jasa  </th>

			<th style="width:10%; vertical-align: middle; text-align:center"> Pokok  </th>
			<th style="width:10%; vertical-align: middle; text-align:center"> Jasa  </th>
		</tr>';

		$no = 1;
		$simpanan_arr = array();

		$jumlah_konsumtif_pokok = 0;
		$jumlah_konsumtif_jasa = 0;

		$jumlah_berjangka_pokok = 0;
		$jumlah_berjangka_jasa = 0;

		$jumlah_barang_pokok = 0;
		$jumlah_barang_jasa = 0;

		$total_jumlah = 0;
		foreach ($simpanan as $value) {
			$jumlah = ($value['konsumtif_pokok'] + $value['konsumtif_jasa']) + ($value['berjangka_pokok'] + $value['berjangka_jasa']) + ($value['barang_pokok'] + $value['barang_jasa']);
			$jumlah_pelunasan = ($value['pelunasan']['konsumtif_pokok'] + $value['pelunasan']['konsumtif_jasa']) + ($value['pelunasan']['berjangka_pokok'] + $value['pelunasan']['berjangka_jasa']) + ($value['pelunasan']['barang_pokok'] + $value['pelunasan']['barang_jasa']);

			$jumlah_konsumtif_pokok += $value['konsumtif_pokok'] + $value['pelunasan']['konsumtif_pokok'];
			$jumlah_konsumtif_jasa += $value['konsumtif_jasa'] + $value['pelunasan']['konsumtif_jasa'];
			$jumlah_berjangka_pokok += $value['berjangka_pokok'] + $value['pelunasan']['berjangka_pokok'];
			$jumlah_berjangka_jasa += $value['berjangka_jasa'] + $value['pelunasan']['berjangka_jasa'];
			$jumlah_barang_pokok += $value['barang_pokok'] + $value['pelunasan']['barang_pokok'];
			$jumlah_barang_jasa += $value['barang_jasa'] + $value['pelunasan']['barang_jasa'];
			$total_jumlah += $jumlah;

			$html .= '
			<tr>
				<td class="h_tengah">'.$no++.'</td>
				<td>'. $bulan[$value['bulan']].'</td>
				<td class="h_kanan">'. number_format($value['konsumtif_pokok']).'</td>
				<td class="h_kanan">'. number_format($value['konsumtif_jasa']).'</td>

				<td class="h_kanan">'. number_format($value['berjangka_pokok']).'</td>
				<td class="h_kanan">'. number_format($value['berjangka_jasa']).'</td>

				<td class="h_kanan">'. number_format($value['barang_pokok']).'</td>
				<td class="h_kanan">'. number_format($value['barang_jasa']).'</td>

				<td class="h_kanan">'. number_format($jumlah).'</td>
			</tr>';

			$html .= '
			<tr>
				<td class="h_tengah"></td>
				<td>Pelunasan</td>
				<td class="h_kanan">'. number_format($value['pelunasan']['konsumtif_pokok']).'</td>
				<td class="h_kanan">'. number_format($value['pelunasan']['konsumtif_jasa']).'</td>

				<td class="h_kanan">'. number_format($value['pelunasan']['berjangka_pokok']).'</td>
				<td class="h_kanan">'. number_format($value['pelunasan']['berjangka_jasa']).'</td>

				<td class="h_kanan">'. number_format($value['pelunasan']['barang_pokok']).'</td>
				<td class="h_kanan">'. number_format($value['pelunasan']['barang_jasa']).'</td>

				<td class="h_kanan">'. number_format($jumlah_pelunasan).'</td>
			</tr>';
		}
		$html .= '
		<tr class="header_kolom">
			<td colspan="2" class="h_tengah"><strong>Jumlah</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_konsumtif_pokok).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_konsumtif_jasa).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_berjangka_pokok).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_berjangka_jasa).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_barang_pokok).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_barang_jasa).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($total_jumlah).'</strong></td>
		</tr>';
		$html .= '</table>';
		$pdf->nsi_html($html);
		$pdf->Output('lap_simpan'.date('Ymd_His') . '.pdf', 'I');
	}
}