<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_users extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	//panggil data anggota untuk laporan
	function lap_data_users() {
		$u_name = isset($_REQUEST['u_name']) ? $_REQUEST['u_name'] : '';
		$level = isset($_REQUEST['level']) ? $_REQUEST['level'] : '';
		$sql = " SELECT * FROM tbl_user ";
		$where = '';
		$q = array(
			'u_name' => $u_name,
			'level' => $level);
		if(is_array($q)) {
			if($q['u_name'] != '') {
				$where .="WHERE u_name LIKE '%".$q['u_name']."%' ";
			} else {
				if($q['level'] != '') {
					$where .="WHERE level = '".$q['level']."' ";
				}
			}

			if($q['u_name'] != '' && $q['level'] != '') {
				$where ="WHERE u_name LIKE '%".$q['u_name']."%' AND level = '".$q['level']."' ";
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
		$sql = "SELECT * FROM tbl_user ";
		$where = "  ";
		if(is_array($q)) {
			if($q['u_name'] != '') {
				$where .="WHERE u_name LIKE '%".$q['u_name']."%' ";
			} else {
				if($q['level'] != '') {
					$where .="WHERE level = '".$q['level']."' ";
				}
			}

			if($q['u_name'] != '' && $q['level'] != '') {
				$where ="WHERE u_name LIKE '%".$q['u_name']."%' AND level = '".$q['level']."' ";
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
				'u_name' =>	$this->input->post('u_name'),
				'pass_word'	=>	sha1('nsi' . $this->input->post('pass_word')),
				'aktif'	=>	$this->input->post('aktif'),
				'level'	=>	$this->input->post('level'),
			);
		return $this->db->insert('tbl_user', $data);
	}

	public function update($id)
	{
		// $this->callback_after_upload($this->input->post('file_pic'),'uploads/anggota',$this->input->post('file_pic'))
		$sql = " SELECT * FROM tbl_user WHERE id =".$id;
		$data_user = '';
		$query = $this->db->query($sql);
		if($query->num_rows() > 0) {
			$data_user = $query->result();
		}
		$this->db->where('id', $id);
		return $this->db->update('tbl_user',array(
			'u_name'			=>	$this->input->post('u_name'),
			'pass_word' => $this->input->post('pass_word') ? sha1('nsi' . $this->input->post('pass_word')) : $data_user->pass_word,
			'aktif'			=>	$this->input->post('aktif'),
			'level'			=>	$this->input->post('level'),
			));
	}

	public function delete($id) {
		return $this->db->delete('tbl_user', array('id' => $id));
	}

}
