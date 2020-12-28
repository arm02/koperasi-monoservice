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
	$tahun = date('Y');
?>

<div class="box box-solid box-primary">
	<div class="box-header">
		<h3 class="box-title">Data Rugi Laba</h3>
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
							<div id="filter_tgl" class="input-group" style="display: inline;">
								<input type="number" name="tahun" id="tahun_cari" value='<?php echo $tahun ?>' placeholder="Isi Tahun">
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
<p></p>

<table
id="dg-pendapatan"
class="easyui-datagrid"
title="Pendapatan"
style="width:auto; height: auto;"
url="<?php echo site_url('lapb_keuangan_rugi_laba/ajax_list_pendapatan'); ?>"
pagination="false" rownumbers="false"
fitColumns="true" singleSelect="true" collapsible="true"
toolbar="#tb"
striped="true"
showFooter="true">
<thead>
	<tr>
		<th data-options="field:'no',width:'3', align:'center'"></th>
		<th data-options="field:'tipe',width:'40', align:'left'"> </th>
		<th data-options="field:'jasa',width:'40', align:'right'">  </th>
	</tr>
</thead>
</table>
<table
id="dg-pendapatan-lain-lain"
class="easyui-datagrid"
title="Pendapatan Lain-Lain"
style="width:auto; height: auto;"
url="<?php echo site_url('lapb_keuangan_rugi_laba/ajax_list_pendapatan_lain_lain'); ?>"
pagination="false" rownumbers="false"
fitColumns="true" singleSelect="true" collapsible="true"
toolbar="#tb"
striped="true"
showFooter="true">
<thead>
	<tr>
		<th data-options="field:'no',width:'3', align:'center'"></th>
		<th data-options="field:'tipe',width:'40', align:'left'"> </th>
		<th data-options="field:'jasa',width:'40', align:'right'">  </th>
	</tr>
</thead>
</table>


<table  class="table table-borderless" style="margin-top: 1%;margin-bottom: 1%">
	<tr>
		<td style="font-weight: bold;vertical-align: middle;text-align:center;">Total Pendapatan</td>
		<td style="font-weight: bold;text-align:center" id="jumlah-pendapatan"></td>
	</tr>
</table>


<table
id="dg-pengeluaran"
class="easyui-datagrid"
title="Pengeluaran"
style="width:auto; height: auto;"
url="<?php echo site_url('lapb_keuangan_rugi_laba/ajax_list_pengeluaran'); ?>"
pagination="false" rownumbers="false"
fitColumns="true" singleSelect="true" collapsible="true"
toolbar="#tb"
striped="true"
showFooter="true">
<thead>
		<th data-options="field:'no',width:'3', align:'center'"></th>
		<th data-options="field:'tipe',width:'40', align:'left'"> </th>
		<th data-options="field:'jasa',width:'40', align:'right'">  </th>
	</tr>
</thead>
</table>

<table  class="table table-borderless" style="margin-top: 1%;margin-bottom: 1%">
	<tr>
		<td style="font-weight: bold;vertical-align: middle;text-align:center;">SHU TAHUN BUKU <?php echo date("Y");?></td>
		<td style="font-weight: bold;text-align:center;" id="jumlah-pembagian-shu"></td>
	</tr>
</table>

<p style="padding-right:90px; text-align:right; font-size: 12pt;"> <br>Bekasi, <?php echo date('d F Y'); ?>  <br> </p>
<p style="padding-bottom:20px; text-align:center; font-size: 15pt; font-weight: bold;"> <br>PENGURUS KOPERASI PEGAWAI PRS BEKASI <br> </p>
<table  class="table table-borderless">
	<tr>
		<th style="border:none; padding-bottom:70px; width:50%; vertical-align: middle; text-align:center" Colspan="2"> KETUA </th>
		<th style="border:none; padding-bottom:70px; width:50%; vertical-align: middle; text-align:center" Colspan="2"> BENDAHARA </th>
	</tr>
	<tr>
		<th style="border:none; padding-bottom:30px; width:50%; vertical-align: middle; text-align:center" Colspan="2"> ISMAWATI </th>
		<th style="border:none; padding-bottom:30px; width:50%; vertical-align: middle; text-align:center" Colspan="2"> DIYAH ROCHYANI </th>
	</tr>
</table>

<p></p>
<p style="text-align:center; font-size: 15pt; font-weight: bold;"> PEMBAGIAN SHU TAHUN BUKU <?php echo date("Y");?> </p>

<table
id="dg-pembagian-shu"
class="easyui-datagrid"
title="Perincian Pembagian Sisa Hasil Usaha ( SHU )"
style="width:auto; height: auto;"
url="<?php echo site_url('lapb_keuangan_rugi_laba/ajax_list_pembagian_shu'); ?>"
pagination="false" rownumbers="false"
fitColumns="true" singleSelect="true" collapsible="true"
toolbar="#tb"
striped="true"
showFooter="true">
<thead>
		<th data-options="field:'no',width:'3', align:'center'"></th>
		<th data-options="field:'tipe',width:'40', align:'left'"> </th>
		<th data-options="field:'jasa',width:'40', align:'right'">  </th>
	</tr>
</thead>
</table>

<table
id="dg-pembagian-shu-anggota"
class="easyui-datagrid"
title="PEMBAGIAN SHU BAGIAN ANGGOTA BERDASARKAN :"
style="width:auto; height: auto;"
url="<?php echo site_url('lapb_keuangan_rugi_laba/ajax_list_pembagian_shu_anggota'); ?>"
pagination="false" rownumbers="false"
fitColumns="true" singleSelect="true" collapsible="true"
toolbar="#tb"
striped="true"
showFooter="true">
<thead>
		<th data-options="field:'no',width:'3', align:'center'"></th>
		<th data-options="field:'tipe',width:'40', align:'left'"> </th>
		<th data-options="field:'jasa',width:'40', align:'right'">  </th>
	</tr>
</thead>
</table>
</table>
<p style="padding-bottom:20px; text-align:center; font-size: 15pt; font-weight: bold;"> <br>PENGURUS KOPERASI PEGAWAI PRS BEKASI <br> </p>
<table  class="table table-borderless">
	<tr>
		<th style="border:none; padding-bottom:70px; width:50%; vertical-align: middle; text-align:center" Colspan="2"> KETUA </th>
		<th style="border:none; padding-bottom:70px; width:50%; vertical-align: middle; text-align:center" Colspan="2"> BENDAHARA </th>
	</tr>
	<tr>
		<th style="border:none; padding-bottom:30px; width:50%; vertical-align: middle; text-align:center" Colspan="2"> ISMAWATI </th>
		<th style="border:none; padding-bottom:30px; width:50%; vertical-align: middle; text-align:center" Colspan="2"> DIYAH ROCHYANI </th>
	</tr>
</table>
</div>
</div>
	
<script type="text/javascript">
$(document).ready(function() {	
})
	setTimeout(function(){
		var totalPendapatan = getTotalPendapatan()
		var totalPengeluaran = getTotalPengeluaran()

		var totalShu = totalPendapatan - totalPengeluaran

		loadDataPembagianShu(totalShu)
		$('#jumlah-pendapatan').text("Rp. " + addCommas(totalPendapatan))
		$('#jumlah-pembagian-shu').text("Rp. " + addCommas(totalShu))
	}, 200);

function getTotalPendapatan() {
	var dataPendapatan = $('#dg-pendapatan').datagrid("getData")
	var dataPendapatanLainLain = $('#dg-pendapatan-lain-lain').datagrid("getData")

	var jumlahPendapatan = dataPendapatan.footer[0].jasa_nominal
	var jumlahPendapatanLainLain = dataPendapatanLainLain.footer[0].jasa_nominal

	var total = jumlahPendapatan + jumlahPendapatanLainLain

	return total

}

function getTotalPengeluaran() {
	var dataPengeluaran = $('#dg-pengeluaran').datagrid("getData")
	var total = dataPengeluaran.footer[0].jasa_nominal
	return total

}

function loadDataPembagianShu(nominal) {
	$('#dg-pembagian-shu').datagrid('load',{
		nominal: nominal
	});

	$('#dg-pembagian-shu-anggota').datagrid('load',{
		nominal: nominal
	});

}

function clearSearch(){
	window.location.href = '<?php echo site_url("lapb_keuangan_rugi_laba"); ?>';
}

function doSearch() {
	var tahun = $('#tahun_cari').val();
	$('#dg-pendapatan').datagrid('load',{
		tahun: tahun
	});
	$('#dg-pendapatan-lain-lain').datagrid('load',{
		tahun: tahun
	});

	$('#dg-pengeluaran').datagrid('load',{
		tahun: tahun
	});

	setTimeout(function(){
		var totalPendapatan = getTotalPendapatan()
		var totalPengeluaran = getTotalPengeluaran()

		var totalShu = totalPendapatan - totalPengeluaran

		loadDataPembagianShu(totalShu)
		$('#jumlah-pendapatan').text("Rp. " + addCommas(totalPendapatan))
		$('#jumlah-pembagian-shu').text("Rp. " + addCommas(totalShu))

	}, 200);
}

function cetak () {
	var tahun = $('input[name=tahun]').val();
	var win = window.open('<?php echo site_url("lapb_keuangan_rugi_laba/cetak/?tahun=' + tahun +'"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}

}
</script>