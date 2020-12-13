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

.tree-file, .tree-folder{
    display: none;
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
		<h3 class="box-title">Rekapitulasi Tagihan</h3>
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
class="easyui-treegrid"
title="Data Rekapitulasi Tagihan"
style="width:auto; height: auto;"
url="<?php echo site_url('lapb_keuangan_tagihan/ajax_list'); ?>"
pagination="false" rownumbers="false"
fitColumns="true"
toolbar="#tb"
striped="true"
showFooter="true"
idField= "bulan",
treeField= "bulan"
>
<thead>
	<tr>
		<th data-options="field:'bulan',width:'20', halign:'center', align:'left'" rowspan="2"> Bulan </th>
		<th colspan="2"> Konsumtif  </th>
		<th colspan="2"> Berjangka  </th>
		<th colspan="2"> Barang  </th>
		<th data-options="field:'jumlah_tagihan',width:'0', halign:'center', align:'right'" rowspan="2"> Jumlah  </th>
	</tr>
	<tr>
		<th data-options="field:'konsumtif_pokok',width:'10', halign:'center', align:'right'"> Pokok </th>
		<th data-options="field:'konsumtif_jasa',width:'10', halign:'center', align:'right'"> Jasa </th>
		<th data-options="field:'berjangka_pokok',width:'10', halign:'center', align:'right'"> Pokok  </th>
		<th data-options="field:'berjangka_jasa',width:'10', halign:'center', align:'right'"> Jasa  </th>
		<th data-options="field:'barang_pokok',width:'10', halign:'center', align:'right'"> Pokok  </th>
		<th data-options="field:'barang_jasa',width:'10', halign:'center', align:'right'"> Jasa  </th>
	</tr>
</thead>
</table>
</div>
</div>
	
<script type="text/javascript">
function clearSearch(){
	window.location.href = '<?php echo site_url("lapb_keuangan_tagihan"); ?>';
}

function doSearch() {
	var tahuns = $('input[name=tahun_cari]').val();
	$('#dg').treegrid('load',{
		tahun: tahuns
	});	
}

function cetak () {
	var tahun = $('input[name=tahun_cari]').val() || new Date().getFullYear();
	var win = window.open('<?php echo site_url("lapb_keuangan_tagihan/cetak?tahun=' + tahun +'"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}

}
</script>