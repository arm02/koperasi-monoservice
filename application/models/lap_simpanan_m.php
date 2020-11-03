<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_simpanan_m extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	//panggil data simpanan
	function get_data_jenis_simpan($limit, $start) {
		$this->db->select('*');
		$this->db->from('jns_simpan');
		$this->db->where('tampil','Y');
		$this->db->order_by('id', 'ASC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}


	function get_jml_data_simpan() {
		$this->db->where('tampil', 'Y');
		return $this->db->count_all_results('jns_simpan');
	}

	function lap_rekap_seluruh_anggota() {
		$sql = "SELECT anggota.id as anggota_id,anggota.nama as nama, simpan.id as id_jenis_simpanan,simpan.jns_simpan as jenis_simpanan, trans.jumlah as jumlah FROM tbl_anggota anggota 
		INNER JOIN tbl_trans_sp trans ON trans.anggota_id=anggota.id
		INNER JOIN jns_simpan simpan ON simpan.id= trans.jenis_id
		LIMIT 100,100";


		$execute = $this->db->query($sql);

		$data = array();
		foreach ($execute->result_array() as $row):   
			$data[] = $this->getListSimpanan($row['anggota_id']);
		endforeach; 
		return $data;	
	}

	function getListSimpanan($id) {
		$sql = "SELECT anggota.nama as nama, simpan.jns_simpan as jenis_simpanan, sum(trans.jumlah) as jumlah FROM tbl_anggota anggota 
		INNER JOIN tbl_trans_sp trans ON trans.anggota_id=anggota.id
		INNER JOIN jns_simpan simpan ON simpan.id= trans.jenis_id where anggota.id = $id group by simpan.jns_simpan";
		$execute = $this->db->query($sql);
		return $execute->result_array();
	}

	//menghitung jumlah simpanan
	function get_jml_simpanan($jenis) {
		$this->db->select('SUM(jumlah) AS jml_total');
		$this->db->from('tbl_trans_sp');
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

//panggil data jenis simpan untuk laporan
	function lap_jenis_simpan() {
		$this->db->select('*');
		$this->db->from('jns_simpan');
		$this->db->where('tampil','Y');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}

	//menghitung jumlah penarikan sesuai jenis
	function get_jml_penarikan($jenis) {
		$this->db->select('SUM(jumlah) AS jml_total');
		$this->db->from('tbl_trans_sp');
		$this->db->where('dk','K');
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
}