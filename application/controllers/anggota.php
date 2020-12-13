<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anggota extends OperatorController {

	public function __construct() {
		parent::__construct();	
		$this->load->helper('form');
		$this->load->helper('fungsi');
		$this->load->library('form_validation');
		$this->load->model('master_anggota');
	}	
	
	public function indexs() {
		$this->data['judul_browser'] = 'Data';
		$this->data['judul_utama'] = 'Data';
		$this->data['judul_sub'] = 'Anggota <a href="'.site_url('anggota/import').'" class="btn btn-sm btn-success">Import Data</a>';

		$this->output->set_template('gc');

		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$this->config->set_item('grocery_crud_file_upload_allow_file_types', 'gif|jpeg|jpg|png');
		$crud->set_table('tbl_anggota');
		$crud->set_subject('Data Anggota');

		$crud->columns('file_pic','id_anggota','identitas','nama','jk','alamat','kota','jabatan_id','departement','tgl_daftar','aktif','created_date');
		$crud->fields('nama','identitas','jk', 'tmp_lahir','tgl_lahir','status','departement','pekerjaan','agama','alamat','kota','notelp','tgl_daftar', 'jabatan_id','pass_word','aktif','file_pic','created_date');

		$crud->display_as('id_anggota','ID Anggota');
		$crud->display_as('identitas','Username');
		$crud->display_as('nama','Nama Lengkap');
		$crud->display_as('tmp_lahir','Tempat Lahir');
		$crud->display_as('tgl_lahir','Tanggal Lahir');
		$crud->display_as('notelp','Nomor Telepon / HP');
		$crud->display_as('tgl_daftar','Tanggal Registrasi');
		$crud->display_as('jabatan_id','Jabatan');
		$crud->display_as('departement','Departement');
		$crud->display_as('pass_word','Password');
		$crud->display_as('file_pic','Photo');
		$crud->display_as('aktif','Aktif Keanggotaan');

		$crud->set_field_upload('file_pic','uploads/anggota');
		$crud->callback_after_upload(array($this,'callback_after_upload'));
		$crud->callback_column('file_pic',array($this,'callback_column_pic'));

		$crud->required_fields('nama','identitas','tmp_lahir','tgl_lahir','jk','alamat','kota','jabatan_id','tgl_daftar','aktif','created_date');
		$crud->unset_texteditor('alamat');
		$crud->field_type('no_rek','invisible'); 
		
		// Dropdown 
		$crud->field_type('jk','dropdown',
			array('L' => 'Laki-laki','P' => 'Perempuan'));
		$crud->display_as('jk','Jenis Kelamin');
		
		$crud->field_type('status','dropdown',
			array('Belum Kawin' => 'Belum Kawin',
				'Kawin' => 'Kawin',
				'Cerai Hidup' => 'Cerai Hidup',
				'Cerai Mati' => 'Cerai Mati',
				'Lainnya' => 'Lainnya'));

		$crud->field_type('agama','dropdown',
			array('Islam' => 'Islam',
				'Katolik' => 'Katolik',
				'Protestan' => 'Protestan',
				'Hindu' => 'Hindu',
				'Budha' => 'Budha',
				'Lainnya' => 'Lainnya'
			));

		// DEPARTEMENT
		$crud->field_type('departement','dropdown',
			array(
				'' 						=> '',
				'Produksi BOPP' 		=> 'Produksi BOPP',
				'Produksi Slitting' 	=> 'Produksi Slitting',
				'WH' 						=> 'WH',
				'QA' 						=> 'QA',
				'HRD' 					=> 'HRD',
				'GA' 						=> 'GA',
				'Purchasing' 			=> 'Purchasing',
				'Accounting' 			=> 'Accounting',
				'Engineering' 			=> 'Engineering'
			));

		$this->db->select('id_kerja,jenis_kerja');
		$this->db->from('pekerjaan');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$result = $query->result();
			foreach ($result as $val) {
				$kerja[$val->jenis_kerja] = $val->jenis_kerja;
			}
		} else {
			$kerja = array('' => '-');
		}
		$crud->field_type('pekerjaan','dropdown',$kerja);
		
		$crud->field_type('jabatan_id','dropdown',
			array('2' => 'Anggota',
				'1' => 'Pengurus'));
		$crud->display_as('jabatan_id','Jabatan');
		
		$crud->field_type('aktif','dropdown',
			array('Y' => 'Aktif','N' => 'Non Aktif'));


		//Pemangggilan field
		$crud->callback_column('id_anggota',array($this, '_kolom_id_cb'));
		$crud->callback_column('alamat',array($this, '_kolom_alamat'));
		
		$crud->callback_edit_field('pass_word',array($this,'_set_password_input_to_empty'));
		$crud->callback_add_field('pass_word',array($this,'_set_password_input_to_empty'));

		$crud->callback_before_insert(array($this,'_encrypt_password_callback'));
		$crud->callback_before_update(array($this,'_encrypt_password_callback'));

		$crud->unset_read();
		
		$output = $crud->render();

		$out['output'] = $this->data['judul_browser'];
		$this->load->section('judul_browser', 'default_v', $out);
		$out['output'] = $this->data['judul_utama'];
		$this->load->section('judul_utama', 'default_v', $out);
		$out['output'] = $this->data['judul_sub'];
		$this->load->section('judul_sub', 'default_v', $out);
		$out['output'] = $this->data['u_name'];
		$this->load->section('u_name', 'default_v', $out);
		$out['level'] = $this->data['level'];

		$this->load->view('default_v', $output);

	}


	public function index() {
		$this->data['judul_browser'] = 'Setting';
		$this->data['judul_utama'] = 'Setting';
		$this->data['judul_sub'] = 'Anggota <a href="'.site_url('anggota/import').'" class="btn btn-sm btn-success">Import Data</a>';

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

		$this->data['isi'] = $this->load->view('static/data_anggota', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}


	function ajax_list() {
		/*Default request pager params dari jeasyUI*/
		$offset = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$limit  = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort  = isset($_POST['sort']) ? $_POST['sort'] : 'created_date';
		$order  = isset($_POST['order']) ? $_POST['order'] : 'desc';
		$id_anggota = isset($_POST['id_anggota']) ? $_POST['id_anggota'] : '';
		$nama = isset($_POST['nama']) ? $_POST['nama'] : '';
		$aktif = isset($_POST['aktif']) ? $_POST['aktif'] : '';
		$search = array(
			'id_anggota' => (int)$id_anggota,
			'nama' => $nama,
			'aktif' => $aktif);
		$offset = ($offset-1)*$limit;
		$data   = $this->master_anggota->get_data_transaksi_ajax($offset,$limit,$search,$sort,$order);
		$i	= 0;
		$rows   = array();

		foreach ($data['data'] as $r) {
			$jabatan = "";
			switch ($r->jabatan_id) {
				case 1:
					$jabatan = "Anggota";
					break;
				
				case 2:
					$jabatan = "Pengurus";
					break;
				
				default:
					$jabatan = "-";
					break;
			}
			$aktif = "";
			switch ($r->aktif) {
				case "Y":
					$aktif = "Aktif";
					break;
				
				case "N":
					$aktif = "Tidak Aktif";
					break;
				
				default:
					$aktif = "-";
					break;
			}
			//array keys ini = attribute 'field' di view nya
			$rows[$i]['id'] = $r->id;
			$rows[$i]['id_anggota'] = 'AG'.sprintf('%04d', $r->id);
			$rows[$i]['nama'] = $r->nama;
			$rows[$i]['identitas'] = $r->identitas;
			$rows[$i]['jk'] = $r->jk;
			$rows[$i]['tmp_lahir'] = $r->tmp_lahir;
			$rows[$i]['tgl_lahir'] = $r->tgl_lahir;
			$rows[$i]['status'] = $r->status;
			$rows[$i]['agama'] = ucfirst($r->agama);
			$rows[$i]['departement'] = $r->departement;
			$rows[$i]['pekerjaan'] = $r->pekerjaan;
			$rows[$i]['alamat'] = $r->alamat;
			$rows[$i]['kota'] = $r->kota;
			$rows[$i]['notelp'] = $r->notelp;
			$rows[$i]['tgl_daftar'] = $r->tgl_daftar;
			$rows[$i]['jabatan_id'] = $jabatan;
			$rows[$i]['aktif'] = $aktif;
			$rows[$i]['file_pic'] = $r->file_pic;
			$rows[$i]['file_pic_html'] = $this->callback_column_pic($r->file_pic);
			$rows[$i]['file_upload'] = "";
			// $rows[$i]['nota'] = '<p></p><p>
			// <a href="'.site_url('cetak_simpanan').'/cetak/' . $r->id . '"  title="Cetak Bukti Transaksi" target="_blank"> <i class="glyphicon glyphicon-print"></i> Nota </a></p>';
			$i++;
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('total'=>$data['count'],'rows'=>$rows);
		echo json_encode($result); //return nya json
	}

	function get_all_data_anggota() {
		/*Default request pager params dari jeasyUI*/
		$data = $this->master_anggota->get_all_data_anggota();

		echo json_encode($data); //return nya json
	}

	public function create() {
		if(!isset($_POST)) {
			show_404();
		}
		if($this->master_anggota->create()){
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
		if($this->master_anggota->update($id)) {
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
		if($this->master_anggota->delete($id))
		{
			//echo 'console.log('.$id.')';
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil dihapus </div>'));
		} else {
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data gagal dihapus </div>'));
		}
	}

	function cetak_laporan() {
		$simpanan = $this->master_anggota->lap_data_anggota();
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
		// <th class="h_tengah" style="width:5%;">Photo</th>
		$html .= '
		<style>
			.h_tengah {text-align: center;}
			.h_kiri {text-align: left;}
			.h_kanan {text-align: right;}
			.txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 12px;}
			.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
			.txt_content {font-size: 10pt; font-style: arial;}
		</style>
		'.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Data Jenis Simpanan <br></span>', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
		<table width="100%" cellspacing="0" cellpadding="3" border="1" border-collapse= "collapse">
		<tr class="header_kolom">
			<th class="h_tengah" style="width:3%;">ID</th>
			<th class="h_tengah" style="width:7%;">ID Anggota</th>
			<th class="h_tengah" style="width:10%;">Nama</th>
			<th class="h_tengah" style="width:10%;">Identitas</th>
			<th class="h_tengah" style="width:5%;">Jenis Kelamin</th>
			<th class="h_tengah" style="width:5%;">Tempat Lahir</th>
			<th class="h_tengah" style="width:5%;">Tanggal Lahir</th>
			<th class="h_tengah" style="width:5%;">Status</th>
			<th class="h_tengah" style="width:5%;">Agama</th>
			<th class="h_tengah" style="width:10%;">Departement</th>
			<th class="h_tengah" style="width:5%;">Pekerjaan</th>
			<th class="h_tengah" style="width:5%;">Alamat</th>
			<th class="h_tengah" style="width:5%;">Kota</th>
			<th class="h_tengah" style="width:5%;">No Telp</th>
			<th class="h_tengah" style="width:5%;">Tanggal Daftar</th>
			<th class="h_tengah" style="width:5%;">Jabatan</th>
			<th class="h_tengah" style="width:5%;"> Aktif </th>
		</tr>';

		$no =1;
		$jml_simpanan = 0;
		foreach ($simpanan as $r) {
			$jabatan = "";
			switch ($r->jabatan_id) {
				case 1:
					$jabatan = "Anggota";
					break;
				
				case 2:
					$jabatan = "Pengurus";
					break;
				
				default:
					$jabatan = "-";
					break;
			}
			$aktif = "";
			switch ($r->aktif) {
				case "Y":
					$aktif = "Aktif";
					break;
				
				case "N":
					$aktif = "Tidak Aktif";
					break;
				
				default:
					$aktif = "-";
					break;
			}
			// '.'AG'.sprintf('%04d', $row->anggota_id).'
			// <td class="h_tengah"> '.$this->callback_column_pic($r->file_pic).'</td>
			$html .= '
			<tr>
				<td class="h_tengah" >'.$no++.'</td>
				<td class="h_tengah"> '.'AG'.sprintf('%04d', $r->id).'</td>
				<td class="h_tengah"> '.$r->nama.'</td>
				<td class="h_tengah"> '.$r->identitas.'</td>
				<td class="h_tengah"> '.$r->jk.'</td>
				<td class="h_tengah"> '.$r->tmp_lahir.'</td>
				<td class="h_tengah"> '.$r->tgl_lahir.'</td>
				<td class="h_tengah"> '.$r->status.'</td>
				<td class="h_tengah"> '.$r->agama.'</td>
				<td class="h_tengah"> '.$r->departement.'</td>
				<td class="h_tengah"> '.$r->pekerjaan.'</td>
				<td class="h_tengah"> '.$r->alamat.'</td>
				<td class="h_tengah"> '.$r->kota.'</td>
				<td class="h_tengah"> '.$r->notelp.'</td>
				<td class="h_tengah"> '.$r->tgl_daftar.'</td>
				<td class="h_tengah"> '.$jabatan.'</td>
				<td class="h_tengah"> '.$aktif.'</td>
			</tr>';
		}
		$html .= '</table>';
		$pdf->nsi_html($html);
		$pdf->Output('data_anggota'.date('Ymd_His') . '.pdf', 'I');
	}

	function import() {
		$this->data['judul_browser'] = 'Import Data';
		$this->data['judul_utama'] = 'Import Data';
		$this->data['judul_sub'] = 'Anggota <a href="'.site_url('anggota').'" class="btn btn-sm btn-success">Kembali</a> <a href="'.site_url('storage/sample_data/sample_data_anggota.xlsx').'" class="btn btn-sm btn-success">Download Sample Data</a>';

		$this->load->helper(array('form'));

		if($this->input->post('submit')) {
			$config['upload_path']   = FCPATH . 'uploads/import_anggota/';
			$config['allowed_types'] = 'xls|xlsx';
			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('import_anggota')) {
				$this->data['error'] = $this->upload->display_errors();
			} else {
				// ok uploaded
				$file = $this->upload->data();
				$this->data['file'] = $file;

				$this->data['lokasi_file'] = $file['full_path'];

				$this->load->library('excel');

				// baca excel
				$objPHPExcel = PHPExcel_IOFactory::load($file['full_path']);
				$no_sheet = 1;
				$header = array();
				$data_list_x = array();
				$data_list = array();
				foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
					if($no_sheet == 1) { // ambil sheet 1 saja
						$no_sheet++;
						$worksheetTitle = $worksheet->getTitle();
						$highestRow = $worksheet->getHighestRow(); // e.g. 10
						$highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
						$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

						$nrColumns = ord($highestColumn) - 64;
						//echo "File ".$worksheetTitle." has ";
						//echo $nrColumns . ' columns';
						//echo ' y ' . $highestRow . ' rows.<br />';

						$data_jml_arr = array();
						//echo 'Data: <table width="100%" cellpadding="3" cellspacing="0"><tr>';
						for ($row = 1; $row <= $highestRow; ++$row) {
						   //echo '<tr>';
							for ($col = 0; $col < $highestColumnIndex; ++$col) {
								$cell = $worksheet->getCellByColumnAndRow($col, $row);
								$val = $cell->getValue();
								$kolom = PHPExcel_Cell::stringFromColumnIndex($col);
								if($row === 1) {
									if($kolom == 'A') {
										$header[$kolom] = 'Nama';
									} else {
										$header[$kolom] = $val;
									}
								} else {
									$data_list_x[$row][$kolom] = $val;
								}
							}
						}
					}
				}

				$no = 1;
				foreach ($data_list_x as $data_kolom) {
					if((@$data_kolom['A'] == NULL || trim(@$data_kolom['A'] == '')) ) { continue; }
					foreach ($data_kolom as $kolom => $val) {
						if(in_array($kolom, array('E', 'K', 'L')) ) {
							$val = ltrim($val, "'");
						}
						$data_list[$no][$kolom] = $val;
					}
					$no++;
				}

				//$arr_data = array();
				$this->data['header'] = $header;
				$this->data['values'] = $data_list;
				/*
				$data_import = array(
					'import_anggota_header'		=> $header,
					'import_anggota_values' 	=> $data_list
					);
				$this->session->set_userdata($data_import);
				*/
			}
		}


		$this->data['isi'] = $this->load->view('anggota_import_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}


	function import_db() {
		if($this->input->post('submit')) {
			$this->load->model('Member_m','member', TRUE);
			$data_import = $this->input->post('val_arr');
			if($this->member->import_db($data_import)) {
				$this->session->set_flashdata('import', 'OK');
			} else {
				$this->session->set_flashdata('import', 'NO');
			}
			//hapus semua file di temp
			$files = glob('uploads/temp/*');
			foreach($files as $file){ 
				if(is_file($file)) {
					@unlink($file);
				}
			}
			redirect('anggota/import');
		} else {
			$this->session->set_flashdata('import', 'NO');
			redirect('anggota/import');
		}
	}

	function import_batal() {
		//hapus semua file di temp
		$files = glob('uploads/temp/*');
		foreach($files as $file){ 
			if(is_file($file)) {
				@unlink($file);
			}
		}
		$this->session->set_flashdata('import', 'BATAL');
		redirect('anggota/import');
	}

	function _set_password_input_to_empty() {
		return "<input type='password' name='pass_word' value='' /><br />Kosongkan password jika tidak ingin ubah/isi.";
	}

	function _encrypt_password_callback($post_array) {
		if(!empty($post_array['pass_word'])) {
			$post_array['pass_word'] = sha1('nsi' . $post_array['pass_word']);
		} else {
			unset($post_array['pass_word']);
		}
		return $post_array;
	}

	function _kolom_id_cb ($value, $row) {
		$value = '<div style="text-align:center;">AG' . sprintf('%04d', $row->id) . '</div>';
		return $value;
	}
	function _kolom_alamat($value, $row) {
		$value = wordwrap($value, 35, "<br />");
		return nl2br($value);
	}

	function callback_column_pic($value) {
		if($value) {
			return '<div style="text-align: center;"><a class="image-thumbnail" href="'.base_url().'uploads/anggota/' . $value .'"><img src="'.base_url().'uploads/anggota/' . $value . '" alt="' . $value . '" width="30" height="40" /></a></div>';
		} else {
			return '<div style="text-align: center;"><img src="'.base_url().'assets/theme_admin/img/photo.jpg" alt="default" width="30" height="40" /></div>';
		}
	}

	function callback_after_upload($uploader_response,$field_info, $files_to_upload) {
		$this->load->library('image_moo');
        //Is only one file uploaded so it ok to use it with $uploader_response[0].
		$file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name;
		$this->image_moo->load($file_uploaded)->resize(250,250)->save($file_uploaded,true);
		return true;
	}



}
