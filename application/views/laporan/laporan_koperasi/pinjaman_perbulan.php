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
.select2-choices {
		min-height: 150px;
		max-height: 150px;
		overflow-y: auto;
	}
.form-control {
	height: 20px;
	padding: 4px;
}	
</style>

<?php 

if(isset($_REQUEST['tahun']) && isset($_REQUEST['bulan'])) {
	$tahun = $_REQUEST['tgl_dari'];
	$bulan = $_REQUEST['bulan'];
} else {
	$tahun = date("Y");
	$bulan = date("n");
}
?>

<div class="box box-solid box-primary">
	<div class="box-header">
		<h3 class="box-title">Laporan Data Pinjaman Perbulan</h3>
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
								<!-- <select id="fr_status" name="fr_status" class="select2_jenis" style="display: inline-block; width: 150px; line-height: 20px; vertical-align: middle;">
									<option value="0">Menunggu Konfirmasi</option>
									<option value="1">Disetujui</option>
									<option value="2">Ditolak</option>
									<option value="3">Sudah Terlaksana</option>
									<option value="4">Batal</option>
								</select> -->
								<select id="bulan_cari" name="bulan" style="display: inline-block; width: 150px; line-height: 20px; vertical-align: middle;" value="<?php echo $bulan; ?>">
									<option value="" disabled selected>-- Pilih Bulan --</option>
									<option value="1" > Januari </option>
									<option value="2" > February </option>
									<option value="3" > Maret </option>
									<option value="4" > April </option>
									<option value="5" > Mei </option>
									<option value="6" > Juni </option>
									<option value="7" > Juli </option>
									<option value="8" > Agustus </option>
									<option value="9" > September </option>
									<option value="10" > Oktober </option>
									<option value="11" > November </option>
									<option value="12" > Desember </option>
								</select>
								<input type="number" name="tahun" id="tahun_cari" value="<?php echo $tahun; ?>" placeholder="Isi Tahun" style="display: inline-block; width: 150px; line-height: 20px; vertical-align: middle;">
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
title="Data Pinjaman Perbulan"
style="width:auto; height: auto;"
url="<?php echo site_url('lapb_koperasi_pinjaman_perbulan/ajax_list'); ?>"
pagination="true" rownumbers="false"
fitColumns="true" singleSelect="false" collapsible="true"
striped="true">
	<thead>
		<tr class="header_kolom">
			<th data-options="field:'uraian_1',width:'17', halign:'center', align:'center'"> </th>
			<th data-options="field:'pokok',width:'17', halign:'center', align:'center'"> Pokok </th>
			<th data-options="field:'jasa',width:'17', halign:'right', align:'right'"> Jasa  </th>
			<th data-options="field:'jumlah_1',width:'17', halign:'right', align:'right'"> Jumlah  </th>
			<th data-options="field:'uraian_2',width:'17', halign:'center', align:'center'"> Uraian  </th>
			<th data-options="field:'jumlah_2',width:'17', halign:'right', align:'right'"> Jumlah  </th>
		</tr>
	</thead>
</table>
</div>
</div>
	
<script type="text/javascript">
function clearSearch(){
	window.location.href = '<?php echo site_url("lapb_koperasi_pinjaman_perbulan"); ?>';
}

function doSearch() {
	var bulan = $('#bulan_cari').val();
	var tahun = $('#tahun_cari').val();
	$('#dg').datagrid('load',{
		bulan: bulan,
		tahun: tahun,
	});	
}

function cetak () {
	var bulan = $('#bulan_cari').val();
	var tahun = $('#tahun_cari').val();
	if(bulan){
		var win = window.open('<?php echo site_url("lapb_koperasi_pinjaman_perbulan/cetak?bulan=' + bulan + '&tahun=' + tahun + '"); ?>');
	}else if(!bulan){
		var win = window.open('<?php echo site_url("lapb_koperasi_pinjaman_perbulan/cetak?tahun=' + tahun + '"); ?>');

	}else{
		var win = window.open('<?php echo site_url("lapb_koperasi_pinjaman_perbulan/cetak"); ?>');
	}
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}

}
</script>