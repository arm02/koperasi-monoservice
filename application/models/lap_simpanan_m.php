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

	function lap_rekap_seluruh_anggota($limit = 200, $offset = 200) {
		$sql = "SELECT anggota.id as anggota_id,anggota.nama as nama, simpan.id as id_jenis_simpanan,simpan.jns_simpan as jenis_simpanan, trans.jumlah as jumlah FROM tbl_anggota anggota 
		INNER JOIN tbl_trans_sp trans ON trans.anggota_id=anggota.id
		INNER JOIN jns_simpan simpan ON simpan.id= trans.jenis_id 
		ORDER BY tgl_daftar desc 
		LIMIT ".$limit.",".$offset."";

		$execute = $this->db->query($sql);

		$data = array();
		foreach ($execute->result_array() as $row):   
			$data[] = $this->getListSimpanan($row['anggota_id'],$row["nama"]);
		endforeach;
		$result["rows"] = $data;
		$result["count"] = count($data);
		return $result;		
	}

	function getListSimpanan($id,$nama_anggota) {
		$tgl_dari = isset($_REQUEST['tgl_dari']) ? $_REQUEST['tgl_dari'] : '';
		$tgl_sampai = isset($_REQUEST['tgl_samp']) ? $_REQUEST['tgl_samp'] : '';
		$sql = "SELECT anggota.nama as nama, simpan.jns_simpan as jenis_simpanan,simpan.inisial as inisial, sum(trans.jumlah) as jumlah FROM tbl_anggota anggota 
		INNER JOIN tbl_trans_sp trans ON trans.anggota_id=anggota.id
		INNER JOIN jns_simpan simpan ON simpan.id= trans.jenis_id where anggota.id = ".$id."";

		$where = "";
		$q = array('tgl_dari' => $tgl_dari,
			'tgl_samp' => $tgl_sampai);
		if(is_array($q)) {
			if($q['tgl_dari'] != '' && $q['tgl_samp'] != '') {
				$where .=" and trans.tgl_transaksi between '".$q['tgl_dari']."' and '".$q['tgl_samp']."' group by trans.jenis_id";
			}else{
				$where .=" group by trans.jenis_id";
			}
		}
		$sql .= $where;

		$execute = $this->db->query($sql);

		$data = array(
			"id_anggota" => $id,
			"nama_anggota" => $nama_anggota,
			"simpananwajib"=>0,
			"simpananpokok"=>0,
			"simpanansukarela"=>0,
			"simpanankhusus"=>0,
			"jumlah_total" => 0,
			"yang_diambil" => 0,
			"saldo_simpanan" => 0
		);

		foreach ($execute->result_array() as $row => $value):  
			$data["nama_anggota"] = $value["nama"];	 
			$data[$value["inisial"]] = $value["jumlah"];
			$data["jumlah_total"] += $value["jumlah"];
			$data["yang_diambil"] = 0;
			$data["saldo_simpanan"] = 0;
		endforeach; 

		return $data;
	}

	function lap_rekap_anggota_pokok($limit, $offset) {
		$sql = "SELECT anggota.id as anggota_id,anggota.nama as nama, simpan.id as id_jenis_simpanan,simpan.jns_simpan as jenis_simpanan, trans.jumlah as jumlah FROM tbl_anggota anggota 
		INNER JOIN tbl_trans_sp trans ON trans.anggota_id=anggota.id
		INNER JOIN jns_simpan simpan ON simpan.id= 40
		GROUP BY anggota.id
		ORDER BY tgl_daftar desc 
		LIMIT ".$limit.",".$offset."";

		$execute = $this->db->query($sql);

		$data = array();
		foreach ($execute->result_array() as $row):   
			$data[] = $this->getListSimpananPokok($row['anggota_id'],$row["nama"]);
		endforeach;
		$result["rows"] = $data; 
		$result["count"] = count($data);
		return $result;	
	}

	function getListSimpananPokok($id,$nama_anggota) {
		$tgl_dari = isset($_REQUEST['tgl_dari']) ? $_REQUEST['tgl_dari'] : '';
		$tgl_sampai = isset($_REQUEST['tgl_samp']) ? $_REQUEST['tgl_samp'] : '';
		$sql = "SELECT anggota.nama as nama, sum(trans.jumlah) as jumlah, trans.tgl_transaksi as tgl_transaksi, EXTRACT( MONTH FROM trans.tgl_transaksi ) as bulan_transaksi, EXTRACT( YEAR FROM trans.tgl_transaksi ) as tahun_transaksi FROM tbl_anggota anggota 
		INNER JOIN tbl_trans_sp trans ON trans.anggota_id=anggota.id AND trans.jenis_id=40 where anggota.id = ".$id."";

		$where = "";
		$q = array('tgl_dari' => $tgl_dari,
			'tgl_samp' => $tgl_sampai);
		if(is_array($q)) {
			if($q['tgl_dari'] != '' && $q['tgl_samp'] != '') {
				$where .=" and trans.tgl_transaksi between '".$q['tgl_dari']."' and '".$q['tgl_samp']."' GROUP BY YEAR(trans.tgl_transaksi), MONTH(trans.tgl_transaksi)";
			}else{
				$where .=" GROUP BY YEAR(trans.tgl_transaksi), MONTH(trans.tgl_transaksi)";
			}
		}
		$sql .= $where;

		$execute = $this->db->query($sql);

		$data = array(
			"id_anggota" => $id,
			"nama_anggota" => $nama_anggota,
			"januari"=>0,
			"februari"=>0,
			"maret"=>0,
			"april"=>0,
			"mei"=>0,
			"juni"=>0,
			"juli"=>0,
			"agustus"=>0,
			"september"=>0,
			"oktober"=>0,
			"november"=>0,
			"desember"=>0,
			"jumlah"=>0,
			"saldo18"=>0,
			"saldo19"=>0
		);

		foreach ($execute->result_array() as $row => $value):  
			if ($value["bulan_transaksi"] == 1) {
				$value["bulan_transaksi"] = 'januari';
			}else if($value["bulan_transaksi"] == 2){
				$value["bulan_transaksi"] = 'februari';
			}else if($value["bulan_transaksi"] == 3){
				$value["bulan_transaksi"] = 'maret';
			}else if($value["bulan_transaksi"] == 4){
				$value["bulan_transaksi"] = 'april';
			}else if($value["bulan_transaksi"] == 5){
				$value["bulan_transaksi"] = 'mei';
			}else if($value["bulan_transaksi"] == 6){
				$value["bulan_transaksi"] = 'juni';
			}else if($value["bulan_transaksi"] == 7){
				$value["bulan_transaksi"] = 'juli';
			}else if($value["bulan_transaksi"] == 8){
				$value["bulan_transaksi"] = 'agustus';
			}else if($value["bulan_transaksi"] == 9){
				$value["bulan_transaksi"] = 'september';
			}else if($value["bulan_transaksi"] == 10){
				$value["bulan_transaksi"] = 'oktober';
			}else if($value["bulan_transaksi"] == 11){
				$value["bulan_transaksi"] = 'november';
			}else if($value["bulan_transaksi"] == 12){
				$value["bulan_transaksi"] = 'desember';
			}
			$data["nama_anggota"] = $value["nama"];	 
			$data[$value["bulan_transaksi"]] = $value["jumlah"];
			$data["jumlah"] += $value["jumlah"];
			$data["saldo18"] = 0;
			$data["saldo19"] = 0;
		endforeach; 

		return $data;
	}

	function lap_rekap_anggota_wajib($limit, $offset) {
		$sql = "SELECT anggota.id as anggota_id,anggota.nama as nama, trans.jumlah as jumlah FROM tbl_anggota anggota 
		INNER JOIN tbl_trans_sp trans ON trans.anggota_id=anggota.id AND trans.jenis_id=41
		GROUP BY anggota.id
		ORDER BY tgl_daftar desc 
		LIMIT ".$limit.",".$offset."";

		$execute = $this->db->query($sql);

		$data = array();
		foreach ($execute->result_array() as $row):   
			$data[] = $this->getListSimpananWajib($row['anggota_id'],$row["nama"]);
		endforeach;
		$result["rows"] = $data; 
		return $result;	
	}

	function getListSimpananWajib($id,$nama_anggota) {
		$tgl_dari = isset($_REQUEST['tgl_dari']) ? $_REQUEST['tgl_dari'] : '';
		$tgl_sampai = isset($_REQUEST['tgl_samp']) ? $_REQUEST['tgl_samp'] : '';
		$sql = "SELECT anggota.nama as nama, simpan.jns_simpan as jenis_simpanan,simpan.inisial as inisial, sum(trans.jumlah) as jumlah, trans.tgl_transaksi as tgl_transaksi, EXTRACT( MONTH FROM trans.tgl_transaksi ) as bulan_transaksi, EXTRACT( YEAR FROM trans.tgl_transaksi ) as tahun_transaksi FROM tbl_anggota anggota 
		INNER JOIN tbl_trans_sp trans ON trans.anggota_id=anggota.id AND trans.jenis_id=41
		INNER JOIN jns_simpan simpan ON simpan.id= 41 where anggota.id = ".$id."";

		$where = "";
		$q = array('tgl_dari' => $tgl_dari,
			'tgl_samp' => $tgl_sampai);
		if(is_array($q)) {
			if($q['tgl_dari'] != '' && $q['tgl_samp'] != '') {
				$where .=" and trans.tgl_transaksi between '".$q['tgl_dari']."' and '".$q['tgl_samp']."' GROUP BY YEAR(trans.tgl_transaksi), MONTH(trans.tgl_transaksi)";
			}else{
				$where .=" GROUP BY YEAR(trans.tgl_transaksi), MONTH(trans.tgl_transaksi)";
			}
		}
		$sql .= $where;

		$execute = $this->db->query($sql);

		$data = array(
			"id_anggota" => $id,
			"nama_anggota" => $nama_anggota,
			"januari"=>0,
			"februari"=>0,
			"maret"=>0,
			"april"=>0,
			"mei"=>0,
			"juni"=>0,
			"juli"=>0,
			"agustus"=>0,
			"september"=>0,
			"oktober"=>0,
			"november"=>0,
			"desember"=>0,
			"jumlah"=>0,
			"saldo18"=>0,
			"saldo19"=>0
		);

		foreach ($execute->result_array() as $row => $value):  
			if ($value["bulan_transaksi"] == 1) {
				$value["bulan_transaksi"] = 'januari';
			}else if($value["bulan_transaksi"] == 2){
				$value["bulan_transaksi"] = 'februari';
			}else if($value["bulan_transaksi"] == 3){
				$value["bulan_transaksi"] = 'maret';
			}else if($value["bulan_transaksi"] == 4){
				$value["bulan_transaksi"] = 'april';
			}else if($value["bulan_transaksi"] == 5){
				$value["bulan_transaksi"] = 'mei';
			}else if($value["bulan_transaksi"] == 6){
				$value["bulan_transaksi"] = 'juni';
			}else if($value["bulan_transaksi"] == 7){
				$value["bulan_transaksi"] = 'juli';
			}else if($value["bulan_transaksi"] == 8){
				$value["bulan_transaksi"] = 'agustus';
			}else if($value["bulan_transaksi"] == 9){
				$value["bulan_transaksi"] = 'september';
			}else if($value["bulan_transaksi"] == 10){
				$value["bulan_transaksi"] = 'oktober';
			}else if($value["bulan_transaksi"] == 11){
				$value["bulan_transaksi"] = 'november';
			}else if($value["bulan_transaksi"] == 12){
				$value["bulan_transaksi"] = 'desember';
			}
			$data["nama_anggota"] = $value["nama"];	 
			$data[$value["bulan_transaksi"]] = $value["jumlah"];
			$data["jumlah"] += $value["jumlah"];
			$data["saldo18"] = 0;
			$data["saldo19"] = 0;
		endforeach; 

		return $data;
	}

	function lap_rekap_anggota_perbulan($limit, $offset) {
		$sql = "SELECT anggota.id as anggota_id,anggota.nama as nama, simpan.id as id_jenis_simpanan,simpan.jns_simpan as jenis_simpanan, trans.jumlah as jumlah FROM tbl_anggota anggota 
		INNER JOIN tbl_trans_sp trans ON trans.anggota_id=anggota.id
		INNER JOIN jns_simpan simpan ON simpan.id= trans.jenis_id 
		ORDER BY tgl_daftar desc 
		LIMIT ".$limit.",".$offset."";

		$execute = $this->db->query($sql);

		$data = array();
		foreach ($execute->result_array() as $row):   
			$data[] = $this->getListAnggotabulan($row['anggota_id'],$row["nama"]);
		endforeach;
		$result["rows"] = $data; 
		return $result;		
	}

	function getListAnggotabulan($id,$nama_anggota) {
		$tgl_dari = isset($_REQUEST['tgl_dari']) ? $_REQUEST['tgl_dari'] : '';
		$tgl_sampai = isset($_REQUEST['tgl_samp']) ? $_REQUEST['tgl_samp'] : '';
		$sql = "SELECT anggota.nama as nama, simpan.jns_simpan as jenis_simpanan,simpan.inisial as inisial, sum(trans.jumlah) as jumlah FROM tbl_anggota anggota 
		INNER JOIN tbl_trans_sp trans ON trans.anggota_id=anggota.id
		INNER JOIN jns_simpan simpan ON simpan.id= trans.jenis_id where anggota.id = ".$id."";

		$where = "";
		$q = array('tgl_dari' => $tgl_dari,
			'tgl_samp' => $tgl_sampai);
		if(is_array($q)) {
			if($q['tgl_dari'] != '' && $q['tgl_samp'] != '') {
				$where .=" and trans.tgl_transaksi between '".$q['tgl_dari']."' and '".$q['tgl_samp']."' group by trans.jenis_id";
			}else{
				$where .=" group by trans.jenis_id";
			}
		}
		$sql .= $where;

		$execute = $this->db->query($sql);

		$data = array(
			"id_anggota" => $id,
			"nama_anggota" => $nama_anggota,
			"simpananpokok"=>0,
			"simpananwajib"=>0,
			"simpanansukarela"=>0,
			"jumlah_total" => 0,
		);

		foreach ($execute->result_array() as $row => $value):  
			$data["nama_anggota"] = $value["nama"];	 
			$data[$value["inisial"]] = $value["jumlah"];
			$data["jumlah_total"] += $value["jumlah"];
		endforeach; 

		return $data;
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