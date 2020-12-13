<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_detail_setoran_m extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	//menghitung jumlah simpanan
	function get_jml_simpanan($jenis, $id) {
		$this->db->select('SUM(jumlah) AS jml_total');
		$this->db->from('tbl_trans_sp');
		$this->db->where('anggota_id',$id);
		$this->db->where('dk','D');
		$this->db->where('jenis_id', $jenis);

		if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$this->db->where('DATE(tgl_transaksi) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tgl_transaksi) <= ', ''.$tgl_samp.'');

		$query = $this->db->get();
		return $query->row();
	}

	//get data setoran
	function get_data_setoran($id) {
		$this->db->select('tbl_trans_sp.tgl_transaksi AS tgl, 
    (SELECT IFNULL(tbl_trans_sp.jumlah, 0) WHERE jns_simpan.jns_simpan LIKE "%pokok%") AS pokok, 
    (SELECT IFNULL(tbl_trans_sp.jumlah, 0) WHERE jns_simpan.jns_simpan LIKE "%wajib%") AS wajib, 
    (SELECT IFNULL(tbl_trans_sp.jumlah, 0) WHERE jns_simpan.jns_simpan LIKE "%sukarela%") AS sukarela, 
    (SELECT IFNULL(tbl_trans_sp.jumlah, 0) WHERE jns_simpan.jns_simpan LIKE "%khusus%") AS khusus', false);
		$this->db->from('tbl_trans_sp');
		$this->db->join('jns_simpan', 'jns_simpan.id = tbl_trans_sp.jenis_id');
		$this->db->where('tbl_trans_sp.anggota_id',$id);
		$this->db->where('tbl_trans_sp.dk','D');
		if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$this->db->where('DATE(tbl_trans_sp.tgl_transaksi) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tbl_trans_sp.tgl_transaksi) <= ', ''.$tgl_samp.'');
		$this->db->order_by('tbl_trans_sp.tgl_transaksi', 'asc');
		//$this->db->group_by('tbl_trans_sp.tgl_transaksi');

		$query = $this->db->get();
		if($query->num_rows() > 0){
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}

	//panggil data jenis simpan
	function get_jenis_simpan() {
		$this->db->select('*');
		$this->db->from('jns_simpan');
		$this->db->where('tampil','Y');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}

	function get_data_anggota($limit, $start, $q='') {
		$anggota_id = isset($_REQUEST['anggota_id']) ? $_REQUEST['anggota_id'] : '';
		
		$sql = '';

		if (!empty($anggota_id)) {
			$sql = "SELECT * FROM tbl_anggota WHERE aktif='Y'";
			$q = array('anggota_id' => $anggota_id);
			if (is_array($q)){
				if($q['anggota_id'] != '') {
					$q['anggota_id'] = str_replace('AG', '', $q['anggota_id']);
					$sql .=" AND (id LIKE '".$q['anggota_id']."' OR nama LIKE '".$q['anggota_id']."') ";
				}
			}
			$sql .= "LIMIT ".$start.", ".$limit." ";
		//$this->db->limit($limit, $start);
			$query = $this->db->query($sql);
			if($query->num_rows() > 0) {
				$out = $query->result();
				return $out;
			} else {
				return array();
			}
		}
	}
	
	//panggil data anggota
	function lap_data_anggota() {
		$anggota_id = isset($_REQUEST['anggota_id']) ? $_REQUEST['anggota_id'] : '';
		$sql = '';
		$sql = "SELECT * FROM tbl_anggota WHERE aktif='Y'";
		$q = array('anggota_id' => $anggota_id);
		if (is_array($q)){
			if($q['anggota_id'] != '') {
				$q['anggota_id'] = str_replace('AG', '', $q['anggota_id']);
				$sql .=" AND (id LIKE '".$q['anggota_id']."') ";
			}
		}
		$query = $this->db->query($sql);
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}

	function get_jml_data_anggota() {
		$this->db->where('aktif', 'Y');
		return $this->db->count_all_results('tbl_anggota');
	}

	//ambil data simpanan
	function get_data_simpanan($id) {
		$this->db->select('*');
		$this->db->from('tbl_trans_sp');
		$this->db->where('anggota_id',$id);
		$this->db->where('dk','D');

		if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$this->db->where('DATE(tgl_transaksi) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tgl_transaksi) <= ', ''.$tgl_samp.'');

		$query = $this->db->get();
		return $query->row();
	}

}

