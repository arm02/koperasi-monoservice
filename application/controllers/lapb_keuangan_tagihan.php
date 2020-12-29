<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lapb_keuangan_tagihan extends OperatorController {

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
		$this->data['judul_sub'] = 'Data Tagihan';

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

		// print_r($this->lap_simpanan_m->lap_keuangan_tagihan(2020));
		$this->data['isi'] = $this->load->view('laporan/laporan_keuangan/tagihan', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}

	function ajax_list() {
		/*Default request pager params dari jeasyUI*/
		$year = isset($_POST['tahun']) ? $_POST['tahun'] : date("Y");
		$data   = $this->lap_simpanan_m->lap_keuangan_tagihan($year);

		$i	= 0;
		$rows   = array();
		$total_konsumtif_pokok = 0;
		$total_konsumtif_jasa = 0;

		$total_berjangka_pokok = 0;
		$total_berjangka_jasa = 0;

		$total_barang_pokok = 0;
		$total_barang_jasa = 0;

		$total_jumlah = 0;
		if($data){
			foreach ($data as $key => $r) {
				$konsumtif_pokok = 0;
				$konsumtif_jasa = 0;

				$berjangka_pokok = 0;
				$berjangka_jasa = 0;

				$barang_pokok = 0;
				$barang_jasa = 0;

				$pelunasan_konsumtif_pokok = 0;
				$pelunasan_konsumtif_jasa = 0;

				$pelunasan_berjangka_pokok = 0;
				$pelunasan_berjangka_jasa = 0;

				$pelunasan_barang_pokok = 0;
				$pelunasan_barang_jasa = 0;

				$jumlah_konsumtif_pokok = 0;
				$jumlah_konsumtif_jasa = 0;

				$jumlah_berjangka_pokok = 0;
				$jumlah_berjangka_jasa = 0;

				$jumlah_barang_pokok = 0;
				$jumlah_barang_jasa = 0;

				$jumlah_pelunasan = 0;
				$jumlah_tagihan = 0;
				foreach($r['tagihan'] as $nominal){
					if(isset($nominal['jenis_pinjaman'])){
						if($nominal['jenis_pinjaman'] == 'Pinjaman Berjangka'){
							if(isset($nominal['pokok'])){
								$berjangka_pokok = $nominal['pokok'];
								$jumlah_berjangka_pokok = $jumlah_berjangka_pokok + $nominal['pokok'];

							}

							if(isset($nominal['jasa'])){
								$berjangka_jasa = $nominal['jasa'];
								$jumlah_berjangka_jasa = $jumlah_berjangka_jasa + $nominal['jasa'];
							}
						}else if($nominal == 'Pinjaman Konsumtif'){
							if(isset($nominal['pokok'])){
								$konsumtif_pokok = $nominal['pokok'];
								$jumlah_konsumtif_pokok = $jumlah_konsumtif_pokok + $nominal['pokok'];
							}

							if(isset($nominal['jasa'])){
								$konsumtif_jasa = $nominal['jasa'];
								$jumlah_konsumtif_jasa = $jumlah_konsumtif_jasa + $nominal['jasa'];
							}
						}else{
							if(isset($nominal['pokok'])){
								$barang_pokok = $nominal['pokok'];
								$jumlah_barang_pokok = $jumlah_barang_pokok + $nominal['pokok'];
							}

							if(isset($nominal['jasa'])){
								$barang_jasa = $nominal['jasa'];
								$jumlah_barang_jasa = $jumlah_barang_jasa + $nominal['jasa'];
							}
						}
						if(isset($nominal['pokok']) && isset($nominal['jasa'])){
							$jumlah_tagihan = $nominal['pokok'];
						}

					}
				}

				foreach($r['pelunasan'] as $nominal){
					if(isset($nominal['jenis_pinjaman'])){
						if($nominal['jenis_pinjaman'] == 'Pinjaman Berjangka'){
							if(isset($nominal['pokok'])){
								$pelunasan_berjangka_pokok = $nominal['pokok'];
								$jumlah_berjangka_pokok = $jumlah_berjangka_pokok + $nominal['pokok'];
							}

							if(isset($nominal['jasa'])){
								$pelunasan_berjangka_jasa = $nominal['jasa'];
								$jumlah_berjangka_jasa = $jumlah_berjangka_jasa + $nominal['jasa'];
							}
						}else if($nominal == 'Pinjaman Konsumtif'){
							if(isset($nominal['pokok'])){
								$pelunasan_konsumtif_pokok = $nominal['pokok'];
								$jumlah_konsumtif_pokok = $jumlah_konsumtif_pokok + $nominal['pokok'];
							}

							if(isset($nominal['jasa'])){
								$pelunasan_konsumtif_jasa = $nominal['jasa'];
								$jumlah_konsumtif_jasa = $jumlah_konsumtif_jasa + $nominal['jasa'];
							}
						}else{
							if(isset($nominal['pokok'])){
								$pelunasan_barang_pokok = $nominal['pokok'];
								$jumlah_barang_pokok = $jumlah_barang_pokok + $nominal['pokok'];
							}

							if(isset($nominal['jasa'])){
								$pelunasan_barang_jasa = $nominal['jasa'];
								$jumlah_barang_jasa = $jumlah_barang_jasa + $nominal['jasa'];
							}
						}
						if(isset($nominal['pokok']) && isset($nominal['jasa'])){
							$jumlah_pelunasan = $nominal['pokok'];
						}
					}
				}
				//array keys ini = attribute 'field' di view nya
				$rows[$i]['bulan'] = ucfirst($key);

				$rows[$i]['konsumtif_pokok'] = 'Rp. ' . number_format($konsumtif_pokok);
				$rows[$i]['konsumtif_jasa'] = 'Rp. ' . number_format($konsumtif_jasa);
				$rows[$i]['berjangka_pokok'] = 'Rp. ' . number_format($berjangka_pokok);
				$rows[$i]['berjangka_jasa'] = 'Rp. ' . number_format($berjangka_jasa);
				$rows[$i]['barang_jasa'] = 'Rp. ' . number_format($barang_jasa);
				$rows[$i]['barang_pokok'] = 'Rp. ' . number_format($barang_pokok);

				$rows[$i]['children'] = array(
					array(
						'bulan' => 'Pelunasan',
						'berjangka_pokok' => 'Rp. ' . number_format($pelunasan_berjangka_pokok),
						'berjangka_jasa' => 'Rp. ' . number_format($pelunasan_berjangka_jasa),
						'konsumtif_pokok' => 'Rp. ' . number_format($pelunasan_konsumtif_pokok),
						'konsumtif_jasa' => 'Rp. ' . number_format($pelunasan_konsumtif_jasa),
						'barang_jasa' => 'Rp. ' . number_format($pelunasan_barang_jasa),
						'barang_pokok' => 'Rp. ' . number_format($pelunasan_barang_pokok),
						'jumlah_tagihan' => 'Rp. ' . number_format($jumlah_pelunasan)
					),
				);

				$rows[$i]['jumlah_tagihan'] = 'Rp. ' . number_format($jumlah_tagihan);
				$rows[$i]['jumlah_pelunasan'] = 'Rp. ' . number_format($jumlah_pelunasan);

				$i++;

				$total_berjangka_pokok = $total_berjangka_pokok + $berjangka_pokok + $pelunasan_berjangka_pokok;
				$total_berjangka_jasa = $total_berjangka_jasa + $berjangka_jasa + $pelunasan_berjangka_jasa;
				$total_konsumtif_pokok = $total_konsumtif_pokok + $konsumtif_pokok + $pelunasan_konsumtif_pokok;
				$total_konsumtif_jasa = $total_konsumtif_jasa + $konsumtif_jasa + $pelunasan_konsumtif_jasa;
				$total_barang_pokok = $total_barang_pokok + $barang_pokok + $pelunasan_barang_pokok;
				$total_barang_jasa = $total_barang_jasa + $barang_jasa + $pelunasan_barang_jasa;
				$total_jumlah = $total_jumlah + $jumlah_tagihan + $jumlah_pelunasan;
			}
		}
		$footer = array(
			array(
				'bulan' => 'Jumlah',
				'berjangka_pokok' => 'Rp. '.number_format($total_berjangka_pokok),
				'berjangka_jasa' => 'Rp. '.number_format($total_berjangka_jasa),
				'konsumtif_pokok' => 'Rp. '.number_format($total_konsumtif_pokok),
				'konsumtif_jasa' => 'Rp. '.number_format($total_konsumtif_jasa),
				'barang_pokok' => 'Rp. '.number_format($total_barang_pokok),
				'barang_jasa' => 'Rp. '.number_format($total_barang_jasa),
				'jumlah_tagihan' => 'Rp. '.number_format($total_jumlah),
			)
		);
		//keys total & rows wajib bagi jEasyUI
		$result = array('rows'=>$rows,'footer'=> $footer);
		echo json_encode($result); //return nya json
	}

	function cetak() {
		$bulan = array("januari","februari","maret","april","mei","juni","juli","agustus","september","oktober","november","desember");
		$year = isset($_REQUEST['tahun']) ? $_REQUEST['tahun'] : date("Y");
		$data   = $this->lap_simpanan_m->lap_keuangan_tagihan($year);

		$i	= 0;
		$tagihan = array();
		$total_konsumtif_pokok = 0;
		$total_konsumtif_jasa = 0;

		$total_berjangka_pokok = 0;
		$total_berjangka_jasa = 0;

		$total_barang_pokok = 0;
		$total_barang_jasa = 0;

		$total_jumlah = 0;
		if($data){
			foreach ($data as $key => $r) {
				$konsumtif_pokok = 0;
				$konsumtif_jasa = 0;

				$berjangka_pokok = 0;
				$berjangka_jasa = 0;

				$barang_pokok = 0;
				$barang_jasa = 0;

				$pelunasan_konsumtif_pokok = 0;
				$pelunasan_konsumtif_jasa = 0;

				$pelunasan_berjangka_pokok = 0;
				$pelunasan_berjangka_jasa = 0;

				$pelunasan_barang_pokok = 0;
				$pelunasan_barang_jasa = 0;

				$jumlah_konsumtif_pokok = 0;
				$jumlah_konsumtif_jasa = 0;

				$jumlah_berjangka_pokok = 0;
				$jumlah_berjangka_jasa = 0;

				$jumlah_barang_pokok = 0;
				$jumlah_barang_jasa = 0;

				$jumlah_pelunasan = 0;
				$jumlah_tagihan = 0;
				foreach($r['tagihan'] as $nominal){
					if(isset($nominal['jenis_pinjaman'])){
						if($nominal['jenis_pinjaman'] == 'Pinjaman Berjangka'){
							if(isset($nominal['pokok'])){
								$berjangka_pokok = $nominal['pokok'];
								$jumlah_berjangka_pokok = $jumlah_berjangka_pokok + $nominal['pokok'];

							}

							if(isset($nominal['jasa'])){
								$berjangka_jasa = $nominal['jasa'];
								$jumlah_berjangka_jasa = $jumlah_berjangka_jasa + $nominal['jasa'];
							}
						}else if($nominal == 'Pinjaman Konsumtif'){
							if(isset($nominal['pokok'])){
								$konsumtif_pokok = $nominal['pokok'];
								$jumlah_konsumtif_pokok = $jumlah_konsumtif_pokok + $nominal['pokok'];
							}

							if(isset($nominal['jasa'])){
								$konsumtif_jasa = $nominal['jasa'];
								$jumlah_konsumtif_jasa = $jumlah_konsumtif_jasa + $nominal['jasa'];
							}
						}else{
							if(isset($nominal['pokok'])){
								$barang_pokok = $nominal['pokok'];
								$jumlah_barang_pokok = $jumlah_barang_pokok + $nominal['pokok'];
							}

							if(isset($nominal['jasa'])){
								$barang_jasa = $nominal['jasa'];
								$jumlah_barang_jasa = $jumlah_barang_jasa + $nominal['jasa'];
							}
						}
						if(isset($nominal['pokok']) && isset($nominal['jasa'])){
							$jumlah_tagihan = $nominal['pokok'];
						}

					}
				}

				foreach($r['pelunasan'] as $nominal){
					if(isset($nominal['jenis_pinjaman'])){
						if($nominal['jenis_pinjaman'] == 'Pinjaman Berjangka'){
							if(isset($nominal['pokok'])){
								$pelunasan_berjangka_pokok = $nominal['pokok'];
								$jumlah_berjangka_pokok = $jumlah_berjangka_pokok + $nominal['pokok'];
							}

							if(isset($nominal['jasa'])){
								$pelunasan_berjangka_jasa = $nominal['jasa'];
								$jumlah_berjangka_jasa = $jumlah_berjangka_jasa + $nominal['jasa'];
							}
						}else if($nominal == 'Pinjaman Konsumtif'){
							if(isset($nominal['pokok'])){
								$pelunasan_konsumtif_pokok = $nominal['pokok'];
								$jumlah_konsumtif_pokok = $jumlah_konsumtif_pokok + $nominal['pokok'];
							}

							if(isset($nominal['jasa'])){
								$pelunasan_konsumtif_jasa = $nominal['jasa'];
								$jumlah_konsumtif_jasa = $jumlah_konsumtif_jasa + $nominal['jasa'];
							}
						}else{
							if(isset($nominal['pokok'])){
								$pelunasan_barang_pokok = $nominal['pokok'];
								$jumlah_barang_pokok = $jumlah_barang_pokok + $nominal['pokok'];
							}

							if(isset($nominal['jasa'])){
								$pelunasan_barang_jasa = $nominal['jasa'];
								$jumlah_barang_jasa = $jumlah_barang_jasa + $nominal['jasa'];
							}
						}
						if(isset($nominal['pokok']) && isset($nominal['jasa'])){
							$jumlah_pelunasan = $nominal['pokok'];
						}
					}
				}
				//array keys ini = attribute 'field' di view nya
				$tagihan[$i]['bulan'] = ucfirst($key);

				$tagihan[$i]['konsumtif_pokok'] = $konsumtif_pokok;
				$tagihan[$i]['konsumtif_jasa'] = $konsumtif_jasa;
				$tagihan[$i]['berjangka_pokok'] = $berjangka_pokok;
				$tagihan[$i]['berjangka_jasa'] = $berjangka_jasa;
				$tagihan[$i]['barang_jasa'] = $barang_jasa;
				$tagihan[$i]['barang_pokok'] = $barang_pokok;

				$tagihan[$i]['pelunasan'] = array(
					'bulan' => 'Pelunasan',
					'berjangka_pokok' => $pelunasan_berjangka_pokok,
					'berjangka_jasa' => $pelunasan_berjangka_jasa,
					'konsumtif_pokok' => $pelunasan_konsumtif_pokok,
					'konsumtif_jasa' => $pelunasan_konsumtif_jasa,
					'barang_jasa' => $pelunasan_barang_jasa,
					'barang_pokok' => $pelunasan_barang_pokok,
					'jumlah_tagihan' => $jumlah_pelunasan
				);

				$tagihan[$i]['jumlah_tagihan'] = $jumlah_tagihan;
				$tagihan[$i]['jumlah_pelunasan'] = $jumlah_pelunasan;

				$i++;

				$total_berjangka_pokok = $total_berjangka_pokok + $berjangka_pokok + $pelunasan_berjangka_pokok;
				$total_berjangka_jasa = $total_berjangka_jasa + $berjangka_jasa + $pelunasan_berjangka_jasa;
				$total_konsumtif_pokok = $total_konsumtif_pokok + $konsumtif_pokok + $pelunasan_konsumtif_pokok;
				$total_konsumtif_jasa = $total_konsumtif_jasa + $konsumtif_jasa + $pelunasan_konsumtif_jasa;
				$total_barang_pokok = $total_barang_pokok + $barang_pokok + $pelunasan_barang_pokok;
				$total_barang_jasa = $total_barang_jasa + $barang_jasa + $pelunasan_barang_jasa;
				$total_jumlah = $total_jumlah + $jumlah_tagihan + $jumlah_pelunasan;
			}
		}
		if($tagihan == FALSE) {
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

		$jumlah_konsumtif_pokok = 0;
		$jumlah_konsumtif_jasa = 0;

		$jumlah_berjangka_pokok = 0;
		$jumlah_berjangka_jasa = 0;

		$jumlah_barang_pokok = 0;
		$jumlah_barang_jasa = 0;

		$total_jumlah = 0;
		foreach ($tagihan as $value) {
			$html .= '
			<tr>
				<td class="h_tengah">'.$no++.'</td>
				<td>'. $value['bulan'].'</td>
				<td class="h_kanan">'. number_format($value['konsumtif_pokok']).'</td>
				<td class="h_kanan">'. number_format($value['konsumtif_jasa']).'</td>

				<td class="h_kanan">'. number_format($value['berjangka_pokok']).'</td>
				<td class="h_kanan">'. number_format($value['berjangka_jasa']).'</td>

				<td class="h_kanan">'. number_format($value['barang_pokok']).'</td>
				<td class="h_kanan">'. number_format($value['barang_jasa']).'</td>

				<td class="h_kanan">'. number_format($value['jumlah_tagihan']).'</td>
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

				<td class="h_kanan">'. number_format($value['jumlah_pelunasan']).'</td>
			</tr>';
		}
		$html .= '
		<tr class="header_kolom">
			<td colspan="2" class="h_tengah"><strong>Jumlah</strong></td>
			<td class="h_kanan"><strong>'. number_format($total_konsumtif_pokok).'</strong></td>
			<td class="h_kanan"><strong>'. number_format($total_konsumtif_jasa).'</strong></td>
			<td class="h_kanan"><strong>'. number_format($total_berjangka_pokok).'</strong></td>
			<td class="h_kanan"><strong>'. number_format($total_berjangka_jasa).'</strong></td>
			<td class="h_kanan"><strong>'. number_format($total_barang_pokok).'</strong></td>
			<td class="h_kanan"><strong>'. number_format($total_barang_jasa).'</strong></td>
			<td class="h_kanan"><strong>'. number_format($total_jumlah).'</strong></td>
		</tr>';
		$html .= '</table>';
		$pdf->nsi_html($html);
		$pdf->Output('lap_simpan'.date('Ymd_His') . '.pdf', 'I');
	}
}