<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenis_akun extends AdminController {

	public function __construct() {
		parent::__construct();
		$this->load->helper('fungsi');
		$this->load->model('master_jnsAkun');
	}

	public function indexs() {
		$this->data['judul_browser'] = 'Setting';
		$this->data['judul_utama'] = 'Setting';
		$this->data['judul_sub'] = 'Jenis Akun Transaksi';

		$this->output->set_template('gc');

		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_table('jns_akun');
		$crud->set_subject('Jenis Akun Transaksi');

		//$crud->fields('jns_trans','pemasukan','pengeluaran','aktif');
		$crud->fields('kd_aktiva','jns_trans', 'akun', 'pemasukan', 'pengeluaran', 'aktif', 'laba_rugi');
		$crud->columns('kd_aktiva','jns_trans', 'akun', 'pemasukan', 'pengeluaran', 'aktif', 'laba_rugi');

		$crud->required_fields('kd_aktiva','jns_trans', 'akun', 'pemasukan', 'pengeluaran', 'aktif');
		$crud->display_as('jns_trans','Jenis Transaksi');
		$this->db->_protect_identifiers = FALSE;
		$crud->order_by('LPAD(kd_aktiva, 1, 0) ASC, LPAD(kd_aktiva, 5, 1)', 'ASC');
		//$this->db->_protect_identifiers = TRUE;

		$crud->unset_read();
		//$crud->unset_add();
		$crud->unset_delete();
		$output = $crud->render();

		$out['output'] = $this->data['judul_browser'];
		$this->load->section('judul_browser', 'default_v', $out);
		$out['output'] = $this->data['judul_utama'];
		$this->load->section('judul_utama', 'default_v', $out);
		$out['output'] = $this->data['judul_sub'];
		$this->load->section('judul_sub', 'default_v', $out);
		$out['output'] = $this->data['u_name'];
		$this->load->section('u_name', 'default_v', $out);

		$this->load->view('default_v', $output);


	}

	public function index() {
		$this->data['judul_browser'] = 'Setting';
		$this->data['judul_utama'] = 'Setting';
		$this->data['judul_sub'] = 'Jenis Akun Transaksi';

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

		$this->data['isi'] = $this->load->view('static/jenis_akun', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}


	function ajax_list() {
		/*Default request pager params dari jeasyUI*/
		$offset = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$limit  = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

		$sort  = isset($_POST['sort']) ? $_POST['sort'] : 'jns_trans';
		$order  = isset($_POST['order']) ? $_POST['order'] : 'desc';
		$jns_trans = isset($_POST['jns_trans']) ? $_POST['jns_trans'] : '';
		$akun = isset($_POST['akuns']) ? $_POST['akuns'] : '';
		$search = array('jns_trans' => $jns_trans,
			'akun' => $akun);
		$offset = ($offset-1)*$limit;
		$data   = $this->master_jnsAkun->get_data_transaksi_ajax($offset,$limit,$search,$sort,$order);
		$i	= 0;
		$rows   = array();

		foreach ($data['data'] as $r) {

			//array keys ini = attribute 'field' di view nya

			$rows[$i]['id'] = $r->id;
			$rows[$i]['kd_aktiva'] = $r->kd_aktiva;
			$rows[$i]['jns_trans'] = $r->jns_trans;
			$rows[$i]['akun'] = $r->akun;
			$rows[$i]['pemasukan'] = $r->pemasukan;
			$rows[$i]['pengeluaran'] = $r->pengeluaran;
			$rows[$i]['pemasukan'] = $r->pemasukan;
			$rows[$i]['aktif'] = $r->aktif;
			$rows[$i]['laba_rugi'] = $r->laba_rugi;
			// $rows[$i]['nota'] = '<p></p><p>
			// <a href="'.site_url('cetak_simpanan').'/cetak/' . $r->id . '"  title="Cetak Bukti Transaksi" target="_blank"> <i class="glyphicon glyphicon-print"></i> Nota </a></p>';
			$i++;
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('total'=>$data['count'],'rows'=>$rows);
		echo json_encode($result); //return nya json
	}


	function get_all_data_akun() {
		/*Default request pager params dari jeasyUI*/
		$data = $this->master_jnsAkun->get_all_data_akun();

		echo json_encode($data); //return nya json
	}

	public function create() {
		if(!isset($_POST)) {
			show_404();
		}
		if($this->master_jnsAkun->create()){
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
		if($this->master_jnsAkun->update($id)) {
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
		if($this->master_jnsAkun->delete($id))
		{
			//echo 'console.log('.$id.')';
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil dihapus </div>'));
		} else {
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data gagal dihapus </div>'));
		}
	}

	function cetak_laporan() {
		$simpanan = $this->master_jnsAkun->lap_data_jns_akun();
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
		'.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Data Jenis Akun Transaksi <br></span>', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
		<table width="100%" cellspacing="0" cellpadding="3" border="1" border-collapse= "collapse">
		<tr class="header_kolom">
			<th class="h_tengah" style="width:10%;" > No. </th>
			<th class="h_tengah" style="width:30%;"> KD Aktiva</th>
			<th class="h_tengah" style="width:30%;"> Jenis Transaksi </th>
			<th class="h_tengah" style="width:30%;"> Akun </th>
			<th class="h_tengah" style="width:30%;"> Pemasukan </th>
			<th class="h_tengah" style="width:30%;"> Pengeluaran </th>
			<th class="h_tengah" style="width:30%;"> Aktif </th>
			<th class="h_tengah" style="width:30%;"> Laba Rugi </th>
		</tr>';

		$no =1;
		$jml_simpanan = 0;
		foreach ($simpanan as $r) {
			// '.'AG'.sprintf('%04d', $row->anggota_id).'
			$html .= '
			<tr>
				<td class="h_tengah" >'.$no++.'</td>
				<td class="h_tengah"> '.$r->kd_aktiva.'</td>
				<td class="h_tengah"> '.$r->jns_trans.'</td>
				<td class="h_tengah"> '.$r->akun.'</td>
				<td class="h_tengah"> '.$r->pemasukan.'</td>
				<td class="h_tengah"> '.$r->pengeluaran.'</td>
				<td class="h_tengah"> '.$r->aktif.'</td>
				<td class="h_tengah"> '.$r->laba_rugi.'</td>
			</tr>';
		}
		$html .= '</table>';
		$pdf->nsi_html($html);
		$pdf->Output('jenis_akub_transaksi'.date('Ymd_His') . '.pdf', 'I');
	}
}
