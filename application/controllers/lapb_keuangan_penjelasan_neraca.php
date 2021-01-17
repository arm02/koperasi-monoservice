<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lapb_keuangan_penjelasan_neraca extends OperatorController {

	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('lap_simpanan_m');
		$this->load->model('master_saldo_kas_m');
	}	

	public function index() {
		$this->load->library("pagination");

		$this->data['judul_browser'] = 'Laporan';
		$this->data['judul_utama'] = 'Laporan';
		$this->data['judul_sub'] = 'Data Penjelasan Neraca';

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
		
		$this->update_saldo_kas();
		$this->data['isi'] = $this->load->view('laporan/laporan_keuangan/penjelasan_neraca', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}

	function update_saldo_kas() {
		$tahun = date("Y");
		$latest_year = $tahun - 1;

		$shu = $this->getTotalPendapatan($tahun);
		$latest_shu = $this->getTotalPendapatan($tahun);
		$neraca = $this->lap_simpanan_m->lap_neraca($shu,$latest_shu, $tahun);

		$saldo_tahun_ini = $this->master_saldo_kas_m->get_data_kas_by_year($tahun);		
		if($saldo_tahun_ini){
			foreach($neraca as $key => $uraian){
				foreach ($uraian as $key_uraian => $value) {
					if(isset($value['kode'])){
						$saldo_kas_by_type = $this->master_saldo_kas_m->get_data_kas_by_type($value['kode'] , $tahun);

						if($saldo_kas_by_type){
							$data = array(
								'tahun' => $tahun, 
								'type' => $value['kode'],
								'nominal' => $value['nominal'],
							);
							$this->master_saldo_kas_m->update($saldo_kas_by_type[0]->id, $data);
						}else{
							$data = array(
								'tahun' => $tahun, 
								'type' => $value['kode'],
								'nominal' => $value['nominal'],
							);
							$this->master_saldo_kas_m->create($data);
						}
					}
				}
			}
		}else{
			foreach($neraca as $key => $uraian){
				foreach ($uraian as $key_uraian => $value) {
					if(isset($value['kode'])){
						$data = array(
							'tahun' => $tahun, 
							'type' => $value['kode'],
							'nominal' => $value['nominal'] ? $value['nominal']  :  0,
						);
						$this->master_saldo_kas_m->create($data);
					}
				}
			}
		}

	}

	function getTotalPendapatan($year) {
		/*Default request pager params dari jeasyUI*/
		$data   = $this->lap_simpanan_m->lap_keuangan_perhitungan_rugi_laba($year);
		$i	= 0;
		$rows   = array();
		$total_pendapatan = 0;
		$total_pendapatan_lain_lain = 0;
		$total_pengeluaran = 0;
		if($data){
			foreach ($data['pendapatan'] as $key => $r) {
				$total_pendapatan = $total_pendapatan + $r['jasa'];
			}
			foreach ($data['pendapatanlainlain'] as $key => $r) {
				foreach($r as $value){
					$total_pendapatan_lain_lain = $total_pendapatan_lain_lain + $value['total'];
				}
			}
			foreach ($data['pengeluaranbiayaumum'] as $key => $r) {
				$total_pengeluaran = $total_pengeluaran + $r['jumlah'];
			}
		}
		//keys total & rows wajib bagi jEasyUI
		return ($total_pendapatan + $total_pendapatan_lain_lain) - $total_pengeluaran;
	}

	function ajax_list() {
		/*Default request pager params dari jeasyUI*/  
		$tahun = isset($_POST['tahun']) ? $_POST['tahun'] : date("Y");
		$latest_year = $tahun - 1;
		
		$shu = $this->getTotalPendapatan($tahun);
		$latest_shu = $this->getTotalPendapatan($latest_year);
		$data   = $this->lap_simpanan_m->lap_penjelasan_neraca($shu,$latest_shu, $tahun);
		$i	= 0;
		$no = 1;
		$rows = array();
		$total = 0;
		if($data){
			foreach ($data as $key => $r) {
				$children = array();
				$i_uraian = 0;
				foreach($r as $key_uraian => $uraian){
					$sub_children = array();
					$i_sub_uraian = 0;
					
					if(is_array($uraian)){
						foreach($uraian as $key_sub_uraian => $sub_uraian){
							$sub_children[$i_sub_uraian]['uraian'] = $key_sub_uraian;
							$sub_children[$i_sub_uraian]['nominal'] = 'Rp. ' . number_format($sub_uraian);
							$i_sub_uraian++;
						}
						$children[$i_uraian]['children'] = $sub_children;
					}else{
						$children[$i_uraian]['nominal'] = 'Rp. ' . number_format($uraian);
					}
					$children[$i_uraian]['uraian'] = $key_uraian;
					$i_uraian++;
				}
				$rows[$i]['uraian'] = $key;
				$rows[$i]['children'] = $children;
				$i++;
			}
			$footer = array(
				array(
					'uraian' => '<b> SHU TAHUN BUKU '. $tahun .' </b>', 
					'nominal' => 'Rp. '. number_format($shu)
				)
			);
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('rows'=>$rows, 'footer' => $footer);
		echo json_encode($result); //return nya json
	}

	function cetak() {
		$tahun = isset($_REQUEST['tahun']) ? $_REQUEST['tahun'] : date("Y");
		$latest_year = $tahun - 1;
		
		$shu = $this->getTotalPendapatan($tahun);
		$latest_shu = $this->getTotalPendapatan($latest_year);
		$data   = $this->lap_simpanan_m->lap_penjelasan_neraca($shu,$latest_shu, $tahun);
		// print_r(json_encode($data));
		// exit();
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
		'.$pdf->nsi_box($text = '<span class="txt_judul">Rekapitulasi Tagihan Tahun '.$_REQUEST['tahun'].' </span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';
		$html.='<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="width:50%; vertical-align: middle; text-align:center"> </th>
			<th style="width:50%; vertical-align: middle; text-align:center"> </th>
		</tr>';
		$no = 1;
		$rows = array();
		$total = 0;
		if($data){
			foreach ($data as $key => $r) {
				$html.= '<tr>';
					$html .= '<td><b>'. $key.'</b></td>';
					$html .= '<td></td>';
				$html.= '</tr>';
				foreach($r as $key_uraian => $uraian){
					if(!is_array($uraian)){
						$html.= '<tr>';
							$html .= '<td>'. $key_uraian.'</td>';
							$html .= '<td>Rp. ' .number_format($uraian).'</td>';
						$html.= '</tr>';
					}else{
						foreach($uraian as $key_sub_uraian => $sub_uraian){
							$html.= '<tr>';
								$html .= '<td>'. $key_uraian.'</td>';
								$html .= '<td></td>';
							$html.= '</tr>';
							$html.= '<tr>';
								$html .= '<td>'. $key_sub_uraian.'</td>';
								$html .= '<td>'. 'Rp. ' . number_format($sub_uraian).'</td>';
							$html.= '</tr>';
						}
					}
				}
			}
			$html .= '<tr><td><b> SHU TAHUN BUKU '. $tahun .' </b></td>
			<td>Rp. '. number_format($shu).'</td></tr>';
		}
		$html .= '</table>';
		$pdf->nsi_html($html);
		$pdf->Output('lap_simpan'.date('Ymd_His') . '.pdf', 'I');
	}
}