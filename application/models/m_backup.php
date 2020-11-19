<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_backup extends CI_Model {

	public function __construct(){
		parent::__construct();
	}


	//panggil data db untuk esyui
	function get_data_db_ajax($offset, $limit, $q='', $sort, $order) {
		$sql = "SELECT backup_db.* FROM backup_db";
		$where = " ";
		if(is_array($q)) {
			if($q['tgl_dari'] != '' && $q['tgl_samp'] != '') {
				$where .=" WHERE backup_db.tanggal between '".$q['tgl_dari']."' and '".$q['tgl_samp']."'";
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
			'tanggal'			=>	date('Y-m-d'),
			'nama_backup'	=>	$this->input->post('nama_backup'),
			'pathdb'			=>	'',
			'created_by'		=>	$this->session->userdata('u_name'),
		);

		return $this->db->insert('backup_db', $data);
	}

	public function update($id)
	{
		$sql = " SELECT * FROM backup_db WHERE id =".$id;
		$data_db = '';
		$query =  $this->db->query($sql);
		if($query->num_rows() > 0) {
			$data_db = $query->result();
		}
		$this->db->where('id', $id);
		$file_pic = $this->ubah_pic($data_db[0]);

		return $this->db->update('backup_db',array(
			'tanggal'			=>	date('Y-m-d'),
			'nama_backup' =>	$this->input->post('nama_backup'),
			'pathdb'			=>	'',
			'created_by'		=>	$this->session->userdata('u_name'),
			));
	}

	public function delete($id) {
		return $this->db->delete('backup_db', array('id' => $id));
	}

}
