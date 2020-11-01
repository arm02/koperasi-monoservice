<!-- Styler -->
<style type="text/css">
td, div {
	font-family: "Arial","​Helvetica","​sans-serif";
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
</style>

<!-- Data Grid -->
<table id="dg" 
class="easyui-datagrid"
title="Data Jenis Angsuran" 
style="width:auto; height: auto;" 
url="<?php echo site_url('data_barang/ajax_list'); ?>" 
pagination="true" rownumbers="true" 
fitColumns="true" singleSelect="true" collapsible="true"
sortName="nm_barang" sortOrder="desc"
toolbar="#tb"
striped="true">
<thead>
	<tr>
		<th data-options="field:'id', sortable:'true',halign:'center', align:'center'" hidden="true">ID</th>
		<th data-options="field:'nm_barang', width:'17', halign:'center', align:'center'">Nama Barang</th>
		<th data-options="field:'type',halign:'center', align:'center', width:'25'">Type</th>
		<th data-options="field:'merk',halign:'center', align:'center', width:'25'">Merk</th>
		<th data-options="field:'harga',halign:'center', align:'center', width:'25'">Harga</th>
		<th data-options="field:'jml_brg',halign:'center', align:'center', width:'25'">Jumlah Barang</th>
		<th data-options="field:'ket',halign:'center', align:'center', width:'25'">ket</th>
	</tr>
</thead>
</table>

<!-- Toolbar -->
<div id="tb" style="height: 35px;">
	<div style="vertical-align: middle; display: inline; padding-top: 15px;">
		<a href="javascript:void(0)" class="easyui-linkbutton"  iconCls="icon-add" plain="true" onclick="create()">Tambah </a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="update()">Edit</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" onclick="hapus()">Hapus</a>
	</div>
	<div class="pull-right" style="vertical-align: middle;">
		<!-- <div id="filter_tgl" class="input-group" style="display: inline;">
			<button class="btn btn-default" id="daterange-btn" style="line-height:16px;border:1px solid #ccc">
				<i class="fa fa-calendar"></i> <span id="reportrange"><span> Tanggal</span></span>
				<i class="fa fa-caret-down"></i>
			</button>
		</div> -->
		<span>Cari :</span>
		<input name="nm_barang" id="nm_barang_cari" size="22" placeholder="[Nama Barang]" style="line-height:22px;border:1px solid #ccc;">
		<input name="type" id="type_cari" size="22" placeholder="[Type]" style="line-height:22px;border:1px solid #ccc;">
		<input name="merk" id="merk_cari" size="22" placeholder="[Merk]" style="line-height:22px;border:1px solid #ccc;">

		<a href="javascript:void(0);" id="btn_filter" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Cari</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak()">Cetak Laporan</a>
		<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Hapus Filter</a>
	</div>
</div>

<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" show= "blind" hide= "blind" modal="true" resizable="false" style="width:480px; height:500px; padding-left:20px; padding-top:20px; " closed="true" buttons="#dialog-buttons" style="display: none;">
	<form id="form" method="post" novalidate>
	<table style="height:150px" >
			<tr>
				<td>
					<table>
						<tr style="height:35px">
							<td> Nama Barang </td>
							<td>:</td>
							<td>
								<input id="nm_barang" name="nm_barang" style="width:190px; height:20px" >
							</td>	
						</tr>
						<tr style="height:35px">
							<td> Type </td>
							<td>:</td>
							<td>
								<input id="type" name="type" style="width:190px; height:20px" >
							</td>	
						</tr>
						<tr style="height:35px">
							<td> Merk </td>
							<td>:</td>
							<td>
								<input id="merk" name="merk" style="width:190px; height:20px" >
							</td>	
						</tr>
						<tr style="height:35px">
							<td> Harga </td>
							<td>:</td>
							<td>
								<input type="number" id="harga" name="harga" style="width:190px; height:20px" >
							</td>	
						</tr>
						<tr style="height:35px">
							<td> Jumlah Barang </td>
							<td>:</td>
							<td>
								<input type="number" id="jml_brg" name="jml_brg" style="width:190px; height:20px" >
							</td>	
						</tr>
						<tr style="height:35px">
							<td> Keterangan </td>
							<td>:</td>
							<td>
								<textarea id="ket" name="ket" style="width:190px; height:20px" ></textarea>
							</td>	
						</tr>
				</table>
				</td>
			</tr>
		</table>
	</form>
</div>

<!-- Dialog Button -->
<div id="dialog-buttons">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="save()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
</div>

<script type="text/javascript">
var url;

function doSearch(){
	$('#dg').datagrid('load',{
		nm_barang: $('#nm_barang_cari').val(),
		type: $('#type_cari').val(),
		merk: $('#merk_cari').val(),
	});
}

function clearSearch(){
	location.reload();
}

function create(){
	$('#dialog-form').dialog('open').dialog('setTitle','Tambah Data');
	$('#form').form('clear');

	url = '<?php echo site_url('data_barang/create'); ?>';
}

function save() {
	var string = $("#form").serialize();
	//validasi teks kosong
	var nm_barang = $("#nm_barang").val();
	if(nm_barang == 0) {
		$.messager.show({
			title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data Nama Barang Kosong.</div>',
			timeout:2000,
			showType:'slide'
		});
		$("#nm_barang").focus();
		return false;
	}
	var type = $("#type").val();
	if(type == 0) {
		$.messager.show({
			title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, data aktif Kosong !.</div>',
			timeout:2000,
			showType:'slide'
		});
		$("#aktif").focus();
		return false;
	}
	var merk = $("#merk").val();
	if(merk == 0) {
		$.messager.show({
			title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, data Merk Kosong !.</div>',
			timeout:2000,
			showType:'slide'
		});
		$("#merk").focus();
		return false;
	}

	var isValid = $('#form').form('validate');
	if (isValid) {
		$.ajax({
			type	: "POST",
			url: url,
			data	: string,
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
			}
		});
	} else {
		$.messager.show({
			title:'<div><i class="fa fa-info"></i> Informasi</div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Lengkapi seluruh pengisian data.</div>',
			timeout:2000,
			showType:'slide'
		});
	}
}

function update(){
	var row = jQuery('#dg').datagrid('getSelected');
	if(row){
		jQuery('#dialog-form').dialog('open').dialog('setTitle','Edit Data Setoran');
		jQuery('#form').form('load',row);
		url = '<?php echo site_url('data_barang/update'); ?>/' + row.id;
		
	}else {
		$.messager.show({
			title:'<div><i class="fa fa-warning"></i> Peringatan !</div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data harus dipilih terlebih dahulu </div>',
			timeout:2000,
			showType:'slide'
		});
	}
}

function hapus(){  
	var row = $('#dg').datagrid('getSelected');  
	if (row){ 
		$.messager.confirm('Konfirmasi','Apakah Anda akan menghapus data Nama Barang : <code>' + row.nm_barang + '</code> ?',function(r){  
			if (r){  
				$.ajax({
					type	: "POST",
					url		: "<?php echo site_url('data_barang/delete'); ?>",
					data	: 'id='+row.id,
					success	: function(result){
						var result = eval('('+result+')');
						$.messager.show({
							title:'<div><i class="fa fa-info"></i> Informasi</div>',
							msg: result.msg,
							timeout:2000,
							showType:'slide'
						});
						if(result.ok) {
							$('#dg').datagrid('reload');
						}
					},
					error : function (){
						$.messager.show({
							title:'<div><i class="fa fa-warning"></i> Peringatan !</div>',
							msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Terjadi kesalahan koneksi, silahkan muat ulang !</div>',
							timeout:2000,
							showType:'slide'
						});
					}
				});  
			}  
		}); 
	}  else {
		$.messager.show({
			title:'<div><i class="fa fa-warning"></i> Peringatan !</div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data harus dipilih terlebih dahulu </div>',
			timeout:2000,
			showType:'slide'
		});	
	}
	$('.messager-button a:last').focus();
}

function cetak () {
	var nm_barang = $('#nm_barang_cari').val()
	var type = $('#type_cari').val()
	var merk = $('#merk_cari').val()
	
	var win = window.open('<?php echo site_url("data_barang/cetak_laporan/?nm_barang=' + nm_barang + '&type=' + type + '&merk=' + merk + '"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}
}
</script>