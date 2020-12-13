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
		<h3 class="box-title">Cetak Data Neraca</h3>
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
<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Neraca Koperasi Pegawai DEPSOS RI PRS Bekasi <br> Per - 31 Desember 2020 </p>

<table  class="table table-bordered">
	<tr class="header_kolom">
		<th style="width:5%; vertical-align: middle; text-align:center"> NO </th>
		<th style="width:25%; vertical-align: middle; text-align:center">URAIAN </th>
		<th style="width:20%; vertical-align: middle; text-align:center"> AKTIVA  </th>
		<th style="width:5%; vertical-align: middle; text-align:center"> NO  </th>
		<th style="width:25%; vertical-align: middle; text-align:center"> URAIAN  </th>
		<th style="width:20%; vertical-align: middle; text-align:center"> PASIVA  </th>
	</tr>
	<tr>
		<td style="vertical-align: middle; text-align:center">I.</td>
		<td style="font-weight: bold;" colspan="2">Harta Lancar</td>
        <td style="vertical-align: middle; text-align:center">I.</td>
		<td style="font-weight: bold;" colspan="2">Hutang Jangka Pendek</td>
	</tr>
	<tr>
		<td></td>
		<td>Kas</td>
		<td>Rp. 273,974,769</td>
		<td>1</td>
		<td>Simpanan Sukarela</td>
		<td>Rp. 273,974,769</td>
	</tr>
	<tr>
		<td></td>
		<td>Bank</td>
		<td>Rp. 273,974,769</td>
		<td>2</td>
		<td>Dana Pembangunan</td>
		<td>Rp. 273,974,769</td>
	</tr>
    <tr>
		<td></td>
		<td>Giro</td>
		<td>Rp. 273,974,769</td>
		<td>3</td>
		<td>Dana pendidikan</td>
		<td>Rp. 273,974,769</td>
	</tr>
    <tr>
		<td></td>
		<td>Piutan Pinjaman Konsumtif</td>
		<td>Rp. 273,974,769</td>
		<td>4</td>
		<td>Dana Sosial</td>
		<td>Rp. 273,974,769</td>
	</tr>
    <tr>
		<td></td>
		<td>Piutan Pinjaman Berjangka</td>
		<td>Rp. 273,974,769</td>
		<td></td>
		<td></td>
		<td>Rp. 0</td>
	</tr>
    <tr>
		<td></td>
		<td>Piutan Pinjaman Barang</td>
		<td>Rp. 273,974,769</td>
		<td></td>
		<td></td>
		<td>Rp. 0</td>
	</tr>
    <tr>
		<td></td>
		<td style="font-weight:bold;">Jumlah Harta Lancar</td>
		<td style="font-weight:bold;">Rp. 273,974,769</td>
		<td></td>
		<td style="font-weight:bold;">Jumlah Hutang Jangka Pendek</td>
		<td style="font-weight:bold;">Rp. 273,974,769</td>
	</tr>
    <tr>
        <td style="padding:10px;" colspan="6"></td>
    </tr>
    <tr>
		<td style="vertical-align: middle; text-align:center">II.</td>
		<td style="font-weight: bold;" colspan="2">Penyerataan</td>
        <td style="vertical-align: middle; text-align:center">II.</td>
		<td style="font-weight: bold;" colspan="2">Hutang Jangka Panjang</td>
	</tr>
	<tr>
		<td></td>
		<td>PKPRI Kota Bekasi</td>
		<td>Rp. 273,974,769</td>
		<td></td>
		<td></td>
		<td>Rp. 0</td>
	</tr>
    <tr>
		<td></td>
		<td style="font-weight:bold;">Jumlah Penyerataan</td>
		<td style="font-weight:bold;">Rp. 273,974,769</td>
		<td></td>
		<td style="font-weight:bold;"></td>
		<td style="font-weight:bold;">Rp. 0</td>
	</tr>
    <tr>
        <td style="padding:10px;" colspan="6"></td>
    </tr>
    <tr>
		<td style="vertical-align: middle; text-align:center">III.</td>
		<td style="font-weight: bold;" colspan="2">Harga Tetap</td>
        <td style="vertical-align: middle; text-align:center">III.</td>
		<td style="font-weight: bold;" colspan="2">Modal Sendiri</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>Rp. 0</td>
		<td></td>
		<td>Simpanan Pokok</td>
		<td>Rp. 273,974,769</td>
	</tr>
    <tr>
		<td></td>
		<td></td>
		<td>Rp. 0</td>
		<td></td>
		<td>Simpanan Wajib</td>
		<td>Rp. 273,974,769</td>
	</tr>
    <tr>
		<td></td>
		<td></td>
		<td>Rp. 0</td>
		<td></td>
		<td>Simpanan Khusus</td>
		<td>Rp. 273,974,769</td>
	</tr>
    <tr>
		<td></td>
		<td></td>
		<td>Rp. 0</td>
		<td></td>
		<td>Dana Cadangan</td>
		<td>Rp. 273,974,769</td>
	</tr>
    <tr>
		<td></td>
		<td></td>
		<td>Rp. 0</td>
		<td></td>
		<td>SHU Tahun Buku 2020</td>
		<td>Rp. 273,974,769</td>
	</tr>
    <tr>
		<td></td>
		<td style="font-weight:bold;"></td>
		<td style="font-weight:bold;">Rp. 0</td>
		<td></td>
		<td style="font-weight:bold;">Jumlah Modal Sendiri</td>
		<td style="font-weight:bold;">Rp. 273,974,769</td>
	</tr>
    <tr class="header_kolom">
		<th style="vertical-align: middle; text-align:center" colspan="2"> Total </th>
		<th >Rp. 3,065,898,296 </th>
        <th style="vertical-align: middle; text-align:center" colspan="2"> Total </th>
		<th >Rp. 3,065,898,296 </th>
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
	window.location.href = '<?php echo site_url("lapb_keuangan_neraca"); ?>';
}

function doSearch() {
	var tgl_dari = $('input[name=daterangepicker_start]').val();
	var tgl_samp = $('input[name=daterangepicker_end]').val();
	$('input[name=tgl_dari]').val(tgl_dari);
	$('input[name=tgl_samp]').val(tgl_samp);
	$('#fmCari').attr('action', '<?php echo site_url('lapb_keuangan_neraca'); ?>');
	$('#fmCari').submit();	
}

function cetak () {
	var tahun = $('input[name=tahun]').val();
	var win = window.open('<?php echo site_url("lapb_keuangan_neraca/cetak/?tahun=' + tahun +'"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}

}
</script>