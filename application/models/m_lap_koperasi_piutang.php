<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_lap_koperasi_piutang extends CI_Model {

	public function __construct(){
		parent::__construct();
	}


	//panggil data db untuk esyui
	function get_data_db_ajax($offset = 0, $limit = 0, $q='', $sort = 0, $order = 0, $status) {

    if($status=="all"){
      $sql = "SELECT tbl_pinjaman_h.* FROM tbl_pinjaman_h";
  		$where = "";
    }else{
      $sql = "SELECT tbl_pinjaman_h.* FROM tbl_pinjaman_h";
      $where = " WHERE lunas = ".$status;
    }

		$sql .= $where;
		$result['count'] = $this->db->query($sql)->num_rows();
		if($sort || $order){
			$sql .=" ORDER BY {$sort} {$order} ";
		}
		if($offset || $limit){
			$sql .=" LIMIT {$offset},{$limit} ";
		}
		$result['data'] = $this->db->query($sql)->result();
		return $result;
	}

  function get_data_perIdBarang($offset, $limit, $q='', $sort, $order, $status, $barangId) {

    if($status=="all"){
      $sql = "SELECT tbl_pinjaman_h.* FROM tbl_pinjaman_h";
  		$where = "";
    }else{
      $sql = "SELECT tbl_pinjaman_h.* FROM tbl_pinjaman_h";
      $where = " WHERE lunas = ".$status." AND barang_id =".$barangId;
    }

		$sql .= $where;
		$result['count'] = $this->db->query($sql)->num_rows();
		$sql .=" ORDER BY {$sort} {$order} ";
		$sql .=" LIMIT {$offset},{$limit} ";
		$result['data'] = $this->db->query($sql)->result();
		return $result;
	}



}
