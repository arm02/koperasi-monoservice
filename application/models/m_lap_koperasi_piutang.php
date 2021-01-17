<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_lap_koperasi_piutang extends CI_Model {

	public function __construct(){
		parent::__construct();
	}


	//panggil data db untuk esyui
	function get_pinjaman_perbulan($bulan,$tahun){

		$tagihan_berjangka = "SELECT COALESCE(SUM(CASE pinjaman_header.barang_id WHEN 1 then pinjaman_header.jumlah end),0) AS
		tagihan_berjangka FROM tbl_pinjaman_h pinjaman_header WHERE pinjaman_header.tgl_pinjam between '".$tahun."-".$bulan."-01' and '".$tahun."-".$bulan."-31'";
		$result_berjangka = $this->db->query($tagihan_berjangka)->result();

		$jasa_tagihan_berjangka = "SELECT COALESCE(SUM(CASE pinjaman_header.barang_id WHEN 1 then FLOOR(((pinjaman_header.jumlah*(pinjaman_header.bunga/100))+pinjaman_header.biaya_adm)*pinjaman_header.lama_angsuran) end),0) AS
		jasa_tagihan_berjangka FROM tbl_pinjaman_h pinjaman_header WHERE pinjaman_header.tgl_pinjam between '".$tahun."-".$bulan."-01' and '".$tahun."-".$bulan."-31'";
		$result_jasa_berjangka = $this->db->query($jasa_tagihan_berjangka)->result();

		$tagihan_barang = "SELECT COALESCE(SUM(CASE pinjaman_header.barang_id WHEN 4 then pinjaman_header.jumlah end),0) AS
		tagihan_barang FROM tbl_pinjaman_h pinjaman_header WHERE pinjaman_header.tgl_pinjam between '".$tahun."-".$bulan."-01' and '".$tahun."-".$bulan."-31'";
		$result_barang = $this->db->query($tagihan_barang)->result();

		$jasa_tagihan_barang = "SELECT COALESCE(SUM(CASE pinjaman_header.barang_id WHEN 4 then FLOOR(((pinjaman_header.jumlah*(pinjaman_header.bunga/100))+pinjaman_header.biaya_adm)*pinjaman_header.lama_angsuran) end),0) AS
		jasa_tagihan_barang FROM tbl_pinjaman_h pinjaman_header WHERE pinjaman_header.tgl_pinjam between '".$tahun."-".$bulan."-01' and '".$tahun."-".$bulan."-31'";
		$result_jasa_barang = $this->db->query($jasa_tagihan_barang)->result();

		$tagihan_konsumtif = "SELECT COALESCE(SUM(CASE pinjaman_header.barang_id WHEN 5 then pinjaman_header.jumlah end),0) AS
		tagihan_konsumtif FROM tbl_pinjaman_h pinjaman_header WHERE pinjaman_header.tgl_pinjam between '".$tahun."-".$bulan."-01' and '".$tahun."-".$bulan."-31'";
		$result_konsumtif = $this->db->query($tagihan_konsumtif)->result();

		$jasa_tagihan_konsumtif = "SELECT COALESCE(SUM(CASE pinjaman_header.barang_id WHEN 5 then FLOOR(((pinjaman_header.jumlah*(pinjaman_header.bunga/100))+pinjaman_header.biaya_adm)*pinjaman_header.lama_angsuran) end),0) AS
		jasa_tagihan_konsumtif FROM tbl_pinjaman_h pinjaman_header WHERE pinjaman_header.tgl_pinjam between '".$tahun."-".$bulan."-01' and '".$tahun."-".$bulan."-31'";
		$result_jasa_konsumtif = $this->db->query($jasa_tagihan_konsumtif)->result();

		$dari_bendahara = "SELECT COALESCE(sum(jumlah),0) as jumlah from bendahara WHERE tanggal between '".$tahun."-".$bulan."-01' and '".$tahun."-".$bulan."-31'";
		$result_dari_bendahara = $this->db->query($dari_bendahara)->result();

		$pelunasan_barang = "SELECT COALESCE(sum(detail.jumlah_bayar+detail.denda_rp),0) as jumlah FROM tbl_pinjaman_d detail
		left join tbl_pinjaman_h pinjaman on detail.pinjam_id = pinjaman.id where pinjaman.barang_id = 5 AND detail.tgl_bayar between '".$tahun."-".$bulan."-01' and '".$tahun."-".$bulan."-31'";
		$result_pelunasan_barang = $this->db->query($pelunasan_barang)->result();

		$pelunasan_berjangka = "SELECT COALESCE(sum(detail.jumlah_bayar+detail.denda_rp),0) as jumlah FROM tbl_pinjaman_d detail
		left join tbl_pinjaman_h pinjaman on detail.pinjam_id = pinjaman.id where pinjaman.barang_id = 1 AND detail.tgl_bayar between '".$tahun."-".$bulan."-01' and '".$tahun."-".$bulan."-31'";
		$result_pelunasan_berjangka = $this->db->query($pelunasan_berjangka)->result();

		$pelunasan_konsumtif = "SELECT COALESCE(sum(detail.jumlah_bayar+detail.denda_rp),0) as jumlah FROM tbl_pinjaman_d detail
		left join tbl_pinjaman_h pinjaman on detail.pinjam_id = pinjaman.id where pinjaman.barang_id = 5 AND detail.tgl_bayar between '".$tahun."-".$bulan."-01' and '".$tahun."-".$bulan."-31'";
		$result_pelunasan_konsumtif = $this->db->query($pelunasan_konsumtif)->result();

		$result_provisi = $this->db->query("SELECT COALESCE((COUNT(*) * header.biaya_adm),0) as provisi  FROM tbl_pinjaman_d detail INNER JOIN tbl_pinjaman_h header ON header.id=detail.pinjam_id WHERE YEAR(detail.tgl_bayar) = '".$tahun."' AND MONTH(detail.tgl_bayar) = '".$bulan."'")->result_array()[0]['provisi'];

		$result_pinjaman_berjangka = $this->db->query("SELECT COALESCE(SUM(jumlah),0) as jumlah from tbl_pinjaman_h where barang_id = 1 and YEAR(tgl_pinjam) = '".$tahun."' AND MONTH(tgl_pinjam) = '".$bulan."'")->result_array()[0]['jumlah'];
		$result_pinjaman_barang = $this->db->query("SELECT COALESCE(SUM(jumlah),0) as jumlah from tbl_pinjaman_h where barang_id = 4 and YEAR(tgl_pinjam) = '".$tahun."' AND MONTH(tgl_pinjam) = '".$bulan."'")->result_array()[0]['jumlah'];
		$result_pinjaman_konsumtif = $this->db->query("SELECT COALESCE(SUM(jumlah),0) as jumlah from tbl_pinjaman_h where barang_id = 5 and YEAR(tgl_pinjam) = '".$tahun."' AND MONTH(tgl_pinjam) = '".$bulan."'")->result_array()[0]['jumlah'];



		//saldo di bulan sebelumnya

		//pinjaman

		$year_before = $this->db->query("SELECT YEAR(DATE_SUB('".$tahun."-".$bulan."-01', INTERVAL 1 MONTH)) as tahun")->result_array()[0]['tahun'];
		$month_before = $this->db->query("SELECT MONTH(DATE_SUB('".$tahun."-".$bulan."-01', INTERVAL 1 MONTH)) as bulan")->result_array()[0]['bulan'];

		$result_sblm_pinjaman_berjangka = $this->db->query("SELECT COALESCE(SUM(jumlah),0) as jumlah from tbl_pinjaman_h where barang_id = 1 and YEAR(tgl_pinjam) = '".$year_before."' AND MONTH(tgl_pinjam) = '".$month_before."'")->result_array()[0]['jumlah'];
		$result_sblm_pinjaman_barang = $this->db->query("SELECT COALESCE(SUM(jumlah),0) as jumlah from tbl_pinjaman_h where barang_id = 4 and YEAR(tgl_pinjam) = '".$year_before."' AND MONTH(tgl_pinjam) = '".$month_before."'")->result_array()[0]['jumlah'];
		$result_sblm_pinjaman_konsumtif = $this->db->query("SELECT COALESCE(SUM(jumlah),0) as jumlah from tbl_pinjaman_h where barang_id = 5 and YEAR(tgl_pinjam) = '".$year_before."' AND MONTH(tgl_pinjam) = '".$month_before."'")->result_array()[0]['jumlah'];

		$tagihan_sblm_berjangka = "SELECT COALESCE(SUM(CASE pinjaman_header.barang_id WHEN 1 then pinjaman_header.jumlah end),0) AS
		tagihan_berjangka FROM tbl_pinjaman_h pinjaman_header WHERE pinjaman_header.tgl_pinjam between '".$year_before."-".$month_before."-01' and '".$year_before."-".$month_before."-31'";
		$result_sblm_berjangka = $this->db->query($tagihan_sblm_berjangka)->result();

		$jasa_sblm_tagihan_berjangka = "SELECT COALESCE(SUM(CASE pinjaman_header.barang_id WHEN 1 then FLOOR(((pinjaman_header.jumlah*(pinjaman_header.bunga/100))+pinjaman_header.biaya_adm)*pinjaman_header.lama_angsuran) end),0) AS
		jasa_tagihan_berjangka FROM tbl_pinjaman_h pinjaman_header WHERE pinjaman_header.tgl_pinjam between '".$year_before."-".$month_before."-01' and '".$year_before."-".$month_before."-31'";
		$result_sblm_jasa_berjangka = $this->db->query($jasa_sblm_tagihan_berjangka)->result();

		$tagihan_sblm_barang = "SELECT COALESCE(SUM(CASE pinjaman_header.barang_id WHEN 4 then pinjaman_header.jumlah end),0) AS
		tagihan_barang FROM tbl_pinjaman_h pinjaman_header WHERE pinjaman_header.tgl_pinjam between '".$year_before."-".$month_before."-01' and '".$year_before."-".$month_before."-31'";
		$result_sblm_barang = $this->db->query($tagihan_sblm_barang)->result();

		$jasa_sblm_tagihan_barang = "SELECT COALESCE(SUM(CASE pinjaman_header.barang_id WHEN 4 then FLOOR(((pinjaman_header.jumlah*(pinjaman_header.bunga/100))+pinjaman_header.biaya_adm)*pinjaman_header.lama_angsuran) end),0) AS
		jasa_tagihan_barang FROM tbl_pinjaman_h pinjaman_header WHERE pinjaman_header.tgl_pinjam between '".$year_before."-".$month_before."-01' and '".$year_before."-".$month_before."-31'";
		$result_sblm_jasa_barang = $this->db->query($jasa_sblm_tagihan_barang)->result();

		$tagihan_sblm_konsumtif = "SELECT COALESCE(SUM(CASE pinjaman_header.barang_id WHEN 5 then pinjaman_header.jumlah end),0) AS
		tagihan_konsumtif FROM tbl_pinjaman_h pinjaman_header WHERE pinjaman_header.tgl_pinjam between '".$year_before."-".$month_before."-01' and '".$year_before."-".$month_before."-31'";
		$result_sblm_konsumtif = $this->db->query($tagihan_sblm_konsumtif)->result();

		$jasa_sblm_tagihan_konsumtif = "SELECT COALESCE(SUM(CASE pinjaman_header.barang_id WHEN 5 then FLOOR(((pinjaman_header.jumlah*(pinjaman_header.bunga/100))+pinjaman_header.biaya_adm)*pinjaman_header.lama_angsuran) end),0) AS
		jasa_tagihan_konsumtif FROM tbl_pinjaman_h pinjaman_header WHERE pinjaman_header.tgl_pinjam between '".$year_before."-".$month_before."-01' and '".$year_before."-".$month_before."-31'";
		$result_sblm_jasa_konsumtif = $this->db->query($jasa_sblm_tagihan_konsumtif)->result();

		$dari_sblm_bendahara = "SELECT COALESCE(sum(jumlah),0) as jumlah from bendahara WHERE tanggal between '".$year_before."-".$month_before."-01' and '".$year_before."-".$month_before."-31'";
		$result_sblm_dari_bendahara = $this->db->query($dari_sblm_bendahara)->result();

		$pelunasan_sblm_barang = "SELECT COALESCE(sum(detail.jumlah_bayar+detail.denda_rp),0) as jumlah FROM tbl_pinjaman_d detail
		left join tbl_pinjaman_h pinjaman on detail.pinjam_id = pinjaman.id where pinjaman.barang_id = 5 AND detail.tgl_bayar between '".$year_before."-".$month_before."-01' and '".$year_before."-".$month_before."-31'";
		$result_sblm_pelunasan_barang = $this->db->query($pelunasan_sblm_barang)->result();

		$pelunasan_sblm_berjangka = "SELECT COALESCE(sum(detail.jumlah_bayar+detail.denda_rp),0) as jumlah FROM tbl_pinjaman_d detail
		left join tbl_pinjaman_h pinjaman on detail.pinjam_id = pinjaman.id where pinjaman.barang_id = 1 AND detail.tgl_bayar between '".$year_before."-".$month_before."-01' and '".$year_before."-".$month_before."-31'";
		$result_sblm_pelunasan_berjangka = $this->db->query($pelunasan_sblm_berjangka)->result();

		$pelunasan_sblm_konsumtif = "SELECT COALESCE(sum(detail.jumlah_bayar+detail.denda_rp),0) as jumlah FROM tbl_pinjaman_d detail
		left join tbl_pinjaman_h pinjaman on detail.pinjam_id = pinjaman.id where pinjaman.barang_id = 5 AND detail.tgl_bayar between '".$year_before."-".$month_before."-01' and '".$year_before."-".$month_before."-31'";
		$result_sblm_pelunasan_konsumtif = $this->db->query($pelunasan_sblm_konsumtif)->result();

		$result_sblm_provisi = $this->db->query("SELECT COALESCE((COUNT(*) * header.biaya_adm),0) as provisi  FROM tbl_pinjaman_d detail INNER JOIN tbl_pinjaman_h header ON header.id=detail.pinjam_id WHERE YEAR(detail.tgl_bayar) = '".$year_before."' AND MONTH(detail.tgl_bayar) = '".$bulan."'")->result_array()[0]['provisi'];




		$data = array(
			'year_before' => $year_before,
			'month_before' => $month_before,
			'tagihan_berjangka' => $result_berjangka[0]->tagihan_berjangka,
			'jasa_tagihan_berjangka' => $result_jasa_berjangka[0]->jasa_tagihan_berjangka,
			'jasa_tagihan_barang' => $result_jasa_barang[0]->jasa_tagihan_barang,
			'jasa_tagihan_konsumtif' => $result_jasa_konsumtif[0]->jasa_tagihan_konsumtif,
			'tagihan_konsumtif' => $result_konsumtif[0]->tagihan_konsumtif,
			'tagihan_barang' 		=> $result_barang[0]->tagihan_barang,
			'dari_bendahara' 		=> $result_dari_bendahara[0]->jumlah,
			'pelunasan_barang' => $result_pelunasan_barang[0]->jumlah,
			'pelunasan_berjangka' => $result_pelunasan_berjangka[0]->jumlah,
			'total_provisi' => $result_provisi,
			'pinjaman_berjangka' => $result_pinjaman_berjangka,
			'pinjaman_barang' => $result_pinjaman_barang,
			'pinjaman_konsumtif' => $result_pinjaman_konsumtif,
			'total_pinjaman' => $result_pinjaman_konsumtif+$result_pinjaman_berjangka+$result_pinjaman_barang,
			'saldo_bulan_sekarang' => ($result_berjangka[0]->tagihan_berjangka+$result_konsumtif[0]->tagihan_konsumtif+$result_barang[0]->tagihan_barang+$result_provisi+$result_jasa_berjangka[0]->jasa_tagihan_berjangka+ $result_jasa_barang[0]->jasa_tagihan_barang+$result_jasa_konsumtif[0]->jasa_tagihan_konsumtif) - ($result_pinjaman_konsumtif+$result_pinjaman_berjangka+$result_pinjaman_barang)
			 + (($result_pelunasan_barang[0]->jumlah+$result_pelunasan_berjangka[0]->jumlah)+$result_pelunasan_barang[0]->jumlah+$result_pelunasan_berjangka[0]->jumlah),
			'total_pokok' => $result_berjangka[0]->tagihan_berjangka+$result_konsumtif[0]->tagihan_konsumtif+$result_barang[0]->tagihan_barang+$result_provisi,
			'total_jasa' => $result_jasa_berjangka[0]->jasa_tagihan_berjangka+ $result_jasa_barang[0]->jasa_tagihan_barang+$result_jasa_konsumtif[0]->jasa_tagihan_konsumtif,
			'jasa_saldo_bulan_sebelum' => ($result_sblm_berjangka[0]->tagihan_berjangka+$result_sblm_konsumtif[0]->tagihan_konsumtif+$result_sblm_barang[0]->tagihan_barang+$result_sblm_provisi+$result_sblm_jasa_berjangka[0]->jasa_tagihan_berjangka+$result_sblm_jasa_barang[0]->jasa_tagihan_barang+$result_sblm_jasa_konsumtif[0]->jasa_tagihan_konsumtif+$result_sblm_pelunasan_barang[0]->jumlah+$result_sblm_pelunasan_berjangka[0]->jumlah) - ($result_sblm_pinjaman_konsumtif+$result_sblm_pinjaman_berjangka+$result_sblm_pinjaman_barang),

		);

		return $data;

	}
	function get_data_db_ajax($offset, $limit, $sort, $order, $tahun) {

		$sql = "SELECT anggota.nama AS nama_anggota,
		SUM(CASE pinjaman_header.barang_id WHEN 1 then pinjaman_header.jumlah end) AS pinjaman_berjangka,
		SUM(CASE pinjaman_header.barang_id WHEN 5 then pinjaman_header.jumlah end) AS pinjaman_konsumtif,
		SUM(CASE pinjaman_header.barang_id WHEN 4 then pinjaman_header.jumlah end) AS pinjaman_barang,
	    SUM(CASE pinjaman_header.barang_id WHEN 1 then FLOOR(((pinjaman_header.jumlah*(pinjaman_header.bunga/100))+pinjaman_header.biaya_adm)*pinjaman_header.lama_angsuran) end) AS bunga_berjangka,
	    SUM(CASE pinjaman_header.barang_id WHEN 4 then FLOOR(((pinjaman_header.jumlah*(pinjaman_header.bunga/100))+pinjaman_header.biaya_adm)*pinjaman_header.lama_angsuran) end) AS bunga_barang,
    	SUM(CASE pinjaman_header.barang_id WHEN 5 then FLOOR(((pinjaman_header.jumlah*(pinjaman_header.bunga/100))+pinjaman_header.biaya_adm)*pinjaman_header.lama_angsuran) end) AS bunga_konsumtif
		FROM tbl_pinjaman_h pinjaman_header
        LEFT join tbl_pinjaman_d detail on pinjaman_header.id = detail.pinjam_id
        LEFT join tbl_anggota anggota on pinjaman_header.anggota_id = anggota.id";

		$where =" WHERE pinjaman_header.tgl_pinjam between '".$tahun."-01-01' and '".$tahun."-12-31' GROUP BY anggota.nama ";

		$sql .= $where;
		// print_r($sql .= $where);
		$result['count'] = $this->db->query($sql)->num_rows();
		$sql .=" ORDER BY {$sort} {$order} ";
		if($offset || $limit){
			$sql .=" LIMIT {$offset},{$limit} ";
		}
		$result['data'] = $this->db->query($sql)->result();
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
