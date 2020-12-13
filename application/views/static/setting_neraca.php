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
<table   id="dg" 
class="easyui-datagrid"
title="Setting Tipe Neraca" 
style="width:auto; height: auto;" 
url="<?php echo site_url('setting_neraca/ajax_list'); ?>" 
pagination="true" rownumbers="true" 
fitColumns="true" singleSelect="true" collapsible="true"
sortName="title" sortOrder="desc"
toolbar="#tb"
striped="true">
<thead>
	<tr>
		<th data-options="field:'id', sortable:'true',halign:'center', align:'center'" hidden="true">ID</th>
		<th data-options="field:'type_desc_neraca', width:'90', halign:'center', align:'center'">Tipe Neraca</th>
		<th data-options="field:'title', width:'90', halign:'center', align:'center'">Deskripsi</th>
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
		<input name="title" id="title_cari" size="22" placeholder="[Deskripsi]" style="line-height:22px;border:1px solid #ccc;">
		<select id="type_cari" name="type" style="width:195px; height:20px" class="easyui-validatebox" required="true" >
			<option value="" selected disabled>-- Pilih Tipe --</option>
			<?php 
				foreach($type_neraca as $key => $value){
					echo '<option value='.$value->id.'>'.$value->title.'</option>';
				}
			?>
		</select>
		<a href="javascript:void(0);" id="btn_filter" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Cari</a>
		<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Hapus Filter</a>
	</div>
</div>

<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" show= "blind" hide= "blind" modal="true" resizable="false" style="width:350px; height:200px; padding-left:20px; padding-top:20px; " closed="true" buttons="#dialog-buttons" style="display: none;">
	<form id="form" method="post" novalidate>
	<table style="height:75px" >
			<tr>
				<td>
					<table>
						<tr style="height:25px">
							<td> Tipe Neraca </td>
							<td>:</td>
							<td>
								<select id="id_type_desc_neraca" name="id_type_desc_neraca" style="width:195px; height:20px" class="easyui-validatebox" required="true" >
									<option value="" disabled>-- Pilih Tipe --</option>
									<?php 
										foreach($type_neraca as $key => $value){
											echo '<option value='.$value->id.'>'.$value->title.'</option>';
										}
									?>
								</select>
							</td>	
						</tr>
						<tr style="height:25px">
							<td> Deskripsi </td>
							<td>:</td>
							<td>
								<input id="title" name="title" style="width:190px;" >
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
		title: $('#title_cari').val(),
		id_type_desc_neraca: $('#type_cari').val(),
	});
}

function clearSearch(){
	location.reload();
}

function create(){
	$('#dialog-form').dialog('open').dialog('setTitle','Tambah Data');
	$('#form').form('clear');
	
	$('#type option[value="0"]').prop('selected', true);

	url = '<?php echo site_url('setting_neraca/create'); ?>';
}

function save() {
	var string = $("#form").serialize();
	//validasi teks kosong
	var kode = $("#kode").val();
	if(kode == 0) {
		$.messager.show({
			title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data Kode Kosong.</div>',
			timeout:2000,
			showType:'slide'
		});
		$("#kode").focus();
		return false;
	}
	var title = $("#title").val();
	if(title == 0) {
		$.messager.show({
			title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data Deskripsi Kosong.</div>',
			timeout:2000,
			showType:'slide'
		});
		$("#title").focus();
		return false;
	}
	var id_type_desc_neraca = $("#id_type_desc_neraca").val();
	if(id_type_desc_neraca == 0) {
		$.messager.show({
			title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Tipe Kosong.</div>',
			timeout:2000,
			showType:'slide'
		});
		$("#id_type_desc_neraca").focus();
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
	if(row.type = 'Perincian Pembagian Sisa Hasil Usaha'){
		row.type = 1
	}else{
		row.type = 2
	}
	if(row){
		jQuery('#dialog-form').dialog('open').dialog('setTitle','Edit Data Setoran');
		jQuery('#form').form('load',row);
		url = '<?php echo site_url('setting_neraca/update'); ?>/' + row.id;
		
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
		$.messager.confirm('Konfirmasi','Apakah Anda akan menghapus data kode transaksi : <code>' + row.nama + '</code> ?',function(r){  
			if (r){  
				$.ajax({
					type	: "POST",
					url		: "<?php echo site_url('setting_neraca/delete'); ?>",
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
</script>