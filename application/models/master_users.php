<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_users extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	//panggil data anggota untuk laporan
	function lap_data_users() {
		$u_name = isset($_REQUEST['u_name']) ? $_REQUEST['u_name'] : '';
		$level = isset($_REQUEST['level']) ? $_REQUEST['level'] : '';
		$sql = '';
		$sql = " SELECT * FROM tbl_user WHERE ";
		$q = array('u_name' => $u_name,
			'level' => $level);
		if(is_array($q)) {
			if($q['u_name'] != '') {
				$sql .=" u_name = '".$q['u_name']."%' ";
			} else {
				if($q['level'] != '') {
					$sql .=" level = '".$q['level']."%' ";
				}
			}
		}
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
		$sql = "SELECT tbl_user.* FROM tbl_user ";
		$where = " WHERE ";
		if(is_array($q)) {
			if($q['u_name'] != '') {
				$where .=" tbl_user.u_name LIKE '%".$q['u_name']."%' ";
			} else {
				if($q['level'] != '') {
					$where .=" tbl_user.level = '%".$q['level']."%' ";
				}
			}
		}
		$sql .= $where;
		$result['count'] = $this->db->query($sql)->num_rows();
		$sql .=" ORDER BY {$sort} {$order} ";
		$sql .=" LIMIT {$offset},{$limit} ";
		$result['data'] = $this->db->query($sql)->result();
		return $result;
	}

}
