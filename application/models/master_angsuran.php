<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_angsuran extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	//panggil data simpanan untuk laporan
	function lap_data_angsuran() {
		$aktif = isset($_REQUEST['aktif']) ? $_REQUEST['aktif'] : '';
		$sql = '';
		$sql = " SELECT * FROM jns_angsuran WHERE ";
		$q = array('aktif' => $aktif);
		if(is_array($q)) {
			if($q['aktif'] != '') {
				$sql .=" aktif = '".$q['aktif']."%' ";
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

	//panggil data simpanan untuk esyui
	function get_data_transaksi_ajax($offset, $limit, $q='', $sort, $order) {
		$sql = "SELECT jns_angsuran.* FROM jns_angsuran ";
		$where = " WHERE ";
		if(is_array($q)) {
			if($q['aktif'] != '') {
				$where .=" jns_angsuran.aktif LIKE '%".$q['aktif']."%' ";
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
