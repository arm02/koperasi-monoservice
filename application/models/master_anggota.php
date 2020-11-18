<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_anggota extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	//panggil data anggota untuk laporan
	function lap_data_anggota() {
		$nama = isset($_REQUEST['nama']) ? $_REQUEST['nama'] : '';
		$aktif = isset($_REQUEST['aktif']) ? $_REQUEST['aktif'] : '';
		$sql = " SELECT * FROM tbl_anggota ";
		$where = "";
		$q = array('nama' => $nama,
			'aktif' => $aktif);
		if(is_array($q)) {
			if($q['nama'] != '') {
				$where .="WHERE nama LIKE '%".$q['nama']."%' ";
			} else {
				if($q['aktif'] != '') {
					$where .="WHERE aktif = '".$q['aktif']."' ";
				}
			}
			if($q['nama'] != '' && $q['aktif'] != '') {
				$where ="WHERE nama LIKE '%".$q['nama']."%' AND aktif = '".$q['aktif']."' ";
			}
		}
		$sql .= $where;
		$query = $this->db->query($sql);
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}

	//panggil data anggota untuk esyui
	function get_data_transaksi_ajax($offset, $limit, $q='', $sort, $order) {
		$sql = "SELECT tbl_anggota.* FROM tbl_anggota ";
		$where = " ";
		if(is_array($q)) {
			if($q['nama'] != '') {
				$where .="WHERE tbl_anggota.nama LIKE '%".$q['nama']."%' ";
			} else {
				if($q['aktif'] != '') {
					$where .="WHERE tbl_anggota.aktif = '".$q['aktif']."' ";
				}
			}

			if($q['nama'] != '' && $q['aktif'] != '') {
				$where ="WHERE nama LIKE '%".$q['nama']."%' AND aktif = '".$q['aktif']."' ";
			}
		}
		$sql .= $where;
		$result['count'] = $this->db->query($sql)->num_rows();
		$sql .=" ORDER BY {$sort} {$order} ";
		$sql .=" LIMIT {$offset},{$limit} ";
		$result['data'] = $this->db->query($sql)->result();

		return $result;
	}

	public function create() {
		$data = array(
			'nama'			=>	$this->input->post('nama'),
			'identitas'			=>	$this->input->post('identitas'),
			'jk'			=>	$this->input->post('jk'),
			'tmp_lahir'			=>	$this->input->post('tmp_lahir'),
			'tgl_lahir'			=>	$this->input->post('tgl_lahir'),
			'status'			=>	$this->input->post('status'),
			'agama'			=>	$this->input->post('agama'),
			'departement'			=>	$this->input->post('departement'),
			'pekerjaan'			=>	$this->input->post('pekerjaan'),
			'alamat'			=>	$this->input->post('alamat'),
			'kota'			=>	$this->input->post('kota'),
			'notelp'			=>	$this->input->post('notelp'),
			'tgl_daftar'			=>	$this->input->post('tgl_daftar'),
			'jabatan_id'			=>	$this->input->post('jabatan_id'),
			'aktif'			=>	$this->input->post('aktif'),
			'pass_word'			=>	sha1('nsi' . $this->input->post('pass_word')),
			'file_pic'			=>	$this->input->post('file_pic') || null,
			);
		return $this->db->insert('tbl_anggota', $data);
	}

	public function update($id)
	{
		$sql = " SELECT * FROM tbl_anggota WHERE id =".$id;
		$data_anggota = '';
		$query =  $this->db->query($sql);
		if($query->num_rows() > 0) {
			$data_anggota = $query->result();
		}
		$this->db->where('id', $id);
		$file_pic = $this->ubah_pic($data_anggota[0]);
		return $this->db->update('tbl_anggota',array(
			'nama'			=>	$this->input->post('nama'),
			'identitas'			=>	$this->input->post('identitas'),
			'jk'			=>	$this->input->post('jk'),
			'tmp_lahir'			=>	$this->input->post('tmp_lahir'),
			'tgl_lahir'			=>	$this->input->post('tgl_lahir'),
			'status'			=>	$this->input->post('status'),
			'agama'			=>	$this->input->post('agama'),
			'departement'			=>	$this->input->post('departement'),
			'pekerjaan'			=>	$this->input->post('pekerjaan'),
			'alamat'			=>	$this->input->post('alamat'),
			'kota'			=>	$this->input->post('kota'),
			'notelp'			=>	$this->input->post('notelp'),
			'tgl_daftar'			=>	$this->input->post('tgl_daftar'),
			'jabatan_id'			=>	$this->input->post('jabatan_id'),
			'aktif'			=>	$this->input->post('aktif'),
			'pass_word' => $this->input->post('pass_word') ? sha1('nsi' . $this->input->post('pass_word')) : $data_anggota[0]->pass_word,
			'file_pic'			=>	$file_pic['success'],
			));
	}

	public function delete($id) {
		return $this->db->delete('tbl_anggota', array('id' => $id));
	}

	public function ubah_pic($row) {
		$out = array('error' => '', 'success' => '');
		$file_lama = $row->file_pic;
		$config['upload_path'] = FCPATH . 'uploads/anggota/';
		$config['file_name'] = uniqid();
		$config['overwrite'] = FALSE;
		$config["allowed_types"] = 'jpg|jpeg|png|gif';
		$config["max_size"] = 1024;
		$config["max_width"] = 2000;
		$config["max_height"] = 2000;
		$this->load->library('upload', $config);

		if(!$this->upload->do_upload('file_upload')) {
			$out['error'] = $this->upload->display_errors();
			$out['success'] = $row->file_pic;
		} else {
			$config['image_library'] = 'gd2';
			$config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 250;
			$config['height'] = 250;
			$config['overwrite'] = TRUE;
			$this->load->library('image_lib',$config); 

			if ( !$this->image_lib->resize()){
				$out['error'] = $this->image_lib->display_errors();
				$out['success'] = $row->file_pic;
			} else {
				//success
				$uploadedFile = $this->upload->data();
				$data = $uploadedFile['file_name'];

				// hapus file lama
				if($file_lama != '') {
					$file_lama_f = FCPATH . '/uploads/anggota/'.$file_lama;
					if(file_exists($file_lama_f)) {
						if(unlink($file_lama_f)) {
							// DELETED
						} else {
							// NOT DELETED
						}
					}
				}
				$out['success'] = $data;
			}
		}
		return $out;
	}
}
