<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenis_kas extends AdminController {

	public function __construct() {
		parent::__construct();
		$this->load->helper('fungsi');
		$this->load->model('master_datakas');
	}	
	
	public function index() {
		$this->data['judul_browser'] = 'Setting';
		$this->data['judul_utama'] = 'Setting';
		$this->data['judul_sub'] = 'Data Kas';

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

		$this->data['isi'] = $this->load->view('static/data_kas', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}


	function ajax_list() {
		/*Default request pager params dari jeasyUI*/
		$offset = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$limit  = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort  = isset($_POST['sort']) ? $_POST['sort'] : 'jns_simpan';
		$order  = isset($_POST['order']) ? $_POST['order'] : 'desc';
		$nama = isset($_POST['nama']) ? $_POST['nama'] : '';
		$aktif = isset($_POST['aktif']) ? $_POST['aktif'] : '';
		$search = array('nama' => $nama,
			'aktif' => $aktif);
		$offset = ($offset-1)*$limit;
		$data   = $this->master_datakas->get_data_transaksi_ajax($offset,$limit,$search,$sort,$order);
		$i	= 0;
		$rows   = array();

		foreach ($data['data'] as $r) {

			//array keys ini = attribute 'field' di view nya

			$rows[$i]['id'] = $r->id;
			$rows[$i]['nama'] = $r->nama;
			$rows[$i]['aktif'] = $r->aktif;
			$rows[$i]['tmpl_simpan'] = $r->tmpl_simpan;
			$rows[$i]['tmpl_penarikan'] = $r->tmpl_penarikan;
			$rows[$i]['tmpl_pinjaman'] = $r->tmpl_pinjaman;
			$rows[$i]['tmpl_bayar'] = $r->tmpl_bayar;
			$rows[$i]['tmpl_pemasukan'] = $r->tmpl_pemasukan;
			$rows[$i]['tmpl_pengeluaran'] = $r->tmpl_pengeluaran;
			$rows[$i]['tmpl_transfer'] = $r->tmpl_transfer;
			// $rows[$i]['nota'] = '<p></p><p>
			// <a href="'.site_url('cetak_simpanan').'/cetak/' . $r->id . '"  title="Cetak Bukti Transaksi" target="_blank"> <i class="glyphicon glyphicon-print"></i> Nota </a></p>';
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
		if($this->master_datakas->create()){
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
		if($this->master_datakas->update($id)) {
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
		if($this->master_datakas->delete($id))
		{
			//echo 'console.log('.$id.')';
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil dihapus </div>'));
		} else {
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data gagal dihapus </div>'));
		}
	}

	function cetak_laporan() {
		$simpanan = $this->master_datakas->lap_data_kas();
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
		'.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Data Kas <br></span>', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
		<table width="100%" cellspacing="0" cellpadding="3" border="1" border-collapse= "collapse">
		<tr class="header_kolom">
			<th class="h_tengah" style="width:10%;" > No. </th>
			<th class="h_tengah" style="width:10%;"> Nama Kas</th>
			<th class="h_tengah" style="width:10%;"> Aktif </th>
			<th class="h_tengah" style="width:10%;"> Simpanan </th>
			<th class="h_tengah" style="width:10%;"> Penarikan </th>
			<th class="h_tengah" style="width:10%;"> Pinjaman </th>
			<th class="h_tengah" style="width:10%;"> Anggaran </th>
			<th class="h_tengah" style="width:10%;"> Pemasukan Kas </th>
			<th class="h_tengah" style="width:10%;"> Pengeluaran Kas </th>
			<th class="h_tengah" style="width:10%;"> Transfer Kas </th>
		</tr>';

		$no =1;
		$jml_simpanan = 0;
		foreach ($simpanan as $r) {
			// '.'AG'.sprintf('%04d', $row->anggota_id).'
			$html .= '
			<tr>
				<td class="h_tengah" >'.$no++.'</td>
				<td class="h_tengah"> '.$r->nama.'</td>
				<td class="h_tengah"> '.$r->aktif.'</td>
				<td class="h_tengah"> '.$r->tmpl_simpan.'</td>
				<td class="h_tengah"> '.$r->tmpl_penarikan.'</td>
				<td class="h_tengah"> '.$r->tmpl_pinjaman.'</td>
				<td class="h_tengah"> '.$r->tmpl_bayar.'</td>
				<td class="h_tengah"> '.$r->tmpl_pemasukan.'</td>
				<td class="h_tengah"> '.$r->tmpl_pengeluaran.'</td>
				<td class="h_tengah"> '.$r->tmpl_transfer.'</td>
			</tr>';
		}
		$html .= '</table>';
		$pdf->nsi_html($html);
		$pdf->Output('data_kas'.date('Ymd_His') . '.pdf', 'I');
	}

}
