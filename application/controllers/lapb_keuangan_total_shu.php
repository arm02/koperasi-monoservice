<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lapb_keuangan_total_shu extends OperatorController {

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
		$this->data['judul_sub'] = 'Data Total SHU';

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
		$config["base_url"] = base_url() . "lapb_keuangan_total_shu/index/halaman";
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
		
		$this->data['isi'] = $this->load->view('laporan/laporan_keuangan/total_shu', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

		// $tgl_dari = isset($_POST['tgl_dari']) ? $_POST['tgl_dari'] : '';
		// $tgl_samp = isset($_POST['tgl_samp']) ? $_POST['tgl_samp'] : '';
		// $search = array(
		// 	'tgl_dari' => $tgl_dari,
		// 	'tgl_samp' => $tgl_samp
		// );
		// print_r(json_encode($this->lap_simpanan_m->lap_keuangan_shu_total(1,10,2020, 270875, 270875)));

	}

	function ajax_list() {
		/*Default request pager params dari jeasyUI*/
		$offset = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$limit  = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$tahun = isset($_POST['tahun']) ? $_POST['tahun'] : date("Y");

		$offset = ($offset-1)*$limit;
		$nominal_pinjaman_shu = $this->getNominalShuPinjaman($tahun);
		$nominal_simpanan_shu = $this->getNominalShuSimpanan($tahun);
		$data   = $this->lap_simpanan_m->lap_keuangan_shu_total($offset,$limit,$tahun,$nominal_pinjaman_shu,$nominal_simpanan_shu);

		$i	= 0;
		$no = 1;
		$sum_jumlah_total = 1;
		if($data){
			foreach ($data["rows"] as $r) {
				//array keys ini = attribute 'field' di view nya
				$rows[$i]['no'] = $no++;
				$rows[$i]['id_anggota'] = $r['id_anggota'];
				$rows[$i]['nama_anggota'] = $r['nama_anggota'];
				$rows[$i]['shu_simpanan'] = 'Rp.'.number_format($r['shu_simpanan']);
				$rows[$i]['shu_pinjaman'] = 'Rp.'.number_format($r['shu_pinjaman']);
				$rows[$i]['jumlah_total'] = 'Rp.'.number_format($r['jumlah_total']);
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

	function getNominalShuPinjaman($tahun){
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
		$nominal_pinjaman_shu = 0;
		if($data_pembagian_shu){
			foreach ($data_pembagian_shu['pembagianshubagiananggota'] as $key => $r) {
				if($r['nama'] == 'Pinjaman Anggota'){
					$nominal_pinjaman_shu = $r['jumlah'];
				}
			}
		}

		return $nominal_pinjaman_shu;
	}
	function cetak() {
		$tahun = isset($_REQUEST['tahun']) ? $_REQUEST['tahun'] : date("Y");
		$nominal_pinjaman_shu = $this->getNominalShuPinjaman($tahun);
		$nominal_simpanan_shu = $this->getNominalShuSimpanan($tahun);
		$data   = $this->lap_simpanan_m->lap_keuangan_shu_total(null,null,$tahun,$nominal_pinjaman_shu,$nominal_simpanan_shu);
		
		$i	= 0;
		$no = 1;
		$sum_jumlah_total = 1;
		$simpanan = array();
		if($data){
			foreach ($data["rows"] as $r) {
				//array keys ini = attribute 'field' di view nya
				$simpanan[$i]['no'] = $no++;
				$simpanan[$i]['nama_anggota'] = $r['nama_anggota'];
				$simpanan[$i]['shu_simpanan'] = $r['shu_simpanan'];
				$simpanan[$i]['shu_pinjaman'] = $r['shu_pinjaman'];
				$simpanan[$i]['jumlah_total'] = $r['jumlah_total'];
				$i++;
			}
		}else{
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
			.txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 15px;}
			.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
		</style>
		'.$pdf->nsi_box($text = '<span class="txt_judul">Rincian Berdasarkan Simpanan Dan Pinjaman Tahun Buku '.$_REQUEST['tahun'].' </span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';
		$html.='<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="width:5%; vertical-align: middle; text-align:center" rowspan="2"> No. </th>
			<th style="width:25%; vertical-align: middle; text-align:center" rowspan="2"> Nama </th>
			<th style="width:40%; vertical-align: middle; text-align:center" colspan="2"> SHU Berdasarkan  </th>
			<th style="width:30%; vertical-align: middle; text-align:center" rowspan="2"> Jumlah  </th>
		</tr>
		<tr class="header_kolom">
			<th style="width:20%; vertical-align: middle; text-align:center"> Simpanan  </th>
			<th style="width:20%; vertical-align: middle; text-align:center"> Pinjaman  </th>
		</tr>';

		$no = 1;
		$simpanan_arr = array();

		$jumlah_simpanan = 0;
		$jumlah_pinjaman = 0;
		$total_jumlah = 0;

		foreach ($simpanan as $value) {
			$jumlah_simpanan += $value['shu_simpanan'];
			$jumlah_pinjaman += $value['shu_pinjaman'];
			$total_jumlah += $value['jumlah_total'];

			$html .= '
			<tr>
				<td class="h_tengah">'.$no++.'</td>
				<td>'. $value['nama_anggota'].'</td>
				<td class="h_kanan">Rp. '.number_format($value['shu_simpanan']).'</td>
				<td class="h_kanan">Rp. '.number_format($value['shu_pinjaman']).'</td>
				<td class="h_kanan">Rp. '.number_format($value['jumlah_total']).'</td>
			</tr>';
		}
		$html .= '
		<tr class="header_kolom">
			<td colspan="2" class="h_tengah"><strong>Jumlah Total</strong></td>
			<td class="h_kanan"><strong>Rp. '.number_format($jumlah_simpanan).'</strong></td>
			<td class="h_kanan"><strong>Rp. '.number_format($jumlah_pinjaman).'</strong></td>
			<td class="h_kanan"><strong>Rp. '.number_format($total_jumlah).'</strong></td>
		</tr>';
		$html .= '</table>';
		$pdf->nsi_html($html);
		$pdf->Output('lap_simpan'.date('Ymd_His') . '.pdf', 'I');
	}
}