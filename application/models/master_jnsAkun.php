<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_jnsAkun extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	//panggil data simpanan untuk laporan
	function lap_data_jns_akun() {
		$jns_trans = isset($_REQUEST['jns_trans']) ? $_REQUEST['jns_trans'] : '';
		$akun = isset($_REQUEST['akun']) ? $_REQUEST['akun'] : '';
		$sql = " SELECT jns_akun.* FROM jns_akun ";
		$where = "";
		$q = array('jns_trans' => $jns_trans,
			'akun' => $akun);
		if(is_array($q)) {
			if($q['jns_trans'] != '') {
				$where .="WHERE jns_akun.jns_trans LIKE '%".$q['jns_trans']."%' ";
			} else {
				if($q['akun'] != '') {
					$where .="WHERE jns_akun.akun = '".$q['akun']."'";
				}
			}

			if($q['jns_trans'] != '' && $q['akun'] != ''){
				$where = "WHERE jns_akun.jns_trans LIKE '%".$q['jns_trans']."%' AND jns_akun.akun = '".$q['akun']."' ";
			}
		}
		$sql.=$where;
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
		$sql = "SELECT jns_akun.* FROM jns_akun ";
		$where = "  ";
		if(is_array($q)) {
			if($q['jns_trans'] != '') {
				$where .="WHERE jns_akun.jns_trans LIKE '%".$q['jns_trans']."%' ";
			} else {
				if($q['akun'] != '') {
					$where .="WHERE jns_akun.akun = '".$q['akun']."' ";
				}
			}

			if($q['jns_trans'] != '' && $q['akun'] != ''){
				$where = "WHERE jns_akun.jns_trans LIKE '%".$q['jns_trans']."%' AND jns_akun.akun = '".$q['akun']."' ";
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
			'jns_trans'			=>	$this->input->post('jns_trans'),
			'kd_aktiva'			=>	$this->input->post('kd_aktiva'),
			'akun'				=>	$this->input->post('akun'),
			'laba_rugi'			=>	$this->input->post('laba_rugi'),
			'pemasukan'			=>	$this->input->post('pemasukan'),
			'pengeluaran'		=>	$this->input->post('pengeluaran'),
			'aktif'				=>	$this->input->post('aktif'),
			);
		return $this->db->insert('jns_akun', $data);
	}

	public function update($id)
	{
		$this->db->where('id', $id);
		return $this->db->update('jns_akun',array(
			'jns_trans'			=>	$this->input->post('jns_trans'),
			'kd_aktiva'			=>	$this->input->post('kd_aktiva'),
			'akun'				=>	$this->input->post('akun'),
			'laba_rugi'			=>	$this->input->post('laba_rugi'),
			'pemasukan'			=>	$this->input->post('pemasukan'),
			'pengeluaran'		=>	$this->input->post('pengeluaran'),
			'aktif'				=>	$this->input->post('aktif'),
			));
	}

	public function delete($id) {
		return $this->db->delete('jns_akun', array('id' => $id));
	}
}
