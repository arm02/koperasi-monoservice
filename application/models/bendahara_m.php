<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bendahara_m extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	//panggil data simpanan untuk laporan
	function lap_data_bendahara() {
		$uraian = isset($_REQUEST['uraian']) ? $_REQUEST['uraian'] : '';
		$untuk_kas = isset($_REQUEST['untuk_kas']) ? $_REQUEST['untuk_kas'] : '';
		$dari_akun = isset($_REQUEST['dari_akun']) ? $_REQUEST['dari_akun'] : '';
		$sql = "SELECT bendahara.* FROM bendahara ";
		$where = "";
		$q = array(
			'uraian' => $uraian,
			'untuk_kas' => $untuk_kas,
			'dari_akun' => $dari_akun,
		);
		if(is_array($q)) {
			if($q['uraian'] != '') {
				$where .="WHERE bendahara.uraian = '".$q['uraian']."' ";
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
		$sql = "SELECT bendahara.* FROM bendahara ";
		$where = " ";
		if(is_array($q)) {
			if($q['uraian'] != '') {
				$where .="WHERE bendahara.uraian = '".$q['uraian']."' ";
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
			'jumlah'	=>	$this->input->post('jumlah'),
			'created_by'	=>	$this->session->userdata('u_name'),
			);
		return $this->db->insert('bendahara', $data);
	}

	public function update($id)
	{
		$this->db->where('id', $id);
		return $this->db->update('bendahara',array(
			'tanggal'			=>	$this->input->post('tanggal'),
			'uraian'			=>	$this->input->post('uraian'),
			'jumlah'	=>	$this->input->post('jumlah'),
			'created_by'	=>	$this->session->userdata('u_name'),
			));
	}

	public function delete($id) {
		return $this->db->delete('bendahara', array('id' => $id));
	}

}
