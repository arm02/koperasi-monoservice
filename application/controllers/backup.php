<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('lap_simpanan_m');
		$this->load->model('master_anggota');
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
		$filename = $folder."database-uhuy-".$date; 

		$handle = fopen($filename.'.sql','w+');

		fwrite($handle,$return);
		fclose($handle);

		// echo "Backup of Database Taken";
		echo $filename;

	}

	// public function restore(){
	// 	$isi_file = file_get_contents('./Database_Backup/database-uhuy-11-13-2020-12-28-29.sql');
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
		$this->data['u_name'] = "admin";

		
		$this->data['isi'] = $this->load->view('backup', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}


	function ajax_list() {
		/*Default request pager params dari jeasyUI*/
		$offset = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$limit  = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$tgl_dari = isset($_POST['tgl_dari']) ? $_POST['tgl_dari'] : '';
		$tgl_samp = isset($_POST['tgl_samp']) ? $_POST['tgl_samp'] : '';
		$search = array(
			'tgl_dari' => $tgl_dari,
			'tgl_samp' => $tgl_samp
		);
		
		$offset = ($offset-1)*$limit;
		$data   = $this->lap_simpanan_m->lap_rekap_anggota_wajib($offset,$limit,$search);
		$i	= 0;
		$rows   = array();
		if($data){
			foreach ($data["rows"] as $r) {
				
				//array keys ini = attribute 'field' di view nya

				$rows[$i]['id'] = 'BCKP'.$r['id_anggota'];
				$rows[$i]['no'] = $i+1;
				$rows[$i]['tgl_upload'] = date('d F Y');;
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
		if($this->master_simpanan->create()){
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil disimpan </div>'));
		}else
		{
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Gagal menyimpan data, pastikan nilai lebih dari <strong>0 (NOL)</strong>. </div>'));
		}
	}
}