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
		<h3 class="box-title">Cetak Data Rugi Laba</h3>
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
								<input type="number" name="tahun" id="tahun" value='<?php echo $tahun ?>' placeholder="Isi Tahun">
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
<p></p>
<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Perhitungan Rugi/Laba </p>

<table  class="table table-bordered">
	<tr class="header_kolom">
		<th style="width:5%;" Colspan="4"> PENDAPATAN </th>
	</tr>
	<tr>
		<td>1</td>
		<td>Jasa Pinjaman Konsumtif</td>
		<td>38546493</td>
		<td></td>
	</tr>
	<tr>
		<td>2</td>
		<td>Jasa Pinjaman Berjangka</td>
		<td>24900700</td>
		<td></td>
	</tr>
	<tr>
		<td>3</td>
		<td>Jasa Pinjaman Barang</td>
		<td>73408500</td>
		<td></td>
	</tr>
	<tr>
		<td style="vertical-align: middle; text-align:center" colspan="2">Sub Total</td>
		<td>360961993</td>
		<td></td>
	</tr>
	<tr class="header_kolom">
		<th Colspan="4"> PENDAPATAN LAIN-LAIN </th>
	</tr>
	<tr>
		<td style="width:5%;">1</td>
		<td style="width:45%;">Provisi Anggota</td>
		<td style="width:25%;">5250000</td>
		<td style="width:25%;"></td>
	</tr>
	<tr>
		<td>2</td>
		<td>Jasa Pinjaman Kantor</td>
		<td>15507770</td>
		<td></td>
	</tr>
	<tr>
		<td style="vertical-align: middle; text-align:center" colspan="2">Sub Total</td>
		<td>20757770</td>
		<td></td>
	</tr>
	<tr>
		<td style="font-weight: bold; vertical-align: middle; text-align:center" colspan="2">Total Pendapatan</td>
		<td></td>
		<td>20757770</td>
	</tr>
    <tr class="header_kolom">
		<th Colspan="4"> PENGELUARAN/BIAYA UMUM </th>
	</tr>
	<tr>
		<td style="width:5%;">1</td>
		<td style="width:45%;">ATK</td>
		<td style="width:25%;">245,000</td>
		<td style="width:25%;"></td>
	</tr>
    <tr>
		<td style="width:5%;">2</td>
		<td style="width:45%;">Pajak</td>
		<td style="width:25%;">245,000</td>
		<td style="width:25%;"></td>
	</tr>
    <tr>
		<td style="width:5%;">3</td>
		<td style="width:45%;">Transport</td>
		<td style="width:25%;">245,000</td>
		<td style="width:25%;"></td>
	</tr>
    <tr>
		<td style="width:5%;">4</td>
		<td style="width:45%;">Biaya Rapat</td>
		<td style="width:25%;">245,000</td>
		<td style="width:25%;"></td>
	</tr>
    <tr>
		<td style="width:5%;">5</td>
		<td style="width:45%;">Humor Pengurus</td>
		<td style="width:25%;">245,000</td>
		<td style="width:25%;"></td>
	</tr>
    <tr>
		<td style="width:5%;">5</td>
		<td style="width:45%;">ATK</td>
		<td style="width:25%;">245,000</td>
		<td style="width:25%;"></td>
	</tr>
    <tr>
		<td style="width:5%;">6</td>
		<td style="width:45%;">THR Tahun 2019</td>
		<td style="width:25%;">245,000</td>
		<td style="width:25%;"></td>
	</tr>
    <tr>
		<td style="width:5%;">7</td>
		<td style="width:45%;">Uang Terompet</td>
		<td style="width:25%;">245,000</td>
		<td style="width:25%;"></td>
	</tr>
    <tr>
		<td style="width:5%;">8</td>
		<td style="width:45%;">Biaya RAT Tahun Buku 2020</td>
		<td style="width:25%;">245,000</td>
		<td style="width:25%;"></td>
	</tr>
    <tr>
		<td style="width:5%;">9</td>
		<td style="width:45%;">Sumbangan Harkop</td>
		<td style="width:25%;">245,000</td>
		<td style="width:25%;"></td>
	</tr>
    <tr>
		<td style="width:5%;">9</td>
		<td style="width:45%;">Luran anggota Dekopinda</td>
		<td style="width:25%;">245,000</td>
		<td style="width:25%;"></td>
	</tr>
    <tr>
		<td style="font-weight: bold; vertical-align: middle; text-align:center" colspan="2">Total Pengeluaran</td>
		<td></td>
		<td>20,757,770</td>
	</tr>
    <tr>
		<td style="font-weight: bold; vertical-align: middle; text-align:center" colspan="2">SHU TAHUN BUKU 2020</td>
		<td></td>
		<td>20,757,770</td>
	</tr>
</table>

<p style="padding-right:90px; text-align:right; font-size: 12pt;"> <br>Bekasi, 11 November 2020  <br> </p>
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
<p style="text-align:center; font-size: 15pt; font-weight: bold;"> PEMBAGIAN SHU TAHUN BUKU 2020 </p>

<table  class="table table-bordered">
	<tr class="header_kolom">
		<th style="width:5%;" Colspan="4"> Perincian Pembagian Sisa Hasil Usaha ( SHU ) </th>
	</tr>
	<tr>
		<td>1</td>
		<td>Dana Cadangan</td>
		<td>30%</td>
		<td>Rp. 71,972,929</td>
	</tr>
	<tr>
		<td>2</td>
		<td>Bagian Anggota</td>
		<td>50%</td>
		<td>Rp. 71,972,929</td>
	</tr>
	<tr>
		<td>3</td>
		<td>Dana Pengurus</td>
		<td>50%</td>
		<td>Rp. 71,972,929</td>
	</tr>
	<tr>
		<td>4</td>
		<td>Dana Karyawan</td>
		<td>50%</td>
		<td>Rp. 71,972,929</td>
	</tr>
	<tr>
		<td>5</td>
		<td>Dana Pendidikan</td>
		<td>50%</td>
		<td>Rp. 71,972,929</td>
	</tr>
	<tr>
		<td>6</td>
		<td>Dana Pembangunan</td>
		<td>50%</td>
		<td>Rp. 71,972,929</td>
	</tr>
	<tr>
		<td>7</td>
		<td>Dana Sosial</td>
		<td>50%</td>
		<td>Rp. 71,972,929</td>
	</tr>
	<tr>
		<td style="vertical-align: middle; text-align:center" colspan="2">Jumlah</td>
		<td></td>
		<td style="font-weight: bold;">Rp. 71,972,929</td>
	</tr>
	<tr class="header_kolom">
		<th Colspan="4"> PEMBAGIAN SHU BAGIAN ANGGOTA BERDASARKAN : </th>
	</tr>
	<tr>
		<td style="width:5%;">1</td>
		<td style="width:45%;">Simpanan Anggota</td>
		<td style="width:25%;">30%</td>
		<td style="width:25%;">Rp. 71,972,929</td>
	</tr>
	<tr>
		<td style="width:5%;">2</td>
		<td style="width:45%;">Pinjaman Anggota</td>
		<td style="width:25%;">30%</td>
		<td style="width:25%;">Rp. 71,972,929</td>
	</tr>
	<tr>
		<td style="vertical-align: middle; text-align:center" colspan="2">Jumlah</td>
		<td></td>
		<td style="font-weight: bold;">Rp. 71,972,929</td>
	</tr>
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
	window.location.href = '<?php echo site_url("lapb_keuangan_rugi_laba"); ?>';
}

function doSearch() {
	var tgl_dari = $('input[name=daterangepicker_start]').val();
	var tgl_samp = $('input[name=daterangepicker_end]').val();
	$('input[name=tgl_dari]').val(tgl_dari);
	$('input[name=tgl_samp]').val(tgl_samp);
	$('#fmCari').attr('action', '<?php echo site_url('lapb_keuangan_rugi_laba'); ?>');
	$('#fmCari').submit();	
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