<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_dataKas extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	//panggil data simpanan untuk laporan
	function lap_data_kas() {
		$nama = isset($_REQUEST['nama']) ? $_REQUEST['nama'] : '';
		$aktif = isset($_REQUEST['aktif']) ? $_REQUEST['aktif'] : '';
		$sql = "SELECT nama_kas_tbl.* FROM nama_kas_tbl ";
		$where = "";
		$q = array('nama' => $nama,
			'aktif' => $aktif);
		if(is_array($q)) {
			if($q['nama'] != '') {
				$where .="WHERE nama_kas_tbl.nama = '".$q['nama']."' ";
			} else {
				if($q['aktif'] != '') {
					$where .="WHERE nama_kas_tbl.aktif = '".$q['aktif']."' ";
				}
			}
			if($q['nama'] != '' && $q['aktif'] != ''){
				$where = "WHERE nama_kas_tbl.nama = '".$q['nama']."' AND nama_kas_tbl.aktif = '".$q['aktif']."' ";
			}
		}
		$sql .= $where;
		$query = $this->db->query($sql);
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}

	//panggil data simpanan untuk esyui
	function get_data_transaksi_ajax($offset, $limit, $q='', $sort, $order) {
		$sql = "SELECT nama_kas_tbl.* FROM nama_kas_tbl ";
		$where = " ";
		if(is_array($q)) {
			if($q['nama'] != '') {
				$where .="WHERE nama_kas_tbl.nama = '".$q['nama']."' ";
			} else {
				if($q['aktif'] != '') {
					$where .="WHERE nama_kas_tbl.aktif = '".$q['aktif']."' ";
				}
			}

			if($q['nama'] != '' && $q['aktif'] != ''){
				$where = "WHERE nama_kas_tbl.nama = '".$q['nama']."' AND nama_kas_tbl.aktif = '".$q['aktif']."' ";
			}
		}
		$sql .= $where;
		$result['count'] = $this->db->query($sql)->num_rows();
		$sql .=" ORDER BY {$sort} {$order} ";
		$sql .=" LIMIT {$offset},{$limit} ";
		$result['data'] = $this->db->query($sql)->result();
		return $result;
	}

	public function create() {
		$data = array(
			'nama'			=>	$this->input->post('nama'),
			'aktif'			=>	$this->input->post('aktif'),
			'tmpl_simpan'	=>	$this->input->post('tmpl_simpan'),
			'tmpl_penarikan'	=>	$this->input->post('tmpl_penarikan'),
			'tmpl_pinjaman'	=>	$this->input->post('tmpl_pinjaman'),
			'tmpl_bayar'	=>	$this->input->post('tmpl_bayar'),
			'tmpl_pemasukan'	=>	$this->input->post('tmpl_pemasukan'),
			'tmpl_pengeluaran'	=>	$this->input->post('tmpl_pengeluaran'),
			'tmpl_transfer'	=>	$this->input->post('tmpl_transfer'),
			);
		return $this->db->insert('nama_kas_tbl', $data);
	}

	public function update($id)
	{
		$this->db->where('id', $id);
		return $this->db->update('nama_kas_tbl',array(
			'nama'			=>	$this->input->post('nama'),
			'aktif'			=>	$this->input->post('aktif'),
			'tmpl_simpan'	=>	$this->input->post('tmpl_simpan'),
			'tmpl_penarikan'	=>	$this->input->post('tmpl_penarikan'),
			'tmpl_pinjaman'	=>	$this->input->post('tmpl_pinjaman'),
			'tmpl_bayar'	=>	$this->input->post('tmpl_bayar'),
			'tmpl_pemasukan'	=>	$this->input->post('tmpl_pemasukan'),
			'tmpl_pengeluaran'	=>	$this->input->post('tmpl_pengeluaran'),
			'tmpl_transfer'	=>	$this->input->post('tmpl_transfer'),
			));
	}

	public function delete($id) {
		return $this->db->delete('nama_kas_tbl', array('id' => $id));
	}

}
