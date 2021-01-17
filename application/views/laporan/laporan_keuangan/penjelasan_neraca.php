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
.tree-file, .tree-folder{
	display: none;
}
.datagrid-body{
	overflow: hidden;
}
</style>
<?php 
	$tahun = date('Y');
?>

<div class="box box-solid box-primary">
	<div class="box-header">
		<h3 class="box-title">Cetak Data Penjelasan Neraca</h3>
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
								<input type="number" name="tahun_cari" id="tahun_cari" value='<?php echo $tahun ?>' placeholder="Isi Tahun">
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
<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Penjelasan Neraca Koperasi Pegawai DEPSOS RI PRS Bekasi <br> Per - 31 Desember 2020 </p>

<table
	id="dg"
	class="easyui-treegrid"
	style="width:auto; height: auto;"
	url="<?php echo site_url('lapb_keuangan_penjelasan_neraca/ajax_list'); ?>"
	pagination="false" rownumbers="false"
	fitColumns="true"
	striped="true"
	showFooter="true"
	idField= "uraian"
	treeField= "uraian"
>
	<thead>
		<tr>
			<th data-options="field:'uraian',width:'10', halign:'center', align:'left'"></th>
			<th data-options="field:'nominal',width:'10', halign:'center', align:'right'"></th>
		</tr>
	</thead>
</table>
<!-- <table  class="table table-bordered">
	<tr class="header_kolom">
		<th style="width:5%; vertical-align: middle; text-align:center"> I. </th>
		<th style="width:25%;" colspan="5">HARTA LANCAR </th>
	</tr>
	<tr>
        <td></td>
		<td style="width:5%; vertical-align: middle; text-align:center">1.</td>
		<td style="width:42%;">Kas Akhir Desember 2020</td>
        <td style="width:5%; vertical-align: middle; text-align:center">=</td>
		<td style="width:43%; vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td style="width:5%;"></td>
	</tr>
	<tr>
        <td></td>
		<td></td>
		<td>Mutasi Pada Tahun 2021</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Penerimaan Kas</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td style="vertical-align: middle; text-align:center">+</td>
	</tr>
    <tr>
    <td></td>
		<td></td>
		<td>Jumlah</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Pengeluaran Kas</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td style="vertical-align: middle; text-align:center">-</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Kas Desember 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
	<tr>
        <td></td>
		<td style="width:5%; vertical-align: middle; text-align:center">2.</td>
		<td style="width:42%;">Bank</td>
        <td style="width:5%; vertical-align: middle; text-align:center">=</td>
		<td style="width:43%; vertical-align: middle; text-align:right">Rp. 0</td>
        <td style="width:5%;"></td>
	</tr>
    <tr>
        <td></td>
		<td style="width:5%; vertical-align: middle; text-align:center">3.</td>
		<td style="width:42%;">Piutang Pinjaman Konsumtif</td>
        <td style="width:5%; vertical-align: middle; text-align:center">=</td>
		<td style="width:43%; vertical-align: middle; text-align:right">Rp. 0</td>
        <td style="width:5%;"></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Piutang Pinjaman Desember 2019</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Mutasi Pada Tahun 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Pinjaman</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>+</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Jumlah</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Penerimaan</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>-</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Piutang Pinjaman Konsumtif Tahun 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td style="width:5%; vertical-align: middle; text-align:center">4.</td>
		<td style="width:42%;">Piutang Pinjaman Berjangka</td>
        <td style="width:5%; vertical-align: middle; text-align:center">=</td>
		<td style="width:43%; vertical-align: middle; text-align:right">Rp. 0</td>
        <td style="width:5%;"></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Piutang Pinjaman Desember 2019</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Mutasi Pada Tahun 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Pinjaman</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>+</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Jumlah</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Penerimaan</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>-</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Piutang Pinjaman Berjangka Tahun 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td style="width:5%; vertical-align: middle; text-align:center">5.</td>
		<td style="width:42%;">Piutang Pinjaman Barang</td>
        <td style="width:5%; vertical-align: middle; text-align:center">=</td>
		<td style="width:43%; vertical-align: middle; text-align:right">Rp. 0</td>
        <td style="width:5%;"></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Piutang Pinjaman Desember 2019</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Mutasi Pada Tahun 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Penjualan Barang</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>+</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Jumlah</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Angsuran Barang</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>-</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Piutang Pinjaman Barang Tahun 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr class="header_kolom">
		<th style="width:5%; vertical-align: middle; text-align:center"> II. </th>
		<th style="width:25%;" colspan="5">PENYERTAAN </th>
	</tr>
	<tr>
        <td></td>
		<td style="width:5%; vertical-align: middle; text-align:center">1.</td>
		<td style="width:42%;">PKPRI Kota Bekasi</td>
        <td style="width:5%; vertical-align: middle; text-align:center">=</td>
		<td style="width:43%; vertical-align: middle; text-align:right">Rp. 0</td>
        <td style="width:5%;"></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Simpanan PKPRI Desember 2019</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Mutasi Pada Tahun 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Penambahan</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>+</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Jumlah</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Pengambilan</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>-</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Simpanan PKPRI Desember 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr class="header_kolom">
		<th style="width:5%; vertical-align: middle; text-align:center"> III. </th>
		<th style="width:25%;" colspan="5">HARTA TETAP </th>
	</tr>
    <tr>
        <td></td>
		<td style="width:5%; vertical-align: middle; text-align:center"></td>
		<td style="width:42%;"></td>
        <td style="width:5%; vertical-align: middle; text-align:center">=</td>
		<td style="width:43%; vertical-align: middle; text-align:right">Rp. 0</td>
        <td style="width:5%;"></td>
	</tr>
    <tr class="header_kolom">
		<th style="width:5%; vertical-align: middle; text-align:center"> IV. </th>
		<th style="width:25%;" colspan="5">HUTANG JANGKA PENDEK </th>
	</tr>
	<tr>
        <td></td>
		<td style="width:5%; vertical-align: middle; text-align:center">1.</td>
		<td style="width:42%;">Simpanan Sukarela</td>
        <td style="width:5%; vertical-align: middle; text-align:center">=</td>
		<td style="width:43%; vertical-align: middle; text-align:right">Rp. 0</td>
        <td style="width:5%;"></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Simpanan Sukarela Desember 2019</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Mutasi Pada Tahun 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Penambahan</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>+</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Jumlah</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Pengambilan</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>-</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Simpanan Sukarela Desember 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td style="width:5%; vertical-align: middle; text-align:center">2.</td>
		<td style="width:42%;">Dana Pembangunan</td>
        <td style="width:5%; vertical-align: middle; text-align:center">=</td>
		<td style="width:43%; vertical-align: middle; text-align:right">Rp. 0</td>
        <td style="width:5%;"></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Dana Pembangunan Desember 2019</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Mutasi Pada Tahun 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Penambahan</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>+</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Jumlah</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Pengambilan</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>-</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Dana Pembangunan Desember 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td style="width:5%; vertical-align: middle; text-align:center">3.</td>
		<td style="width:42%;">Dana Pendidikan</td>
        <td style="width:5%; vertical-align: middle; text-align:center">=</td>
		<td style="width:43%; vertical-align: middle; text-align:right">Rp. 0</td>
        <td style="width:5%;"></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Dana Pendidikan  Desember 2019</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Mutasi Pada Tahun 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Penambahan</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>+</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Jumlah</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Pengambilan (Uang Kolak)</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>-</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Dana Pendidikan Desember 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td style="width:5%; vertical-align: middle; text-align:center">4.</td>
		<td style="width:42%;">Dana Sosial</td>
        <td style="width:5%; vertical-align: middle; text-align:center">=</td>
		<td style="width:43%; vertical-align: middle; text-align:right">Rp. 0</td>
        <td style="width:5%;"></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Dana Sosial Desember 2019</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Mutasi Pada Tahun 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Penambahan</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>+</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Jumlah</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Pengambilan</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>-</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Dana Sosial Desember 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr class="header_kolom">
		<th style="width:5%; vertical-align: middle; text-align:center"> V. </th>
		<th style="width:25%;" colspan="5">HUTANG JANGKA PANJANG </th>
	</tr>
	<tr>
        <td></td>
		<td style="width:5%; vertical-align: middle; text-align:center">1.</td>
		<td style="width:42%;">Saldo Hutang Jangka Panjang Desember 2019</td>
        <td style="width:5%; vertical-align: middle; text-align:center">=</td>
		<td style="width:43%; vertical-align: middle; text-align:right">Rp. 0</td>
        <td style="width:5%;"></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Penambahan</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>+</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Jumlah</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Pembayaran Hutang jangka Panjang</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>-</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Hutang Jangka Panjang Desember 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr class="header_kolom">
		<th style="width:5%; vertical-align: middle; text-align:center"> VI. </th>
		<th style="width:25%;" colspan="5">MODAL SENDIRI </th>
	</tr>
	<tr>
        <td></td>
		<td style="width:5%; vertical-align: middle; text-align:center">1.</td>
		<td style="width:42%;">Simpanan Pokok</td>
        <td style="width:5%; vertical-align: middle; text-align:center">=</td>
		<td style="width:43%; vertical-align: middle; text-align:right">Rp. 0</td>
        <td style="width:5%;"></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Simpanan Pokok Desember 2019</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Mutasi Pada Tahun 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Penambahan</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>+</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Jumlah</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Pengambilan</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>-</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Simpanan Pokok Desember 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td style="width:5%; vertical-align: middle; text-align:center">2.</td>
		<td style="width:42%;">Simpanan Wajib</td>
        <td style="width:5%; vertical-align: middle; text-align:center">=</td>
		<td style="width:43%; vertical-align: middle; text-align:right">Rp. 0</td>
        <td style="width:5%;"></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Simpanan Wajib Desember 2019</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Mutasi Pada Tahun 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Penambahan</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>+</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Jumlah</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Pengambilan</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>-</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Simpanan Wajib Desember 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td style="width:5%; vertical-align: middle; text-align:center">3.</td>
		<td style="width:42%;">Dana Cadangan</td>
        <td style="width:5%; vertical-align: middle; text-align:center">=</td>
		<td style="width:43%; vertical-align: middle; text-align:right">Rp. 0</td>
        <td style="width:5%;"></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Dana Cadangan  Desember 2019</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Mutasi Pada Tahun 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Penambahan</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>+</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Jumlah</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Pengambilan</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>-</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Dana Cadangan Desember 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td style="width:5%; vertical-align: middle; text-align:center">4.</td>
		<td style="width:42%;">Simpanan Khusus</td>
        <td style="width:5%; vertical-align: middle; text-align:center">=</td>
		<td style="width:43%; vertical-align: middle; text-align:right">Rp. 0</td>
        <td style="width:5%;"></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Simpanan Khusus Desember 2019</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Mutasi Pada Tahun 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Penambahan</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>+</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Jumlah</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Pengambilan</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td>-</td>
	</tr>
    <tr>
        <td></td>
		<td></td>
		<td>Saldo Simpanan Khusus Desember 2020</td>
        <td style="vertical-align: middle; text-align:center">=</td>
		<td style="vertical-align: middle; text-align:right">Rp. 285,166,893</td>
        <td></td>
	</tr>

    <tr class="header_kolom">
		<th style="vertical-align: middle; text-align:center" colspan="3"> SHU Tahun Buku 2020 </th>
		<th style="vertical-align: middle; text-align:center">=</th>
        <th style="vertical-align: middle; text-align:right"> Rp. 285,166,893 </th>
        <th></th>
	</tr>
    </table>
    <p style="padding-bottom:20px; text-align:center; font-size: 15pt; font-weight: bold;"> <br>PENGURUS KOPERASI PRS BEKASI <br> </p>
    <table  class="table table-borderless">
        <tr>
            <th style="border:none; padding-bottom:70px; width:50%; vertical-align: middle; text-align:center" Colspan="2"> KETUA </th>
            <th style="border:none; padding-bottom:70px; width:50%; vertical-align: middle; text-align:center" Colspan="2"> BENDAHARA </th>
        </tr>
        <tr>
            <th style="border:none; padding-bottom:30px; width:50%; vertical-align: middle; text-align:center" Colspan="2"> ISMAWATI </th>
            <th style="border:none; padding-bottom:30px; width:50%; vertical-align: middle; text-align:center" Colspan="2"> DIYAH ROCHYANI </th>
        </tr>
    </table> -->
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
	window.location.href = '<?php echo site_url("lapb_keuangan_penjelasan_neraca"); ?>';
}

function doSearch() {
	var year = parseInt($('input[name=tahun_cari]').val());
	$('#dg').treegrid('load',{
		tahun: year
	});
}

function cetak () {
	var tahun = $('input[name=tahun_cari]').val();
	var win = window.open('<?php echo site_url("lapb_keuangan_penjelasan_neraca/cetak/?tahun=' + tahun +'"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}

}
</script>