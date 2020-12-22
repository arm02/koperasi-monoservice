<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_lap_koperasi_piutang extends CI_Model {

	public function __construct(){
		parent::__construct();
	}


	//panggil data db untuk esyui
	function get_data_db_ajax($offset = null, $limit = null, $q='', $sort) {

		$sql = "SELECT anggota.nama AS nama_anggota,
		(CASE barang.kode_barang WHEN 'PBRJ' then SUM(pinjaman_header.jumlah) end) AS pinjaman_berjangka,
		(CASE barang.kode_barang WHEN 'PJMKNSTF' then SUM(pinjaman_header.jumlah) end) AS pinjaman_konsumtif,
		(CASE barang.kode_barang WHEN 'PNJMBRG' then SUM(pinjaman_header.jumlah) end) AS pinjaman_barang
		from tbl_barang barang
		INNER JOIN tbl_pinjaman_h pinjaman_header ON barang.id = pinjaman_header.barang_id
		INNER JOIN tbl_anggota anggota ON pinjaman_header.anggota_id = anggota.id";

		$where = "";
		if(is_array($q)) {
			if($q['tgl_dari'] != '' && $q['tgl_samp'] != '') {
				$where .=" WHERE pinjaman_header.tgl_pinjam between '".$q['tgl_dari']."' and '".$q['tgl_samp']."' GROUP BY anggota.nama ORDER BY anggota.nama ASC";
			}
		}

		$sql .= $where;
		$result['count'] = $this->db->query($sql)->num_rows();
		$sql .=" GROUP BY anggota.nama ORDER BY ${sort} ASC ";
		if($offset && $limit){
			$sql .=" LIMIT {$offset},{$limit} ";
		}

		$result['rows'] = $this->db->query($sql)->result();
		return $result;
	}
}
