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

<div class="box box-solid box-primary">
	<div class="box-header">
		<h3 class="box-title">Rekapitulasi Simpanan Keseluruhan Anggota</h3>
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
									<i class="fa fa-calendar"></i> <span id="reportrange"><span><?php echo $tgl_periode_txt; ?>
									</span></span>
									<i class="fa fa-caret-down"></i>
								</button>
							</div>
						</td>
						<td>
							<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak()">Cetak Laporan</a>

							<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Hapus Filter</a>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>

<div class="box box-primary">
<div class="box-body">

<table
id="dg"
class="easyui-datagrid"
title="Data Rekapitulasi Simpanan Anggota"
style="width:auto; height: auto;"
url="<?php echo site_url('Lapb_anggota_rekap_keseluruhan/ajax_list'); ?>"
pagination="true" rownumbers="true"
fitColumns="true" singleSelect="true" collapsible="true"
sortName="nama_anggota" sortOrder="desc"
toolbar="#tb"
striped="true">
<thead>
	<tr>
		<th data-options="field:'id_anggota',width:'17', halign:'center', align:'center',hidden: true"> ID </th>
		<th data-options="field:'no',width:'17', halign:'center', align:'center'"> No </th>
		<th data-options="field:'nama_anggota',width:'17', halign:'center', align:'center'"> Nama </th>
		<!-- <th style="width:20%; vertical-align: middle; text-align:center" colspan="4"> Simpanan </th> -->
		<th data-options="field:'simpananwajib',width:'17', halign:'center', align:'center'"> Simpanan Pokok  </th>
		<th data-options="field:'simpananpokok',width:'17', halign:'center', align:'center'"> Simpanan Wajib  </th>
		<th data-options="field:'simpanansukarela',width:'17', halign:'center', align:'center'"> Simpanan Sukarela  </th>
		<th data-options="field:'simpanankhusus',width:'17', halign:'center', align:'center'"> Khusus  </th>

		<th data-options="field:'jumlah_total',width:'17', halign:'center', align:'center'"> Jumlah </th>
		<th data-options="field:'yang_diambil',width:'17', halign:'center', align:'center'"> Yang Diambil </th>
		<th data-options="field:'saldo_simpanan',width:'17', halign:'center', align:'center'"> Saldo Disimpan </th>
	</tr>
</thead>
</table>
</div>
</div>
	
<script type="text/javascript">
$(document).ready(function() {
	fm_filter_tgl();
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
					tgl_dari: '".$tgl_dari."',
					tgl_samp: '".$tgl_samp."'
				";
			} else {
				echo "
					tgl_dari: moment().startOf('year').startOf('month'),
					tgl_samp: moment().endOf('year').endOf('month')
				";
			}
		?>
	},

	function (start, end) {
		doSearch();
	});
}

function clearSearch(){
	window.location.href = '<?php echo site_url("lapb_anggota_rekap_keseluruhan"); ?>';
}

function doSearch() {
	var tgl_dari = $('input[name=daterangepicker_start]').val();
	var tgl_samp = $('input[name=daterangepicker_end]').val();
	$('#dg').datagrid('load',{
		tgl_dari: tgl_dari,
		tgl_samp: tgl_samp,
	});		
}

function cetak () {
	var validationFilterData = '<?php 
		 						if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])){
		 							echo true;
		 						}else{
		 							echo false;
		 						}
	 						?>'
	if(validationFilterData){
		var tgl_dari = '<?php echo isset($_REQUEST['tgl_dari']) ? $_REQUEST['tgl_dari'] : '' ?>'
		var tgl_samp = '<?php echo isset($_REQUEST['tgl_samp']) ? $_REQUEST['tgl_samp'] : ''?>'
		var win = window.open('<?php echo site_url("lapb_anggota_rekap_keseluruhan/cetak?tgl_dari=' + tgl_dari + '&tgl_samp=' + tgl_samp + '"); ?>');
	}else{
		var win = window.open('<?php echo site_url("lapb_anggota_rekap_keseluruhan/cetak"); ?>');
	}
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}

}
</script>