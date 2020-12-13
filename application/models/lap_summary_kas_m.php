<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_summary_kas_m extends CI_Model {
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
			return FALSE;
		}
	}

	//menghitung jumlah penarikan
	function get_jml_penarikan($jenis, $id) {
		$this->db->select('SUM(jumlah) AS jml_total');
		$this->db->from('tbl_trans_sp');
		$this->db->where('dk','K');
		$this->db->where('anggota_id', $id);
		$this->db->where('jenis_id', $jenis);
		$query = $this->db->get();
		return $query->row();
	}

	//panggil data anggota
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
			$query = $this->db->query($sql);
			if($query->num_rows() > 0) {
				$out = $query->result();
				return $out;
			} else {
				return array();
			}
		} else {
			$sql = "SELECT * FROM tbl_anggota WHERE aktif='Y'";
			$sql .= "LIMIT ".$start.", ".$limit." ";
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

	//ambil data pinjaman header berdasarkan ID peminjam
	function get_data_pinjam($id) {
		$this->db->select('*');
		$this->db->from('v_hitung_pinjaman');
		$this->db->where('anggota_id',$id);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$out = $query->row();
			return $out;
		} else {
			return FALSE;
		}
	}

	//menghitung jumlah yang sudah dibayar
	function get_jml_bayar($id) {
		$this->db->select('SUM(jumlah_bayar) AS total');
		$this->db->from('tbl_pinjaman_d');
		$this->db->where('pinjam_id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	//menghitung jumlah denda harus dibayar
	function get_jml_denda($id) {
		$this->db->select('SUM(denda_rp) AS total_denda');
		$this->db->from('tbl_pinjaman_d');
		$this->db->where('pinjam_id',$id);
		$query = $this->db->get();
		return $query->row();
	}
}