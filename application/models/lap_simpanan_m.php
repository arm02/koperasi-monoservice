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

	function lap_rekap_seluruh_anggota($offset = 200, $limit = 200, $q = "") {
		$sql = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id
		ORDER BY anggota.nama asc";

		if($offset || $limit){
			$sql .=" LIMIT {$offset},{$limit} ";
		}

		$count = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id";

		$execute = $this->db->query($sql);

		$data = array();
		foreach ($execute->result_array() as $row):   
			$data[] = $this->getListSimpanan($row['anggota_id'],$row["nama"], $q);
		endforeach;
		$result["count"] = $this->db->query($count)->num_rows();	
		$result["rows"] = $data;
		return $result;		
	}

	function getListSimpanan($id,$nama_anggota,$q = "") {
		$tgl_dari = isset($_REQUEST['tgl_dari']) ? $_REQUEST['tgl_dari'] : '';
		$tgl_sampai = isset($_REQUEST['tgl_samp']) ? $_REQUEST['tgl_samp'] : '';
		$sql = "SELECT anggota.nama as nama, simpan.jns_simpan as jenis_simpanan,simpan.inisial as inisial, sum(trans.jumlah) as jumlah FROM tbl_anggota anggota 
		INNER JOIN tbl_trans_sp trans ON trans.anggota_id=anggota.id
		INNER JOIN jns_simpan simpan ON simpan.id= trans.jenis_id where anggota.id = ".$id."";

		$where = "";
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

	function lap_rekap_anggota_pokok($limit = null, $offset = null,$q = "") {
		$sql = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id
		ORDER BY anggota.nama asc";

		if($offset || $limit){
			$sql .=" LIMIT {$offset},{$limit} ";
		}

		$count = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id";

		$execute = $this->db->query($sql);

		$data = array();
		foreach ($execute->result_array() as $row):   
			$data[] = $this->getListSimpananPokok($row['anggota_id'],$row["nama"], $q);
		endforeach;
		$result["count"] = $this->db->query($count)->num_rows();	
		$result["rows"] = $data; 
		return $result;	
	}


	function getListSimpananPokok($id,$nama_anggota,$q = "") {
		$saldo1 = date("Y",strtotime("-1 year"));
		$saldo2 = date("Y",strtotime("-2 year"));
		$sql = "SELECT anggota.nama as nama, sum(trans.jumlah) as jumlah, trans.tgl_transaksi as tgl_transaksi, EXTRACT( MONTH FROM trans.tgl_transaksi ) as bulan_transaksi, EXTRACT( YEAR FROM trans.tgl_transaksi ) as tahun_transaksi, sum(case when year(trans.tgl_transaksi) = ".$saldo1." then trans.jumlah else 0 end) saldo1, sum(case when year(trans.tgl_transaksi) = ".$saldo2." then trans.jumlah else 0 end) saldo2
		FROM tbl_anggota anggota 
		INNER JOIN tbl_trans_sp trans ON trans.anggota_id=anggota.id AND trans.jenis_id=40 where anggota.id = ".$id."";

		$where = "";
		if(is_array($q)) {
			if($q['tgl_dari'] != '' && $q['tgl_samp'] != '') {
				$where .=" and trans.tgl_transaksi between '".$q['tgl_dari']."' and '".$q['tgl_samp']."'";
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
			"saldo".$saldo2.""=>0,
			"saldo".$saldo1.""=>0
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
			if($value["saldo2"]){
				$data["saldo".$saldo2.""] = $value["saldo2"];
			}
			if($value["saldo1"]){
				$data["saldo".$saldo1.""] = $value["saldo1"];
			}
		endforeach; 

		return $data;
	}

	function lap_rekap_anggota_wajib($offset = null, $limit = null,$q = "") {
		$sql = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id
		ORDER BY anggota.nama asc";

		if($offset || $limit){
			$sql .=" LIMIT {$offset},{$limit} ";
		}

		$count = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id";

		$execute = $this->db->query($sql);

		$data = array();
		foreach ($execute->result_array() as $row):   
			$data[] = $this->getListSimpananWajib($row['anggota_id'],$row["nama"],$q);
		endforeach;

		$result["count"] = $this->db->query($count)->num_rows();	
		$result["rows"] = $data; 
		return $result;	
	}

	function getListSimpananWajib($id,$nama_anggota,$q = "") {
		$saldo1 = date("Y",strtotime("-1 year"));
		$saldo2 = date("Y",strtotime("-2 year"));
		$sql = "SELECT anggota.nama as nama, simpan.jns_simpan as jenis_simpanan,simpan.inisial as inisial, sum(trans.jumlah) as jumlah, trans.tgl_transaksi as tgl_transaksi, EXTRACT( MONTH FROM trans.tgl_transaksi ) as bulan_transaksi, EXTRACT( YEAR FROM trans.tgl_transaksi ) as tahun_transaksi, 
		sum(case when year(trans.tgl_transaksi) = $saldo1 then trans.jumlah else 0 end) saldo1, 
		sum(case when year(trans.tgl_transaksi) = $saldo2 then trans.jumlah else 0 end) saldo2 FROM tbl_anggota anggota 
		INNER JOIN tbl_trans_sp trans ON trans.anggota_id=anggota.id AND trans.jenis_id=41
		INNER JOIN jns_simpan simpan ON simpan.id= 41 where anggota.id = ".$id."";

		$where = "";
		if(is_array($q)) {
			if($q['tgl_dari'] != '' && $q['tgl_samp'] != '') {
				$where .=" and trans.tgl_transaksi between '".$q['tgl_dari']."' and '".$q['tgl_samp']."'";
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
			"saldo".$saldo2.""=>0,
			"saldo".$saldo1.""=>0
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
			if($value["saldo2"]){
				$data["saldo".$saldo2.""] = $value["saldo2"];
			}
			if($value["saldo1"]){
				$data["saldo".$saldo1.""] = $value["saldo1"];
			}
		endforeach; 

		return $data;
	}

	function lap_rekap_anggota_perbulan($offset = null, $limit = null, $q="") {
		$sql = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id
		ORDER BY anggota.nama asc";

		if($offset || $limit){
			$sql .=" LIMIT {$offset},{$limit} ";
		}

		$count = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id";

		$execute = $this->db->query($sql);

		$data = array();
		foreach ($execute->result_array() as $row):   
			$data[] = $this->getListAnggotabulan($row['anggota_id'],$row["nama"], $q);
		endforeach;
		$result["count"] = $this->db->query($count)->num_rows();
		$result["rows"] = $data; 
		return $result;		
	}

	function getListAnggotabulan($id,$nama_anggota,$q) {
		$sql = "SELECT anggota.nama as nama, simpan.jns_simpan as jenis_simpanan,simpan.inisial as inisial, sum(trans.jumlah) as jumlah FROM tbl_anggota anggota 
		INNER JOIN tbl_trans_sp trans ON trans.anggota_id=anggota.id
		INNER JOIN jns_simpan simpan ON simpan.id= trans.jenis_id where anggota.id = ".$id."";

		$where = "";
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
			if($value["jenis_simpanan"] != 112 ){
				$data["jumlah_total"] += $value["jumlah"];
			}
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

	function lap_keuangan_pinjaman($year) {

		$januari = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(jumlah) as jumlah_pinjaman FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 1
		GROUP BY barang_id");

		$februari = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(jumlah) as jumlah_pinjaman FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 2
		GROUP BY barang_id");

		$maret = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(jumlah) as jumlah_pinjaman FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 3
		GROUP BY barang_id");

		$april = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(jumlah) as jumlah_pinjaman FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 4
		GROUP BY barang_id");

		$mei = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(jumlah) as jumlah_pinjaman FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 5
		GROUP BY barang_id");

		$juni = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(jumlah) as jumlah_pinjaman FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 6
		GROUP BY barang_id");

		$juli = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(jumlah) as jumlah_pinjaman FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 7
		GROUP BY barang_id");

		$agustus = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(jumlah) as jumlah_pinjaman FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 8
		GROUP BY barang_id");

		$september = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(jumlah) as jumlah_pinjaman FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 9
		GROUP BY barang_id");

		$oktober = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(jumlah) as jumlah_pinjaman FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 10
		GROUP BY barang_id");

		$november = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(jumlah) as jumlah_pinjaman FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 11
		GROUP BY barang_id");
		$desember = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(jumlah) as jumlah_pinjaman FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND MONTH(pinjaman.tgl_pinjam) = 12
		GROUP BY barang_id");


		$data = array(
			"januari"=> $januari->result_array(),
			"februari"=> $februari->result_array(),
			"maret"=> $maret->result_array(),
			"april"=> $april->result_array(),
			"mei"=> $mei->result_array(),
			"juni"=> $juni->result_array(),
			"juli"=> $juli->result_array(),
			"agustus"=> $agustus->result_array(),
			"september"=> $september->result_array(),
			"oktober"=> $oktober->result_array(),
			"november"=> $november->result_array(),
			"desember"=> $desember->result_array()
		);
		return $data;
	}

	function lap_keuangan_tagihan($year) {

		$januari_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah * FLOOR(pinjaman.bunga) / 100)) as jasa FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 1
		GROUP BY barang_id");

		$januari_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + pinjaman.biaya_adm) as jasa FROM tbl_pinjaman_d pelunasan
		INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 1
		GROUP BY barang_id");

		$februari_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah * FLOOR(pinjaman.bunga) / 100)) as jasa FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 2
		GROUP BY barang_id");

		$februari_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + pinjaman.biaya_adm) as jasa FROM tbl_pinjaman_d pelunasan
		INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 2
		GROUP BY barang_id");

		$maret_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah * FLOOR(pinjaman.bunga) / 100)) as jasa FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 3
		GROUP BY barang_id");

		$maret_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + pinjaman.biaya_adm) as jasa FROM tbl_pinjaman_d pelunasan
		INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 3
		GROUP BY barang_id");

		$april_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah * FLOOR(pinjaman.bunga) / 100)) as jasa FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 4
		GROUP BY barang_id");

		$april_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + pinjaman.biaya_adm) as jasa FROM tbl_pinjaman_d pelunasan
		INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 4
		GROUP BY barang_id");

		$mei_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah * FLOOR(pinjaman.bunga) / 100)) as jasa FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 5
		GROUP BY barang_id");

		$mei_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + pinjaman.biaya_adm) as jasa FROM tbl_pinjaman_d pelunasan
		INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 5
		GROUP BY barang_id");

		$juni_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah * FLOOR(pinjaman.bunga) / 100)) as jasa FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 6
		GROUP BY barang_id");

		$juni_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + pinjaman.biaya_adm) as jasa FROM tbl_pinjaman_d pelunasan
		INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 6
		GROUP BY barang_id");

		$juli_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah * FLOOR(pinjaman.bunga) / 100)) as jasa FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 7
		GROUP BY barang_id");

		$juli_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + pinjaman.biaya_adm) as jasa FROM tbl_pinjaman_d pelunasan
		INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 7
		GROUP BY barang_id");

		$agustus_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah * FLOOR(pinjaman.bunga) / 100)) as jasa FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 8
		GROUP BY barang_id");

		$agustus_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + pinjaman.biaya_adm) as jasa FROM tbl_pinjaman_d pelunasan
		INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 8
		GROUP BY barang_id");

		$september_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah * FLOOR(pinjaman.bunga) / 100)) as jasa FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 9
		GROUP BY barang_id");

		$september_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + pinjaman.biaya_adm) as jasa FROM tbl_pinjaman_d pelunasan
		INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 9
		GROUP BY barang_id");

		$oktober_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah * FLOOR(pinjaman.bunga) / 100)) as jasa FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 10
		GROUP BY barang_id");

		$oktober_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + pinjaman.biaya_adm) as jasa FROM tbl_pinjaman_d pelunasan
		INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 10
		GROUP BY barang_id");

		$november_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah * FLOOR(pinjaman.bunga) / 100)) as jasa FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 11
		GROUP BY barang_id");

		$november_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + pinjaman.biaya_adm) as jasa FROM tbl_pinjaman_d pelunasan
		INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 11
		GROUP BY barang_id");

		$desember_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah * FLOOR(pinjaman.bunga) / 100)) as jasa FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 12
		GROUP BY barang_id");

		$desember_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + pinjaman.biaya_adm) as jasa FROM tbl_pinjaman_d pelunasan
		INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 12
		GROUP BY barang_id");

		$data = array(
			"januari"=> array(
				"tagihan" => $januari_tagihan->result_array(),
				"pelunasan" => $januari_pelunasan->result_array()
			),
			"februari"=> array(
				"tagihan" => $februari_tagihan->result_array(),
				"pelunasan" => $februari_pelunasan->result_array()
			),
			"maret"=> array(
				"tagihan" => $maret_tagihan->result_array(),
				"pelunasan" => $maret_pelunasan->result_array()
			),
			"april"=> array(
				"tagihan" => $april_tagihan->result_array(),
				"pelunasan" => $april_pelunasan->result_array()
			),
			"mei"=> array(
				"tagihan" => $mei_tagihan->result_array(),
				"pelunasan" => $mei_pelunasan->result_array()
			),
			"juni"=> array(
				"tagihan" => $juni_tagihan->result_array(),
				"pelunasan" => $juni_pelunasan->result_array()
			),
			"juli"=> array(
				"tagihan" => $juli_tagihan->result_array(),
				"pelunasan" => $juli_pelunasan->result_array()
			),
			"agustus"=> array(
				"tagihan" => $agustus_tagihan->result_array(),
				"pelunasan" => $agustus_pelunasan->result_array()
			),
			"september"=> array(
				"tagihan" => $september_tagihan->result_array(),
				"pelunasan" => $september_pelunasan->result_array()
			),
			"oktober"=> array(
				"tagihan" => $oktober_tagihan->result_array(),
				"pelunasan" => $oktober_pelunasan->result_array()
			),
			"november"=> array(
				"tagihan" => $november_tagihan->result_array(),
				"pelunasan" => $november_pelunasan->result_array()
			),
			"desember"=> array(
				"tagihan" => $desember_tagihan->result_array(),
				"pelunasan" => $desember_pelunasan->result_array()
			),
		);
		return $data;
	}

	function lap_koperasi_pinjaman_barang($limit = 0, $offset = 0,$q = "") {
		$sql = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota
		GROUP BY anggota.id
		ORDER BY anggota.nama";

		$paging = "";

		if($limit || $offset){
			$paging = " asc LIMIT ".$limit.",".$offset."";			
		}
		$count = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id";

		$sql.= $paging;
		$execute = $this->db->query($sql);
		$data = array();
		foreach ($execute->result_array() as $row):   
			$data[] = $this->getListPinjamanBarang($row['anggota_id'],$row["nama"], $q);
		endforeach;
		$result["count"] = $this->db->query($count)->num_rows();	
		$result["rows"] = $data; 
		return $result;	
	}


	function getListPinjamanBarang($id,$nama_anggota,$q = "") {
		$saldo1 = date("Y",strtotime("-1 year"));
		$saldo2 = date("Y",strtotime("-2 year"));
		$sql = "SELECT anggota.nama as nama, sum(pinjaman.jumlah) as jumlah, pinjaman.tgl_pinjam as tgl_pinjam, EXTRACT( MONTH FROM pinjaman.tgl_pinjam ) as bulan_transaksi, EXTRACT( YEAR FROM pinjaman.tgl_pinjam ) as tahun_transaksi
		FROM tbl_anggota anggota 
		INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.anggota_id=anggota.id AND pinjaman.barang_id=4 where anggota.id = ".$id."";

		$where = "";
		if(is_array($q)) {
			if($q['tgl_dari'] != '' && $q['tgl_samp'] != '') {
				$where .=" and pinjaman.tgl_pinjam between '".$q['tgl_dari']."' and '".$q['tgl_samp']."'";
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
			"jumlah"=>0
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
		endforeach; 

		return $data;
	}


	function lap_koperasi_pinjaman_berjangka($limit = 0, $offset = 0,$q = "") {
		$sql = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota
		GROUP BY anggota.id
		ORDER BY anggota.nama";

		$paging = "";

		if($limit || $offset){
			$paging = " asc LIMIT ".$limit.",".$offset."";			
		}
		$count = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id";

		$sql.=$paging;
		$execute = $this->db->query($sql);
		$data = array();
		foreach ($execute->result_array() as $row):   
			$data[] = $this->getListPinjamanBerjangka($row['anggota_id'],$row["nama"], $q);
		endforeach;
		$result["count"] = $this->db->query($count)->num_rows();	
		$result["rows"] = $data; 
		return $result;	
	}


	function getListPinjamanBerjangka($id,$nama_anggota,$q = "") {
		$saldo1 = date("Y",strtotime("-1 year"));
		$saldo2 = date("Y",strtotime("-2 year"));
		$sql = "SELECT anggota.nama as nama, sum(pinjaman.jumlah) as jumlah, pinjaman.tgl_pinjam as tgl_pinjam, EXTRACT( MONTH FROM pinjaman.tgl_pinjam ) as bulan_transaksi, EXTRACT( YEAR FROM pinjaman.tgl_pinjam ) as tahun_transaksi
		FROM tbl_anggota anggota 
		INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.anggota_id=anggota.id AND pinjaman.barang_id=1 where anggota.id = ".$id."";

		$where = "";
		if(is_array($q)) {
			if($q['tgl_dari'] != '' && $q['tgl_samp'] != '') {
				$where .=" and pinjaman.tgl_pinjam between '".$q['tgl_dari']."' and '".$q['tgl_samp']."'";
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
			"jumlah"=>0
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
		endforeach; 

		return $data;
	}

	function lap_koperasi_pinjaman_konsumtif($limit = 0, $offset = 0,$q = "") {
		$sql = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota
		GROUP BY anggota.id
		ORDER BY anggota.nama";

		$paging = "";

		if($limit || $offset){
			$paging = " asc LIMIT ".$limit.",".$offset."";			
		}

		$count = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id";

		$sql.=$paging;
		$execute = $this->db->query($sql);
		$data = array();
		foreach ($execute->result_array() as $row):   
			$data[] = $this->getListPinjamanBerjangka($row['anggota_id'],$row["nama"], $q);
		endforeach;
		$result["count"] = $this->db->query($count)->num_rows();	
		$result["rows"] = $data; 
		return $result;	
	}


	function getListPinjamanKonsumtif($id,$nama_anggota,$q = "") {
		$saldo1 = date("Y",strtotime("-1 year"));
		$saldo2 = date("Y",strtotime("-2 year"));
		$sql = "SELECT anggota.nama as nama, sum(pinjaman.jumlah) as jumlah, pinjaman.tgl_pinjam as tgl_pinjam, EXTRACT( MONTH FROM pinjaman.tgl_pinjam ) as bulan_transaksi, EXTRACT( YEAR FROM pinjaman.tgl_pinjam ) as tahun_transaksi
		FROM tbl_anggota anggota 
		INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.anggota_id=anggota.id AND pinjaman.barang_id=5 where anggota.id = ".$id."";

		$where = "";
		if(is_array($q)) {
			if($q['tgl_dari'] != '' && $q['tgl_samp'] != '') {
				$where .=" and pinjaman.tgl_pinjam between '".$q['tgl_dari']."' and '".$q['tgl_samp']."'";
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
			"jumlah"=>0
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
		endforeach; 

		return $data;
	}

	function lap_keuangan_rekap_sukarela($offset = null, $limit = null,$q = "") {
		$sql = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id
		ORDER BY anggota.nama asc";

		if($offset || $limit){
			$sql .=" LIMIT {$offset},{$limit} ";
		}

		$count = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id";

		$execute = $this->db->query($sql);

		$data = array();
		foreach ($execute->result_array() as $row):   
			$data[] = $this->getListSimpananSukarela($row['anggota_id'],$row["nama"],$q);
		endforeach;

		$result["count"] = $this->db->query($count)->num_rows();	
		$result["rows"] = $data; 
		return $result;	
	}

	function getListSimpananSukarela($id,$nama_anggota,$q = "") {
		$saldo1 = date("Y",strtotime("-1 year"));
		$saldo2 = date("Y",strtotime("-2 year"));
		$sql = "SELECT anggota.nama as nama, simpan.jns_simpan as jenis_simpanan,simpan.inisial as inisial, sum(trans.jumlah) as jumlah, trans.tgl_transaksi as tgl_transaksi, EXTRACT( MONTH FROM trans.tgl_transaksi ) as bulan_transaksi, EXTRACT( YEAR FROM trans.tgl_transaksi ) as tahun_transaksi, 
		sum(case when year(trans.tgl_transaksi) = $saldo1 then trans.jumlah else 0 end) saldo1, 
		sum(case when year(trans.tgl_transaksi) = $saldo2 then trans.jumlah else 0 end) saldo2 FROM tbl_anggota anggota 
		INNER JOIN tbl_trans_sp trans ON trans.anggota_id=anggota.id AND trans.jenis_id=32
		INNER JOIN jns_simpan simpan ON simpan.id= 32 where anggota.id = ".$id."";

		$where = "";
		if(is_array($q)) {
			if($q['tgl_dari'] != '' && $q['tgl_samp'] != '') {
				$where .=" and trans.tgl_transaksi between '".$q['tgl_dari']."' and '".$q['tgl_samp']."'";
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
			"saldo".$saldo2.""=>0,
			"saldo".$saldo1.""=>0
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
			if($value["saldo2"]){
				$data["saldo".$saldo2.""] = $value["saldo2"];
			}
			if($value["saldo1"]){
				$data["saldo".$saldo1.""] = $value["saldo1"];
			}
		endforeach; 

		return $data;
	}

	function lap_keuangan_simpanan_total($offset = null, $limit = null, $q = "") {
		$sql = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id
		ORDER BY anggota.nama asc";

		if($offset || $limit){
			$sql .=" LIMIT {$offset},{$limit} ";
		}

		$count = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id";

		$execute = $this->db->query($sql);

		$data = array();
		foreach ($execute->result_array() as $row):   
			$data[] = $this->getListSimpananTotal($row['anggota_id'],$row["nama"], $q);
		endforeach;
		$result["count"] = $this->db->query($count)->num_rows();	
		$result["rows"] = $data;
		return $result;		
	}

	function getListSimpananTotal($id,$nama_anggota,$q = "") {
		$tgl_dari = isset($_REQUEST['tgl_dari']) ? $_REQUEST['tgl_dari'] : '';
		$tgl_sampai = isset($_REQUEST['tgl_samp']) ? $_REQUEST['tgl_samp'] : '';
		$sql = "SELECT anggota.nama as nama, simpan.jns_simpan as jenis_simpanan,simpan.inisial as inisial, sum(trans.jumlah) as jumlah FROM tbl_anggota anggota 
		INNER JOIN tbl_trans_sp trans ON trans.anggota_id=anggota.id
		INNER JOIN jns_simpan simpan ON simpan.id= trans.jenis_id where anggota.id = ".$id."";

		$where = "";
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

	function lap_keuangan_perhitungan_rugi_laba($year) {

		$pendapatan = $this->db->query("SELECT jenis.nm_barang as tipe, FLOOR(sum(pinjaman.jumlah * FLOOR(pinjaman.bunga) / 100)) as jasa FROM tbl_pinjaman_h pinjaman 
		INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year."
		GROUP BY barang_id");

		$provisi_anggota = $this->db->query("SELECT sum(pinjaman.biaya_adm) as total FROM tbl_pinjaman_h pinjaman 
		WHERE YEAR(pinjaman.tgl_pinjam) = ".$year);

		$pengeluaranbiayaumum = $this->db->query("SELECT *FROM biaya_umum umum 
		WHERE YEAR(umum.tanggal) = ".$year);

		$data = array(
			"pendapatan"=> $pendapatan->result_array(),
			"pendapatanlainlain"=> array(
				"provisi_anggota" => $provisi_anggota->result_array(),
			),
			"pengeluaranbiayaumum"=> $pengeluaranbiayaumum->result_array()
		);
		return $data;
	}

	function lap_keuangan_pembagian_shu($shu) {

		$pembagiansisahasilusaha = $this->db->query("SELECT pembagihanshu.type as tipe, pembagihanshu.persentase as persentase, pembagihanshu.nama as nama, FLOOR(sum(".$shu." * FLOOR(pembagihanshu.persentase) / 100)) as jumlah FROM pembagian_shu_labarugi pembagihanshu 
		WHERE pembagihanshu.type = 1
		GROUP BY pembagihanshu.id");

		$pembagianshubagiananggota = $this->db->query("SELECT pembagihanshu.type as tipe,pembagihanshu.persentase as persentase, pembagihanshu.nama as nama, FLOOR(sum(".$shu." * FLOOR(pembagihanshu.persentase) / 100)) as jumlah FROM pembagian_shu_labarugi pembagihanshu 
		WHERE pembagihanshu.type = 2
		GROUP BY pembagihanshu.id");

		$data = array(
			"shu"=> $shu,
			"pembagiansisahasilusaha"=> $pembagiansisahasilusaha->result_array(),
			"pembagianshubagiananggota"=> $pembagianshubagiananggota->result_array()
		);
		return $data;
	}

	function lap_keuangan_shu_pinjaman($offset = null, $limit = null, $year, $shu_pinjaman) {
		$sql = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id
		ORDER BY anggota.nama asc";

		if($offset || $limit){
			$sql .=" LIMIT {$offset},{$limit} ";
		}

		$count = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id";

		$execute = $this->db->query($sql);

		$seluruh_pinjaman = "SELECT sum(pinjaman.jumlah) as seluruh_pinjaman FROM tbl_pinjaman_h pinjaman";
		$execute_send_params_seluruh_pinjaman = $this->db->query($seluruh_pinjaman)->row()->seluruh_pinjaman;

		$data = array();
		foreach ($execute->result_array() as $row):   
			$data[] = $this->getListSHUPinjaman($row['anggota_id'],$row["nama"], $year, $execute_send_params_seluruh_pinjaman, $shu_pinjaman);
		endforeach;
		$result["count"] = $this->db->query($count)->num_rows();	
		$result["rows"] = $data;
		return $result;		
	}

	function getListSHUPinjaman($id,$nama_anggota,$year, $seluruh_pinjaman, $shu_pinjaman) {
		$tgl_dari = isset($_REQUEST['tgl_dari']) ? $_REQUEST['tgl_dari'] : '';
		$tgl_sampai = isset($_REQUEST['tgl_samp']) ? $_REQUEST['tgl_samp'] : '';
		$sql = "SELECT anggota.nama as nama ,jenisP.nm_barang as inisial, sum(pinjaman.jumlah) as jumlah FROM tbl_anggota anggota 
		INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.anggota_id = anggota.id
		INNER JOIN tbl_barang jenisP ON jenisP.id = pinjaman.barang_id where anggota.id = ".$id." 
		AND YEAR(pinjaman.tgl_pinjam) = ".$year." group by pinjaman.barang_id";


		$execute = $this->db->query($sql);

		$data = array(
			"id_anggota" => $id,
			"nama_anggota" => $nama_anggota,
			"Pinjaman Konsumtif"=>0,
			"Pinjaman Berjangka"=>0,
			"Pinjaman Barang"=>0,
			"jumlah_total" => 0,
			"shu"=>0
		);

		foreach ($execute->result_array() as $row => $value):  
			$data["nama_anggota"] = $value["nama"];	 
			$data[$value["inisial"]] = $value["jumlah"];
			$data["jumlah_total"] += $value["jumlah"];
			$data["shu"] = $data["jumlah_total"] / $seluruh_pinjaman * $shu_pinjaman;
		endforeach; 

		return $data;
	}


	function lap_keuangan_shu_simpanan($offset = null, $limit = null, $year, $shu_simpanan) {
		$sql = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id
		ORDER BY anggota.nama asc";

		if($offset || $limit){
			$sql .=" LIMIT {$offset},{$limit} ";
		}

		$count = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id";

		$execute = $this->db->query($sql);

		$seluruh_simpanan = "SELECT sum(simpanan.jumlah) as seluruh_simpanan FROM tbl_trans_sp simpanan";
		$execute_send_params_seluruh_simpanan = $this->db->query($seluruh_simpanan)->row()->seluruh_simpanan;

		$data = array();
		foreach ($execute->result_array() as $row):   
			$data[] = $this->getListSHUSimpanan($row['anggota_id'],$row["nama"], $year, $execute_send_params_seluruh_simpanan, $shu_simpanan);
		endforeach;
		$result["count"] = $this->db->query($count)->num_rows();	
		$result["rows"] = $data;
		return $result;		
	}

	function getListSHUSimpanan($id,$nama_anggota,$year, $seluruh_simpanan, $shu_simpanan) {
		$tgl_dari = isset($_REQUEST['tgl_dari']) ? $_REQUEST['tgl_dari'] : '';
		$tgl_sampai = isset($_REQUEST['tgl_samp']) ? $_REQUEST['tgl_samp'] : '';
		$sql = "SELECT anggota.nama as nama, sum(simpanan.jumlah) as jumlah FROM tbl_anggota anggota 
		INNER JOIN tbl_trans_sp simpanan ON simpanan.anggota_id = anggota.id where anggota.id = ".$id."
		AND YEAR(simpanan.tgl_transaksi) = ".$year."";


		$execute = $this->db->query($sql);

		$data = array(
			"id_anggota" => $id,
			"nama_anggota" => $nama_anggota,
			"jumlah_total" => 0,
			"shu"=>0
		);

		foreach ($execute->result_array() as $row => $value):  
			$data["nama_anggota"] = $value["nama"];	 
			$data["jumlah_total"] += $value["jumlah"];
			$data["shu"] = $data["jumlah_total"] / $seluruh_simpanan * $shu_simpanan;
		endforeach; 

		return $data;
	}

	function lap_keuangan_shu_total($offset = null, $limit = null, $year, $shu_pinjaman, $shu_simpanan) {
		$sql = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id
		ORDER BY anggota.nama asc";

		if($offset || $limit){
			$sql .=" LIMIT {$offset},{$limit} ";
		}

		$count = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id";

		$execute = $this->db->query($sql);

		$seluruh_pinjaman = "SELECT sum(pinjaman.jumlah) as seluruh_pinjaman FROM tbl_pinjaman_h pinjaman";
		$execute_send_params_seluruh_pinjaman = $this->db->query($seluruh_pinjaman)->row()->seluruh_pinjaman;

		$seluruh_simpanan = "SELECT sum(simpanan.jumlah) as seluruh_simpanan FROM tbl_trans_sp simpanan";
		$execute_send_params_seluruh_simpanan = $this->db->query($seluruh_simpanan)->row()->seluruh_simpanan;

		$data = array();
		foreach ($execute->result_array() as $row):   
			$data[] = $this->getListSHUTotal($row['anggota_id'],$row["nama"], $year, $execute_send_params_seluruh_pinjaman,$execute_send_params_seluruh_simpanan, $shu_pinjaman, $shu_simpanan);
		endforeach;
		$result["count"] = $this->db->query($count)->num_rows();	
		$result["rows"] = $data;
		return $result;		
	}

	function getListSHUTotal($id,$nama_anggota,$year, $seluruh_pinjaman,$seluruh_simpanan, $shu_pinjaman, $shu_simpanan) {

		$sql = "SELECT anggota.nama as nama ,(case when year(pinjaman.tgl_pinjam) = ".$year." then sum(pinjaman.jumlah) else 0 end) jumlah_pinjaman, (case when year(simpanan.tgl_transaksi) = ".$year." then sum(simpanan.jumlah) else 0 end) jumlah_simpanan FROM tbl_anggota anggota 
		LEFT JOIN tbl_pinjaman_h pinjaman ON pinjaman.anggota_id = anggota.id
		LEFT JOIN tbl_trans_sp simpanan ON simpanan.anggota_id = anggota.id where anggota.id = ".$id."";


		$execute = $this->db->query($sql);

		$data = array(
			"id_anggota" => $id,
			"nama_anggota" => $nama_anggota,
			"simpanan"=>0,
			"total_simpanan"=>0,
			"pinjaman"=>0,
			"total_pinjaman"=>0,
			"shu_simpanan"=>0,
			"shu_pinjaman"=>0,
			"jumlah_total" => 0
		);

		foreach ($execute->result_array() as $row => $value):  
			$data["nama_anggota"] = $value["nama"];	 
			$data["simpanan"] = $value["jumlah_simpanan"];
			$data["total_simpanan"] = $seluruh_simpanan;
			$data["pinjaman"] = $value["jumlah_pinjaman"];
			$data["total_pinjaman"] = $seluruh_pinjaman;
			$data["shu_simpanan"] = $value["jumlah_simpanan"] / $seluruh_simpanan * $shu_simpanan;
			$data["shu_pinjaman"] = $value["jumlah_pinjaman"] / $seluruh_pinjaman * $shu_pinjaman;
			$data["jumlah_total"] = $data["shu_simpanan"] + $data["shu_pinjaman"];
		endforeach; 

		return $data;
	}


function lap_keuangan_dana_cadangan($offset = null, $limit = null, $year, $dana_cadangan) {
		$sql = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id
		ORDER BY anggota.nama asc";

		if($offset || $limit){
			$sql .=" LIMIT {$offset},{$limit} ";
		}

		$count = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
		GROUP BY anggota.id";

		$execute = $this->db->query($sql);

		$seluruh_simpanan = "SELECT sum(simpanan.jumlah) as seluruh_simpanan FROM tbl_trans_sp simpanan";
		$execute_send_params_seluruh_simpanan = $this->db->query($seluruh_simpanan)->row()->seluruh_simpanan;

		$data = array();
		foreach ($execute->result_array() as $row):   
			$data[] = $this->getListDanaCadangan($row['anggota_id'],$row["nama"], $year, $execute_send_params_seluruh_simpanan, $dana_cadangan);
		endforeach;
		$result["count"] = $this->db->query($count)->num_rows();	
		$result["rows"] = $data;
		return $result;		
	}

	function getListDanaCadangan($id,$nama_anggota,$year, $seluruh_simpanan, $dana_cadangan) {
		$sql = "SELECT anggota.nama as nama, sum(simpanan.jumlah) as jumlah FROM tbl_anggota anggota 
		INNER JOIN tbl_trans_sp simpanan ON simpanan.anggota_id = anggota.id where anggota.id = ".$id."
		AND YEAR(simpanan.tgl_transaksi) = ".$year."";


		$execute = $this->db->query($sql);

		$data = array(
			"id_anggota" => $id,
			"nama_anggota" => $nama_anggota,
			"jumlah_total" => 0,
			"seluruh_simpanan" => 0,
			"kalkulasi_persentasi_danacadangan" => 0,
			"shu_dana_cadangan"=>0
		);

		foreach ($execute->result_array() as $row => $value):  
			$data["nama_anggota"] = $value["nama"];	 
			$data["jumlah_total"] += $value["jumlah"];
			$data["seluruh_simpanan"] = $seluruh_simpanan;
			$data["kalkulasi_persentasi_danacadangan"] = $dana_cadangan;
			$data["shu_dana_cadangan"] = $data["jumlah_total"] / $seluruh_simpanan * $dana_cadangan;
		endforeach; 

		return $data;
	}


}