<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Biaya_umum extends OperatorController {

	public function __construct() {
		parent::__construct();
		$this->load->helper('fungsi');
		$this->load->model('biaya_umum_m');
		$this->load->model('pinjaman_m');
		$this->load->model('pemasukan_m');
	}	

	public function index() {
		$this->data['judul_browser'] = 'Setting';
		$this->data['judul_utama'] = 'Setting';
		$this->data['judul_sub'] = 'Biaya Umum';

		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';

		#include tanggal
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';

		#include daterange
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';

		//number_format
		$this->data['js_files'][] = base_url() . 'assets/extra/fungsi/number_format.js';
		$this->data['kas_id'] = $this->pinjaman_m->get_data_kas();
		$this->data['akun_id'] = $this->pemasukan_m->get_data_akun();

		$this->data['isi'] = $this->load->view('static/biaya_umum', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}


	function ajax_list() {
		/*Default request pager params dari jeasyUI*/
		$offset = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$limit  = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort  = isset($_POST['sort']) ? $_POST['sort'] : 'uraian';
		$order  = isset($_POST['order']) ? $_POST['order'] : 'desc';
		$uraian = isset($_POST['uraian']) ? $_POST['uraian'] : '';
		$untuk_kas = isset($_POST['untuk_kas']) ? $_POST['untuk_kas'] : '';
		$dari_akun = isset($_POST['dari_akun']) ? $_POST['dari_akun'] : '';
		$search = array(
			'uraian' => $uraian,
			'untuk_kas' => $untuk_kas,
			'dari_akun' => $dari_akun,
		);
		$offset = ($offset-1)*$limit;
		$data   = $this->biaya_umum_m->get_data_transaksi_ajax($offset,$limit,$search,$sort,$order);
		$kas_id = $this->pinjaman_m->get_data_kas();
		$akun_id = $this->pemasukan_m->get_data_akun();
		$i	= 0;
		$no	= 0;
		$rows   = array();

		foreach ($data['data'] as $r) {
			$kas = "";
			$akun = "";
			//array keys ini = attribute 'field' di view nya
			foreach($kas_id as $kas_value){
				if($kas_value->id == $r->untuk_kas){
					$kas = $kas_value->nama;
				}	
			}

			foreach($akun_id as $akun_value){
				if($akun_value->id == $r->dari_akun){
					$akun = $akun_value->jns_trans;
				}	
			}
			$rows[$i]['id'] = $r->id;
			$rows[$i]['no'] = $no++;
			$rows[$i]['tanggal'] = $r->tanggal;
			$rows[$i]['uraian'] = $r->uraian;
			$rows[$i]['untuk_kas'] = $r->untuk_kas;
			$rows[$i]['untuk_kas_nama'] = $kas;
			$rows[$i]['dari_akun'] = $r->dari_akun;
			$rows[$i]['dari_akun_nama'] = $akun;
			$rows[$i]['jumlah'] = number_format($r->jumlah);
			$i++;
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('total'=>$data['count'],'rows'=>$rows);
		echo json_encode($result); //return nya json
	}

	public function create() {
		if(!isset($_POST)) {
			show_404();
		}
		if($this->biaya_umum_m->create()){
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil disimpan </div>'));
		}else
		{
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Gagal menyimpan data, pastikan nilai lebih dari <strong>0 (NOL)</strong>. </div>'));
		}
	}

	public function update($id=null) {
		if(!isset($_POST)) {
			show_404();
		}
		if($this->biaya_umum_m->update($id)) {
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil diubah </div>'));
		} else {
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i>  Maaf, Data gagal diubah, pastikan nilai lebih dari <strong>0 (NOL)</strong>. </div>'));
		}

	}
	public function delete() {
		if(!isset($_POST))	 {
			show_404();
		}
		$id = intval(addslashes($_POST['id']));
		if($this->biaya_umum_m->delete($id))
		{
			//echo 'console.log('.$id.')';
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil dihapus </div>'));
		} else {
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data gagal dihapus </div>'));
		}
	}

	function cetak_laporan() {
		$simpanan = $this->biaya_umum_m->lap_data_biaya_umum();
		if($simpanan == FALSE) {
			//redirect('simpanan');
			echo 'DATA KOSONG<br>Pastikan Filter Tanggal dengan benar.';
			exit();
		}

		$this->load->library('Pdf');
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->set_nsi_header(TRUE);
		$pdf->AddPage('L');
		$html = '';
		$html .= '
		<style>
			.h_tengah {text-align: center;}
			.h_kiri {text-align: left;}
			.h_kanan {text-align: right;}
			.txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 12px;}
			.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
			.txt_content {font-size: 10pt; font-style: arial;}
		</style>
		'.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Data Jenis Pinjaman <br></span>', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
		<table width="100%" cellspacing="0" cellpadding="3" border="1" border-collapse= "collapse">
		<tr class="header_kolom">
			<th class="h_tengah" style="width:10%;" > No. </th>
			<th class="h_tengah" style="width:90%;"> Nama Barang</th>
		</tr>';

		$no =1;
		foreach ($simpanan as $r) {
			// '.'AG'.sprintf('%04d', $row->anggota_id).'
			$html .= '
			<tr>
				<td class="h_tengah" >'.$no++.'</td>
				<td class="h_tengah"> '.$r->uraian.'</td>
				<td class="h_tengah"> '.$r->tanggal.'</td>
				<td class="h_tengah"> '.$r->kas.'</td>
				<td class="h_tengah"> '.$r->akun.'</td>
				<td class="h_tengah"> '.$r->jumlah.'</td>
			</tr>';
		}
		$html .= '</table>';
		$pdf->nsi_html($html);
		$pdf->Output('data_barang'.date('Ymd_His') . '.pdf', 'I');
	}
}
