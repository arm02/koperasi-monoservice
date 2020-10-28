<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_simpanan extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	//panggil data simpanan untuk laporan
	function lap_data_simpanan() {
		$jenis_simpanan = isset($_REQUEST['jenis_simpanan']) ? $_REQUEST['jenis_simpanan'] : '';
		$tampil = isset($_REQUEST['tampil']) ? $_REQUEST['tampil'] : '';
		$sql = '';
		$sql = " SELECT * FROM jns_simpan WHERE ";
		$q = array('jenis_simpanan' => $jenis_simpanan,
			'tampil' => $tampil);
		if(is_array($q)) {
			if($q['jenis_simpanan'] != '') {
				$sql .=" jns_simpan = '".$q['jenis_simpanan']."%' ";
			} else {
				if($q['tampil'] != '') {
					$sql .=" tampil = '".$q['tampil']."%' ";
				}
			}
		}
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
		$sql = "SELECT jns_simpan.* FROM jns_simpan ";
		$where = " WHERE ";
		if(is_array($q)) {
			if($q['jenis_simpanan'] != '') {
				$where .=" jns_simpan.jns_simpan LIKE '%".$q['jenis_simpanan']."%' ";
			} else {
				if($q['tampil'] != '') {
					$where .=" jns_simpan.tampil = '%".$q['tampil']."%' ";
				}
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
		if(str_replace(',', '', $this->input->post('jumlah')) <= 0) {
			return FALSE;
		}
		$data = array(
			'jns_simpan'		=>	$this->input->post('jenis_simpan'),
			'tampil'				=>	$this->input->post('tampil'),
			'jumlah'				=>	str_replace(',', '', $this->input->post('jumlah'))
			);
		return $this->db->insert('jns_simpan', $data);
	}

	public function update($id)
	{
		if(str_replace(',', '', $this->input->post('jumlah')) <= 0) {
			return FALSE;
		}
		$tanggal_u = date('Y-m-d H:i');
		$this->db->where('id', $id);
		return $this->db->update('jns_simpan',array(
			'jns_simpan'		=>	$this->input->post('jenis_simpan'),
			'tampil'				=>	$this->input->post('tampil'),
			'jumlah'				=>	str_replace(',', '', $this->input->post('jumlah'))
			));
	}

	public function delete($id) {
		return $this->db->delete('jns_simpan', array('id' => $id));
	}
}
