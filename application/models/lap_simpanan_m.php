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

 		$januari_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100 + pinjaman.biaya_adm) * pinjaman.lama_angsuran) as jasa FROM tbl_pinjaman_h pinjaman 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 1
 			GROUP BY barang_id");

 		$januari_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + sum(pinjaman.biaya_adm)) as jasa FROM tbl_pinjaman_d pelunasan
 			INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 1
 			GROUP BY barang_id");

 		$februari_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100 + pinjaman.biaya_adm) * pinjaman.lama_angsuran) as jasa FROM tbl_pinjaman_h pinjaman 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 2
 			GROUP BY barang_id");

 		$februari_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + sum(pinjaman.biaya_adm)) as jasa FROM tbl_pinjaman_d pelunasan
 			INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 2
 			GROUP BY barang_id");

 		$maret_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100 + pinjaman.biaya_adm) * pinjaman.lama_angsuran) as jasa FROM tbl_pinjaman_h pinjaman 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 3
 			GROUP BY barang_id");

 		$maret_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + sum(pinjaman.biaya_adm)) as jasa FROM tbl_pinjaman_d pelunasan
 			INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 3
 			GROUP BY barang_id");

 		$april_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100 + pinjaman.biaya_adm) * pinjaman.lama_angsuran) as jasa FROM tbl_pinjaman_h pinjaman 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 4
 			GROUP BY barang_id");

 		$april_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + sum(pinjaman.biaya_adm)) as jasa FROM tbl_pinjaman_d pelunasan
 			INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 4
 			GROUP BY barang_id");

 		$mei_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100 + pinjaman.biaya_adm) * pinjaman.lama_angsuran) as jasa FROM tbl_pinjaman_h pinjaman 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 5
 			GROUP BY barang_id");

 		$mei_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + sum(pinjaman.biaya_adm)) as jasa FROM tbl_pinjaman_d pelunasan
 			INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 5
 			GROUP BY barang_id");

 		$juni_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100 + pinjaman.biaya_adm) * pinjaman.lama_angsuran) as jasa FROM tbl_pinjaman_h pinjaman 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 6
 			GROUP BY barang_id");

 		$juni_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + sum(pinjaman.biaya_adm)) as jasa FROM tbl_pinjaman_d pelunasan
 			INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 6
 			GROUP BY barang_id");

 		$juli_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100 + pinjaman.biaya_adm) * pinjaman.lama_angsuran) as jasa FROM tbl_pinjaman_h pinjaman 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 7
 			GROUP BY barang_id");

 		$juli_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + sum(pinjaman.biaya_adm)) as jasa FROM tbl_pinjaman_d pelunasan
 			INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 7
 			GROUP BY barang_id");

 		$agustus_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100 + pinjaman.biaya_adm) * pinjaman.lama_angsuran) as jasa FROM tbl_pinjaman_h pinjaman 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 8
 			GROUP BY barang_id");

 		$agustus_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + sum(pinjaman.biaya_adm)) as jasa FROM tbl_pinjaman_d pelunasan
 			INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 8
 			GROUP BY barang_id");

 		$september_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100 + pinjaman.biaya_adm) * pinjaman.lama_angsuran) as jasa FROM tbl_pinjaman_h pinjaman 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 9
 			GROUP BY barang_id");

 		$september_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + sum(pinjaman.biaya_adm)) as jasa FROM tbl_pinjaman_d pelunasan
 			INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 9
 			GROUP BY barang_id");

 		$oktober_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100 + pinjaman.biaya_adm) * pinjaman.lama_angsuran) as jasa FROM tbl_pinjaman_h pinjaman 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 10
 			GROUP BY barang_id");

 		$oktober_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + sum(pinjaman.biaya_adm)) as jasa FROM tbl_pinjaman_d pelunasan
 			INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 10
 			GROUP BY barang_id");

 		$november_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100 + pinjaman.biaya_adm) * pinjaman.lama_angsuran) as jasa FROM tbl_pinjaman_h pinjaman 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 11
 			GROUP BY barang_id");

 		$november_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + sum(pinjaman.biaya_adm)) as jasa FROM tbl_pinjaman_d pelunasan
 			INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id = pelunasan.pinjam_id 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 11
 			GROUP BY barang_id");

 		$desember_tagihan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, sum(pinjaman.jumlah) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100 + pinjaman.biaya_adm) * pinjaman.lama_angsuran) as jasa FROM tbl_pinjaman_h pinjaman 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year." AND  MONTH(pinjaman.tgl_pinjam) = 12
 			GROUP BY barang_id");

 		$desember_pelunasan = $this->db->query("SELECT jenis.nm_barang as jenis_pinjaman, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran)) as pokok, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100) + sum(pinjaman.biaya_adm)) as jasa FROM tbl_pinjaman_d pelunasan
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

 	function lap_koperasi_pinjaman_konsumtif($limit = null, $offset = null,$q = "") {
 		$sql = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota
 		GROUP BY anggota.id
 		ORDER BY anggota.nama";


 		if($limit || $offset){
 			$sql .= " asc LIMIT ".$limit.",".$offset."";			
 		}

 		$count = "SELECT anggota.id as anggota_id,anggota.nama as nama FROM tbl_anggota anggota 
 		GROUP BY anggota.id";

 		$execute = $this->db->query($sql);
 		$data = array();
 		foreach ($execute->result_array() as $row):   
 			$data[] = $this->getListPinjamanKonsumtif($row['anggota_id'],$row["nama"], $q);
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

 		$pendapatan = $this->db->query("SELECT jenis.nm_barang as tipe, FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100 + pinjaman.biaya_adm) * pinjaman.lama_angsuran) as jasa FROM tbl_pinjaman_h pinjaman 
 			INNER JOIN tbl_barang jenis ON jenis.id=pinjaman.barang_id
 			WHERE YEAR(pinjaman.tgl_pinjam) = ".$year."
 			GROUP BY barang_id");

 		$provisi_anggota = $this->db->query("SELECT sum(pinjaman.biaya_adm * pinjaman.lama_angsuran) as total FROM tbl_pinjaman_h pinjaman 
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

 	function lap_koperasi_tagihan_berjangka($limit = 0, $offset = 0, $tahun) {

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
 			$data[] = $this->getListTagihanBerjangka($row['anggota_id'],$row["nama"], $tahun);
 		endforeach;
 		$result["count"] = $this->db->query($count)->num_rows();
 		$result["rows"] = $data;
 		return $result;
 	}


 	function getListTagihanBerjangka($id,$nama_anggota,$tahun) {
 		$saldo1 = date("Y",strtotime("-1 year"));
 		$saldo2 = date("Y",strtotime("-2 year"));
 		$sql = "SELECT anggota.nama as nama, anggota.id as anggota_id,pinjaman.lama_angsuran as tenor,pinjaman.id as pinjaman_id,
 		((((pinjaman.bunga/100)*pinjaman.jumlah)+pinjaman.jumlah+pinjaman.biaya_adm)/pinjaman.lama_angsuran) as jumlah,
 		detail.tgl_bayar as tgl_bayar,
 		EXTRACT( MONTH FROM detail.tgl_bayar ) as bulan_transaksi,
 		EXTRACT( YEAR FROM detail.tgl_bayar ) as tahun_transaksi
 		FROM tbl_anggota anggota
 		LEFT JOIN tbl_pinjaman_h pinjaman ON pinjaman.anggota_id=anggota.id AND pinjaman.barang_id=1
 		LEFT JOIN tbl_pinjaman_d detail ON detail.pinjam_id = pinjaman.id
 		where pinjaman.lunas = 'Belum' and anggota.id = ".$id."";

 		$where = "";
 		if($tahun != '') {
 			$where .=" and detail.tgl_bayar between '".$tahun."-01-01 00:00:01' and '".$tahun."-12-31 23:59:59'";
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

 			$count_sisa = "SELECT * FROM tbl_pinjaman_d WHERE pinjam_id = ".$value['pinjaman_id'];
 			$execute_count = $this->db->query($count_sisa)->num_rows();

 			$data['januari'] 			=  $value["bulan_transaksi"] == 1? 0 : $value["jumlah"];
 			$data['februari'] 		=  $value["bulan_transaksi"]== 2? 0 : $value["jumlah"];
 			$data['maret'] 				=  $value["bulan_transaksi"]== 3? 0 : $value["jumlah"];
 			$data['april'] 				=  $value["bulan_transaksi"]== 4? 0 : $value["jumlah"];
 			$data['mei'] 					=  $value["bulan_transaksi"]== 5? 0 : $value["jumlah"];
 			$data['juni'] 				=  $value["bulan_transaksi"]== 6? 0 : $value["jumlah"];
 			$data['juli'] 				=  $value["bulan_transaksi"]== 7? 0 : $value["jumlah"];
 			$data['agustus'] 			=  $value["bulan_transaksi"]== 8? 0 : $value["jumlah"];
 			$data['september'] 		=  $value["bulan_transaksi"]== 9? 0 : $value["jumlah"];
 			$data['oktober'] 			=  $value["bulan_transaksi"]== 10? 0 : $value["jumlah"];
 			$data['november'] 		=  $value["bulan_transaksi"]== 11? 0 : $value["jumlah"];
 			$data['desember'] 		=  $value["bulan_transaksi"]== 12? 0 : $value["jumlah"];
 			$data["nama_anggota"] =  $value["nama"];
 			$data["jumlah"] 			=  ($value['tenor'] - $execute_count)*$value['jumlah'];
 		endforeach;

 		return $data;
 	}

 	function lap_koperasi_tagihan_konsumtif($limit = 0, $offset = 0, $tahun) {

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
 			$data[] = $this->getListTagihanKonsumtif($row['anggota_id'],$row["nama"], $tahun);
 		endforeach;
 		$result["count"] = $this->db->query($count)->num_rows();
 		$result["rows"] = $data;
 		return $result;
 	}


 	function getListTagihanKonsumtif($id,$nama_anggota,$tahun) {
 		$saldo1 = date("Y",strtotime("-1 year"));
 		$saldo2 = date("Y",strtotime("-2 year"));
 		$sql = "SELECT anggota.nama as nama, anggota.id as anggota_id,pinjaman.lama_angsuran as tenor,pinjaman.id as pinjaman_id,
 		((((pinjaman.bunga/100)*pinjaman.jumlah)+pinjaman.jumlah+pinjaman.biaya_adm)/pinjaman.lama_angsuran) as jumlah,
 		detail.tgl_bayar as tgl_bayar,
 		EXTRACT( MONTH FROM detail.tgl_bayar ) as bulan_transaksi,
 		EXTRACT( YEAR FROM detail.tgl_bayar ) as tahun_transaksi
 		FROM tbl_anggota anggota
 		LEFT JOIN tbl_pinjaman_h pinjaman ON pinjaman.anggota_id=anggota.id AND pinjaman.barang_id=5
 		LEFT JOIN tbl_pinjaman_d detail ON detail.pinjam_id = pinjaman.id
 		where pinjaman.lunas = 'Belum' and anggota.id = ".$id."";

 		$where = "";
 		if($tahun != '') {
 			$where .=" and detail.tgl_bayar between '".$tahun."-01-01 00:00:01' and '".$tahun."-12-31 23:59:59'";
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

 			$count_sisa = "SELECT * FROM tbl_pinjaman_d WHERE pinjam_id = ".$value['pinjaman_id'];
 			$execute_count = $this->db->query($count_sisa)->num_rows();

 			$data['januari'] 			=  $value["bulan_transaksi"] == 1? 0 : $value["jumlah"];
 			$data['februari'] 		=  $value["bulan_transaksi"]== 2? 0 : $value["jumlah"];
 			$data['maret'] 				=  $value["bulan_transaksi"]== 3? 0 : $value["jumlah"];
 			$data['april'] 				=  $value["bulan_transaksi"]== 4? 0 : $value["jumlah"];
 			$data['mei'] 					=  $value["bulan_transaksi"]== 5? 0 : $value["jumlah"];
 			$data['juni'] 				=  $value["bulan_transaksi"]== 6? 0 : $value["jumlah"];
 			$data['juli'] 				=  $value["bulan_transaksi"]== 7? 0 : $value["jumlah"];
 			$data['agustus'] 			=  $value["bulan_transaksi"]== 8? 0 : $value["jumlah"];
 			$data['september'] 		=  $value["bulan_transaksi"]== 9? 0 : $value["jumlah"];
 			$data['oktober'] 			=  $value["bulan_transaksi"]== 10? 0 : $value["jumlah"];
 			$data['november'] 		=  $value["bulan_transaksi"]== 11? 0 : $value["jumlah"];
 			$data['desember'] 		=  $value["bulan_transaksi"]== 12? 0 : $value["jumlah"];
 			$data["nama_anggota"] =  $value["nama"];
 			$data["jumlah"] 			=  ($value['tenor'] - $execute_count)*$value['jumlah'];
 		endforeach;

 		return $data;
 	}
 	function lap_koperasi_tagihan_barang($limit = 0, $offset = 0, $tahun) {

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
 			$data[] = $this->getListTagihanBarang($row['anggota_id'],$row["nama"], $tahun);
 		endforeach;
 		$result["count"] = $this->db->query($count)->num_rows();
 		$result["rows"] = $data;
 		return $result;
 	}


 	function getListTagihanBarang($id,$nama_anggota,$tahun) {
 		$saldo1 = date("Y",strtotime("-1 year"));
 		$saldo2 = date("Y",strtotime("-2 year"));
 		$sql = "SELECT anggota.nama as nama, anggota.id as anggota_id,pinjaman.lama_angsuran as tenor,pinjaman.id as pinjaman_id,
 		((((pinjaman.bunga/100)*pinjaman.jumlah)+pinjaman.jumlah+pinjaman.biaya_adm)/pinjaman.lama_angsuran) as jumlah,
 		detail.tgl_bayar as tgl_bayar,
 		EXTRACT( MONTH FROM detail.tgl_bayar ) as bulan_transaksi,
 		EXTRACT( YEAR FROM detail.tgl_bayar ) as tahun_transaksi
 		FROM tbl_anggota anggota
 		LEFT JOIN tbl_pinjaman_h pinjaman ON pinjaman.anggota_id=anggota.id AND pinjaman.barang_id=4
 		LEFT JOIN tbl_pinjaman_d detail ON detail.pinjam_id = pinjaman.id
 		where pinjaman.lunas = 'Belum' and anggota.id = ".$id."";

 		$where = "";
 		if($tahun != '') {
 			$where .=" and detail.tgl_bayar between '".$tahun."-01-01 00:00:01' and '".$tahun."-12-31 23:59:59'";
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

 			$count_sisa = "SELECT * FROM tbl_pinjaman_d WHERE pinjam_id = ".$value['pinjaman_id'];
 			$execute_count = $this->db->query($count_sisa)->num_rows();

 			$data['januari'] 			=  $value["bulan_transaksi"] == 1? 0 : $value["jumlah"];
 			$data['februari'] 		=  $value["bulan_transaksi"]== 2? 0 : $value["jumlah"];
 			$data['maret'] 				=  $value["bulan_transaksi"]== 3? 0 : $value["jumlah"];
 			$data['april'] 				=  $value["bulan_transaksi"]== 4? 0 : $value["jumlah"];
 			$data['mei'] 					=  $value["bulan_transaksi"]== 5? 0 : $value["jumlah"];
 			$data['juni'] 				=  $value["bulan_transaksi"]== 6? 0 : $value["jumlah"];
 			$data['juli'] 				=  $value["bulan_transaksi"]== 7? 0 : $value["jumlah"];
 			$data['agustus'] 			=  $value["bulan_transaksi"]== 8? 0 : $value["jumlah"];
 			$data['september'] 		=  $value["bulan_transaksi"]== 9? 0 : $value["jumlah"];
 			$data['oktober'] 			=  $value["bulan_transaksi"]== 10? 0 : $value["jumlah"];
 			$data['november'] 		=  $value["bulan_transaksi"]== 11? 0 : $value["jumlah"];
 			$data['desember'] 		=  $value["bulan_transaksi"]== 12? 0 : $value["jumlah"];
 			$data["nama_anggota"] =  $value["nama"];
 			$data["jumlah"] 			=  ($value['tenor'] - $execute_count)*$value['jumlah'];
 		endforeach;

 		return $data;
 	}

 	function searchArray($array, $key, $value)
 	{
 		$results = array();

 		if (is_array($array)) {
 			if (isset($array[$key]) && $array[$key] == $value) {
 				$results[] = $array;
 			}

 			foreach ($array as $subarray) {
 				$results = array_merge($results, $this->searchArray($subarray, $key, $value));
 			}
 		}

 		return $results;
 	}

 	function lap_neraca($shu, $latest_shu, $year){
 		$latest_year = $year - 1;
 		$two_years_ago = $year - 2;

 		$list_lembaga = $this->db->query("SELECT neraca.title as title,
 			CASE neraca.id_type_neraca WHEN 1 THEN 'hartalancar' ELSE 'not registered' END as type , 
 			neraca.kode as kode, neraca.tahun as tahun, neraca.nominal as nominal FROM type_desc_neraca neraca 
 			WHERE neraca.id_type_neraca = 1 AND neraca.tahun = $year");

 		//KAS
 		$kas_pemasukan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE akun = 'Pemasukan' AND YEAR(kas.tgl_catat) = $year");
 		$kas_pengeluaran = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE akun = 'Pengeluaran' AND YEAR(kas.tgl_catat) = $year");
 		$latest_kas_pemasukan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE akun = 'Pemasukan' AND YEAR(kas.tgl_catat) = $latest_year");
 		$latest_kas_pengeluaran = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE akun = 'Pengeluaran' AND YEAR(kas.tgl_catat) = $latest_year");
 		$latest_kas = $this->db->query("SELECT SUM(latestkas.nominal) as nominal FROM saldo_kas latestkas WHERE latestkas.type = 'HLKas' AND latestkas.tahun = $latest_year")->result_array()[0]['nominal'];
 		
 		//BANK && GIRO
 		$pemasukan_bank = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 119 AND YEAR(kas.tgl_catat) = $year");
 		$pengeluaran_bank = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 119 AND YEAR(kas.tgl_catat) = $year");
 		$pemasukan_giro = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 118 AND YEAR(kas.tgl_catat) = $year");
 		$pengeluaran_giro = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 118 AND YEAR(kas.tgl_catat) = $year");

 		//PINJAMAN KOMSUMTIF
 		$pinjaman_komsumtif = $this->db->query("SELECT SUM(pinjaman.jumlah) as nominal FROM tbl_pinjaman_h pinjaman WHERE barang_id = 5 AND YEAR(pinjaman.tgl_pinjam) = $year");
 		$jasa_pinjaman_komsumtif = $this->db->query("SELECT FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100 + pinjaman.biaya_adm) * pinjaman.lama_angsuran) as nominal FROM tbl_pinjaman_h pinjaman 
 			WHERE barang_id = 5
 			AND YEAR(pinjaman.tgl_pinjam) = ".$year."");
 		$saldo_pinjaman_komsumtif = $pinjaman_komsumtif->result_array()[0]['nominal'] + $jasa_pinjaman_komsumtif->result_array()[0]['nominal'];
 		$penerimaan_pinjaman_komsumtif = $this->db->query("SELECT SUM(penerimaan.jumlah_bayar) as nominal 
 			FROM tbl_pinjaman_d penerimaan INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id=penerimaan.pinjam_id
 			WHERE pinjaman.barang_id = 5 AND YEAR(penerimaan.tgl_bayar) = $year");
 		$latest_saldo_pinjaman_komsumtif = $this->db->query("SELECT SUM(latestkas.nominal) as nominal FROM saldo_kas latestkas WHERE latestkas.type = 'HLPPK' AND latestkas.tahun = $latest_year")->result_array()[0]['nominal'];


 		//PINJAMAN BERJANGKA
 		$pinjaman_berjangka = $this->db->query("SELECT SUM(pinjaman.jumlah) as nominal FROM tbl_pinjaman_h pinjaman WHERE barang_id = 1 AND YEAR(pinjaman.tgl_pinjam) = $year");
 		$jasa_pinjaman_berjangka = $this->db->query("SELECT FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100 + pinjaman.biaya_adm) * pinjaman.lama_angsuran) as nominal FROM tbl_pinjaman_h pinjaman 
 			WHERE barang_id = 1
 			AND YEAR(pinjaman.tgl_pinjam) = ".$year."");
 		$saldo_pinjaman_berjangka = $pinjaman_berjangka->result_array()[0]['nominal'] + $jasa_pinjaman_berjangka->result_array()[0]['nominal'];
 		$penerimaan_pinjaman_berjangka = $this->db->query("SELECT SUM(penerimaan.jumlah_bayar) as nominal 
 			FROM tbl_pinjaman_d penerimaan INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id=penerimaan.pinjam_id
 			WHERE pinjaman.barang_id = 1 AND YEAR(penerimaan.tgl_bayar) = $year");
 		$latest_saldo_pinjaman_berjangka = $this->db->query("SELECT SUM(latestkas.nominal) as nominal FROM saldo_kas latestkas WHERE latestkas.type = 'HLPPB' AND latestkas.tahun = $latest_year")->result_array()[0]['nominal'];

 		//PINJAMAN BARANG
 		$pinjaman_barang = $this->db->query("SELECT SUM(pinjaman.jumlah) as nominal FROM tbl_pinjaman_h pinjaman WHERE barang_id = 4 AND YEAR(pinjaman.tgl_pinjam) = $year");
 		$jasa_pinjaman_barang = $this->db->query("SELECT FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100 + pinjaman.biaya_adm) * pinjaman.lama_angsuran) as nominal FROM tbl_pinjaman_h pinjaman 
 			WHERE barang_id = 4
 			AND YEAR(pinjaman.tgl_pinjam) = ".$year."");
 		$saldo_pinjaman_barang = $pinjaman_barang->result_array()[0]['nominal'] + $jasa_pinjaman_barang->result_array()[0]['nominal'];
 		$penerimaan_pinjaman_barang = $this->db->query("SELECT SUM(penerimaan.jumlah_bayar) as nominal 
 			FROM tbl_pinjaman_d penerimaan INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id=penerimaan.pinjam_id
 			WHERE pinjaman.barang_id = 4 AND YEAR(penerimaan.tgl_bayar) = $year");
 		$latest_saldo_pinjaman_barang = $this->db->query("SELECT SUM(latestkas.nominal) as nominal FROM saldo_kas latestkas WHERE latestkas.type = 'HLPPBarang' AND latestkas.tahun = $latest_year")->result_array()[0]['nominal'];


 		$static_neraca_harta_lancar = array(
 			array(
 				"title" => "Kas",
 				"type" => "hartalancar",
 				"kode" => "HLKas",
 				"tahun" => $year,
 				"nominal" => $latest_kas + $kas_pemasukan->result_array()[0]['nominal'] - $kas_pengeluaran->result_array()[0]['nominal']
 			),
 			array(
 				"title" => "Bank",
 				"type" => "hartalancar",
 				"kode" => "HLBANK",
 				"tahun" => $year,
 				"nominal" => $pemasukan_bank->result_array()[0]['nominal'] - $pengeluaran_bank->result_array()[0]['nominal'],
 			),
 			array(
 				"title" => "Giro",
 				"type" => "hartalancar",
 				"kode" => "HLGIRO",
 				"tahun" => $year,
 				"nominal" => $pemasukan_giro->result_array()[0]['nominal'] - $pengeluaran_giro->result_array()[0]['nominal'],
 			),
 			array(
 				"title" => "Piutang Pinjaman Komsumtif",
 				"type" => "hartalancar",
 				"kode" => "HLPPK",
 				"tahun" => $year,
 				"nominal" => $latest_saldo_pinjaman_komsumtif + $saldo_pinjaman_komsumtif - $penerimaan_pinjaman_komsumtif->result_array()[0]['nominal']
 			),
 			array(
 				"title" => "Piutang Pinjaman Berjangka",
 				"type" => "hartalancar",
 				"kode" => "HLPPB",
 				"tahun" => $year,
 				"nominal" => $latest_saldo_pinjaman_berjangka + $saldo_pinjaman_berjangka - $penerimaan_pinjaman_berjangka->result_array()[0]['nominal']
 			),
 			array(
 				"title" => "Piutang Pinjaman Barang",
 				"type" => "hartalancar",
 				"kode" => "HLPPBarang",
 				"tahun" => $year,
 				"nominal" => $latest_saldo_pinjaman_barang + $saldo_pinjaman_barang - $penerimaan_pinjaman_barang->result_array()[0]['nominal']
 			)
 		);

 		//PENYERTAAN PKPRI
 		$latest_pkpri = $this->db->query("SELECT SUM(latestkas.nominal) as nominal FROM saldo_kas latestkas WHERE latestkas.type = 'PKPRI' AND latestkas.tahun = $latest_year")->result_array()[0]['nominal'];
 		$penambahan_pkpri = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 120 AND YEAR(kas.tgl_catat) = $year");
 		$pengambilan_pkpri = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 120 AND YEAR(kas.tgl_catat) = $year");
 		$type_neraca_penyertaan = array(
 			array(
 				"title" => "PKPRI",
 				"type" => "penyertaan",
 				"kode" => "PKPRI",
 				"tahun" => $year,
 				"nominal" => $latest_pkpri + $penambahan_pkpri->result_array()[0]['nominal'] - $pengambilan_pkpri->result_array()[0]['nominal']
 			),
 		);

 		//HARGATETAP
 		$type_neraca_hargatetap = $this->db->query("SELECT neraca.title as title,
 			CASE neraca.id_type_neraca WHEN 3 THEN 'hargatetap' ELSE 'not registered' END as type , 
 			neraca.kode as kode, neraca.tahun as tahun, neraca.nominal as nominal FROM type_desc_neraca neraca 
 			WHERE neraca.id_type_neraca = 3 AND neraca.tahun = $year");

 		//MODALHUTANGPENDEK
 		
 		//SIMPANAN SUKARELA
 		$simpanansukarela = $this->db->query("SELECT SUM(simpanan.jumlah) as nominal FROM tbl_trans_sp simpanan WHERE simpanan.jenis_id = 32 AND simpanan.akun = 'Setoran' AND YEAR(simpanan.tgl_transaksi) = $year");
 		$latestsimpanansukarela = $this->db->query("SELECT SUM(latestkas.nominal) as nominal FROM saldo_kas latestkas WHERE latestkas.type = 'HJPSS' AND latestkas.tahun = $latest_year")->result_array()[0]['nominal'];
 		$penarikansukarela = $this->db->query("SELECT SUM(simpanan.jumlah) as nominal FROM tbl_trans_sp simpanan WHERE simpanan.jenis_id = 32 AND simpanan.akun = 'Penarikan' AND YEAR(simpanan.tgl_transaksi) = $year");

 		//SHU
 		$totalshu = $this->lap_keuangan_pembagian_shu($shu);
 		$latest_totalshu = $this->lap_keuangan_pembagian_shu($latest_shu);


 		//DANA PEMBANGUNAN
 		$danapembangunan = $this->searchArray($totalshu['pembagiansisahasilusaha'], 'nama', 'Dana Pembangunan');
 		$latestdanapembangunan = $this->searchArray($latest_totalshu['pembagiansisahasilusaha'], 'nama', 'Dana Pembangunan');
 		$penambahandanapembangunan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 114 AND YEAR(kas.tgl_catat) = $year");
 		$penarikandanapembangunan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 114 AND YEAR(kas.tgl_catat) = $year");
 		$latestpenambahandanapembangunan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 114 AND YEAR(kas.tgl_catat) = $latest_year");
 		$latestpenarikandanapembangunan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 114 AND YEAR(kas.tgl_catat) = $latest_year");
 		$saldoterakhirdanapembangunan = $latestdanapembangunan[0]['jumlah'] + $latestpenambahandanapembangunan->result_array()[0]['nominal'] - $latestpenarikandanapembangunan->result_array()[0]['nominal'];
 		$saldodanapembangunan = $penambahandanapembangunan->result_array()[0]['nominal'] + $danapembangunan[0]['jumlah'];

 		//DANA PENDIDIKAN
 		$danapendidikan = $this->searchArray($totalshu['pembagiansisahasilusaha'], 'nama', 'Dana Pendidikan');
 		$latestdanapendidikan = $this->searchArray($latest_totalshu['pembagiansisahasilusaha'], 'nama', 'Dana Pendidikan');
 		$penambahandanapendidikan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 115 AND YEAR(kas.tgl_catat) = $year");
 		$penarikandanapendidikan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 115 AND YEAR(kas.tgl_catat) = $year");
 		$latestpenambahandanapendidikan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 115 AND YEAR(kas.tgl_catat) = $latest_year");
 		$latestpenarikandanapendidikan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 115 AND YEAR(kas.tgl_catat) = $latest_year");
 		$saldoterakhirdanapendidikan = $latestdanapendidikan[0]['jumlah'] + $latestpenambahandanapendidikan->result_array()[0]['nominal'] - $latestpenarikandanapendidikan->result_array()[0]['nominal'];
 		$saldodanapendidikan = $penambahandanapendidikan->result_array()[0]['nominal'] + $danapendidikan[0]['jumlah'];

 		//DANA SOSIAL
 		$danasosial = $this->searchArray($totalshu['pembagiansisahasilusaha'], 'nama', 'Dana Sosial');
 		$latestdanasosial = $this->searchArray($latest_totalshu['pembagiansisahasilusaha'], 'nama', 'Dana Sosial');
 		$penambahandanasosial = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 116 AND YEAR(kas.tgl_catat) = $year");
 		$penarikandanasosial = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 116 AND YEAR(kas.tgl_catat) = $year");
 		$latestpenambahandanasosial = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 116 AND YEAR(kas.tgl_catat) = $latest_year");
 		$latestpenarikandanasosial = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 116 AND YEAR(kas.tgl_catat) = $latest_year");
 		$saldoterakhirdanasosial = $latestdanasosial[0]['jumlah'] + $latestpenambahandanasosial->result_array()[0]['nominal'] - $latestpenarikandanasosial->result_array()[0]['nominal'];
 		$saldodanasosial = $penambahandanasosial->result_array()[0]['nominal'] + $danasosial[0]['jumlah'];

 		$static_neraca_hutangjangkapendek = array(
 			array(
 				"title" => "Simpanan Sukarela",
 				"type" => "hutangjangkapendek",
 				"kode" => "HJPSS",
 				"tahun" => $year,
 				"nominal" => $latestsimpanansukarela + $simpanansukarela->result_array()[0]['nominal'] - $penarikansukarela->result_array()[0]['nominal']
 			),
 			array(
 				"title" => "Dana Pembangunan",
 				"type" => "hutangjangkapendek",
 				"kode" => "HJPDP",
 				"tahun" => $year,
 				"nominal" => $saldoterakhirdanapembangunan + $saldodanapembangunan - $penarikandanapembangunan->result_array()[0]['nominal']
 			),
 			array(
 				"title" => "Dana Pendidikan",
 				"type" => "hutangjangkapendek",
 				"kode" => "HJPDPendidikan",
 				"tahun" => $year,
 				"nominal" => $saldoterakhirdanapendidikan + $saldodanapendidikan - $penarikandanapendidikan->result_array()[0]['nominal']
 			),
 			array(
 				"title" => "Dana Sosial",
 				"type" => "hutangjangkapendek",
 				"kode" => "HJPDS",
 				"tahun" => $year,
 				"nominal" => $saldoterakhirdanasosial + $saldodanasosial - $penarikandanasosial->result_array()[0]['nominal']
 			)
 		);

 		//HUTANG JANGKA PANJANG
 		$latest_hjp = $this->db->query("SELECT SUM(latestkas.nominal) as nominal FROM saldo_kas latestkas WHERE latestkas.type = 'HJP' AND latestkas.tahun = $latest_year")->result_array()[0]['nominal'];
 		$penambahan_hjp = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 36 AND YEAR(kas.tgl_catat) = $year");
 		$pengambilan_hjp = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 36 AND YEAR(kas.tgl_catat) = $year");

 		$type_neraca_hutangjangkapanjang = array(
 			array(
 				"title" => "Saldo",
 				"type" => "hutangjangkapanjang",
 				"kode" => "HJP",
 				"tahun" => $year,
 				"nominal" => $latest_hjp + $penambahan_hjp->result_array()[0]['nominal'] - $pengambilan_hjp->result_array()[0]['nominal']
 			),
 		);

 		//MODALSENDIRI

 		$latest_simpananpokok = $this->db->query("SELECT SUM(latestkas.nominal) as nominal FROM saldo_kas latestkas WHERE latestkas.type = 'MSSP' AND latestkas.tahun = $latest_year")->result_array()[0]['nominal'];
 		$penambahan_simpananpokok = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 40 AND YEAR(kas.tgl_catat) = $year");
 		$pengambilan_simpananpokok = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 40 AND YEAR(kas.tgl_catat) = $year");

 		$latest_simpananwajib = $this->db->query("SELECT SUM(latestkas.nominal) as nominal FROM saldo_kas latestkas WHERE latestkas.type = 'MSSW' AND latestkas.tahun = $latest_year")->result_array()[0]['nominal'];
 		$penambahan_simpananwajib = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 41 AND YEAR(kas.tgl_catat) = $year");
 		$pengambilan_simpananwajib = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 41 AND YEAR(kas.tgl_catat) = $year");

 		$latest_simpanankhusus = $this->db->query("SELECT SUM(latestkas.nominal) as nominal FROM saldo_kas latestkas WHERE latestkas.type = 'MSSK' AND latestkas.tahun = $latest_year")->result_array()[0]['nominal'];
 		$penambahan_simpanankhusus = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 112 AND YEAR(kas.tgl_catat) = $year");
 		$pengambilan_simpanankhusus = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 112 AND YEAR(kas.tgl_catat) = $year");

 		//DANA CADANGAN
 		$danacadangan = $this->searchArray($totalshu['pembagiansisahasilusaha'], 'nama', 'Dana Cadangan');
 		$latestdanacadangan = $this->searchArray($latest_totalshu['pembagiansisahasilusaha'], 'nama', 'Dana Cadangan');
 		$penambahandanacadangan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 117 AND YEAR(kas.tgl_catat) = $year");
 		$penarikandanacadangan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 117 AND YEAR(kas.tgl_catat) = $year");
 		$latestpenambahandanacadangan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 117 AND YEAR(kas.tgl_catat) = $latest_year");
 		$latestpenarikandanacadangan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 117 AND YEAR(kas.tgl_catat) = $latest_year");
 		$saldoterakhirdanacadangan = $latestdanacadangan[0]['jumlah'] + $latestpenambahandanacadangan->result_array()[0]['nominal'] - $latestpenarikandanacadangan->result_array()[0]['nominal'];
 		$saldodanacadangan = $penambahandanacadangan->result_array()[0]['nominal'] + $danacadangan[0]['jumlah'];

 		$static_neraca_modalsendiri = array(
 			array(
 				"title" => "Simpanan Pokok",
 				"type" => "modalsendiri",
 				"kode" => "MSSP",
 				"tahun" => $year,
 				"nominal" => $latest_simpananpokok + $penambahan_simpananpokok->result_array()[0]['nominal'] - $pengambilan_simpananpokok->result_array()[0]['nominal']
 			),
 			array(
 				"title" => "Simpanan Wajib",
 				"type" => "modalsendiri",
 				"kode" => "MSSW",
 				"tahun" => $year,
 				"nominal" => $latest_simpananwajib + $penambahan_simpananwajib->result_array()[0]['nominal'] - $pengambilan_simpananwajib->result_array()[0]['nominal']
 			),
 			array(
 				"title" => "Simpanan Khusus",
 				"type" => "modalsendiri",
 				"kode" => "MSSK",
 				"tahun" => $year,
 				"nominal" => $latest_simpanankhusus + $penambahan_simpanankhusus->result_array()[0]['nominal'] - $pengambilan_simpanankhusus->result_array()[0]['nominal']
 			),
 			array(
 				"title" => "Dana Cadangan",
 				"type" => "modalsendiri",
 				"kode" => "MSDC",
 				"tahun" => $year,
 				"nominal" => $saldoterakhirdanacadangan + $saldodanacadangan - $penarikandanacadangan->result_array()[0]['nominal']
 			),
 			array(
 				"title" => "SHU Tahun Buku ".$year,
 				"type" => "modalsendiri",
 				"kode" => "MSSTB",
 				"tahun" => $year,
 				"nominal" => "$shu"
 			)
 		);

 		$data = array(
 			"hartalancar"=> $static_neraca_harta_lancar,
 			"penyertaan"=> $type_neraca_penyertaan,
 			"hargatetap"=> $type_neraca_hargatetap->result_array(),
 			"hutangjangkapendek"=> $static_neraca_hutangjangkapendek,
 			"hutangjangkapanjang"=> $type_neraca_hutangjangkapanjang,
 			"modalsendiri"=> $static_neraca_modalsendiri
 		);

 		return $data;
 	}

 	function lap_penjelasan_neraca($shu, $latest_shu, $year){
 		$latest_year = $year - 1;
 		$two_years_ago = $year - 2;

 		$list_lembaga = $this->db->query("SELECT neraca.title as title,
 			CASE neraca.id_type_neraca WHEN 1 THEN 'hartalancar' ELSE 'not registered' END as type , 
 			neraca.kode as kode, neraca.tahun as tahun, neraca.nominal as nominal FROM type_desc_neraca neraca 
 			WHERE neraca.id_type_neraca = 1 AND neraca.tahun = $year");

 		//KAS
 		$kas_pemasukan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE akun = 'Pemasukan' AND YEAR(kas.tgl_catat) = $year");
 		$kas_pengeluaran = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE akun = 'Pengeluaran' AND YEAR(kas.tgl_catat) = $year");
 		$latest_kas_pemasukan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE akun = 'Pemasukan' AND YEAR(kas.tgl_catat) = $latest_year");
 		$latest_kas_pengeluaran = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE akun = 'Pengeluaran' AND YEAR(kas.tgl_catat) = $latest_year");
 		$latest_kas = $this->db->query("SELECT SUM(latestkas.nominal) as nominal FROM saldo_kas latestkas WHERE latestkas.type = 'HLKas' AND latestkas.tahun = $latest_year")->result_array()[0]['nominal'];
 		
 		//BANK && GIRO
 		$pemasukan_bank = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 119 AND YEAR(kas.tgl_catat) = $year");
 		$pengeluaran_bank = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 119 AND YEAR(kas.tgl_catat) = $year");
 		$pemasukan_giro = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 118 AND YEAR(kas.tgl_catat) = $year");
 		$pengeluaran_giro = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 118 AND YEAR(kas.tgl_catat) = $year");

 		//PINJAMAN KOMSUMTIF
 		$pinjaman_komsumtif = $this->db->query("SELECT SUM(pinjaman.jumlah) as nominal FROM tbl_pinjaman_h pinjaman WHERE barang_id = 5 AND YEAR(pinjaman.tgl_pinjam) = $year");
 		$jasa_pinjaman_komsumtif = $this->db->query("SELECT FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100 + pinjaman.biaya_adm) * pinjaman.lama_angsuran) as nominal FROM tbl_pinjaman_h pinjaman 
 			WHERE barang_id = 5
 			AND YEAR(pinjaman.tgl_pinjam) = ".$year."");
 		$saldo_pinjaman_komsumtif = $pinjaman_komsumtif->result_array()[0]['nominal'] + $jasa_pinjaman_komsumtif->result_array()[0]['nominal'];
 		$penerimaan_pinjaman_komsumtif = $this->db->query("SELECT SUM(penerimaan.jumlah_bayar) as nominal 
 			FROM tbl_pinjaman_d penerimaan INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id=penerimaan.pinjam_id
 			WHERE pinjaman.barang_id = 5 AND YEAR(penerimaan.tgl_bayar) = $year");
 		$latest_saldo_pinjaman_komsumtif = $this->db->query("SELECT SUM(latestkas.nominal) as nominal FROM saldo_kas latestkas WHERE latestkas.type = 'HLPPK' AND latestkas.tahun = $latest_year")->result_array()[0]['nominal'];


 		//PINJAMAN BERJANGKA
 		$pinjaman_berjangka = $this->db->query("SELECT SUM(pinjaman.jumlah) as nominal FROM tbl_pinjaman_h pinjaman WHERE barang_id = 1 AND YEAR(pinjaman.tgl_pinjam) = $year");
 		$jasa_pinjaman_berjangka = $this->db->query("SELECT FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100 + pinjaman.biaya_adm) * pinjaman.lama_angsuran) as nominal FROM tbl_pinjaman_h pinjaman 
 			WHERE barang_id = 1
 			AND YEAR(pinjaman.tgl_pinjam) = ".$year."");
 		$saldo_pinjaman_berjangka = $pinjaman_berjangka->result_array()[0]['nominal'] + $jasa_pinjaman_berjangka->result_array()[0]['nominal'];
 		$penerimaan_pinjaman_berjangka = $this->db->query("SELECT SUM(penerimaan.jumlah_bayar) as nominal 
 			FROM tbl_pinjaman_d penerimaan INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id=penerimaan.pinjam_id
 			WHERE pinjaman.barang_id = 1 AND YEAR(penerimaan.tgl_bayar) = $year");
 		$latest_saldo_pinjaman_berjangka = $this->db->query("SELECT SUM(latestkas.nominal) as nominal FROM saldo_kas latestkas WHERE latestkas.type = 'HLPPB' AND latestkas.tahun = $latest_year")->result_array()[0]['nominal'];

 		//PINJAMAN BARANG
 		$pinjaman_barang = $this->db->query("SELECT SUM(pinjaman.jumlah) as nominal FROM tbl_pinjaman_h pinjaman WHERE barang_id = 4 AND YEAR(pinjaman.tgl_pinjam) = $year");
 		$jasa_pinjaman_barang = $this->db->query("SELECT FLOOR(sum(pinjaman.jumlah / pinjaman.lama_angsuran * FLOOR(pinjaman.bunga) / 100 + pinjaman.biaya_adm) * pinjaman.lama_angsuran) as nominal FROM tbl_pinjaman_h pinjaman 
 			WHERE barang_id = 4
 			AND YEAR(pinjaman.tgl_pinjam) = ".$year."");
 		$saldo_pinjaman_barang = $pinjaman_barang->result_array()[0]['nominal'] + $jasa_pinjaman_barang->result_array()[0]['nominal'];
 		$penerimaan_pinjaman_barang = $this->db->query("SELECT SUM(penerimaan.jumlah_bayar) as nominal 
 			FROM tbl_pinjaman_d penerimaan INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.id=penerimaan.pinjam_id
 			WHERE pinjaman.barang_id = 4 AND YEAR(penerimaan.tgl_bayar) = $year");
 		$latest_saldo_pinjaman_barang = $this->db->query("SELECT SUM(latestkas.nominal) as nominal FROM saldo_kas latestkas WHERE latestkas.type = 'HLPPBarang' AND latestkas.tahun = $latest_year")->result_array()[0]['nominal'];


 		$static_neraca_harta_lancar = array(
 			"Kas" => array(
 				"Kas Akhir Tahun $latest_year" => $latest_kas,
 				"Mutasi Pasa Tahun $year" => 0,
 				"Penerimaan Kas" => $kas_pemasukan->result_array()[0]['nominal'],
 				"Jumlah" => $latest_kas + $kas_pemasukan->result_array()[0]['nominal'],
 				"Pengeluaran Kas" => $kas_pengeluaran->result_array()[0]['nominal'],
 				"Saldo Kas Tahun $year" => $latest_kas + $kas_pemasukan->result_array()[0]['nominal'] - $kas_pengeluaran->result_array()[0]['nominal']
 			),
 			"Bank" => array(
 				// "kode" => "BANK",
 				"Pemasukan" => $pemasukan_bank->result_array()[0]['nominal'],
 				"Pengeluaran" => $pengeluaran_bank->result_array()[0]['nominal'],
 				"Saldo" => $pemasukan_bank->result_array()[0]['nominal'] - $pengeluaran_bank->result_array()[0]['nominal'],
 			),
 			"Giro" => array(
 				// "kode" => "GIRO",
 				"Pemasukan" => $pemasukan_giro->result_array()[0]['nominal'],
 				"Pengeluaran" => $pengeluaran_giro->result_array()[0]['nominal'],
 				"Saldo" => $pemasukan_giro->result_array()[0]['nominal'] - $pengeluaran_giro->result_array()[0]['nominal'],
 			),
 			
 			"Piutang Pinjaman Konsumtif" => array(
 				// "kode" => "HLPPK",
 				"Saldo Piutang Pinjaman $latest_year" => $latest_saldo_pinjaman_komsumtif,
 				"Mutasi Pada Tahun $year" => 0,
 				"Pinjaman" => $saldo_pinjaman_komsumtif,
 				"Jumlah" => $latest_saldo_pinjaman_komsumtif + $saldo_pinjaman_komsumtif,
 				"Penerimaan" => $penerimaan_pinjaman_komsumtif->result_array()[0]['nominal'],
 				"Saldo" => $latest_saldo_pinjaman_komsumtif + $saldo_pinjaman_komsumtif - $penerimaan_pinjaman_komsumtif->result_array()[0]['nominal']
 			),
 			"Piutang Pinjaman Berjangka" => array(
 				// "kode" => "HLPPB",
 				"Saldo Piutang Pinjaman $latest_year" => $latest_saldo_pinjaman_berjangka,
 				"Mutasi Pada Tahun $year" => 0,
 				"Pinjaman" => $saldo_pinjaman_berjangka,
 				"Jumlah" => $latest_saldo_pinjaman_berjangka + $saldo_pinjaman_berjangka,
 				"Penerimaan" => $penerimaan_pinjaman_berjangka->result_array()[0]['nominal'],
 				"Saldo" => $latest_saldo_pinjaman_berjangka + $saldo_pinjaman_berjangka - $penerimaan_pinjaman_berjangka->result_array()[0]['nominal']
 			),
 			"Piutang Pinjaman Barang" => array(
 				// "kode" => "HLPPBarang",
 				"Saldo Piutang Pinjaman $latest_year" => $latest_saldo_pinjaman_barang,
 				"Mutasi Pada Tahun $year" => 0,
 				"Pinjaman" => $saldo_pinjaman_barang,
 				"Jumlah" => $latest_saldo_pinjaman_barang + $saldo_pinjaman_barang,
 				"Penerimaan" => $penerimaan_pinjaman_barang->result_array()[0]['nominal'],
 				"Saldo" => $latest_saldo_pinjaman_barang + $saldo_pinjaman_barang - $penerimaan_pinjaman_barang->result_array()[0]['nominal']
 			)
 		);

 		//PENYERTAAN PKPRI
 		$latest_pkpri = $this->db->query("SELECT SUM(latestkas.nominal) as nominal FROM saldo_kas latestkas WHERE latestkas.type = 'PKPRI' AND latestkas.tahun = $latest_year")->result_array()[0]['nominal'];
 		$penambahan_pkpri = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 120 AND YEAR(kas.tgl_catat) = $year");
 		$pengambilan_pkpri = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 120 AND YEAR(kas.tgl_catat) = $year");

 		$type_neraca_penyertaan = array(
 			"PKPRI Kota Bekasi" => array(
 				// "kode" => "PKPRI",
 				"Saldo Simpanan Sukarela Tahun $year" => $latest_pkpri,
 				"Mutasi Pada Tahun $year" => 0,
 				"Penambahan" => $penambahan_pkpri->result_array()[0]['nominal'],
 				"Jumlah" => $latest_pkpri + $penambahan_pkpri->result_array()[0]['nominal'],
 				"Pengambilan" => $pengambilan_pkpri->result_array()[0]['nominal'],
 				"Saldo" => $latest_pkpri + $penambahan_pkpri->result_array()[0]['nominal'] - $pengambilan_pkpri->result_array()[0]['nominal']
 			),
 		);

 		$type_neraca_hargatetap = $this->db->query("SELECT neraca.nominal as Nominal FROM type_desc_neraca neraca 
 			WHERE neraca.id_type_neraca = 3 AND neraca.tahun = $year");

 		//SIMPANAN SUKARELA
 		$simpanansukarela = $this->db->query("SELECT SUM(simpanan.jumlah) as nominal FROM tbl_trans_sp simpanan WHERE simpanan.jenis_id = 32 AND simpanan.akun = 'Setoran' AND YEAR(simpanan.tgl_transaksi) = $year");
 		$latestsimpanansukarela = $this->db->query("SELECT SUM(latestkas.nominal) as nominal FROM saldo_kas latestkas WHERE latestkas.type = 'HJPSS' AND latestkas.tahun = $latest_year")->result_array()[0]['nominal'];
 		$penarikansukarela = $this->db->query("SELECT SUM(simpanan.jumlah) as nominal FROM tbl_trans_sp simpanan WHERE simpanan.jenis_id = 32 AND simpanan.akun = 'Penarikan' AND YEAR(simpanan.tgl_transaksi) = $year");

 		//SHU
 		$totalshu = $this->lap_keuangan_pembagian_shu($shu);
 		$latest_totalshu = $this->lap_keuangan_pembagian_shu($latest_shu);


 		//DANA PEMBANGUNAN
 		$danapembangunan = $this->searchArray($totalshu['pembagiansisahasilusaha'], 'nama', 'Dana Pembangunan');
 		$latestdanapembangunan = $this->searchArray($latest_totalshu['pembagiansisahasilusaha'], 'nama', 'Dana Pembangunan');
 		$penambahandanapembangunan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 114 AND YEAR(kas.tgl_catat) = $year");
 		$penarikandanapembangunan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 114 AND YEAR(kas.tgl_catat) = $year");
 		$latestpenambahandanapembangunan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 114 AND YEAR(kas.tgl_catat) = $latest_year");
 		$latestpenarikandanapembangunan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 114 AND YEAR(kas.tgl_catat) = $latest_year");
 		$saldoterakhirdanapembangunan = $latestdanapembangunan[0]['jumlah'] + $latestpenambahandanapembangunan->result_array()[0]['nominal'] - $latestpenarikandanapembangunan->result_array()[0]['nominal'];
 		$saldodanapembangunan = $penambahandanapembangunan->result_array()[0]['nominal'] + $danapembangunan[0]['jumlah'];

 		//DANA PENDIDIKAN
 		$danapendidikan = $this->searchArray($totalshu['pembagiansisahasilusaha'], 'nama', 'Dana Pendidikan');
 		$latestdanapendidikan = $this->searchArray($latest_totalshu['pembagiansisahasilusaha'], 'nama', 'Dana Pendidikan');
 		$penambahandanapendidikan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 115 AND YEAR(kas.tgl_catat) = $year");
 		$penarikandanapendidikan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 115 AND YEAR(kas.tgl_catat) = $year");
 		$latestpenambahandanapendidikan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 115 AND YEAR(kas.tgl_catat) = $latest_year");
 		$latestpenarikandanapendidikan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 115 AND YEAR(kas.tgl_catat) = $latest_year");
 		$saldoterakhirdanapendidikan = $latestdanapendidikan[0]['jumlah'] + $latestpenambahandanapendidikan->result_array()[0]['nominal'] - $latestpenarikandanapendidikan->result_array()[0]['nominal'];
 		$saldodanapendidikan = $penambahandanapendidikan->result_array()[0]['nominal'] + $danapendidikan[0]['jumlah'];

 		//DANA SOSIAL
 		$danasosial = $this->searchArray($totalshu['pembagiansisahasilusaha'], 'nama', 'Dana Sosial');
 		$latestdanasosial = $this->searchArray($latest_totalshu['pembagiansisahasilusaha'], 'nama', 'Dana Sosial');
 		$penambahandanasosial = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 116 AND YEAR(kas.tgl_catat) = $year");
 		$penarikandanasosial = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 116 AND YEAR(kas.tgl_catat) = $year");
 		$latestpenambahandanasosial = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 116 AND YEAR(kas.tgl_catat) = $latest_year");
 		$latestpenarikandanasosial = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 116 AND YEAR(kas.tgl_catat) = $latest_year");
 		$saldoterakhirdanasosial = $latestdanasosial[0]['jumlah'] + $latestpenambahandanasosial->result_array()[0]['nominal'] - $latestpenarikandanasosial->result_array()[0]['nominal'];
 		$saldodanasosial = $penambahandanasosial->result_array()[0]['nominal'] + $danasosial[0]['jumlah'];


 		$type_neraca_hutangjangkapendek = array(
 			"Simpanan Sukarela" => array(
 				// "kode" => "HJPSS",
 				"Saldo Simpanan Sukarela $latest_year" => $latestsimpanansukarela,
 				"Mutasi" => 0,
 				"Penambahan" => $simpanansukarela->result_array()[0]['nominal'],
 				"Jumlah" => $latestsimpanansukarela + $simpanansukarela->result_array()[0]['nominal'],
 				"Pengambilan" => $penarikansukarela->result_array()[0]['nominal'],
 				"Saldo Tahun $year" => $latestsimpanansukarela + $simpanansukarela->result_array()[0]['nominal'] - $penarikansukarela->result_array()[0]['nominal']
 			),
 			"Dana Pembangunan" => array(
 				// "kode" => "HJPDP",
 				"Saldo Dana Pembangunan $latest_year" => $saldoterakhirdanapembangunan,
 				"Mutasi" => 0,
 				"Penambahan" => $saldodanapembangunan,
 				"Jumlah" => $saldoterakhirdanapembangunan + $saldodanapembangunan,
 				"Pengambilan" => $penarikandanapembangunan->result_array()[0]['nominal'],
 				"Saldo Tahun $year" => $saldoterakhirdanapembangunan + $saldodanapembangunan - $penarikandanapembangunan->result_array()[0]['nominal']
 			),
 			"Dana Pendidikan" => array(
 				// "kode" => "HJPDPendidikan",
 				"Saldo Dana Pendidikan $latest_year" => $saldoterakhirdanapendidikan,
 				"Mutasi" => 0,
 				"Penambahan" => $saldodanapendidikan,
 				"Jumlah" => $saldoterakhirdanapendidikan + $saldodanapendidikan,
 				"Pengambilan" => $penarikandanapendidikan->result_array()[0]['nominal'],
 				"Saldo Tahun $year" => $saldoterakhirdanapendidikan + $saldodanapendidikan - $penarikandanapendidikan->result_array()[0]['nominal']
 			),
 			"Dana Sosial" => array(
 				// "kode" => "HJPDS",
 				"Saldo Dana Sosial $latest_year" => $saldoterakhirdanasosial,
 				"Mutasi" => 0,
 				"Penambahan" => $saldodanasosial,
 				"Jumlah" => $saldoterakhirdanasosial + $saldodanasosial,
 				"Pengambilan" => $penarikandanasosial->result_array()[0]['nominal'],
 				"Saldo Tahun $year" => $saldoterakhirdanasosial + $saldodanasosial - $penarikandanasosial->result_array()[0]['nominal']
 			),
 		);


		//HUTANG JANGKA PANJANG
 		$latest_hjp = $this->db->query("SELECT SUM(latestkas.nominal) as nominal FROM saldo_kas latestkas WHERE latestkas.type = 'HJP' AND latestkas.tahun = $latest_year")->result_array()[0]['nominal'];
 		$penambahan_hjp = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 36 AND YEAR(kas.tgl_catat) = $year");
 		$pengambilan_hjp = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 36 AND YEAR(kas.tgl_catat) = $year");
 		$type_neraca_hutangjangkapanjang = array(
			"Saldo Hutang Jangka Panjang Tahun $latest_year" => $latest_hjp,
			"Penambahan" => $penambahan_hjp->result_array()[0]['nominal'],
			"Jumlah" => $latest_hjp + $penambahan_hjp->result_array()[0]['nominal'],
			"Pembayaran" => $pengambilan_hjp->result_array()[0]['nominal'],
			"Saldo Tahun $year" => $latest_hjp + $penambahan_hjp->result_array()[0]['nominal'] - $pengambilan_hjp->result_array()[0]['nominal']
 		);

 		//MODALSENDIRI

 		$latest_simpananpokok = $this->db->query("SELECT SUM(latestkas.nominal) as nominal FROM saldo_kas latestkas WHERE latestkas.type = 'MSSP' AND latestkas.tahun = $latest_year")->result_array()[0]['nominal'];
 		$penambahan_simpananpokok = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 40 AND YEAR(kas.tgl_catat) = $year");
 		$pengambilan_simpananpokok = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 40 AND YEAR(kas.tgl_catat) = $year");

 		$latest_simpananwajib = $this->db->query("SELECT SUM(latestkas.nominal) as nominal FROM saldo_kas latestkas WHERE latestkas.type = 'MSSW' AND latestkas.tahun = $latest_year")->result_array()[0]['nominal'];
 		$penambahan_simpananwajib = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 41 AND YEAR(kas.tgl_catat) = $year");
 		$pengambilan_simpananwajib = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 41 AND YEAR(kas.tgl_catat) = $year");

 		$latest_simpanankhusus = $this->db->query("SELECT SUM(latestkas.nominal) as nominal FROM saldo_kas latestkas WHERE latestkas.type = 'MSSK' AND latestkas.tahun = $latest_year")->result_array()[0]['nominal'];
 		$penambahan_simpanankhusus = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 112 AND YEAR(kas.tgl_catat) = $year");
 		$pengambilan_simpanankhusus = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 112 AND YEAR(kas.tgl_catat) = $year");

 		//DANA CADANGAN
 		$danacadangan = $this->searchArray($totalshu['pembagiansisahasilusaha'], 'nama', 'Dana Cadangan');
 		$latestdanacadangan = $this->searchArray($latest_totalshu['pembagiansisahasilusaha'], 'nama', 'Dana Cadangan');
 		$penambahandanacadangan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 117 AND YEAR(kas.tgl_catat) = $year");
 		$penarikandanacadangan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 117 AND YEAR(kas.tgl_catat) = $year");
 		$latestpenambahandanacadangan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pemasukan' AND kas.jns_trans = 117 AND YEAR(kas.tgl_catat) = $latest_year");
 		$latestpenarikandanacadangan = $this->db->query("SELECT SUM(kas.jumlah) as nominal FROM tbl_trans_kas kas WHERE kas.akun = 'Pengeluaran' AND kas.jns_trans = 117 AND YEAR(kas.tgl_catat) = $latest_year");
 		$saldoterakhirdanacadangan = $latestdanacadangan[0]['jumlah'] + $latestpenambahandanacadangan->result_array()[0]['nominal'] - $latestpenarikandanacadangan->result_array()[0]['nominal'];
 		$saldodanacadangan = $penambahandanacadangan->result_array()[0]['nominal'] + $danacadangan[0]['jumlah'];

 		$type_neraca_modalsendiri = array(
 			"Simpanan Pokok" => array(
 				// "kode" => "MSSP",
 				"Saldo Simpanan Pokok Tahun $latest_year" => $latest_simpananpokok,
 				"Mutasi Pada Tahun $year" => 0,
 				"Penambahan" => $penambahan_simpananpokok->result_array()[0]['nominal'],
 				"Jumlah" => $latest_simpananpokok + $penambahan_simpananpokok->result_array()[0]['nominal'],
 				"Pengambilan" => $pengambilan_simpananpokok->result_array()[0]['nominal'],
 				"Saldo Tahun $year" => $latest_simpananpokok + $penambahan_simpananpokok->result_array()[0]['nominal'] - $pengambilan_simpananpokok->result_array()[0]['nominal']
 			),
 			"Simpanan Wajib" => array(
 				// "kode" => "MSSP",
 				"Saldo Simpanan Wajib Tahun $latest_year" => $latest_simpananwajib,
 				"Mutasi Pada Tahun $year" => 0,
 				"Penambahan" => $penambahan_simpananwajib->result_array()[0]['nominal'],
 				"Jumlah" => $latest_simpananwajib + $penambahan_simpananwajib->result_array()[0]['nominal'],
 				"Pengambilan" => $pengambilan_simpananwajib->result_array()[0]['nominal'],
 				"Saldo Tahun $year" => $latest_simpananwajib + $penambahan_simpananwajib->result_array()[0]['nominal'] - $pengambilan_simpananwajib->result_array()[0]['nominal']
 			),
 			"Simpanan Khusus" => array(
 				// "kode" => "MSSP",
 				"Saldo Simpanan Khusus Tahun $latest_year" => $latest_simpanankhusus,
 				"Mutasi Pada Tahun $year" => 0,
 				"Penambahan" => $penambahan_simpanankhusus->result_array()[0]['nominal'],
 				"Jumlah" => $latest_simpanankhusus + $penambahan_simpanankhusus->result_array()[0]['nominal'],
 				"Pengambilan" => $pengambilan_simpanankhusus->result_array()[0]['nominal'],
 				"Saldo Tahun $year" => $latest_simpanankhusus + $penambahan_simpanankhusus->result_array()[0]['nominal'] - $pengambilan_simpanankhusus->result_array()[0]['nominal']
 			),
 			"Dana Cadangan" => array(
 				// "kode" => "MSDC",
 				"Saldo Dana Cadangan Tahun $latest_year" => $saldoterakhirdanacadangan,
 				"Mutasi Pada Tahun $year" => 0,
 				"Penambahan" => $saldodanacadangan,
 				"Jumlah" => $saldoterakhirdanacadangan + $saldodanacadangan,
 				"Pengambilan" => $penarikandanacadangan->result_array()[0]['nominal'],
 				"Saldo Tahun $year" => $saldoterakhirdanacadangan + $saldodanacadangan - $penarikandanacadangan->result_array()[0]['nominal']
 			),
 		);


 		$data = array(
 			"Harta Lancar"=> $static_neraca_harta_lancar,
 			"Penyertaan"=> $type_neraca_penyertaan,
 			"Harga Tetap"=>  count($type_neraca_hargatetap->result()) == 0 ? [array()] : $type_neraca_hargatetap->result()[0],
 			"Hutang Jangka Pendek"=> $type_neraca_hutangjangkapendek,
 			"Hutang Jangka Panjang"=> $type_neraca_hutangjangkapanjang,
 			"Modal  Sendiri"=> $type_neraca_modalsendiri,
 		);

 		return $data;
 	}

 }