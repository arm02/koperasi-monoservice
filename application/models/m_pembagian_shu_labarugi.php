<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_pembagian_shu_labarugi extends CI_Model {

	public function __construct(){
		parent::__construct();
	}


	//panggil data db untuk esyui
	function get_data_db_ajax($offset, $limit, $q='', $sort, $order) {
		$sql = "SELECT pembagian_shu_labarugi.* FROM pembagian_shu_labarugi ";
		$where = " ";
		if(is_array($q)) {
			if($q['kode'] != '') {
				$where .="WHERE pembagian_shu_labarugi.kode = '".$q['kode']."' ";
			} else {
				if($q['type'] != '') {
					$where .="WHERE pembagian_shu_labarugi.type = '".$q['type']."' ";
				}
			}

			if($q['kode'] != '' && $q['type'] != ''){
				$where = "WHERE pembagian_shu_labarugi.type = '".$q['type']."' AND pembagian_shu_labarugi.kode = '".$q['kode']."' ";
			}
		}
		$sql .= $where;
		$result['count'] = $this->db->query($sql)->num_rows();
		$sql .=" ORDER BY {$sort} {$order} ";
		$sql .=" LIMIT {$offset},{$limit} ";
		$result['data'] = $this->db->query($sql)->result();
		return $result;
	}

  	function get_data_pertahun($offset, $limit, $q='', $sort, $order, $tahunTransaksi) {
		$sql = "SELECT pembagian_shu_labarugi.* FROM pembagian_shu_labarugi";
		$where = "WHERE tahun = ".$tahunTransaksi;
		$sql .= $where;
		$result['count'] = $this->db->query($sql)->num_rows();
		$sql .=" ORDER BY {$sort} {$order} ";
		$sql .=" LIMIT {$offset},{$limit} ";
		$result['data'] = $this->db->query($sql)->result();
		return $result;
	}

	function get_all_pembagian_shu_labarugi() {
		$this->db->select('*');
		$this->db->from('pembagian_shu_labarugi');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}

	function get_by_type_pembagian_shu_labarugi($type) {
		$this->db->select('*');
		$this->db->from('pembagian_shu_labarugi');
		$this->db->where('type', $type);
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}

	public function create() {
		$data = array(
			'create_date'	=>	date('Y-m-d'),
      		'create_by'		=>	$this->input->post('auth_name'),
			'nama'	      =>	$this->input->post('nama'),
			'kode'	      =>	$this->input->post('kode'),
			'persentase'	=>	$this->input->post('persentase'),
			'tahun'	      =>	$this->input->post('tahun'),
			'type'	      =>	$this->input->post('type')
		);
		return $this->db->insert('pembagian_shu_labarugi', $data);
	}

	public function update($id)
	{
		$sql = " SELECT * FROM pembagian_shu_labarugi WHERE id =".$id;
		$data_db = '';
		$query =  $this->db->query($sql);
		if($query->num_rows() > 0) {
			$data_db = $query->result();
		}
		$this->db->where('id', $id);

		return $this->db->update('pembagian_shu_labarugi',array(
	      'create_date'	=>	date('Y-m-d'),
	      'id'		=>	$this->input->post('id'),
	      'create_by'		=>	$this->input->post('auth_name'),
			'nama'	      =>	$this->input->post('nama'),
			'kode'	      =>	$this->input->post('kode'),
			'persentase'	=>	$this->input->post('persentase'),
			'tahun'	      =>	$this->input->post('tahun'),
			'type'	      =>	$this->input->post('type')
			));
	}

	public function delete($id) {
		return $this->db->delete('pembagian_shu_labarugi', array('id' => $id));
	}

}
