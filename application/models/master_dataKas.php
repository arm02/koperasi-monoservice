<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_dataKas extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	//panggil data simpanan untuk laporan
	function lap_data_kas() {
		$nama = isset($_REQUEST['nama']) ? $_REQUEST['nama'] : '';
		$aktif = isset($_REQUEST['aktif']) ? $_REQUEST['aktif'] : '';
		$sql = '';
		$sql = " SELECT * FROM nama_kas_tbl WHERE ";
		$q = array('nama' => $nama,
			'aktif' => $aktif);
		if(is_array($q)) {
			if($q['nama'] != '') {
				$sql .=" nama = '".$q['nama']."%' ";
			} else {
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
		$sql = "SELECT nama_kas_tbl.* FROM nama_kas_tbl ";
		$where = " WHERE ";
		if(is_array($q)) {
			if($q['nama'] != '') {
				$where .=" nama_kas_tbl.nama LIKE '%".$q['nama']."%' ";
			} else {
				if($q['aktif'] != '') {
					$where .=" nama_kas_tbl.aktif = '%".$q['aktif']."%' ";
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
