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
		<h3 class="box-title">Rekapitulasi Tagihan Pinjaman Konsumtif</h3>
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
								<input type="number" id="tahun_cari" name="tahun" value="<?php echo date("Y");?>">
							</div>
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
title="Rekapitulasi Tagihan Pinjaman Konsumtif"
style="width:auto; height: auto;"
url="<?php echo site_url('lapb_koperasi_tagihan_konsumtif/ajax_list'); ?>"
pagination="true" rownumbers="false"
fitColumns="true" singleSelect="false" collapsible="true"
sortName="nama_anggota" sortOrder="desc"
toolbar="#tb"
striped="true">
	<thead>
		<tr class="header_kolom">
			<th data-options="field:'id_anggota',width:'17', halign:'center', align:'center'" hidden="true"> ID Anggota</th>
			<th data-options="field:'no',width:'17', halign:'center', align:'center'"> ID Anggota</th>
			<th data-options="field:'nama_anggota',width:'30', halign:'center', align:'center'">Nama </th>
			<th data-options="field:'januari',width:'17', halign:'right', align:'right'"> Januari  </th>
			<th data-options="field:'februari',width:'17', halign:'right', align:'right'"> Februari  </th>
			<th data-options="field:'maret',width:'17', halign:'right', align:'right'"> Maret  </th>
			<th data-options="field:'april',width:'17', halign:'right', align:'right'"> April  </th>
			<th data-options="field:'mei',width:'17', halign:'right', align:'right'"> Mei  </th>
			<th data-options="field:'juni',width:'17', halign:'right', align:'right'"> Juni  </th>
			<th data-options="field:'juli',width:'17', halign:'right', align:'right'"> Juli  </th>
			<th data-options="field:'agustus',width:'17', halign:'right', align:'right'"> Agustus  </th>
			<th data-options="field:'september',width:'17', halign:'right', align:'right'"> September  </th>
			<th data-options="field:'oktober',width:'17', halign:'right', align:'right'"> Oktober  </th>
			<th data-options="field:'november',width:'17', halign:'right', align:'right'"> November  </th>
			<th data-options="field:'desember',width:'17', halign:'right', align:'right'"> Desember  </th>
			<th data-options="field:'jumlah',width:'17', halign:'right', align:'right'"> Jumlah  </th>
		</tr>
	</thead>
</table>
</div>
</div>
	
<script type="text/javascript">
function clearSearch(){
	window.location.href = '<?php echo site_url("lapb_koperasi_tagihan_konsumtif"); ?>';
}

function doSearch() {
	var tahun = $('#tahun_cari').val();
	$('#dg').datagrid('load',{
		tahun: tahun,
	});	
}

function cetak () {
	var tahun = $('#tahun_cari').val();
	if(tahun){
		var win = window.open('<?php echo site_url("lapb_koperasi_tagihan_konsumtif/cetak?tahun=' + tahun +'"); ?>');
	}else{
		var win = window.open('<?php echo site_url("lapb_koperasi_tagihan_konsumtif/cetak"); ?>');
	}
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}

}
</script>