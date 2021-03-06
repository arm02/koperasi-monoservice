
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

.datagrid-footer .datagrid-row{
	background: #efefef;
}
</style>

<?php 

if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
	$tgl_dari = $_REQUEST['tgl_dari'];
	$tgl_samp = $_REQUEST['tgl_samp'];
} else {
	$tgl_dari = null;
	$tgl_samp = null;
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
							<input type="number" name="tahun_cari" id="tahun_cari" value='<?php echo date("Y") ?>'>
						</td>
						<td>
							<a href="javascript:void(0);" id="btn_filter" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Cari</a>

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
title="Rekapitulasi Simpanan Keseluruhan Anggota"
style="width:auto; height: auto;"
url="<?php echo site_url('lapb_keuangan_pinjaman/ajax_list'); ?>"
pagination="false" rownumbers="false"
fitColumns="true" singleSelect="true" collapsible="true"
toolbar="#tb"
striped="true"
showFooter="true">
<thead>
	<tr>
		<th data-options="field:'bulan',width:'25', halign:'center', align:'center'"> Bulan</th>
		<th data-options="field:'konsumtif',width:'25', halign:'center', align:'right'"> Konsumtif </th>
		<th data-options="field:'berjangka',width:'25', halign:'center', align:'right'"> Berjangka  </th>
		<th data-options="field:'barang',width:'25', halign:'center', align:'right'"> Barang  </th>
		<th data-options="field:'jumlah',width:'25', halign:'center', align:'right'"> Jumlah </th>
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
			}
		?>
	},

	function (start, end) {
		$('#reportrange').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
		doSearch();
	});
}

function clearSearch(){
	window.location.href = '<?php echo site_url("lapb_keuangan_pinjaman"); ?>';
}

function doSearch() {
	var tahun = $('input[name=tahun_cari]').val();
	$('#dg').datagrid('load',{
		tahun: tahun
	});		
}

function cetak () {
	var tahun = $('input[name=tahun_cari]').val() || new Date().getFullYear();
	var win = window.open('<?php echo site_url("lapb_keuangan_pinjaman/cetak?tahun=' + tahun +'"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}

}
</script>