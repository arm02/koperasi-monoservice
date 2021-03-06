<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lapb_koperasi_piutang extends OperatorController {

	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('lap_simpanan_m');
		$this->load->model('m_lap_koperasi_piutang');
	}	

	public function index() {
		$this->load->library("pagination");

		$this->data['judul_browser'] = 'Laporan';
		$this->data['judul_utama'] = 'Laporan';
		$this->data['judul_sub'] = 'Data Piutang';

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
		
		$this->data['isi'] = $this->load->view('laporan/laporan_koperasi/piutang', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}

	function ajax_list() {
		/*Default request pager params dari jeasyUI*/
		$offset = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$limit  = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? $_POST['sort'] : 'nama_anggota';
		$tahun = isset($_POST['tahun']) ? $_POST['tahun'] : date("Y");

		$offset = ($offset-1)*$limit;
		$data   = $this->m_lap_koperasi_piutang->get_data_db_ajax($offset,$limit,$sort,"",$tahun);
		$i	= 0;
		$rows   = array();
		if($data){
			foreach ($data["data"] as $r) {
				//array keys ini = attribute 'field' di view nya
				$jumlah = $r->pinjaman_konsumtif + $r->pinjaman_berjangka + $r->pinjaman_barang;

				$rows[$i]['no'] = $i+1;
				$rows[$i]['nama_anggota'] = $r->nama_anggota;
				$rows[$i]['pinjaman_konsumtif'] = 'Rp.'.number_format($r->pinjaman_konsumtif);
				$rows[$i]['pinjaman_berjangka'] = 'Rp.'.number_format($r->pinjaman_berjangka);
				$rows[$i]['pinjaman_barang'] = 'Rp.'.number_format($r->pinjaman_barang);
				$rows[$i]['jumlah_total'] = 'Rp.'.number_format($jumlah);
				$i++;
			}
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('total'=>$data['count'],'rows'=>$rows);
		echo json_encode($result); //return nya json
	}

	function cetak() {
		$simpanan = array(
			array(
				"nama" => 'Alimin',
				"konsumtif" => 550000,
				"berjangka" => 0,
				"barang" => 0,
				"shu" => 73100,
			),
		);
		$tahun = isset($_REQUEST['tahun']) ? $_REQUEST['tahun'] : date("Y");
		$sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'nama_anggota';
		$data   = $this->m_lap_koperasi_piutang->get_data_db_ajax(null,null,$sort,"",$tahun);

		if($data == FALSE) {
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
		'.$pdf->nsi_box($text = '<span class="txt_judul">Rincian Berdasarkan Jasa Pinjaman Periode '.$tgl_periode_txt.' </span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';
		$html.='<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="width:5%; vertical-align: middle; text-align:center" rowspan="2"> No. </th>
			<th style="width:15%; vertical-align: middle; text-align:center" rowspan="2"> Nama </th>
			<th style="width:60%; vertical-align: middle; text-align:center" colspan="3"> Jasa Pinjaman  </th>
			<th style="width:20%; vertical-align: middle; text-align:center" rowspan="2"> Jumlah  </th>
		</tr>
		<tr class="header_kolom">
			<th style="width:20%; vertical-align: middle; text-align:center"> Konsumtif  </th>
			<th style="width:20%; vertical-align: middle; text-align:center"> Berjangka  </th>
			<th style="width:20%; vertical-align: middle; text-align:center"> Barang  </th>
		</tr>';

		$no = 1;
		$simpanan_arr = array();

		$jumlah_konsumtif = 0;
		$jumlah_berjangka = 0;
		$jumlah_barang = 0;
		$total_jumlah = 0;

		foreach ($data['data'] as $value) {
			$jumlah = $value->pinjaman_konsumtif + $value->pinjaman_berjangka + $value->pinjaman_barang;
			$jumlah_konsumtif += $value->pinjaman_konsumtif;
			$jumlah_berjangka += $value->pinjaman_berjangka;
			$jumlah_barang += $value->pinjaman_barang;
			$total_jumlah += $jumlah;

			$html .= '
			<tr>
				<td class="h_tengah">'.$no++.'</td>
				<td>'. $value->nama_anggota.'</td>
				<td class="h_kanan">Rp. '. number_format($value->pinjaman_konsumtif).'</td>
				<td class="h_kanan">Rp. '. number_format($value->pinjaman_berjangka).'</td>
				<td class="h_kanan">Rp. '. number_format($value->pinjaman_barang).'</td>
				<td class="h_kanan">Rp. '. number_format($jumlah).'</td>
			</tr>';
		}
		$html .= '
		<tr class="header_kolom">
			<td colspan="2" class="h_tengah"><strong>Jumlah Total</strong></td>
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