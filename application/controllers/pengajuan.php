<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengajuan extends OPPController {
	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('general_m');
	}	

	public function index() {
		$this->load->model('pinjaman_m');
		$this->data['judul_browser'] = 'Pengajuan Pinjaman';
		$this->data['judul_utama'] = 'Pengajuan';
		$this->data['judul_sub'] = 'Pinjaman';

		//table
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap-table/bootstrap-table.min.css';
		$this->data['js_files2'][] = base_url() . 'assets/extra/bootstrap-table/bootstrap-table.min.js';
		$this->data['js_files2'][] = base_url() . 'assets/extra/bootstrap-table/extensions/filter-control/bootstrap-table-filter-control.min.js';
		$this->data['js_files2'][] = base_url() . 'assets/extra/bootstrap-table/bootstrap-table-id-ID.js';

		//modal
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap-modal/css/bootstrap-modal-bs3patch.css';
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap-modal/css/bootstrap-modal.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap-modal/js/bootstrap-modalmanager.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap-modal/js/bootstrap-modal.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap-modal/js/nsi_modal_default.js';

		// datepicker
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/datepicker/datepicker3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/datepicker/bootstrap-datepicker.js';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/datepicker/locales/bootstrap-datepicker.id.js';
		//$this->data['barang_id'] = $this->pinjaman_m->get_id_barang();

		//daterange
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';

		//select2
		$this->data['css_files'][] = base_url() . 'assets/extra/select2/select2.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/select2/select2.min.js';

		//editable
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap3-editable/css/bootstrap-editable.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap3-editable/js/bootstrap-editable.min.js';	

		$this->data['jenis_ags'] = $this->pinjaman_m->get_data_angsuran();
		$this->data['biaya'] = $this->pinjaman_m->get_biaya_adm();

		$this->data['isi'] = $this->load->view('pengajuan_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}

	public function ajax_pengajuan() {
		$this->load->model('pinjaman_m');
		$this->load->model('master_barang');
		$jenis_pinjaman = $this->master_barang->get_all_barang();
		$out = $this->pinjaman_m->get_pengajuan();
		$i = 0;
		foreach ($out['rows'] as $key => $value) {
			foreach ($jenis_pinjaman as $jenis_value) {
				if($jenis_value->nm_barang == $value->jenis){
					$out['rows'][$i]->jenis_id = $jenis_value->id;
				}
			}
			$i = $i++;
		}
		header('Content-Type: application/json');
		echo json_encode($out);
		exit();
	}

	function aksi() {
		$status = $this->input->post('aksi');
		$this->load->model('pinjaman_m');
		if($this->pinjaman_m->pengajuan_aksi()) {
			echo 'OK';
		} else {
			echo 'Gagal';
		}
	}

	function edit() {
		$this->load->model('pinjaman_m');
		$res = $this->pinjaman_m->pengajuan_edit();
		echo $res;
	}

}
