<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_barang extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	//panggil data untuk laporan
	function lap_data_barang() {
		$nm_barang = isset($_REQUEST['nm_barang']) ? $_REQUEST['nm_barang'] : '';
		// $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
		// $merk = isset($_REQUEST['merk']) ? $_REQUEST['merk'] : '';
		$sql = " SELECT tbl_barang.* FROM tbl_barang ";
		$where = "";
		$q = array('nm_barang' => $nm_barang
			// 'type' => $type,
			// 'merk' => $merk
    	);
		if(is_array($q)) {
			// if($q['nm_barang'] != '') {
			// 	$where .="WHERE tbl_barang.nm_barang LIKE '%".$q['nm_barang']."%' ";
			// } 
			// else if($q['type'] != '') {
			// 	$where .="WHERE tbl_barang.type = '".$q['type']."' ";
			// } else {
   //      		if($q['merk'] != '') {
			// 		$where .="WHERE tbl_barang.merk = '".$q['merk']."' ";
			// 	}
	  //     	}

	  //     	if($q['nm_barang'] != '' && $q['type'] != ''){
	  //     		$where ="WHERE tbl_barang.nm_barang LIKE '%".$q['nm_barang']."%' AND tbl_barang.type = '".$q['type']."'  ";
	  //     	}

	  //     	if($q['nm_barang'] != '' && $q['merk'] != ''){
	  //     		$where ="WHERE tbl_barang.nm_barang LIKE '%".$q['nm_barang']."%' AND tbl_barang.merk = '".$q['merk']."'  ";
	  //     	}

	  //     	if($q['type'] != '' && $q['merk'] != ''){
	  //     		$where ="WHERE tbl_barang.merk = '".$q['merk']."' AND tbl_barang.type = '".$q['type']."'  ";
	  //     	}

	  //     	if($q['nm_barang'] != '' && $q['type'] != '' && $q['merk'] != ''){
	  //     		$where ="WHERE tbl_barang.nm_barang LIKE '%".$q['nm_barang']."%' AND tbl_barang.type = '".$q['type']."' AND tbl_barang.merk = '".$q['merk']."'";
	  //     	}
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

	//panggil data untuk esyui
	function get_data_transaksi_ajax($offset, $limit, $q='', $sort, $order) {
		$sql = "SELECT tbl_barang.* FROM tbl_barang ";
		$where = " ";
    	if(is_array($q)) {
			if($q['nm_barang'] != '') {
				$where .="WHERE tbl_barang.nm_barang LIKE '%".$q['nm_barang']."%' ";
			} 
			// else if($q['type'] != '') {
			// 	$where .="WHERE tbl_barang.type = '".$q['type']."' ";
			// } else {
   //      		if($q['merk'] != '') {
			// 		$where .="WHERE tbl_barang.merk = '".$q['merk']."' ";
			// 	}
   //    		}

   //    		if($q['nm_barang'] != '' && $q['type'] != ''){
	  //     		$where ="WHERE tbl_barang.nm_barang LIKE '%".$q['nm_barang']."%' AND tbl_barang.type = '".$q['type']."'  ";
	  //     	}

	  //     	if($q['nm_barang'] != '' && $q['merk'] != ''){
	  //     		$where ="WHERE tbl_barang.nm_barang LIKE '%".$q['nm_barang']."%' AND tbl_barang.merk = '".$q['merk']."'  ";
	  //     	}

	  //     	if($q['type'] != '' && $q['merk'] != ''){
	  //     		$where ="WHERE tbl_barang.merk = '".$q['merk']."' AND tbl_barang.type = '".$q['type']."'  ";
	  //     	}

	  //     	if($q['nm_barang'] != '' && $q['type'] != '' && $q['merk'] != ''){
	  //     		$where ="WHERE tbl_barang.nm_barang LIKE '%".$q['nm_barang']."%' AND tbl_barang.type = '".$q['type']."' AND tbl_barang.merk = '".$q['merk']."'";
	  //     	}
		}

		$sql .= $where;
		$result['count'] = $this->db->query($sql)->num_rows();
		$sql .=" ORDER BY {$sort} {$order} ";
		$sql .=" LIMIT {$offset},{$limit} ";
		$result['data'] = $this->db->query($sql)->result();
		return $result;
	}

	function get_all_barang() {
		$sql = "SELECT tbl_barang.* FROM tbl_barang ";
		$result = $this->db->query($sql)->result();
		return $result;
	}

	public function create() {
		$data = array(
			'nm_barang'			=>	$this->input->post('nm_barang'),
			'type'			=>	$this->input->post('type'),
			'merk'			=>	$this->input->post('merk'),
			'harga'			=>	$this->input->post('harga'),
			'jml_brg'			=>	$this->input->post('jml_brg'),
			'ket'			=>	$this->input->post('ket'),
			);
		return $this->db->insert('tbl_barang', $data);
	}

	public function update($id)
	{
		$this->db->where('id', $id);
		return $this->db->update('tbl_barang',array(
			'nm_barang'			=>	$this->input->post('nm_barang'),
			'type'			=>	$this->input->post('type'),
			'merk'			=>	$this->input->post('merk'),
			'harga'			=>	$this->input->post('harga'),
			'jml_brg'			=>	$this->input->post('jml_brg'),
			'ket'			=>	$this->input->post('ket'),
			));
	}

	public function delete($id) {
		return $this->db->delete('tbl_barang', array('id' => $id));
	}
}
