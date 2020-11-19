<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('lap_simpanan_m');
		$this->load->model('m_backup');
	}

	public function backup_db()
	{

		$return="";
		$allTables = array();
		$conn = mysqli_connect('localhost', 'root', '','nsi_koperasi');
		$result = mysqli_query($conn,'SHOW TABLES');
		while($row = mysqli_fetch_row($result))
		{
			$allTables[] = $row[0];
		}

		foreach($allTables as $table)
		{
			$result = mysqli_query($conn,'SELECT * FROM '.$table);

			$num_fields = mysqli_num_fields($result);

			$return.= 'DROP TABLE IF EXISTS '.$table.';';

			$row2 = mysqli_fetch_row(mysqli_query($conn,'SHOW CREATE TABLE '.$table));

			$return.= "\n\n".$row2[1].";\n\n";

			for ($i = 0; $i < $num_fields; $i++) 

			{
				while($row = mysqli_fetch_row($result))
				{
					$return.= 'INSERT INTO '.$table.' VALUES(';
					for($j=0; $j<$num_fields; $j++)
					{
						$row[$j] = addslashes($row[$j]);
						$row[$j] = str_replace("\n","\\n",$row[$j]);

						if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } 
						else { $return.= '""'; }

						if ($j<($num_fields-1)) { $return.= ','; }
					}
					$return.= ");\n";
				}
			}
			$return.="\n\n";
		}

		$folder = 'Database_Backup/';

		if (!is_dir($folder))

			mkdir($folder, 0755, true);
		chmod($folder, 0755);

		$date = date('m-d-Y-H-i-s', time()); 
		$filename = "Backup-Database-Koperasi-".$date.".sql"; 
		$path = $folder."Backup-Database-Koperasi-".$date; 

		$handle = fopen($path.'.sql','w+');

		fwrite($handle,$return);
		fclose($handle);

		// echo "Backup of Database Taken";
		$result = array(
			'path' => $path, 
			'filename' => $filename, 
		);
		echo json_encode($result);

	}

	// public function restore(){
	// 	$isi_file = file_get_contents('./Database_Backup/Backup-Database-Koperasi-11-13-2020-12-28-29.sql');
	// 	$string_query = rtrim( $isi_file, "\n;" );
	// 	$array_query = explode(";", $string_query);
	// 	foreach($array_query as $query)
	// 	{
	// 		$this->db->query($query);
	// 	}
	// }

	public function index() {
		$this->load->library("pagination");

		$this->data['judul_browser'] = 'Laporan';
		$this->data['judul_utama'] = 'Laporan';
		$this->data['judul_sub'] = 'Data Simpanan';

		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';

		#include tanggal
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';

			#include seach
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';
		$this->data['js_files2'] = [];
		$this->data['u_name'] = $this->session->userdata('u_name');

		
		$this->data['isi'] = $this->load->view('backup', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}


	function ajax_list() {
		/*Default request pager params dari jeasyUI*/
		$offset = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$limit  = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$tgl_dari = isset($_POST['tgl_dari']) ? $_POST['tgl_dari'] : '';
		$tgl_samp = isset($_POST['tgl_samp']) ? $_POST['tgl_samp'] : '';
		$sort  = isset($_POST['sort']) ? $_POST['sort'] : 'tanggal';
		$order  = isset($_POST['order']) ? $_POST['order'] : 'desc';
		$search = array(
			'tgl_dari' => $tgl_dari,
			'tgl_samp' => $tgl_samp
		);
		
		$offset = ($offset-1)*$limit;
		$data   = $this->m_backup->get_data_db_ajax($offset,$limit,$search,$sort,$order);
		$i	= 0;
		$rows   = array();
		if($data){
			foreach ($data["data"] as $r) {
				//array keys ini = attribute 'field' di view nya

				$rows[$i]['no'] = $i+1;
				$rows[$i]['id'] = 'BCKP'.$r->id;
				$rows[$i]['nama_backup'] = $r->nama_backup;
				$rows[$i]['tanggal'] = date_format(date_create($r->tanggal), "d F Y");
				$i++;
			}
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('total'=>$data['count'],'rows'=>$rows);
		echo json_encode($result); //return nya json
	}

	public function create() {
		if(!isset($_POST)) {
			show_404();
		}
		if($this->m_backup->create()){
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil disimpan </div>'));
		}else{
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Gagal menyimpan data, pastikan nilai lebih dari <strong>0 (NOL)</strong>. </div>'));
		}
	}
}