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
<<<<<<< HEAD

.datagrid-footer .datagrid-row{
	background: #efefef;
}

.tree-file, .tree-folder{
    display: none;
  }
=======
>>>>>>> 75912ff4d4790bdf3a7f792d928bea874142238a
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
<<<<<<< HEAD
				<input type="hidden" name="tgl_dari" id="tgl_dari">
				<input type="hidden" name="tgl_samp" id="tgl_samp">
				<table>
					<tr>
						<td>
							<input type="number" name="tahun_cari" id="tahun_cari" value='<?php echo date("Y") ?>'>
						</td>
						<td>
							<a href="javascript:void(0);" id="btn_filter" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Cari</a>

=======
				<table>
					<tr>
						<td>
							<div id="filter_tgl" class="input-group" style="display: inline;">
								<button class="btn btn-default" id="daterange-btn">
									<i class="fa fa-calendar"></i> <span id="reportrange">Tanggal</span>
									<i class="fa fa-caret-down"></i>
								</button>
							</div>
						</td>
						<td>
>>>>>>> 75912ff4d4790bdf3a7f792d928bea874142238a
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

<<<<<<< HEAD
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
=======
<table  class="table table-bordered">
	<tr class="header_kolom">
		<th style="width:5%; vertical-align: middle; text-align:center" rowspan="2"> No. </th>
		<th style="width:15%; vertical-align: middle; text-align:center" rowspan="2">Bulan </th>
		<th style="width:20%; vertical-align: middle; text-align:center" colspan="2"> Konsumtif  </th>
		<th style="width:20%; vertical-align: middle; text-align:center" colspan="2"> Berjangka  </th>
		<th style="width:20%; vertical-align: middle; text-align:center" colspan="2"> Barang  </th>
		<th style="width:15%; vertical-align: middle; text-align:center" rowspan="2"> Jumlah  </th>
	</tr>
	<tr class="header_kolom">
		<th style="width:10%; vertical-align: middle; text-align:center"> Pokok  </th>
		<th style="width:10%; vertical-align: middle; text-align:center"> Jasa  </th>

		<th style="width:10%; vertical-align: middle; text-align:center"> Pokok  </th>
		<th style="width:10%; vertical-align: middle; text-align:center"> Jasa  </th>

		<th style="width:10%; vertical-align: middle; text-align:center"> Pokok  </th>
		<th style="width:10%; vertical-align: middle; text-align:center"> Jasa  </th>
	</tr>
	<tr>
		<td>1</td>
		<td>Januari</td>
		<td>1000000</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>
	<tr>
		<td></td>
		<td>Pelunasan</td>
		<td></td>
		<td></td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>

	<tr>
		<td>2</td>
		<td>Februari</td>
		<td>1000000</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>
	<tr>
		<td></td>
		<td>Pelunasan</td>
		<td></td>
		<td></td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>

	<tr>
		<td>3</td>
		<td>Maret</td>
		<td>1000000</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>
	<tr>
		<td></td>
		<td>Pelunasan</td>
		<td></td>
		<td></td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>

	<tr>
		<td>4</td>
		<td>April</td>
		<td>1000000</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>
	<tr>
		<td></td>
		<td>Pelunasan</td>
		<td></td>
		<td></td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>

	<tr>
		<td>5</td>
		<td>Mei</td>
		<td>1000000</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>
	<tr>
		<td></td>
		<td>Pelunasan</td>
		<td></td>
		<td></td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>

	<tr>
		<td>6</td>
		<td>Juni</td>
		<td>1000000</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>
	<tr>
		<td></td>
		<td>Pelunasan</td>
		<td></td>
		<td></td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>

	<tr>
		<td>7</td>
		<td>Juli</td>
		<td>1000000</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>
	<tr>
		<td></td>
		<td>Pelunasan</td>
		<td></td>
		<td></td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>

	<tr>
		<td>8</td>
		<td>Agustus</td>
		<td>1000000</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>
	<tr>
		<td></td>
		<td>Pelunasan</td>
		<td></td>
		<td></td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>

	<tr>
		<td>9</td>
		<td>September</td>
		<td>1000000</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>
	<tr>
		<td></td>
		<td>Pelunasan</td>
		<td></td>
		<td></td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>

	<tr>
		<td>10</td>
		<td>Oktober</td>
		<td>1000000</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>
	<tr>
		<td></td>
		<td>Pelunasan</td>
		<td></td>
		<td></td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>

	<tr>
		<td>11</td>
		<td>November</td>
		<td>1000000</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>
	<tr>
		<td></td>
		<td>Pelunasan</td>
		<td></td>
		<td></td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>

	<tr>
		<td>12</td>
		<td>Desember</td>
		<td>1000000</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>
	<tr>
		<td></td>
		<td>Pelunasan</td>
		<td></td>
		<td></td>
		<td>14322341</td>
		<td>14322341</td>
		<td>29644682</td>
		<td>29644682</td>
		<td>29644682</td>
	</tr>
	<tr class="header_kolom">
		<th style="width:5%; vertical-align: middle; text-align:center" colspan="2"> Jumlah </th>
		<th style="width:15%;" >3000000 </th>
		<th style="width:20%;" > 42967023  </th>
		<th style="width:15%;" > 42967023  </th>
		<th style="width:15%;" > 42967023   </th>
		<th style="width:15%;" > 88934046   </th>
		<th style="width:15%;" > 88934046   </th>
		<th style="width:15%;" > 88934046   </th>
	</tr>
>>>>>>> 75912ff4d4790bdf3a7f792d928bea874142238a
</div>
</div>
	
<script type="text/javascript">
<<<<<<< HEAD
=======
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

>>>>>>> 75912ff4d4790bdf3a7f792d928bea874142238a
function clearSearch(){
	window.location.href = '<?php echo site_url("lapb_keuangan_tagihan"); ?>';
}

function doSearch() {
<<<<<<< HEAD
	var tahuns = $('input[name=tahun_cari]').val();
	$('#dg').treegrid('load',{
		tahun: tahuns
	});	
}

function cetak () {
	var tahun = $('input[name=tahun_cari]').val() || new Date().getFullYear();
	var win = window.open('<?php echo site_url("lapb_keuangan_tagihan/cetak?tahun=' + tahun +'"); ?>');
=======
	var tgl_dari = $('input[name=daterangepicker_start]').val();
	var tgl_samp = $('input[name=daterangepicker_end]').val();
	$('input[name=tgl_dari]').val(tgl_dari);
	$('input[name=tgl_samp]').val(tgl_samp);
	$('#fmCari').attr('action', '<?php echo site_url('lapb_keuangan_tagihan'); ?>');
	$('#fmCari').submit();	
}

function cetak () {
	var tahun = $('input[name=tahun]').val();
	var win = window.open('<?php echo site_url("lapb_keuangan_tagihan/cetak/?tahun=' + tahun +'"); ?>');
>>>>>>> 75912ff4d4790bdf3a7f792d928bea874142238a
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}

}
</script>