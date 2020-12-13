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
		<h3 class="box-title">Cetak Data Tagihan Konsumtif</h3>
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
<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Rekapitulasi Tagihan Pinjaman Konsumtif </p>

<table  class="table table-bordered">
	<tr class="header_kolom">
		<th style="vertical-align: middle; text-align:center"> No. </th>
		<th style="vertical-align: middle; text-align:center"> Nama </th>
		<th style="vertical-align: middle; text-align:center"> Jan  </th>
		<th style="vertical-align: middle; text-align:center"> Feb  </th>
		<th style="vertical-align: middle; text-align:center"> Mar  </th>
		<th style="vertical-align: middle; text-align:center"> Apr  </th>
		<th style="vertical-align: middle; text-align:center"> Mei  </th>
		<th style="vertical-align: middle; text-align:center"> Jun  </th>
		<th style="vertical-align: middle; text-align:center"> Jul  </th>
		<th style="vertical-align: middle; text-align:center"> Agust  </th>
		<th style="vertical-align: middle; text-align:center"> Sept  </th>
		<th style="vertical-align: middle; text-align:center"> Okt  </th>
		<th style="vertical-align: middle; text-align:center"> Nov  </th>
		<th style="vertical-align: middle; text-align:center"> Des  </th>
		<th style="vertical-align: middle; text-align:center"> Jumlah  </th>
	</tr>
	<tr>
		<td>1</td>
		<td>Alimin</td>
		<td>100000</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>100000</td>
		<td>1000000</td>
	</tr>
	<tr>
		<td>2</td>
		<td>Endin</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>100000</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>1000000</td>
	</tr>
	<tr>
		<td>3</td>
		<td>Empat Siti Fatimah</td>
		<td>100000</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>100000</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>1000000</td>
	</tr>
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
	window.location.href = '<?php echo site_url("lapb_koperasi_tagihan_konsumtif"); ?>';
}

function doSearch() {
	var tgl_dari = $('input[name=daterangepicker_start]').val();
	var tgl_samp = $('input[name=daterangepicker_end]').val();
	$('input[name=tgl_dari]').val(tgl_dari);
	$('input[name=tgl_samp]').val(tgl_samp);
	$('#fmCari').attr('action', '<?php echo site_url('lapb_koperasi_tagihan_konsumtif'); ?>');
	$('#fmCari').submit();	
}

function cetak () {
	var tahun = $('input[name=tahun]').val();
	var win = window.open('<?php echo site_url("lapb_koperasi_tagihan_konsumtif/cetak/?tahun=' + tahun +'"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}

}
</script>