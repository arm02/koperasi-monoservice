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
url="<?php echo site_url('jenis_akun/ajax_list'); ?>" 
pagination="true" rownumbers="true" 
fitColumns="true" singleSelect="true" collapsible="true"
sortName="jns_trans" sortOrder="desc"
toolbar="#tb"
striped="true">
<thead>
	<tr>
		<th data-options="field:'id', sortable:'true',halign:'center', align:'center'" hidden="true">ID</th>
		<th data-options="field:'kd_aktiva', width:'17', halign:'center', align:'center'">KD Aktivita</th>
		<th data-options="field:'jns_trans',halign:'center', align:'center', width:'25'">Jenis Transaksi</th>
		<th data-options="field:'akun', width:'25', halign:'center', align:'center'">Akun</th>
		<th data-options="field:'pemasukan', width:'25', halign:'center', align:'center'">Pemasukan</th>
		<th data-options="field:'pengeluaran', width:'25', halign:'center', align:'center'">Pengeluaran</th>
		<th data-options="field:'aktif', width:'25', halign:'center', align:'center'">Aktif</th>
		<th data-options="field:'laba_rugi', width:'25', halign:'center', align:'center'">Laba Rugi</th>
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
		<input name="jns_trans" id="jns_trans_cari" size="22" placeholder="[Jenis Transaksi]" style="line-height:22px;border:1px solid #ccc;">
		<!-- <input name="akun" id="akun_cari" size="22" placeholder="[Akun]" style="line-height:22px;border:1px solid #ccc;"> -->
		<select id="akun_cari" name="akun" style="width:170px; height:27px" >
			<option value=""> -- Pilih Akun --</option>			
			<option value="Pasiva">Pasiva</option>
			<option value="Aktiva">Aktiva</option>
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
							<td> KD Aktiva</td>
							<td>:</td>
							<td>
								<input id="kd_aktiva" name="kd_aktiva" style="width:190px; height:20px" >
							</td>	
						</tr>
						<tr style="height:35px">
							<td> Jenis Transaksi</td>
							<td>:</td>
							<td>
								<input id="jns_trans" name="jns_trans" style="width:190px; height:20px" >
							</td>	
						</tr>
						<tr style="height:35px">
							<td> Akun </td>
							<td>:</td>
							<td>
								<select id="akun" name="akun" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0" selected disabled> -- Pilih Akun --</option>
									<option value="Aktiva">Aktiva</option>
									<option value="Pasiva">Pasiva</option>
								</select>
							</td>
						</tr>
						<tr style="height:35px">
							<td>Pemasukan</td>
							<td>:</td>
							<td>
								<select id="pemasukan" name="pemasukan" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0" selected disabled> -- Pilih Pemasukan --</option>
									<option value="Y">Y</option>
									<option value="N">N</option>
								</select>
							</td>
						</tr>
						<tr style="height:35px">
							<td>Pengeluaran</td>
							<td>:</td>
							<td>
								<select id="pengeluaran" name="pengeluaran" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0" selected disabled> -- Pilih Pengeluaran --</option>
									<option value="Y">Y</option>
									<option value="N">N</option>
								</select>
							</td>
						</tr>
						<tr style="height:35px">
							<td>Aktif</td>
							<td>:</td>
							<td>
								<select id="aktif" name="aktif" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0" selected disabled> -- Pilih Aktif --</option>
									<option value="Y">Y</option>
									<option value="N">N</option>
								</select>
							</td>
						</tr>
						<tr style="height:35px">
							<td> Laba Rugi </td>
							<td>:</td>
							<td>
								<input id="laba_rugi" name="laba_rugi" style="width:190px; height:20px" >
								<select id="laba_rugi" name="laba_rugi" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0" selected disabled> -- Pilih Laba Rugi --</option>
									<option value="PENDAPATAN">PENDAPATAN</option>
									<option value="BIAYA">BIAYA</option>
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
		jns_trans: $('#jns_trans_cari').val(),
		akuns: $('#akun_cari').val(),
	});
}

function clearSearch(){
	location.reload();
}

function create(){
	$('#dialog-form').dialog('open').dialog('setTitle','Tambah Data');
	$('#form').form('clear');

	url = '<?php echo site_url('jenis_akun/create'); ?>';
}

function save() {
	var string = $("#form").serialize();
	//validasi teks kosong
	var jenis_id = $("#jns_trans").val();
	if(jenis_id == 0) {
		$.messager.show({
			title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data Jenis Transaksi Kosong.</div>',
			timeout:2000,
			showType:'slide'
		});
		$("#jns_trans").focus();
		return false;
	}
	var akun = $("#akun").val();
	if(akun == 0) {
		$.messager.show({
			title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, data Akun Kosong !.</div>',
			timeout:2000,
			showType:'slide'
		});
		$("#akun").focus();
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
		url = '<?php echo site_url('jenis_akun/update'); ?>/' + row.id;
		
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
		$.messager.confirm('Konfirmasi','Apakah Anda akan menghapus data kode transaksi : <code>' + row.jns_trans + '</code> ?',function(r){  
			if (r){  
				$.ajax({
					type	: "POST",
					url		: "<?php echo site_url('jenis_akun/delete'); ?>",
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
	var jns_trans 	= $('#jns_trans_cari').val();
	var akun 	= $('#akun_cari').val();
	
	var win = window.open('<?php echo site_url("jenis_akun/cetak_laporan/?jns_trans=' + jns_trans + '&akun=' + akun + '"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}
}
</script>