<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lapb_koperasi_pinjaman_perbulan extends OperatorController {

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
		
		$this->data['isi'] = $this->load->view('laporan/laporan_koperasi/pinjaman_perbulan', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}

	function cetak() {
		$bulan = array("januari","februari","maret","april","mei","juni","juli","agustus","september","oktober","november","desember");

		$dataPelunasan = array(
			"januari" => 1000000,
			"februari" => 0,
			"maret" => 0,
			"april" => 0,
			"mei" => 0,
			"juni" => 0,
			"juli" => 0,
			"agustus" => 0,
			"september" => 0,
			"oktober" => 0,
			"november" => 0,
			"desember" => 1000000,
		);
		$data = array(
			array(
			"nama" => 'Alimin',
			"januari" => 1000000,
			"februari" => 0,
			"maret" => 0,
			"april" => 0,
			"mei" => 0,
			"juni" => 0,
			"juli" => 0,
			"agustus" => 0,
			"september" => 0,
			"oktober" => 0,
			"november" => 0,
			"desember" => 1000000,
			)
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
		'.$pdf->nsi_box($text = '<span class="txt_judul">Rekapitulasi Pinjaman Barang Tahun Buku '.$_REQUEST['tahun'].' </span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';
		$html.='<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="vertical-align: middle; text-align:center"> No. </th>
			<th style="vertical-align: middle; text-align:center">Nama </th>
			<th style="vertical-align: middle; text-align:center"> Jan  </th>
			<th style="vertical-align: middle; text-align:center"> Feb  </th>
			<th style="vertical-align: middle; text-align:center"> Mar  </th>
			<th style="vertical-align: middle; text-align:center"> Apr  </th>
			<th style="vertical-align: middle; text-align:center"> Mei  </th>
			<th style="vertical-align: middle; text-align:center"> Jun  </th>
			<th style="vertical-align: middle; text-align:center"> Jul  </th>
			<th style="vertical-align: middle; text-align:center"> Agust  </th>
			<th style="vertical-align: middle; text-align:center"> Sept  </th>
			<th style="vertical-align: middle; text-align:center"> Okt  </th>
			<th style="vertical-align: middle; text-align:center"> Nov  </th>
			<th style="vertical-align: middle; text-align:center"> Des  </th>
			<th style="vertical-align: middle; text-align:center"> Jumlah  </th>
		</tr>';

		$no = 1;
		$jumlah_januari = 0;
		$jumlah_februari = 0;
		$jumlah_maret = 0;
		$jumlah_april = 0;
		$jumlah_mei = 0;
		$jumlah_juni = 0;
		$jumlah_juli = 0;
		$jumlah_agustus = 0;
		$jumlah_september = 0;
		$jumlah_oktober = 0;
		$jumlah_november = 0;
		$jumlah_desember = 0;
		$total_jumlah = 0;
		$jumlah = 0;
		foreach ($data as $value) {
			foreach ($bulan as $month) {
				$jumlah = $jumlah + $value[$month];
			}

			$jumlah_januari += $value['januari'];
			$jumlah_februari += $value['februari'];
			$jumlah_maret += $value['maret'];
			$jumlah_april += $value['april'];
			$jumlah_mei += $value['mei'];
			$jumlah_juni += $value['juni'];
			$jumlah_juli += $value['juli'];
			$jumlah_agustus += $value['agustus'];
			$jumlah_september += $value['september'];
			$jumlah_oktober += $value['oktober'];
			$jumlah_november += $value['november'];
			$jumlah_desember += $value['desember'];
			$total_jumlah += $jumlah;

			$html .= '
			<tr>
				<td class="h_tengah">'.$no++.'</td>
				<td>'. $value['nama'].'</td>
				<td class="h_kanan">'. number_format($value['januari']).'</td>
				<td class="h_kanan">'. number_format($value['februari']).'</td>
				<td class="h_kanan">'. number_format($value['maret']).'</td>
				<td class="h_kanan">'. number_format($value['april']).'</td>
				<td class="h_kanan">'. number_format($value['mei']).'</td>
				<td class="h_kanan">'. number_format($value['juni']).'</td>
				<td class="h_kanan">'. number_format($value['juli']).'</td>
				<td class="h_kanan">'. number_format($value['agustus']).'</td>
				<td class="h_kanan">'. number_format($value['september']).'</td>
				<td class="h_kanan">'. number_format($value['oktober']).'</td>
				<td class="h_kanan">'. number_format($value['november']).'</td>
				<td class="h_kanan">'. number_format($value['desember']).'</td>
				<td class="h_kanan">'. number_format($jumlah).'</td>
			</tr>';
		}
		$html .= '
		<tr class="header_kolom">
			<td colspan="2" class="h_tengah"><strong>Jumlah Total</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_januari).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_februari).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_maret).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_april).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_mei).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_juni).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_juli).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_agustus).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_september).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_oktober).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_november).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($jumlah_desember).'</strong></td>
			<td class="h_kanan"><strong>'.number_format($total_jumlah).'</strong></td>
		</tr>';
		$html .= '</table>';

		$pdf->nsi_html($html);
		$pdf->Output('lap_koperasi_pinjaman_perbulan'.date('Ymd_His') . '.pdf', 'I');
	}
}