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

.datagrid-footer .datagrid-row{
	background: #efefef;
}

.tree-file, .tree-folder{
	display: none;
}
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
		<h3 class="box-title">Neraca Koperasi Pegawai DEPSOS RI PRS Bekasi</h3>
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
							<input type="number" name="tahun_cari" id="tahun_cari" value='<?php echo date("Y") ?>'>
						</td>
						<td>
							<a href="javascript:void(0);" id="btn_filter" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Cari</a>

							<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak()">Cetak Laporan</a>

							<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Hapus Filter</a>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>

<div class="box box-primary text-center">
	<div class="box-body row">
		<div class="col-md-5">
			<table
				id="dg-aktiva"
				class="easyui-treegrid"
				title="Data Neraca Aktiva"
				style="width:auto; height: auto;"
				url="<?php echo site_url('lapb_keuangan_neraca/ajax_list_aktiva'); ?>"
				pagination="false" rownumbers="false"
				fitColumns="true"
				striped="true"
				showFooter="true"
				idField= "no",
				treeField= "uraian"
			>
				<thead>
					<tr>
						<th data-options="field:'no',width:'1', halign:'center', align:'left'"> No </th>
						<th data-options="field:'uraian',width:'10', halign:'center', align:'left'"> Uraian </th>
						<th data-options="field:'nominal',width:'10', halign:'center', align:'right'"> Aktiva  </th>
					</tr>
				</thead>
			</table>
		</div>
		<div class="col-md-6">
			<table
				id="dg-pasiva"
				class="easyui-treegrid"
				title="Data Neraca Pasiva"
				style="width:auto; height: auto;"
				url="<?php echo site_url('lapb_keuangan_neraca/ajax_list_pasiva'); ?>"
				pagination="false" rownumbers="false"
				fitColumns="true"
				striped="true"
				showFooter="true"
				idField= "no",
				treeField= "uraian"
			>
				<thead>
					<tr>
						<th data-options="field:'no',width:'1', halign:'center', align:'left'"> No </th>
						<th data-options="field:'uraian',width:'10', halign:'center', align:'left'"> Uraian </th>
						<th data-options="field:'nominal',width:'10', halign:'center', align:'right'"> Pasiva  </th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
<table  class="table table-borderless">
	<tr>
		<th style="border:none; padding-bottom:30px; width:50%; vertical-align: middle; text-align:center" Colspan="2"> KETUA </th>
		<th style="border:none; padding-bottom:30px; width:50%; vertical-align: middle; text-align:center" Colspan="2"> BENDAHARA </th>
	</tr>
	<tr>
		<th style="border:none; padding-bottom:30px; width:50%; vertical-align: middle; text-align:center" Colspan="2"> 
			<img height="100" src="<?php echo base_url().'assets/asset/images/ttd/ttd1.png'; ?>"> 
		</th>
		<th style="border:none; padding-bottom:30px; width:50%; vertical-align: middle; text-align:center" Colspan="2"> 
			<img height="100" src="<?php echo base_url().'assets/asset/images/ttd/ttd2.jpg'; ?>"> 
		</th>
	</tr>
	<tr>
		<th style="border:none; padding-bottom:30px; width:50%; vertical-align: middle; text-align:center" Colspan="2"> ISMAWATI </th>
		<th style="border:none; padding-bottom:30px; width:50%; vertical-align: middle; text-align:center" Colspan="2"> DIYAH ROCHYANI </th>
	</tr>
</table>
	
<script type="text/javascript">
function clearSearch(){
	window.location.href = '<?php echo site_url("lapb_keuangan_neraca"); ?>';
}

function doSearch() {
	var tahuns = $('input[name=tahun_cari]').val();
	$('#dg-aktiva').treegrid('load',{
		tahun: tahuns
	});	
	$('#dg-pasiva').treegrid('load',{
		tahun: tahuns
	});	
}

function cetak () {
	var tahun = $('input[name=tahun_cari]').val() || new Date().getFullYear();
	var win = window.open('<?php echo site_url("lapb_keuangan_neraca/cetak?tahun=' + tahun +'"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}

}
</script>