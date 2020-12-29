<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lapb_keuangan_rugi_laba extends OperatorController {

	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('lap_simpanan_m');
		$this->load->model('m_pembagian_shu_labarugi');
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
		$this->data["pembagian_shu"] = $this->m_pembagian_shu_labarugi->get_by_type_pembagian_shu_labarugi(1);
		$this->data["pembagian_shu_anggota"] = $this->m_pembagian_shu_labarugi->get_by_type_pembagian_shu_labarugi(2);
		$this->data['isi'] = $this->load->view('laporan/laporan_keuangan/rugi_laba', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
		// print_r(json_encode($this->lap_simpanan_m->lap_keuangan_pembagian_shu(2020)));

	}

	function ajax_list_pendapatan() {
		/*Default request pager params dari jeasyUI*/
		$year = isset($_POST['tahun']) ? $_POST['tahun'] : date("Y");
		$data   = $this->lap_simpanan_m->lap_keuangan_perhitungan_rugi_laba($year);
		$i	= 0;
		$rows   = array();
		$total_pendapatan = 0;
		if($data){
			foreach ($data['pendapatan'] as $key => $r) {
				$total_pendapatan = $total_pendapatan + $r['jasa'];
				//array keys ini = attribute 'field' di view nya
				$rows[$i]['no'] = $key + 1;
				$rows[$i]['tipe'] = 'Jasa '.$r['tipe'];
				$rows[$i]['jasa'] = 'Rp. '.number_format($r['jasa']);
				$rows[$i]['jasa_nominal'] = $r['jasa'];
				$i++;
			}
		}
		$footer = array(
			array(
				'tipe' => 'Sub Total',
				'jasa' => 'Rp. '.number_format($total_pendapatan),
				'jasa_nominal' => $total_pendapatan,
			)
		);
		//keys total & rows wajib bagi jEasyUI
		$result = array('rows'=>$rows,'footer'=> $footer);
		echo json_encode($result); //return nya json
	}
	function ajax_list_pendapatan_lain_lain() {
		/*Default request pager params dari jeasyUI*/
		$year = isset($_POST['tahun']) ? $_POST['tahun'] : date("Y");
		$data   = $this->lap_simpanan_m->lap_keuangan_perhitungan_rugi_laba($year);
		$i	= 0;
		$no	= 1;
		$rows   = array();
		$total_pendapatan = 0;
		if($data){
			foreach ($data['pendapatanlainlain'] as $key => $r) {
				$nominal = 0;
				foreach($r as $value){
					$nominal = $nominal + $value['total'];
					$total_pendapatan = $total_pendapatan + $value['total'];
				}
				$tipe = ucwords(str_replace("_"," ",$key));
				//array keys ini = attribute 'field' di view nya
				$rows[$i]['no'] = $no++;
				$rows[$i]['tipe'] = $tipe;
				$rows[$i]['jasa'] = 'Rp. '.number_format($nominal);
				$rows[$i]['jasa_nominal'] = $nominal;
				$i++;
			}
		}
		$footer = array(
			array(
				'tipe' => 'Sub Total',
				'jasa' => 'Rp. '.number_format($total_pendapatan),
				'jasa_nominal' => $total_pendapatan,
			)
		);
		//keys total & rows wajib bagi jEasyUI
		$result = array('rows'=>$rows,'footer'=> $footer);
		echo json_encode($result); //return nya json
	}
	function ajax_list_pengeluaran() {
		/*Default request pager params dari jeasyUI*/
		$year = isset($_POST['tahun']) ? $_POST['tahun'] : date("Y");
		$data   = $this->lap_simpanan_m->lap_keuangan_perhitungan_rugi_laba($year);
		$i	= 0;
		$no	= 1;
		$rows   = array();
		$total_pengeluaran = 0;
		if($data){
			foreach ($data['pengeluaranbiayaumum'] as $key => $r) {
				$total_pengeluaran = $total_pengeluaran + $r['jumlah'];
				//array keys ini = attribute 'field' di view nya
				$rows[$i]['no'] = $no++;
				$rows[$i]['tipe'] = $r['uraian'];
				$rows[$i]['jasa'] = 'Rp. '.number_format($r['jumlah']);
				$rows[$i]['jasa_nominal'] = $r['jumlah'];
				$i++;
			}
		}
		$footer = array(
			array(
				'tipe' => 'Sub Total',
				'jasa' => 'Rp. '.number_format($total_pengeluaran),
				'jasa_nominal' => $total_pengeluaran,
			)
		);
		//keys total & rows wajib bagi jEasyUI
		$result = array('rows'=>$rows,'footer'=> $footer);
		echo json_encode($result); //return nya json
	}

	function ajax_list_pembagian_shu() {
		/*Default request pager params dari jeasyUI*/
		$nominal = isset($_POST['nominal']) ? $_POST['nominal'] : 0;
		$data   = $this->lap_simpanan_m->lap_keuangan_pembagian_shu($nominal);
		
		$i	= 0;
		$no	= 1;
		$rows   = array();
		$total = 0;
		if($data){
			foreach ($data['pembagiansisahasilusaha'] as $key => $r) {
				$total = $total + $r['jumlah'];
				//array keys ini = attribute 'field' di view nya
				$rows[$i]['no'] = $no++;
				$rows[$i]['tipe'] = $r['nama'];
				$rows[$i]['persentase'] = $r['persentase'].'%';
				$rows[$i]['jasa'] = 'Rp. '.number_format($r['jumlah']);
				$i++;
			}
		}
		$footer = array(
			array(
				'tipe' => 'Jumlah',
				'jasa' => 'Rp. '.number_format($total),
			)
		);
		//keys total & rows wajib bagi jEasyUI
		$result = array('rows'=>$rows,'footer'=> $footer);
		echo json_encode($result); //return nya json
	}

	function ajax_list_pembagian_shu_anggota() {
		/*Default request pager params dari jeasyUI*/
		$nominal = isset($_POST['nominal']) ? $_POST['nominal'] : 0;
		$data   = $this->lap_simpanan_m->lap_keuangan_pembagian_shu($nominal);
		
		$i	= 0;
		$no	= 1;
		$rows   = array();
		$total = 0;
		if($data){
			foreach ($data['pembagianshubagiananggota'] as $key => $r) {
				$total = $total + $r['jumlah'];
				//array keys ini = attribute 'field' di view nya
				$rows[$i]['no'] = $no++;
				$rows[$i]['tipe'] = $r['nama'];
				$rows[$i]['persentase'] = $r['persentase'].'%';
				$rows[$i]['jasa'] = 'Rp. '.number_format($r['jumlah']);
				$i++;
			}
		}
		$footer = array(
			array(
				'tipe' => 'Jumlah',
				'jasa' => 'Rp. '.number_format($total),
			)
		);
		//keys total & rows wajib bagi jEasyUI
		$result = array('rows'=>$rows,'footer'=> $footer);
		echo json_encode($result); //return nya json
	}

	function cetak() {
		$year = isset($_REQUEST['tahun']) ? $_REQUEST['tahun'] : date("Y");
		$nominal = isset($_REQUEST['nominal']) ? $_REQUEST['nominal'] : 0;
		$data_perhitungan   = $this->lap_simpanan_m->lap_keuangan_perhitungan_rugi_laba($year);

		$i	= 0;
		$total_pendapatan = 0;
		$total_pendapatan_lain_lain = 0;
		$total_pengeluaran = 0;
		$html = "";

		if($data_perhitungan == FALSE) {
			echo 'DATA KOSONG';
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
			.txt_judul {font-size: 12pt; font-weight: bold;}
			.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
		</style>
		'.$pdf->nsi_box($text = '<span class="txt_judul">Rekapitulasi Laba Rugi Tahun '.$_REQUEST['tahun'].' </span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';
		$html.='<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="width:100%; vertical-align: middle; text-align:left" colspan="2"> Pendapatan </th>
		</tr>';

		// PENDAPATAN
		if($data_perhitungan){
			foreach ($data_perhitungan['pendapatan'] as $key => $r) {
						// <td class="h_tengah">'.$no++.'</td>
				$html .= '
					<tr>
						<td> Jasa '.$r['tipe'].'</td>
						<td class="h_kanan"> Rp. '. number_format($r['jasa']).'</td>
					</tr>';
				$total_pendapatan = $total_pendapatan + $r['jasa'];
			}
			$html .= '
			<tr>
				<td> Sub Total </td>
				<td class="h_kanan"> Rp. '. number_format($total_pendapatan).'</td>
			</tr>';
		}
		$html .= '</table>';

		$html.='<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="width:100%; vertical-align: middle; text-align:left" colspan="2"> Pendapatan Lain-Lain</th>
		</tr>';
		// END PENDAPATAN

		// PENDAPATAN LAIN LAIN
		foreach ($data_perhitungan['pendapatanlainlain'] as $key => $r) {
			$nominal_lain_lain = 0;
			$tipe = ucwords(str_replace("_"," ",$key));
			foreach($r as $value){
				$nominal_lain_lain = $nominal_lain_lain + $value['total'];
				$total_pendapatan_lain_lain = $total_pendapatan_lain_lain + $value['total'];
			}
					// <td class="h_tengah">'.$no++.'</td>
			$html .= '
				<tr>
					<td> Jasa '.$tipe.'</td>
					<td class="h_kanan"> Rp. '. number_format($nominal_lain_lain).'</td>
				</tr>';
		}
		$html .= '
		<tr>
			<td> Sub Total </td>
			<td class="h_kanan"> Rp. '. number_format($total_pendapatan_lain_lain).'</td>
		</tr>';

		// TOTAL PENDAPATAN
		$html .= '
		<tr>
			<td style="text-align: center"> Total Pendapatan </td>
			<td class="h_kanan"> <b> Rp. '. number_format($total_pendapatan + $total_pendapatan_lain_lain).'</b></td>
		</tr>';
		$html .= '</table> <br/> <br/>';
		// END PENDAPATAN LAIN LAIN

		// PENGELUARAN
		$html.='<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="width:100%; vertical-align: middle; text-align:left" colspan="2"> Pengeluaran </th>
		</tr>';
		foreach ($data_perhitungan['pengeluaranbiayaumum'] as $key => $r) {
			$total_pengeluaran = $total_pengeluaran + $r['jumlah'];
			$html .= '
				<tr>
					<td> Jasa '.$r['uraian'].'</td>
					<td class="h_kanan"> Rp. '. number_format($r['jumlah']).'</td>
				</tr>';
		}
		$html .= '
		<tr>
			<td> Sub Total </td>
			<td class="h_kanan"> Rp. '. number_format($total_pendapatan_lain_lain).'</td>
		</tr>';

		// TOTAL PENGELUARAN
		$html .= '
		<tr>
			<td style="text-align: center"> Total Pengeluaran </td>
			<td class="h_kanan"> <b> Rp. '. number_format($total_pengeluaran).'</b></td>
		</tr>';

		$html .= '
		<tr>
			<td style="text-align: center"> SHU TAHUN BUKU '.$year.' </td>
			<td class="h_kanan"> <b> Rp. '. number_format(($total_pendapatan + $total_pendapatan_lain_lain) - $total_pengeluaran).'</b></td>
		</tr>';
		$html .= '</table>';
		// END PENGELUARAN

		$html .= '
			<p style="padding-right:90px; text-align:right; font-size: 12pt;"> <br>Bekasi, '.date('d F').' <label class="year">'.$year.'</label>  <br> </p>
			<p style="padding-bottom:20px; text-align:center; font-size: 15pt; font-weight: bold;"> <br>PENGURUS KOPERASI PEGAWAI PRS BEKASI <br> </p>
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

			<p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p>
			<p style="text-align:center; font-size: 15pt; font-weight: bold;top: 1000"> PEMBAGIAN SHU TAHUN BUKU <label class="year">'.$year.'</label> </p>
		';

		$nominal = ($total_pendapatan + $total_pendapatan_lain_lain) - $total_pengeluaran;
		$data_pembagian_shu  = $this->lap_simpanan_m->lap_keuangan_pembagian_shu($nominal);

		// PEMBAGIAN SHU
		$html.='<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="width:100%; vertical-align: middle; text-align:left" colspan="3"> Perincian Pembagian Sisa Hasil Usaha ( SHU ) </th>
		</tr>';

		$total_pembagian_shu = 0;
		if($data_pembagian_shu){
			foreach ($data_pembagian_shu['pembagiansisahasilusaha'] as $key => $r) {
				$html .= '
					<tr>
						<td>'.$r['nama'].'</td>
						<td>'.$r['persentase'].'%</td>
						<td class="h_kanan"> Rp. '. number_format($r['jumlah']).'</td>
					</tr>';
				$total_pembagian_shu = $total_pembagian_shu + $r['jumlah'];
			}
			$html .= '
					<tr>
						<td colspan="2" class="h_tengah"> Jumlah</td>
						<td class="h_kanan"><b> Rp. '. number_format($total_pembagian_shu).'</b></td>
					</tr>';
		}else{
			echo 'DATA KOSONG';
			exit();
		}
		$html .= '</table>';
		// END PEMBAGIAN SHU


		$html.='<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="width:100%; vertical-align: middle; text-align:left" colspan="3"> PEMBAGIAN SHU BAGIAN ANGGOTA BERDASARKAN : </th>
		</tr>';
		$total_pembagian_anggota = 0;
		foreach ($data_pembagian_shu['pembagianshubagiananggota'] as $key => $r) {
			$html .= '
				<tr>
					<td>'.$r['nama'].'</td>
					<td>'.$r['persentase'].'%</td>
					<td class="h_kanan"> Rp. '. number_format($r['jumlah']).'</td>
				</tr>';
			$total_pembagian_anggota = $total_pembagian_anggota + $r['jumlah'];
		}
		$html .= '
				<tr>
					<td colspan="2" class="h_tengah"> Jumlah </td>
					<td class="h_kanan"><b> Rp. '. number_format($total_pembagian_anggota).'</b></td>
				</tr>';
		$html .= '</table>';

		$html .= '
			<p style="padding-right:90px; text-align:right; font-size: 12pt;"> <br>Bekasi, '.date('d F').' <label class="year">'.$year.'</label>  <br> </p>
			<p style="padding-bottom:20px; text-align:center; font-size: 15pt; font-weight: bold;"> <br>PENGURUS KOPERASI PEGAWAI PRS BEKASI <br> </p>
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
		// END PEMBAGIAN SHU
		$pdf->nsi_html($html);
		$pdf->Output('lapb_keuangan_rugi_laba_'.date('d-F-y') . '.pdf', 'I');
		$pdf->Output('lapb_keuangan_rugi_laba_'.date('Ymd_His') . '.pdf', 'I');
	}
}