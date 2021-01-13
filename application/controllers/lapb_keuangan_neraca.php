<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lapb_keuangan_neraca extends OperatorController {

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
		$this->data['judul_sub'] = 'Data Neraca';

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
		
		$this->data['isi'] = $this->load->view('laporan/laporan_keuangan/neraca_new', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
		// print_r(json_encode($this->lap_simpanan_m->lap_neraca(5000000, 2021)));

	}

	function getTotalPendapatan() {
		/*Default request pager params dari jeasyUI*/
		$year = isset($_POST['tahun']) ? $_POST['tahun'] : date("Y");
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
	function ajax_list_aktiva() {
		/*Default request pager params dari jeasyUI*/
		$tahun = isset($_POST['tahun']) ? $_POST['tahun'] : date("Y");
		
		$shu = $this->getTotalPendapatan();
		$data   = $this->lap_simpanan_m->lap_neraca($shu, $tahun);
		$i	= 0;
		$no = 1;
		$rows = array();
		$total = 0;
		if($data){
			foreach ($data as $key => $r) {
				if($i < 3){
					switch ($key) {
						case 'hartalancar':
							$rows[$i]['uraian'] = '<b> Harta Lancar </b>';
							break;
						case 'penyertaan':
							$rows[$i]['uraian'] = '<b> Penyertaan </b>';
							break;
						case 'hargatetap':
							$rows[$i]['uraian'] = '<b> Harga Tetap </b>';
							break;
					}
					$children = array();
					$ir = 0;
					foreach($r as $value){
						$total = $total + $value['nominal'];
						$children[$ir]['uraian'] = $value['title'];
						$children[$ir]['nominal'] = 'Rp. '.number_format($value['nominal']);
						$ir++;
					}
					//array keys ini = attribute 'field' di view nya
					$rows[$i]['no'] = $no++;
					$rows[$i]['children'] = $children;
					$i++;
				}
			}
			$footer = array(
				array(
					'no' => ' ',
					'uraian' => '<b> Total </b>', 
					'nominal' => 'Rp. '. number_format($total)
				)
			);
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('rows'=>$rows,'footer'=> $footer);
		echo json_encode($result); //return nya json
	}

	function ajax_list_pasiva() {
		/*Default request pager params dari jeasyUI*/
		$tahun = isset($_POST['tahun']) ? $_POST['tahun'] : date("Y");
		
		$shu = $this->getTotalPendapatan();
		$data   = $this->lap_simpanan_m->lap_neraca($shu, $tahun);
		$i	= 0;
		$no = 1;
		$rows = array();
		$total = 0;
		if($data){
			unset($data['hartalancar'],$data['penyertaan'],$data['hargatetap']);
			foreach ($data as $key => $r) {
					switch ($key) {
						case 'hutangjangkapendek':
							$rows[$i]['uraian'] = '<b> Hutang Jangka Pendek </b>';
							break;
						case 'hutangjangkapanjang':
							$rows[$i]['uraian'] = '<b> Hutang Jangka Panjang </b>';
							break;
						case 'modalsendiri':
							$rows[$i]['uraian'] = '<b> Modal Sendiri </b>';
							break;
					}
					$children = array();
					$ir = 0;
					foreach($r as $value){
						$total = $total + $value['nominal'];
						$children[$ir]['uraian'] = $value['title'];
						$children[$ir]['nominal'] = 'Rp. '.number_format($value['nominal']);
						$ir++;
					}
					//array keys ini = attribute 'field' di view nya
					$rows[$i]['no'] = $no++;
					$rows[$i]['children'] = $children;
					$i++;
			}
			$footer = array(
				array(
					'no' => ' ',
					'uraian' => '<b> Total </b>', 
					'nominal' => 'Rp. '. number_format($total)
				)
			);
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('rows'=>$rows,'footer'=> $footer);
		echo json_encode($result); //return nya json
	}

	function cetak() {
		$tahun = isset($_REQUEST['tahun']) ? $_REQUEST['tahun'] : date("Y");
		
		$shu = $this->getTotalPendapatan();
		$data   = $this->lap_simpanan_m->lap_neraca($shu, $tahun);

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
			.flex-container {
			  display: grid;
			  grid-template-columns: auto auto auto;
			  background-color: #2196F3;
			  padding: 10px;
			}
		</style>
		'.$pdf->nsi_box($text = '<span class="txt_judul">Neraca Koperasi Pegawai DEPSOS RI PRS Bekasi Tahun '.$_REQUEST['tahun'].' </span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';
		$html.= '<table width="100%" cellspacing="0" cellpadding="3" border="0">';
		$html.='<tr><td>';				
		$html.='<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="width:10%; vertical-align: middle; text-align:center"> No  </th>
			<th style="width:45%; vertical-align: middle; text-align:center"> Uraian  </th>
			<th style="width:45%; vertical-align: middle; text-align:center"> Aktiva  </th>
		</tr>';

		$no = 1;
		$total_aktiva = 0;
		$total_pasiva = 0;
		$data_aktiva = $data;
		$data_pasiva = $data;
		unset($data_aktiva['hutangjangkapendek'],$data_aktiva['hutangjangkapanjang'],$data_aktiva['modalsendiri']);
		foreach ($data_aktiva as $key => $r) {
			switch ($key) {
				case 'hartalancar':
					$uraian_aktiva = '<b> Harta Lancar </b>';
					break;
				case 'penyertaan':
					$uraian_aktiva = '<b> Penyertaan </b>';
					break;
				case 'hargatetap':
					$uraian_aktiva = '<b> Harga Tetap </b>';
					break;
			}
			$html .= '
			<tr>
				<td class="h_tengah">'.$no++.'</td>
				<td>'. $uraian_aktiva .'</td>
				<td></td>
			</tr>';
			foreach($r as $value){
				$total_aktiva = $total_aktiva + $value['nominal'];
				$html .= '
				<tr>
					<td></td>
					<td>'. $value['title'] .'</td>
					<td class="h_kanan">Rp. '. number_format($value['nominal']).'</td>
				</tr>';
			}
		}
		$html .= '
			<tr>
				<td style="text-align: center;" colspan="2"><b>TOTAL</b></td>
				<td class="h_kanan"><b>Rp. '. number_format($total_aktiva).'</b></td>
			</tr>';
		$html .= '</table></td>';

		$html.='<td>
			<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="width:10%; vertical-align: middle; text-align:center"> No  </th>
			<th style="width:45%; vertical-align: middle; text-align:center"> Uraian  </th>
			<th style="width:45%; vertical-align: middle; text-align:center"> Pasiva  </th>
		</tr>';
		
		unset($data_pasiva['hartalancar'],$data_pasiva['penyertaan'],$data_pasiva['hargatetap']);
		foreach ($data_pasiva as $key => $r) {
			switch ($key) {
				case 'hutangjangkapendek':
					$uraian_pasiva = '<b> Hutang Jangka Pendek </b>';
					break;
				case 'hutangjangkapanjang':
					$uraian_pasiva = '<b> Hutang Jangka Panjang </b>';
					break;
				case 'modalsendiri':
					$uraian_pasiva = '<b> Modal Sendiri </b>';
					break;
			}
			$html .= '
			<tr>
				<td class="h_tengah">'.$no++.'</td>
				<td>'. $uraian_pasiva .'</td>
				<td></td>
			</tr>';
			foreach($r as $value){
				$total_pasiva = $total_pasiva + $value['nominal'];
				$html .= '
				<tr>
					<td></td>
					<td>'. $value['title'] .'</td>
					<td class="h_kanan">Rp. '. number_format($value['nominal']).'</td>
				</tr>';
			}
		}
		$html .= '
		<tr>
			<td style="text-align: center;" colspan="2"><b>TOTAL</b></td>
			<td class="h_kanan"><b>Rp. '. number_format($total_pasiva).'</b></td>
		</tr>';
		$html.='</table></td></tr>
		</table>';
		$html .= '<br><br><br><br>
			<p class="txt_judul" style="text-align:center; font-weight: bold;"> <br>PENGURUS KOPERASI PEGAWAI PRS BEKASI <br> </p>
			<table  class="table table-borderless">
				<tr>
					<th style="border:none; width:50%; vertical-align: middle; text-align:center" Colspan="2"> KETUA </th>
					<th style="border:none; width:50%; vertical-align: middle; text-align:center" Colspan="2"> BENDAHARA </th>
				</tr>
				<tr>
					<th style="border:none; width:50%; vertical-align: middle; text-align:center" Colspan="2"> 
						<img height="100" src="assets/asset/images/ttd/ttd1.png"> 
					</th>
					<th style="border:none; width:50%; vertical-align: middle; text-align:center" Colspan="2"> 
						<img height="100" src="assets/asset/images/ttd/ttd2.jpg"> 
					</th>
				</tr>
				<tr>
					<th style="border:none; width:50%; vertical-align: middle; text-align:center" Colspan="2"> ISMAWATI </th>
					<th style="border:none; width:50%; vertical-align: middle; text-align:center" Colspan="2"> DIYAH ROCHYANI </th>
				</tr>
			</table>
		';
		$pdf->nsi_html($html);
		$pdf->Output('lap_simpan'.date('Ymd_His') . '.pdf', 'I');
	}
}