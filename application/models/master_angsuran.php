<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_angsuran extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	//panggil data simpanan untuk laporan
	function lap_data_angsuran() {
		$aktif = isset($_REQUEST['aktif']) ? $_REQUEST['aktif'] : '';
		$sql = "SELECT * FROM jns_angsuran ";
		$where = "";
		$q = array('aktif' => $aktif);
		if(is_array($q)) {
			if($q['aktif'] != '') {
				$where .="WHERE aktif = '".$q['aktif']."' ";
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
		$sql = "SELECT jns_angsuran.* FROM jns_angsuran ";
		$where = " ";
		if(is_array($q)) {
			if($q['aktif'] != '') {
					$where .="WHERE jns_angsuran.aktif = '".$q['aktif']."' ";
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
			'ket'			=>	$this->input->post('ket'),
			'aktif'			=>	$this->input->post('aktif'),
			);
		return $this->db->insert('jns_angsuran', $data);
	}

	public function update($id)
	{
		$this->db->where('id', $id);
		return $this->db->update('jns_angsuran',array(
			'ket'			=>	$this->input->post('ket'),
			'aktif'			=>	$this->input->post('aktif'),
			));
	}

	public function delete($id) {
		return $this->db->delete('jns_angsuran', array('id' => $id));
	}
}
