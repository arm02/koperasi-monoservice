<!-- Styler -->
<style type="text/css">
.panel * {
	font-family: "Arial","​Helvetica","​sans-serif";
}
.fa {
	font-family: "FontAwesome";
}
.datagrid-header-row * {
	font-weight: bold;
}
.messager-window * a:focus, .messager-window * span:focus {
	color: blue;
	font-weight: bold;
}
.daterangepicker * {
	font-family: "Source Sans Pro","Arial","​Helvetica","​sans-serif";
	box-sizing: border-box;
}
.glyphicon	{font-family: "Glyphicons Halflings"}

.form-control {
	height: 20px;
	padding: 4px;
}	
</style>

<?php 
if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
	$tgl_dari = $_REQUEST['tgl_dari'];
	$tgl_samp = $_REQUEST['tgl_samp'];
} else {
	$tgl_dari = date('Y') . '-01-01';
	$tgl_samp = date('Y') . '-12-31';
}
$tgl_dari_txt = jin_date_ina($tgl_dari, 'p');
$tgl_samp_txt = jin_date_ina($tgl_samp, 'p');
$tgl_periode_txt = $tgl_dari_txt . ' - ' . $tgl_samp_txt;
?>

<div class="row">
	<div class="col-md-12">
		<div class="box box-solid box-primary">
			<div class="box-header">
				<h3 class="box-title"> Cetak Laporan Summary Kas</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-primary btn-sm" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body">
				<div>
					<form id="fmCari" method="GET">
						<input type="hidden" name="tgl_dari" id="tgl_dari">
						<input type="hidden" name="tgl_samp" id="tgl_samp">
						<table>
							<tr>
								<td>
									<div id="filter_tgl" class="input-group" style="display: inline;">
										<button class="btn btn-default" id="daterange-btn">
											<i class="fa fa-calendar"></i><span id="reportrange"><span><?php echo $tgl_periode_txt; ?></span>
											<i class="fa fa-caret-down"></i>
										</button>
									</div>
								</td>
								<td> Pilih ID Anggota </td>
								<td>
									<input id="anggota_id" name="anggota_id" value="" style="width:200px; height:25px" class="">
								</td>	
								<td>
									<a href="javascript:void(0);" id="btn_filter" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Lihat Laporan</a>
									<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak()">Cetak Laporan</a>
									<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Hapus Filter</a>
								</td>
							</tr>
						</table>
					</form>
				</div>
				<!-- <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak()"> Cetak Laporan</a> -->
				<p></p>
				<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Laporan Summary Kas </p>
				<table  class="table table-bordered">
					<tr class="header_kolom">
						<th style="width:5%; vertical-align: middle; text-align:center" rowspan="2"> No. </th>
						<th style="width:20%; vertical-align: middle; text-align:center" rowspan="2"> ID Anggota </th>
						<th style="width:25%; vertical-align: middle; text-align:center" rowspan="2"> Nama Anggota </th>
						<th style="width:40%; vertical-align: middle; text-align:center" colspan="4" rowspan="1"> Simpanan </th>
						<th style="width:10%; vertical-align: middle; text-align:center" rowspan="2"> Total </th>
					</tr>
					<tr class="header_kolom">
						<?php
						foreach ($data_jns_simpanan as $jenis) {
							$jns_arr = explode(' ', $jenis->jns_simpan);

							echo '
							<th style="width: 10%; vertical-align: middle; text-align:center"> '.$jns_arr[1].'</th>';
						}
						?>
					</tr>

					<?php
					$no = $offset + 1;
					$mulai=1;
					if (!empty($data_anggota)) {

						foreach ($data_anggota as $row) {

							if(($no % 2) == 0) {
								$warna="#EEEEEE";
							} else {
								$warna="#FFFFFF";
							}

							echo '
							<tr bgcolor='.$warna.' >
							<td class="h_tengah" style="vertical-align: middle "> '.$no++.' </td>
							<td class="h_tengah" style="vertical-align: middle "> '.$row->identitas.'</td>
							<td class="h_kiri" style="vertical-align: middle "> '.strtoupper($row->nama).'</td>';

							$nilai_total = 0;
							for ($i=0; $i < count($data_jns_simpanan); $i++) {
								$nilai_s = $this->lap_summary_kas_m->get_jml_simpanan($data_jns_simpanan[$i]->id, $row->id);
								
								echo '
								<td class="h_kanan" style="vertical-align: middle "> '.number_format($nilai_s->jml_total).'</td>';

								$nilai_total += $nilai_s->jml_total;
							}

							echo'
							<td class="h_kanan" style="vertical-align: middle; font-weight: bold">'.number_format($nilai_total).'</td>
							</tr>';
						}
						echo '</table>
						<div class="box-footer">'.$halaman.'</div>';
					} else {
						echo '<tr>
						<td colspan="9" >
						<code> Tidak Ada Data <br> </code>
						</td>
						</tr>
						</table>';
					}
					?>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function() {
			fm_filter_tgl();

			<?php 
			if(isset($_REQUEST['anggota_id'])) {
				echo 'var anggota_id = "'.$_REQUEST['anggota_id'].'";';
			} else {
				echo 'var anggota_id = "";';
			}
			echo '$("#anggota_id").val(anggota_id);';
			echo '$("#anggota_id").attr("value", anggota_id)';
			?>

			$('#anggota_id').combogrid({
				panelWidth:300,
				url: '<?php echo site_url('lap_shu_anggota/list_anggota'); ?>' ,
				idField:'id',
				valueField:'id',
				textField:'id_nama',
				mode:'remote',
				fitColumns:true,
				columns:[[
				{field:'photo',title:'Photo',align:'center',width:5},
				{field:'id',title:'ID', hidden: true},
				{field:'id_nama', title:'IDNama', hidden: true},
				{field:'kode_anggota', title:'ID', align:'center', width:15},
				{field:'nama',title:'Nama Anggota',align:'left',width:20}
				]]
			});
			}); // ready

		function fm_filter_tgl() {
			$('#daterange-btn').daterangepicker({
				ranges: {
					'Hari ini': [moment(), moment()],
					'Kemarin': [moment().subtract('days', 1), moment().subtract('days', 1)],
					'7 Hari yang lalu': [moment().subtract('days', 6), moment()],
					'30 Hari yang lalu': [moment().subtract('days', 29), moment()],
					'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
					'Bulan kemarin': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')],
					'Tahun ini': [moment().startOf('year').startOf('month'), moment().endOf('year').endOf('month')],
					'Tahun kemarin': [moment().subtract('year', 1).startOf('year').startOf('month'), moment().subtract('year', 1).endOf('year').endOf('month')]
				},
				locale: 'id',
				showDropdowns: true,
				format: 'YYYY-MM-DD',
				<?php 
				if(isset($tgl_dari) && isset($tgl_samp)) {
					echo "
					startDate: '".$tgl_dari."',
					endDate: '".$tgl_samp."'
					";
				} else {
					echo "
					startDate: moment().startOf('year').startOf('month'),
					endDate: moment().endOf('year').endOf('month')
					";
				}
				?>
			},

			function (start, end) {
				doSearch();
			});
		}

		function clearSearch(){
			window.location.href = '<?php echo site_url("lap_summary_kas"); ?>';
		}

		function doSearch() {
			var tgl_dari = $('input[name=daterangepicker_start]').val();
			var tgl_samp = $('input[name=daterangepicker_end]').val();
			$('input[name=tgl_dari]').val(tgl_dari);
			$('input[name=tgl_samp]').val(tgl_samp);
			$('#fmCari').attr('action', '<?php echo site_url('lap_summary_kas'); ?>');
			$('#fmCari').submit();	
		}

		function cetak () {
			<?php 
			if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
				echo 'var tgl_dari = "'.$_REQUEST['tgl_dari'].'";';
				echo 'var tgl_samp = "'.$_REQUEST['tgl_samp'].'";';
			} else {
				echo 'var tgl_dari = $("#tgl_dari").val();';
				echo 'var tgl_samp = $("#tgl_samp").val();';
			}
			if(isset($_REQUEST['anggota_id'])) {
				echo 'var anggota_id = "'.$_REQUEST['anggota_id'].'";';
			} else {
				echo 'var anggota_id = $("#anggota_id").val();';
			}
			?>
			var win = window.open('<?php echo site_url("lap_summary_kas/cetak?tgl_dari=' + tgl_dari + '&tgl_samp=' + tgl_samp + '&anggota_id=' + anggota_id +'"); ?>');
			if (win) {
				win.focus();
			} else {
				alert('Popup jangan di block');
			}
		}
	</script>