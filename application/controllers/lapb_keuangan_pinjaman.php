<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lapb_keuangan_pinjaman extends OperatorController {

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
		$this->data['judul_sub'] = 'Data Pinjaman';

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

		$this->data['isi'] = $this->load->view('laporan/laporan_keuangan/pinjaman', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}

	function ajax_list() {
		/*Default request pager params dari jeasyUI*/
		$year = isset($_POST['tahun']) ? $_POST['tahun'] : date("Y");
		$data   = $this->lap_simpanan_m->lap_keuangan_pinjaman($year);
		$i	= 0;
		$rows   = array();
		$jumlah_konsumtif = 0;
		$jumlah_berjangka = 0;
		$jumlah_barang = 0;
		$total_jumlah = 0;
		if($data){
			foreach ($data as $key => $r) {
				$berjangka = 0;
				$konsumtif = 0;
				$barang = 0;
				$jumlah = 0;
				foreach($r as $nominal){
					if(isset($nominal['jenis_pinjaman'])){
						if($nominal['jenis_pinjaman'] == 'Pinjaman Berjangka'){
							$berjangka = $nominal['jumlah_pinjaman'];
							$jumlah_berjangka = $jumlah_berjangka + $nominal['jumlah_pinjaman'];
						}else if($nominal['jenis_pinjaman'] == 'Pinjaman Konsumtif'){
							$konsumtif = $nominal['jumlah_pinjaman'];
							$jumlah_konsumtif = $jumlah_konsumtif + $nominal['jumlah_pinjaman'];
						}else{
							$barang = $nominal['jumlah_pinjaman'];
							$jumlah_barang = $jumlah_barang + $nominal['jumlah_pinjaman'];
						}

						$jumlah = $jumlah + $nominal['jumlah_pinjaman'];
					}
				}
				$total_jumlah = $total_jumlah + $jumlah;
				//array keys ini = attribute 'field' di view nya
				$rows[$i]['bulan'] = ucfirst($key);
				$rows[$i]['konsumtif'] = 'Rp. '.number_format($konsumtif);
				$rows[$i]['berjangka'] = 'Rp. '.number_format($berjangka);
				$rows[$i]['barang'] = 'Rp. '.number_format($barang);
				$rows[$i]['jumlah'] = 'Rp. '.number_format($jumlah);
				$i++;
			}
		}
		$footer = array(
			array(
				'bulan' => 'Jumlah',
				'konsumtif' => 'Rp. '.number_format($jumlah_konsumtif),
				'berjangka' => 'Rp. '.number_format($jumlah_berjangka),
				'barang' => 'Rp. '.number_format($jumlah_barang),
				'jumlah' => 'Rp. '.number_format($total_jumlah),
			)
		);
		//keys total & rows wajib bagi jEasyUI
		$result = array('rows'=>$rows,'footer'=> $footer);
		echo json_encode($result); //return nya json
	}
	
	function cetak() {
		$bulan = array("januari","februari","maret","april","mei","juni","juli","agustus","september","oktober","november","desember");

		$year = isset($_REQUEST['tahun']) ? $_REQUEST['tahun'] : date("Y");
		$data   = $this->lap_simpanan_m->lap_keuangan_pinjaman($year);
		
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
		'.$pdf->nsi_box($text = '<span class="txt_judul">Rekapitulasi Pinjaman Tahun '.$_REQUEST['tahun'].' </span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';
		$html.='<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="width:5%; vertical-align: middle; text-align:center"> No. </th>
			<th style="width:15%; vertical-align: middle; text-align:center"> Bulan </th>
			<th style="width:20%; vertical-align: middle; text-align:center"> Konsumtif  </th>
			<th style="width:20%; vertical-align: middle; text-align:center"> Berjangka  </th>
			<th style="width:20%; vertical-align: middle; text-align:center"> Barang  </th>
			<th style="width:20%; vertical-align: middle; text-align:center"> Jumlah  </th>
		</tr>';
		$jumlah_konsumtif = 0;
		$jumlah_berjangka = 0;
		$jumlah_barang = 0;
		$total_jumlah = 0;
		$i = 0;
		if($data){
			foreach ($data as $key => $r) {
				$i++;
				$berjangka = 0;
				$konsumtif = 0;
				$barang = 0;
				$jumlah = 0;
				foreach($r as $nominal){
					if(isset($nominal['jenis_pinjaman'])){
						if($nominal['jenis_pinjaman'] == 'Pinjaman Berjangka'){
							$berjangka = $nominal['jumlah_pinjaman'];
							$jumlah_berjangka = $jumlah_berjangka + $nominal['jumlah_pinjaman'];
						}else if($nominal['jenis_pinjaman'] == 'Pinjaman Konsumtif'){
							$konsumtif = $nominal['jumlah_pinjaman'];
							$jumlah_konsumtif = $jumlah_konsumtif + $nominal['jumlah_pinjaman'];
						}else{
							$barang = $nominal['jumlah_pinjaman'];
							$jumlah_barang = $jumlah_barang + $nominal['jumlah_pinjaman'];
						}

						$jumlah = $jumlah + $nominal['jumlah_pinjaman'];
					}
				}
				$total_jumlah = $total_jumlah + $jumlah;
				//array keys ini = attribute 'field' di view nya
				$html .= '
				<tr>
					<td class="h_tengah">'.$i.'</td>
					<td>'. ucfirst($key).'</td>
					<td class="h_kanan">'. 'Rp. '.number_format($konsumtif).'</td>
					<td class="h_kanan">'. 'Rp. '.number_format($berjangka).'</td>
					<td class="h_kanan">'. 'Rp. '.number_format($barang).'</td>
					<td class="h_kanan">'. 'Rp. '.number_format($jumlah).'</td>
				</tr>';
			}
		}
		$html .= '
		<tr class="header_kolom">
			<td colspan="2" class="h_tengah"><strong>Jumlah</strong></td>
			<td class="h_kanan"><strong>Rp. '.number_format($jumlah_konsumtif).'</strong></td>
			<td class="h_kanan"><strong>Rp. '.number_format($jumlah_berjangka).'</strong></td>
			<td class="h_kanan"><strong>Rp. '.number_format($jumlah_barang).'</strong></td>
			<td class="h_kanan"><strong>Rp. '.number_format($total_jumlah).'</strong></td>
		</tr>';
		$html .= '</table>';
		$pdf->nsi_html($html);
		$pdf->Output('lap_simpan'.date('Ymd_His') . '.pdf', 'I');
	}
}