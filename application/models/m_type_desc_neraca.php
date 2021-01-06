<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_type_desc_neraca extends CI_Model {

	public function __construct(){
		parent::__construct();
	}


	//panggil data db untuk esyui
	function get_data_db_ajax($offset, $limit, $q='', $sort, $order) {
		$sql = "SELECT type_desc_neraca.* FROM type_desc_neraca";
		$where = " ";
		if(is_array($q)) {
			if($q['title'] != ''){
				$where .="WHERE type_desc_neraca.title = '".$q['title']."' ";
			}
		}
		$sql .= $where;
		$result['count'] = $this->db->query($sql)->num_rows();
		$sql .=" ORDER BY {$sort} {$order} ";
		$sql .=" LIMIT {$offset},{$limit} ";
		$result['data'] = $this->db->query($sql)->result();
		return $result;
	}

	function get_all_data() {
		$sql = "SELECT type_desc_neraca.* FROM type_desc_neraca";
		$result = $this->db->query($sql)->result();
		return $result;
	}

	public function create() {
		$data = array(
			'id_type_neraca'	 =>	$this->input->post('id_type_neraca'),
			'kode'	               =>	$this->input->post('kode'),
			'title'	               =>	$this->input->post('title'),
			'tahun'	               =>	$this->input->post('tahun'),
			'nominal'	               =>	$this->input->post('nominal')
		);
		return $this->db->insert('type_desc_neraca', $data);
	}

	public function update($id)
	{
		$sql = " SELECT * FROM type_desc_neraca WHERE id =".$id;
		$data_db = '';
		$query =  $this->db->query($sql);
		if($query->num_rows() > 0) {
			$data_db = $query->result();
		}
		$this->db->where('id', $id);

		return $this->db->update('type_desc_neraca',array(
			'id_type_neraca'	 =>	$this->input->post('id_type_neraca'),
			'kode'	               =>	$this->input->post('kode'),
			'title'	               =>	$this->input->post('title'),
			'tahun'	               =>	$this->input->post('tahun'),
			'nominal'	               =>	$this->input->post('nominal')
			));
	}

	public function delete($id) {
		return $this->db->delete('type_desc_neraca', array('id' => $id));
	}

}
