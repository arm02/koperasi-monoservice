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
		// $this->callback_after_upload($this->input->post('file_pic'),'uploads/anggota',$this->input->post('file_pic'))
		$sql = " SELECT * FROM tbl_anggota WHERE id =".$id;
		$data_anggota = '';
		$query = $this->db->query($sql);
		if($query->num_rows() > 0) {
			$data_anggota = $query->result();
		}
		$this->db->where('id', $id);
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
			'pass_word' => $this->input->post('pass_word') ? sha1('nsi' . $this->input->post('pass_word')) : $data_anggota->pass_word,
			'file_pic'			=>	$this->input->post('file_pic'),
			));
	}

	public function delete($id) {
		return $this->db->delete('tbl_anggota', array('id' => $id));
	}

	function callback_after_upload($uploader_response,$field_info, $files_to_upload) {
		$this->load->library('image_moo');
        //Is only one file uploaded so it ok to use it with $uploader_response[0].
		$file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name;
		$this->image_moo->load($file_uploaded)->resize(250,250)->save($file_uploaded,true);
		return true;
	}
}
