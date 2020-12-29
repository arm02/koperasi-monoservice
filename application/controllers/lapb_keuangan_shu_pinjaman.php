<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lapb_keuangan_shu_pinjaman extends OperatorController {

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
		$this->data['judul_sub'] = 'Data SHU Pinjaman';

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
		$config["base_url"] = base_url() . "lapb_keuangan_shu_pinjaman/index/halaman";
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
		
		$this->data['isi'] = $this->load->view('laporan/laporan_keuangan/shu_pinjaman', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
		// $tgl_dari = isset($_POST['tgl_dari']) ? $_POST['tgl_dari'] : '';
		// $tgl_samp = isset($_POST['tgl_samp']) ? $_POST['tgl_samp'] : '';
		// $search = array(
		// 	'tgl_dari' => $tgl_dari,
		// 	'tgl_samp' => $tgl_samp
		// );
		// print_r(json_encode($this->lap_simpanan_m->lap_keuangan_shu_pinjaman(1,10,$search, 270875)));

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
		$nominal_pinjaman_shu = $this->getNominalShuPinjaman($tahun);
		$data   = $this->lap_simpanan_m->lap_keuangan_shu_pinjaman($offset,$limit,$search,$nominal_pinjaman_shu);
		$i	= 0;
		$no = 1;
		$rows   = array();
		if($data){
			foreach ($data["rows"] as $r) {
				//array keys ini = attribute 'field' di view nya
				$rows[$i]['no'] = $no++;
				$rows[$i]['id_anggota'] = $r['id_anggota'];
				$rows[$i]['nama_anggota'] = $r['nama_anggota'];
				$rows[$i]['pinjaman_konsumtif'] = 'Rp.'.number_format($r['Pinjaman Konsumtif']);
				$rows[$i]['pinjaman_berjangka'] = 'Rp.'.number_format($r['Pinjaman Berjangka']);
				$rows[$i]['pinjaman_barang'] = 'Rp.'.number_format($r['Pinjaman Barang']);
				$rows[$i]['jumlah_total'] = 'Rp.'.number_format($r['jumlah_total']);
				$rows[$i]['shu'] = 'Rp.'.number_format($r['shu']);
				$i++;
			}
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('total'=>$data['count'],'rows'=>$rows);
		echo json_encode($result); //return nya json
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
		$tgl_dari = isset($_REQUEST['tgl_dari']) ? $_REQUEST['tgl_dari'] : '';
		$tgl_samp = isset($_REQUEST['tgl_samp']) ? $_REQUEST['tgl_samp'] : '';

		$search = array(
			'tgl_dari' => $tgl_dari,
			'tgl_samp' => $tgl_samp
		);

		$nominal_pinjaman_shu = $this->getNominalShuPinjaman($tahun);
		$data   = $this->lap_simpanan_m->lap_keuangan_shu_pinjaman(200,200,$search,$nominal_pinjaman_shu);
		$i	= 0;
		$no = 1;
		$rows   = array();
		if($data){
			foreach ($data["rows"] as $r) {
				//array keys ini = attribute 'field' di view nya
				$simpanan[$i]['no'] = $no++;
				$simpanan[$i]['id_anggota'] = $r['id_anggota'];
				$simpanan[$i]['nama_anggota'] = $r['nama_anggota'];
				$simpanan[$i]['pinjaman_konsumtif'] = $r['Pinjaman Konsumtif'];
				$simpanan[$i]['pinjaman_berjangka'] = $r['Pinjaman Berjangka'];
				$simpanan[$i]['pinjaman_barang'] = $r['Pinjaman Barang'];
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
		'.$pdf->nsi_box($text = '<span class="txt_judul">Rincian Berdasarkan Jasa Pinjaman Tahun Buku '.$_REQUEST['tahun'].' </span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';
		$html.='<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="width:5%; vertical-align: middle; text-align:center" rowspan="2"> No. </th>
			<th style="width:15%; vertical-align: middle; text-align:center" rowspan="2"> Nama </th>
			<th style="width:60%; vertical-align: middle; text-align:center" colspan="4"> Jasa Pinjaman  </th>
			<th style="width:20%; vertical-align: middle; text-align:center" rowspan="2"> SHU  </th>
		</tr>
		<tr class="header_kolom">
			<th style="width:15%; vertical-align: middle; text-align:center"> Konsumtif  </th>
			<th style="width:15%; vertical-align: middle; text-align:center"> Berjangka  </th>
			<th style="width:15%; vertical-align: middle; text-align:center"> Barang  </th>
			<th style="width:15%; vertical-align: middle; text-align:center"> Jumlah  </th>
		</tr>';

		$no = 1;
		$simpanan_arr = array();

		$jumlah_konsumtif = 0;
		$jumlah_berjangka = 0;
		$jumlah_barang = 0;
		$total_jumlah = 0;
		$jumlah_shu = 0;

		foreach ($simpanan as $value) {
			$jumlah_konsumtif += $value['pinjaman_konsumtif'];
			$jumlah_berjangka += $value['pinjaman_berjangka'];
			$jumlah_barang += $value['pinjaman_barang'];
			$total_jumlah += $value['jumlah_total'];
			$jumlah_shu += $value['shu'];

			$html .= '
			<tr>
				<td class="h_tengah">'.$no++.'</td>
				<td>'. $value['nama_anggota'].'</td>
				<td class="h_kanan">Rp. '. number_format($value['pinjaman_konsumtif']).'</td>
				<td class="h_kanan">Rp. '. number_format($value['pinjaman_berjangka']).'</td>
				<td class="h_kanan">Rp. '. number_format($value['pinjaman_barang']).'</td>
				<td class="h_kanan">Rp. '. number_format($value['jumlah_total']).'</td>
				<td class="h_kanan">Rp. '. number_format($value['shu']).'</td>
			</tr>';
		}
		$html .= '
		<tr class="header_kolom">
			<td colspan="2" class="h_tengah"><strong>Jumlah Total</strong></td>
			<td class="h_kanan"><strong>Rp. '.number_format($jumlah_konsumtif).'</strong></td>
			<td class="h_kanan"><strong>Rp. '.number_format($jumlah_berjangka).'</strong></td>
			<td class="h_kanan"><strong>Rp. '.number_format($jumlah_barang).'</strong></td>
			<td class="h_kanan"><strong>Rp. '.number_format($total_jumlah).'</strong></td>
			<td class="h_kanan"><strong>Rp. '.number_format($jumlah_shu).'</strong></td>
		</tr>';
		$html .= '</table>';
		$pdf->nsi_html($html);
		$pdf->Output('lap_keuangan_shu_pinjaman'.date('Ymd_His') . '.pdf', 'I');
	}
}