<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lapb_keuangan_shu_simpanan extends OperatorController {

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
		$this->data['judul_sub'] = 'Data SHU Simpanan';

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
		
		
		$this->data['isi'] = $this->load->view('laporan/laporan_keuangan/shu_simpanan', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}

	function ajax_list() {
		/*Default request pager params dari jeasyUI*/
		$offset = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$limit  = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$tahun = isset($_POST['tahun']) ? $_POST['tahun'] : date("Y");
		$tgl_dari = isset($_POST['tgl_dari']) ? $_POST['tgl_dari'] : '';
		$tgl_samp = isset($_POST['tgl_samp']) ? $_POST['tgl_samp'] : '';

		$search = array(
			'tgl_dari' => $tgl_dari,
			'tgl_samp' => $tgl_samp
		);
		$offset = ($offset-1)*$limit;
		$nominal_simpanan_shu = $this->getNominalShuSimpanan($tahun);
		$data   = $this->lap_simpanan_m->lap_keuangan_shu_simpanan($offset,$limit,$search,$nominal_simpanan_shu);
		$i	= 0;
		$no = 1;
		$sum_jumlah_total = 1;
		if($data){
			foreach ($data["rows"] as $r) {
				//array keys ini = attribute 'field' di view nya
				$rows[$i]['no'] = $no++;
				$rows[$i]['id_anggota'] = $r['id_anggota'];
				$rows[$i]['nama_anggota'] = $r['nama_anggota'];
				$rows[$i]['jumlah_total'] = 'Rp.'.number_format($r['jumlah_total']);
				$rows[$i]['shu'] = 'Rp.'.number_format($r['shu']);
				$i++;
			}
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('total'=>$data['count'],'rows'=>$rows);
		echo json_encode($result); //return nya json
	}

	function getNominalShuSimpanan($tahun){
		$data_nominal_shu   = $this->lap_simpanan_m->lap_keuangan_perhitungan_rugi_laba($tahun);
		$nominal_shu = 0; 
		if($data_nominal_shu){
			$total_pendapatan = 0;
			$total_pengeluaran = 0;
			foreach ($data_nominal_shu['pendapatan'] as $key => $r) {
				$total_pendapatan = $total_pendapatan + $r['jasa'];
			}
			foreach ($data_nominal_shu['pendapatanlainlain'] as $key => $r) {
				foreach($r as $value){
					$total_pendapatan = $total_pendapatan + $value['total'];
				}
			}
			foreach ($data_nominal_shu['pengeluaranbiayaumum'] as $key => $r) {
				$total_pengeluaran = $total_pengeluaran + $r['jumlah'];
			}
			$nominal_shu = $total_pendapatan - $total_pengeluaran;
		}
		$data_pembagian_shu   = $this->lap_simpanan_m->lap_keuangan_pembagian_shu($nominal_shu);
		$nominal_simpanan_shu = 0;
		if($data_pembagian_shu){
			foreach ($data_pembagian_shu['pembagianshubagiananggota'] as $key => $r) {
				if($r['nama'] == 'Simpanan Anggota'){
					$nominal_simpanan_shu = $r['jumlah'];
				}
			}
		}

		return $nominal_simpanan_shu;
	}
	function cetak() {
		$tahun = isset($_REQUEST['tahun']) ? $_REQUEST['tahun'] : date("Y");
		$tgl_dari = isset($_REQUEST['tgl_dari']) ? $_REQUEST['tgl_dari'] : '';
		$tgl_samp = isset($_REQUEST['tgl_samp']) ? $_REQUEST['tgl_samp'] : '';

		$search = array(
			'tgl_dari' => $tgl_dari,
			'tgl_samp' => $tgl_samp
		);

		$nominal_simpanan_shu = $this->getNominalShuSimpanan($tahun);
		$data   = $this->lap_simpanan_m->lap_keuangan_shu_simpanan(200,200,$search,$nominal_simpanan_shu);
		$i	= 0;
		$no = 1;
		$simpanan   = array();
		if($data){
			foreach ($data["rows"] as $r) {
				//array keys ini = attribute 'field' di view nya
				$simpanan[$i]['no'] = $no++;
				$simpanan[$i]['id_anggota'] = $r['id_anggota'];
				$simpanan[$i]['nama_anggota'] = $r['nama_anggota'];
				$simpanan[$i]['jumlah_total'] = $r['jumlah_total'];
				$simpanan[$i]['shu'] = $r['shu'];
				$i++;
			}
		}else{
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
		'.$pdf->nsi_box($text = '<span class="txt_judul">Rincian Berdasarkan Jasa Simpanan Tahun Buku '.$_REQUEST['tahun'].' </span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';
		$html.='<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="width:5%; vertical-align: middle; text-align:center"> No. </th>
			<th style="width:35%; vertical-align: middle; text-align:center"> Nama </th>
			<th style="width:30%; vertical-align: middle; text-align:center"> Jumlah Simpanan  </th>
			<th style="width:30%; vertical-align: middle; text-align:center"> SHU  </th>
		</tr>';

		$no = 1;
		$simpanan_arr = array();

		$jumlah_konsumtif = 0;
		$jumlah_berjangka = 0;
		$jumlah_barang = 0;
		$total_jumlah = 0;
		$jumlah_shu = 0;

		foreach ($simpanan as $value) {
			$total_jumlah += $value['jumlah_total'];
			$jumlah_shu += $value['shu'];

			$html .= '
			<tr>
				<td class="h_tengah">'.$no++.'</td>
				<td>'. $value['nama_anggota'].'</td>
				<td class="h_kanan">Rp. '. number_format($value['jumlah_total']).'</td>
				<td class="h_kanan">Rp. '. number_format($value['shu']).'</td>
			</tr>';
		}
		$html .= '
		<tr class="header_kolom">
			<td colspan="2" class="h_tengah"><strong>Jumlah Total</strong></td>
			<td class="h_kanan"><strong>Rp. '.number_format($total_jumlah).'</strong></td>
			<td class="h_kanan"><strong>Rp. '.number_format($jumlah_shu).'</strong></td>
		</tr>';
		$html .= '</table>';
		$pdf->nsi_html($html);
		$pdf->Output('lap_keuangan_shu_simpanan'.date('Ymd_His') . '.pdf', 'I');
	}
}