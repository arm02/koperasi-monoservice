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
title="Data Master Jenis Simpanan" 
style="width:auto; height: auto;" 
url="<?php echo site_url('biaya_umum/ajax_list'); ?>" 
pagination="true" rownumbers="true" 
fitColumns="true" singleSelect="true" collapsible="true"
sortName="uraian" sortOrder="desc"
toolbar="#tb"
striped="true">
<thead>
	<tr>
		<th data-options="field:'id', sortable:'true',halign:'center', align:'center'" hidden="true">ID</th>
		<th data-options="field:'uraian', width:'17', halign:'center', align:'center'">Uraian</th>
		<th data-options="field:'tanggal', width:'17', halign:'center', align:'center'">Tanggal</th>
		<th data-options="field:'untuk_kas_nama',halign:'center', align:'center', width:'25'">Kas</th>
		<th data-options="field:'dari_akun_nama', width:'25', halign:'center', align:'center'">Akun</th>
		<th data-options="field:'jumlah', width:'25', halign:'center', align:'center'">Jumlah</th>
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
		<input name="uraian" id="uraian_cari" size="22" placeholder="[Uraian]" style="line-height:22px;border:1px solid #ccc;">
		<select id="untuk_kas_cari" name="untuk_kas" style="width:170px; height:27px" >
			<option value=""> -- Pilih Kas --</option>
			<?php 
				foreach($kas_id as $key => $value){
					echo '<option value="'.$value->id.'"> '.$value->nama.' </option>';
				}
			?>
		</select>

		<select id="dari_akun_cari" name="dari_akun" style="width:170px; height:27px" >
			<option value=""> -- Pilih Akun --</option>
			<?php 
				foreach($akun_id as $key => $value){
					echo '<option value="'.$value->id.'"> '.$value->jns_trans.' </option>';
				}
			?>
		</select>

		<a href="javascript:void(0);" id="btn_filter" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Cari</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak()">Cetak Laporan</a>
		<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Hapus Filter</a>
	</div>
</div>

<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" show= "blind" hide= "blind" modal="true" resizable="false" style="width:480px; height:300px; padding-left:20px; padding-top:20px; " closed="true" buttons="#dialog-buttons" style="display: none;">
	<form id="form" method="post" novalidate>
	<table style="height:150px" >
			<tr>
				<td>
					<table>
						<tr style="height:35px">
							<td> Tanggal </td>
							<td>:</td>
							<td>
								<input id="tanggal" name="tanggal" type="date" style="width:190px; height:20px" >
							</td>	
						</tr>
						<tr style="height:35px">
							<td> Uraian</td>
							<td>:</td>
							<td>
								<input id="uraian" name="uraian" style="width:190px; height:20px" >
							</td>	
						</tr>
						<tr style="height:35px">
							<td> Jumlah </td>
							<td>:</td>
							<td>
								<input id="jumlah" name="jumlah" style="width:190px; height:20px" >
							</td>	
						</tr>
						<tr style="height:35px">
							<td>Kas</td>
							<td>:</td>
							<td>
								<select id="untuk_kas" name="untuk_kas" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0"> -- Pilih Kas --</option>
									<?php 
										foreach($kas_id as $key => $value){
											echo '<option value="'.$value->id.'"> '.$value->nama.' </option>';
										}
									?>
								</select>
							</td>
						</tr>
						<tr style="height:35px">
							<td>Akun</td>
							<td>:</td>
							<td>
								<select id="dari_akun" name="dari_akun" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0"> -- Pilih Akun --</option>
									<?php 
										foreach($akun_id as $key => $value){
											echo '<option value="'.$value->id.'"> '.$value->jns_trans.' </option>';
										}
									?>
								</select>
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
		uraian: $('#uraian_cari').val(),
		untuk_kas: $('#untuk_kas_cari').val(),
		dari_akun: $('#dari_akun_cari').val(),
	});
}

function clearSearch(){
	location.reload();
}

function create(){
	$('#dialog-form').dialog('open').dialog('setTitle','Tambah Data');
	$('#form').form('clear');
	
	$('#untuk_kas option[value="0"]').prop('selected', true);
	$('#dari_akun option[value="0"]').prop('selected', true);
	$('#jumlah').keyup(function(){
		var val_jumlah = $(this).val();
		$('#jumlah').val(number_format(val_jumlah));
	});

	url = '<?php echo site_url('biaya_umum/create'); ?>';
}

function save() {
	var string = $("#form").serialize();
	//validasi teks kosong
	var jenis_id = $("#uraian").val();
	if(jenis_id == 0) {
		$.messager.show({
			title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data Jenis Simpanan Kosong.</div>',
			timeout:2000,
			showType:'slide'
		});
		$("#uraian").focus();
		return false;
	}
	var untuk_kas = $("#untuk_kas").val();
	if(untuk_kas == 0) {
		$.messager.show({
			title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Jenis Simpanan.</div>',
			timeout:2000,
			showType:'slide'
		});
		$("#uraian").focus();
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
		url = '<?php echo site_url('biaya_umum/update'); ?>/' + row.id;
		$('#jumlah ~ span input').keyup(function(){
			var val_jumlah = $(this).val();
			$('#jumlah').numberbox('setValue', number_format(val_jumlah));
		});
		
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
		$.messager.confirm('Konfirmasi','Apakah Anda akan menghapus data kode transaksi : <code>' + row.uraian + '</code> ?',function(r){  
			if (r){  
				$.ajax({
					type	: "POST",
					url		: "<?php echo site_url('biaya_umum/delete'); ?>",
					data	: 'id='+row.id,
					success	: function(result){
						var result = eval('('+result+')');
						$.messager.show({
							title:'<div><i class="fa fa-info"></i> Informasi </div>',
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
	var uraian 	= $('#uraian_cari').val();
	var untuk_kas 	= $('#untuk_kas_cari').val();
	var dari_akun 	= $('#dari_akun_cari').val();
	
	var win = window.open('<?php echo site_url("biaya_umum/cetak_laporan/?uraian=' + uraian + '&untuk_kas=' + untuk_kas + '&dari_akun=' + dari_akun + '"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}
}
</script>