<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Biaya_umum_m extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	//panggil data simpanan untuk laporan
	function lap_data_biaya_umum() {
		$uraian = isset($_REQUEST['uraian']) ? $_REQUEST['uraian'] : '';
		$untuk_kas = isset($_REQUEST['untuk_kas']) ? $_REQUEST['untuk_kas'] : '';
		$dari_akun = isset($_REQUEST['dari_akun']) ? $_REQUEST['dari_akun'] : '';
		$sql = "SELECT biaya_umum.* FROM biaya_umum ";
		$where = "";
		$q = array(
			'uraian' => $uraian,
			'untuk_kas' => $untuk_kas,
			'dari_akun' => $dari_akun,
		);
		if(is_array($q)) {
			if($q['uraian'] != '') {
				$where .="WHERE biaya_umum.uraian = '".$q['uraian']."' ";
			}
			else if($q['untuk_kas'] != '') {
				$where .="WHERE biaya_umum.untuk_kas = '".$q['untuk_kas']."' ";
			} else {
        		if($q['dari_akun'] != '') {
					$where .="WHERE biaya_umum.dari_akun = '".$q['dari_akun']."' ";
				}
	      	}

	      	if($q['uraian'] != '' && $q['untuk_kas'] != ''){
	      		$where ="WHERE biaya_umum.uraian LIKE '%".$q['uraian']."%' AND biaya_umum.untuk_kas = '".$q['untuk_kas']."'  ";
	      	}

	      	if($q['uraian'] != '' && $q['dari_akun'] != ''){
	      		$where ="WHERE biaya_umum.uraian LIKE '%".$q['uraian']."%' AND biaya_umum.dari_akun = '".$q['dari_akun']."'  ";
	      	}

	      	if($q['untuk_kas'] != '' && $q['dari_akun'] != ''){
	      		$where ="WHERE biaya_umum.dari_akun = '".$q['dari_akun']."' AND biaya_umum.untuk_kas = '".$q['untuk_kas']."'  ";
	      	}

	      	if($q['uraian'] != '' && $q['untuk_kas'] != '' && $q['dari_akun'] != ''){
	      		$where ="WHERE biaya_umum.uraian LIKE '%".$q['uraian']."%' AND biaya_umum.untuk_kas = '".$q['untuk_kas']."' AND biaya_umum.dari_akun = '".$q['dari_akun']."'";
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
		$sql = "SELECT biaya_umum.* FROM biaya_umum ";
		$where = " ";
		if(is_array($q)) {
			if($q['uraian'] != '') {
				$where .="WHERE biaya_umum.uraian = '".$q['uraian']."' ";
			}
			else if($q['untuk_kas'] != '') {
				$where .="WHERE biaya_umum.untuk_kas = '".$q['untuk_kas']."' ";
			} else {
        		if($q['dari_akun'] != '') {
					$where .="WHERE biaya_umum.dari_akun = '".$q['dari_akun']."' ";
				}
	      	}

	      	if($q['uraian'] != '' && $q['untuk_kas'] != ''){
	      		$where ="WHERE biaya_umum.uraian LIKE '%".$q['uraian']."%' AND biaya_umum.untuk_kas = '".$q['untuk_kas']."'  ";
	      	}

	      	if($q['uraian'] != '' && $q['dari_akun'] != ''){
	      		$where ="WHERE biaya_umum.uraian LIKE '%".$q['uraian']."%' AND biaya_umum.dari_akun = '".$q['dari_akun']."'  ";
	      	}

	      	if($q['untuk_kas'] != '' && $q['dari_akun'] != ''){
	      		$where ="WHERE biaya_umum.dari_akun = '".$q['dari_akun']."' AND biaya_umum.untuk_kas = '".$q['untuk_kas']."'  ";
	      	}

	      	if($q['uraian'] != '' && $q['untuk_kas'] != '' && $q['dari_akun'] != ''){
	      		$where ="WHERE biaya_umum.uraian LIKE '%".$q['uraian']."%' AND biaya_umum.untuk_kas = '".$q['untuk_kas']."' AND biaya_umum.dari_akun = '".$q['dari_akun']."'";
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
			'tanggal'			=>	$this->input->post('tanggal'),
			'uraian'			=>	$this->input->post('uraian'),
			'untuk_kas'	=>	$this->input->post('untuk_kas'),
			'dari_akun'	=>	$this->input->post('dari_akun'),
			'jumlah'	=>	$this->input->post('jumlah'),
			'created_by'	=>	$this->session->userdata('u_name'),
			);
		return $this->db->insert('biaya_umum', $data);
	}

	public function update($id)
	{
		$this->db->where('id', $id);
		return $this->db->update('biaya_umum',array(
			'tanggal'			=>	$this->input->post('tanggal'),
			'uraian'			=>	$this->input->post('uraian'),
			'untuk_kas'	=>	$this->input->post('untuk_kas'),
			'dari_akun'	=>	$this->input->post('dari_akun'),
			'jumlah'	=>	$this->input->post('jumlah'),
			'created_by'	=>	$this->session->userdata('u_name'),
			));
	}

	public function delete($id) {
		return $this->db->delete('biaya_umum', array('id' => $id));
	}

}
