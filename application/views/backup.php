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
		<h3 class="box-title">Backup Database</h3>
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
								<button class="btn btn-default" id="daterange-btn">
									<i class="fa fa-calendar"></i> <span id="reportrange">Tanggal</span>
									<i class="fa fa-caret-down"></i>
								</button>
							</div>
						</td>
						<td>
							<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="backup()">Backup Data</a>

							<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Hapus Filter</a>

							<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-save" plain="false" onclick="downloadBackup()">Download Backup</a>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>

<div class="box box-primary">
<div class="box-body">

<table id="dg"
class="easyui-datagrid"
title="Data Backup"
style="width:auto; height: auto;"
url="<?php echo site_url('backup/ajax_list'); ?>"
pagination="true" rownumbers="false"
fitColumns="true" singleSelect="true" collapsible="true"
sortName="tanggal" sortOrder="desc"
toolbar="#tb"
striped="true">
	<thead>
		<tr class="header_kolom">
			<th data-options="field:'id',width:'17', halign:'center', align:'center'"> ID </th>
			<th data-options="field:'nama_backup',width:'30', halign:'left', align:'left'"> Nama Backup </th>
			<th data-options="field:'tanggal',width:'30', halign:'center', align:'center'"> Tanggal Backup </th>
		</tr>
	</thead>
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
			}
		?>
	},

	function (start, end) {
		$('#reportrange').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
		doSearch();
	});
}

function clearSearch(){
	window.location.href = '<?php echo site_url("backup"); ?>';
}

function doSearch() {
	var tgl_dari = $('input[name=daterangepicker_start]').val();
	var tgl_samp = $('input[name=daterangepicker_end]').val();
	console.log(tgl_dari,tgl_samp)
	$('#dg').datagrid('load',{
		tgl_dari: tgl_dari,
		tgl_samp: tgl_samp,
	});	
}
function backup () {
	var url = '<?php echo site_url("backup/backup_db"); ?>'
	$.ajax({
		url: url,
		type	: "GET",
		success	: function(result){
			var response = jQuery.parseJSON(result)
			create(response)
		}
	});

}

function downloadBackup() {
	var row = jQuery('#dg').datagrid('getSelected');
	var data = row
	if(data){
		window.location.href = data.pathdb+'.sql'
		
	}else {
		$.messager.show({
			title:'<div><i class="fa fa-warning"></i> Peringatan !</div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data harus dipilih terlebih dahulu </div>',
			timeout:2000,
			showType:'slide'
		});
	}
}
function create (datas) {
	var url = '<?php echo site_url("backup/create"); ?>'
	$.ajax({
		url: url,
		type: "POST",
		data: {
			nama_backup : datas.filename,
			pathdb : datas.path,
		},
		success	: function(result){
			var result = eval('('+result+')');
			$.messager.show({
					title:'<div><i class="fa fa-info"></i> Informasi</div>',
					msg: result.msg,
					timeout:2000,
					showType:'slide'
				});
				if(result.ok) {
					jQuery('#dialog-form').dialog('close');
					//clearSearch();
					$('#dg').datagrid('reload');
				}
			// location.reload()
		}
	});

}
</script>