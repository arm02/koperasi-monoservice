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
title="Data Master Kas" 
style="width:auto; height: auto;" 
url="<?php echo site_url('jenis_kas/ajax_list'); ?>" 
pagination="true" rownumbers="true" 
fitColumns="true" singleSelect="true" collapsible="true"
sortName="nama" sortOrder="desc"
toolbar="#tb"
striped="true">
<thead>
	<tr>
		<th data-options="field:'id', sortable:'true',halign:'center', align:'center'" hidden="true">ID</th>
		<th data-options="field:'nama', width:'17', halign:'center', align:'center'">Nama Kas</th>
		<th data-options="field:'aktif',halign:'center', align:'center', width:'25'">Aktif</th>
		<th data-options="field:'tmpl_simpan', width:'25', halign:'center', align:'center'">Simpanan</th>
		<th data-options="field:'tmpl_penarikan', width:'25', halign:'center', align:'center'">Penarikan</th>
		<th data-options="field:'tmpl_pinjaman', width:'25', halign:'center', align:'center'">Pinjaman</th>
		<th data-options="field:'tmpl_bayar', width:'25', halign:'center', align:'center'">Angsuran</th>
		<th data-options="field:'tmpl_pemasukan', width:'25', halign:'center', align:'center'">Pemasukan Kas</th>
		<th data-options="field:'tmpl_pengeluaran', width:'25', halign:'center', align:'center'">Pengeluaran Kas</th>
		<th data-options="field:'tmpl_transfer', width:'25', halign:'center', align:'center'">Transfer Kas</th>
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
		<input name="nama" id="nama_cari" size="22" placeholder="[Nama Kas]" style="line-height:22px;border:1px solid #ccc;">
		<!-- <input name="akun" id="akun_cari" size="22" placeholder="[Akun]" style="line-height:22px;border:1px solid #ccc;"> -->
		<select id="aktif_cari" name="aktif" style="width:170px; height:27px" >
			<option value=""> -- Pilih Aktif --</option>			
			<option value="Y">Y</option>
			<option value="T">T</option>
		</select>

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
							<td> Nama Kas </td>
							<td>:</td>
							<td>
								<input id="nama" name="nama" style="width:190px; height:20px" >
							</td>	
						</tr>
						<tr style="height:35px">
							<td>Aktif</td>
							<td>:</td>
							<td>
								<select id="aktif" name="aktif" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0" selected disabled> -- Pilih Pemasukan --</option>
									<option value="Y">Y</option>
									<option value="T">T</option>
								</select>
							</td>
						</tr>
						<tr style="height:35px">
							<td>Simpanan</td>
							<td>:</td>
							<td>
								<select id="tmpl_simpan" name="tmpl_simpan" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0" selected disabled> -- Pilih Simpanan --</option>
									<option value="Y">Y</option>
									<option value="T">T</option>
								</select>
							</td>
						</tr>
						<tr style="height:35px">
							<td>Penarikan</td>
							<td>:</td>
							<td>
								<select id="tmpl_penarikan" name="tmpl_penarikan" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0" selected disabled> -- Pilih Penarikan --</option>
									<option value="Y">Y</option>
									<option value="T">T</option>
								</select>
							</td>
						</tr>
						<tr style="height:35px">
							<td>Pinjaman</td>
							<td>:</td>
							<td>
								<select id="tmpl_pinjaman" name="tmpl_pinjaman" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0" selected disabled> -- Pilih Pinjaman --</option>
									<option value="Y">Y</option>
									<option value="T">T</option>
								</select>
							</td>
						</tr>
						<tr style="height:35px">
							<td>Angsuran</td>
							<td>:</td>
							<td>
								<select id="tmpl_bayar" name="tmpl_bayar" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0" selected disabled> -- Pilih Angsuran --</option>
									<option value="Y">Y</option>
									<option value="T">T</option>
								</select>
							</td>
						</tr>
						<tr style="height:35px">
							<td>Pemasukan Kas</td>
							<td>:</td>
							<td>
								<select id="tmpl_pemasukan" name="tmpl_pemasukan" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0" selected disabled> -- Pilih Pemasukan Kas --</option>
									<option value="Y">Y</option>
									<option value="T">T</option>
								</select>
							</td>
						</tr>
						<tr style="height:35px">
							<td>Pengeluaran Kas</td>
							<td>:</td>
							<td>
								<select id="tmpl_pengeluaran" name="tmpl_pengeluaran" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0" selected disabled> -- Pilih Pengeluaran Kas --</option>
									<option value="Y">Y</option>
									<option value="T">T</option>
								</select>
							</td>
						</tr>
						<tr style="height:35px">
							<td>Transfer Kas</td>
							<td>:</td>
							<td>
								<select id="tmpl_transfer" name="tmpl_transfer" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0" selected disabled> -- Pilih Transfer Kas --</option>
									<option value="Y">Y</option>
									<option value="T">T</option>
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
		nama: $('#nama_cari').val(),
		aktif: $('#aktif_cari').val(),
	});
}

function clearSearch(){
	location.reload();
}

function create(){
	$('#dialog-form').dialog('open').dialog('setTitle','Tambah Data');
	$('#form').form('clear');

	url = '<?php echo site_url('jenis_kas/create'); ?>';
}

function save() {
	var string = $("#form").serialize();
	//validasi teks kosong
	var nama = $("#nama").val();
	if(nama == 0) {
		$.messager.show({
			title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data Nama Kosong.</div>',
			timeout:2000,
			showType:'slide'
		});
		$("#nama").focus();
		return false;
	}
	var aktif = $("#aktif").val();
	if(aktif == 0) {
		$.messager.show({
			title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, data aktif Kosong !.</div>',
			timeout:2000,
			showType:'slide'
		});
		$("#aktif").focus();
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
		url = '<?php echo site_url('jenis_kas/update'); ?>/' + row.id;
		
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
		$.messager.confirm('Konfirmasi','Apakah Anda akan menghapus data Nama Kas : <code>' + row.nama + '</code> ?',function(r){  
			if (r){  
				$.ajax({
					type	: "POST",
					url		: "<?php echo site_url('jenis_kas/delete'); ?>",
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
	var nama = $('#nama_cari').val()
	var aktif = $('#aktif_cari').val()
	
	var win = window.open('<?php echo site_url("jenis_kas/cetak_laporan/?nama=' + nama + '&aktif=' + aktif + '"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}
}
</script>