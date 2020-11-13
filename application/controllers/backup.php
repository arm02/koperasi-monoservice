<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->database();   

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

		echo "Backup of Database Taken";

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
}