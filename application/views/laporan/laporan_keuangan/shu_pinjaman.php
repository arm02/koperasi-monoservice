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

<div class="box box-solid box-primary">
	<div class="box-header">
		<h3 class="box-title">RINCIAN SHU BERDASARKAN JASA PINJAMAN</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-primary btn-sm" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="box-body">
		<div>
			<form id="fmCari" method="GET">
				<table>
					<tr>
						<td>
							<input type="number" class="form-control" name="tahun" id="tahun_cari" value="<?php echo date("Y")?>">
						</td>
						<td>
							<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Cari</a>

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
title="DATA RINCIAN SHU BERDASARKAN JASA PINJAMAN"
style="width:auto; height: auto;"
url="<?php echo site_url('lapb_keuangan_shu_pinjaman/ajax_list'); ?>"
pagination="true" rownumbers="false"
fitColumns="true" singleSelect="true" collapsible="true"
sortName="nama_anggota" sortOrder="desc"
toolbar="#tb"
striped="true">
<thead>
	<tr>
		<th data-options="field:'no',width:'10', halign:'center', align:'center'" rowspan="2"> No</th>
		<th data-options="field:'nama_anggota',width:'30', halign:'center', align:'center'" rowspan="2">Nama </th>
		<th colspan="4">Pinjaman</th>
		<th data-options="field:'shu',width:'17', halign:'center', align:'right'" rowspan="2"> SHU </th>
	</tr>
	<tr>
		<th data-options="field:'pinjaman_konsumtif',width:'17', halign:'center', align:'right'"> Konsumtif  </th>
		<th data-options="field:'pinjaman_berjangka',width:'17', halign:'center', align:'right'"> Berjangka  </th>
		<th data-options="field:'pinjaman_barang',width:'17', halign:'center', align:'right'"> Barang  </th>
		<th data-options="field:'jumlah_total',width:'17', halign:'center', align:'right'"> Jumlah  </th>
	</tr>
</thead>
</table>
</div>
</div>
	
<script type="text/javascript">
function clearSearch(){
	window.location.href = '<?php echo site_url("lapb_keuangan_shu_pinjaman"); ?>';
}

function doSearch() {
	var tahun = $('#tahun_cari').val();
	$('#dg').datagrid('load',{
		tahun: tahun,
	});		
}

function cetak () {
	var tahun = $('#tahun_cari').val();
	if($('#reportrange').text() != 'Tanggal'){
		var win = window.open('<?php echo site_url("lapb_keuangan_shu_pinjaman/cetak?tahun=' + tahun + '"); ?>');
	}else{
		var win = window.open('<?php echo site_url("lapb_keuangan_shu_pinjaman/cetak"); ?>');
	}
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}

}
</script>