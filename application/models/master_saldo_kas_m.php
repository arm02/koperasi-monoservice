<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_saldo_kas_m extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	//panggil data simpanan untuk laporan
	function get_data_kas_by_year($year) {
		$sql = "SELECT saldo_kas.* FROM saldo_kas ";
		$where = "";
		if($year != '') {
			$where .="WHERE saldo_kas.tahun = '".$year."' ";
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
	function get_data_kas_by_type($type,$tahun) {
		$this->db->select('*');
		$this->db->from('saldo_kas');
		if($type != '') {
			$this->db->where('type', $type);
		}
		if($tahun != '') {
			$this->db->where('tahun', $tahun);
		}
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}

	public function create($data) {
		if(is_array($data)) {
			return $this->db->insert('saldo_kas', $data);
		}
	}

	public function update($id,$data)
	{
		$this->db->where('id', $id);
		if(is_array($data)) {
			return $this->db->update('saldo_kas',$data);
		}
	}

	public function delete($id) {
		return $this->db->delete('saldo_kas', array('id' => $id));
	}

}
