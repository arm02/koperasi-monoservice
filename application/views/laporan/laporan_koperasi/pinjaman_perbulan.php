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
		<h3 class="box-title">Cetak Data Pinjaman Perbulan</h3>
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
								<select id="bulan_cari" name="bulan" style="width:195px;">
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
								<input type="number" name="tahun" id="tahun" value='<?php echo $tahun ?>' placeholder="Isi Tahun">
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
<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Laporan Bagian Pinjaman Bulan Januari 2020 </p>

<table  class="table table-bordered">
	<tr class="header_kolom">
		<th style="width:5%; vertical-align: middle; text-align:center"> No </th>
		<th style="vertical-align: middle; text-align:center">  </th>
		<th style="vertical-align: middle; text-align:center"> Pokok  </th>
		<th style="vertical-align: middle; text-align:center"> Jasa  </th>
		<th style="vertical-align: middle; text-align:center"> Jumlah  </th>
		<th style="vertical-align: middle; text-align:center"> Uraian  </th>
		<th style="vertical-align: middle; text-align:center"> Jumlah  </th>
	</tr>
	<tr>
		<td></td>
		<td>Saldo Bulan Desember 2019</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td></td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
	</tr>
    <tr>
		<td></td>
		<td>Terima Dari Bendahara</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td></td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
	</tr>
    <tr>
		<td></td>
		<td>Tagihan Konsumtif</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td>Pinjaman Konsumtif</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
	</tr>
    <tr>
		<td></td>
		<td>Tagihan Berjangka</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td>Pinjaman Berjangka</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
	</tr>
    <tr>
		<td></td>
		<td>Tagihan Barang</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td>Pinjaman Barang</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
	</tr>
    <tr>
		<td></td>
		<td>Pelunasan Berjangka</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td></td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
	</tr>
    <tr>
		<td></td>
		<td>Pelunasan Barang</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td></td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
	</tr>
    <tr>
		<td></td>
		<td>Provisi</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td></td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
	</tr>
    <tr>
		<td></td>
		<td>Total</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td>Total</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
	</tr>
    <tr>
		<td></td>
		<td>Saldo Januari 2020</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
		<td></td>
		<td style="vertical-align: middle; text-align:right">Rp. 0</td>
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
	window.location.href = '<?php echo site_url("lapb_koperasi_pinjaman_perbulan"); ?>';
}

function doSearch() {
	var tgl_dari = $('input[name=daterangepicker_start]').val();
	var tgl_samp = $('input[name=daterangepicker_end]').val();
	$('input[name=tgl_dari]').val(tgl_dari);
	$('input[name=tgl_samp]').val(tgl_samp);
	$('#fmCari').attr('action', '<?php echo site_url('lapb_koperasi_pinjaman_perbulan'); ?>');
	$('#fmCari').submit();	
}

function cetak () {
	var tahun = $('input[name=tahun]').val();
	var win = window.open('<?php echo site_url("lapb_koperasi_pinjaman_perbulan/cetak/?tahun=' + tahun +'"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}

}
</script>