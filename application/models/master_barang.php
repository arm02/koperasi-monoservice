<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_barang extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	//panggil data untuk laporan
	function lap_data_barang() {
		$nm_barang = isset($_REQUEST['nm_barang']) ? $_REQUEST['nm_barang'] : '';
		$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
		$merk = isset($_REQUEST['merk']) ? $_REQUEST['merk'] : '';
		$sql = '';
		$sql = " SELECT * FROM tbl_barang WHERE ";
		$q = array('nm_barang' => $nm_barang,
			'type' => $tampil
			'merk' => $merk
    );
		if(is_array($q)) {
			if($q['nm_barang'] != '') {
				$sql .=" nm_barang = '".$q['nm_barang']."%' ";
			} else if($q['type'] != '') {
				$sql .=" type = '".$q['type']."%' ";
			} else {
        if($q['merk'] != '') {
					$sql .=" merk = '".$q['merk']."%' ";
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

	//panggil data untuk esyui
	function get_data_transaksi_ajax($offset, $limit, $q='', $sort, $order) {
		$sql = "SELECT jns_stbl_barangimpan.* FROM tbl_barang ";
		$where = " WHERE ";
    if(is_array($q)) {
			if($q['nm_barang'] != '') {
				$where .=" tbl_barang.nm_barang LIKE '%".$q['nm_barang']."%' ";
			} else if($q['type'] != '') {
				$where .=" tbl_barang.type LIKE '%".$q['type']."%' ";
			} else {
        if($q['merk'] != '') {
				$where .=" tbl_barang.merk LIKE '%".$q['merk']."%' ";
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
