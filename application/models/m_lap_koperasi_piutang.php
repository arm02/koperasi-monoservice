<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_lap_koperasi_piutang extends CI_Model {

	public function __construct(){
		parent::__construct();
	}


	//panggil data db untuk esyui
	function get_data_db_ajax($offset = null, $limit = null, $sort, $order, $tahun) {

		$sql = "SELECT anggota.nama AS nama_anggota,
		(CASE barang.kode_barang WHEN 'PBRJ' then SUM(pinjaman_header.jumlah) end) AS pinjaman_berjangka,
		(CASE barang.kode_barang WHEN 'PJMKNSTF' then SUM(pinjaman_header.jumlah) end) AS pinjaman_konsumtif,
		(CASE barang.kode_barang WHEN 'PNJMBRG' then SUM(pinjaman_header.jumlah) end) AS pinjaman_barang
		from tbl_barang barang
		INNER JOIN tbl_pinjaman_h pinjaman_header ON barang.id = pinjaman_header.barang_id
		INNER JOIN tbl_anggota anggota ON pinjaman_header.anggota_id = anggota.id	";

		$where =" WHERE pinjaman_header.tgl_pinjam between '".$tahun."-01-01' and '".$tahun."-12-31' GROUP BY anggota.nama ";

		$sql .= $where;
		// print_r($sql .= $where);
		$result['count'] = $this->db->query($sql)->num_rows();
		$sql .=" ORDER BY nama_anggota {$order} ";
		if($offset && $limit){
			$sql .=" LIMIT {$offset},{$limit} ";
		}
		$result['rows'] = $this->db->query($sql)->result();
		return $result;
	}

	function lap_koperasi_jasa_berjangka($limit = 0, $offset = 0,$q = "") {
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
			$data[] = $this->getListJasaBerjangka($row['anggota_id'],$row["nama"], $q);
		endforeach;
		$result["count"] = $this->db->query($count)->num_rows();
		$result["rows"] = $data;
		return $result;
	}


	function getListJasaBerjangka($id,$nama_anggota,$q = "") {
		$saldo1 = date("Y",strtotime("-1 year"));
		$saldo2 = date("Y",strtotime("-2 year"));
		$sql = "SELECT anggota.nama as nama,
		((((pinjaman.bunga/100)*pinjaman.jumlah)/pinjaman.lama_angsuran+pinjaman.biaya_adm)) as jumlah,
		detail.tgl_bayar as tgl_bayar,
		EXTRACT( MONTH FROM detail.tgl_bayar ) as bulan_transaksi,
		EXTRACT( YEAR FROM detail.tgl_bayar ) as tahun_transaksi
		FROM tbl_anggota anggota
		INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.anggota_id=anggota.id AND pinjaman.barang_id=1
		INNER JOIN tbl_pinjaman_d detail ON detail.pinjam_id = pinjaman.id
		where anggota.id = ".$id."";

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

	function lap_koperasi_jasa_konsumtif($limit = 0, $offset = 0,$q = "") {
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
			$data[] = $this->getListJasaKonsumtif($row['anggota_id'],$row["nama"], $q);
		endforeach;
		$result["count"] = $this->db->query($count)->num_rows();
		$result["rows"] = $data;
		return $result;
	}


	function getListJasaKonsumtif($id,$nama_anggota,$q = "") {
		$saldo1 = date("Y",strtotime("-1 year"));
		$saldo2 = date("Y",strtotime("-2 year"));
		$sql = "SELECT anggota.nama as nama,
		((((pinjaman.bunga/100)*pinjaman.jumlah)/pinjaman.lama_angsuran+pinjaman.biaya_adm)) as jumlah,
		detail.tgl_bayar as tgl_bayar,
		EXTRACT( MONTH FROM detail.tgl_bayar ) as bulan_transaksi,
		EXTRACT( YEAR FROM detail.tgl_bayar ) as tahun_transaksi
		FROM tbl_anggota anggota
		INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.anggota_id=anggota.id AND pinjaman.barang_id=5
		INNER JOIN tbl_pinjaman_d detail ON detail.pinjam_id = pinjaman.id
		where anggota.id = ".$id."";

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

	function lap_koperasi_jasa_barang($limit = 0, $offset = 0,$q = "") {
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
			$data[] = $this->getListJasaBarang($row['anggota_id'],$row["nama"], $q);
		endforeach;
		$result["count"] = $this->db->query($count)->num_rows();
		$result["rows"] = $data;
		return $result;
	}


	function getListJasaBarang($id,$nama_anggota,$q = "") {
		$saldo1 = date("Y",strtotime("-1 year"));
		$saldo2 = date("Y",strtotime("-2 year"));
		$sql = "SELECT anggota.nama as nama,
		((((pinjaman.bunga/100)*pinjaman.jumlah)/pinjaman.lama_angsuran+pinjaman.biaya_adm)) as jumlah,
		detail.tgl_bayar as tgl_bayar,
		EXTRACT( MONTH FROM detail.tgl_bayar ) as bulan_transaksi,
		EXTRACT( YEAR FROM detail.tgl_bayar ) as tahun_transaksi
		FROM tbl_anggota anggota
		INNER JOIN tbl_pinjaman_h pinjaman ON pinjaman.anggota_id=anggota.id AND pinjaman.barang_id=4
		INNER JOIN tbl_pinjaman_d detail ON detail.pinjam_id = pinjaman.id
		where anggota.id = ".$id."";

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
}
