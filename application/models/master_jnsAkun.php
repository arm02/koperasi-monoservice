<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_jnsAkun extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	//panggil data simpanan untuk laporan
	function lap_data_jns_akun() {
		$jns_trans = isset($_REQUEST['jns_trans']) ? $_REQUEST['jns_trans'] : '';
		$akun = isset($_REQUEST['akun']) ? $_REQUEST['akun'] : '';
		$sql = '';
		$sql = " SELECT * FROM jns_akun WHERE ";
		$q = array('jns_trans' => $jns_trans,
			'akun' => $akun);
		if(is_array($q)) {
			if($q['jns_trans'] != '') {
				$sql .=" jns_trans = '".$q['jns_trans']."%' ";
			} else {
				if($q['akun'] != '') {
					$sql .=" akun = '".$q['akun']."%' ";
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
		$sql = "SELECT jns_akun.* FROM jns_akun ";
		$where = " WHERE ";
		if(is_array($q)) {
			if($q['jns_trans'] != '') {
				$where .=" jns_akun.jns_trans LIKE '%".$q['jns_trans']."%' ";
			} else {
				if($q['akun'] != '') {
					$where .=" jns_akun.akun = '%".$q['akun']."%' ";
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
