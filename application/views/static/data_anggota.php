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
title="Data Anggota" 
style="width:auto; height: auto;" 
url="<?php echo site_url('anggota/ajax_list'); ?>" 
pagination="true" rownumbers="true" 
fitColumns="true" singleSelect="true" collapsible="true"
sortName="nama" sortOrder="desc"
toolbar="#tb"
striped="true">
<thead>
	<tr>
		<th data-options="field:'id', sortable:'true',halign:'center', align:'center'" hidden="true">ID</th>
		<th data-options="field:'id_anggota', sortable:'true',halign:'center', align:'center'" hidden="true">ID Anggota</th>
		<th data-options="field:'file_pic_html',halign:'center', align:'center', width:'25'">Photo</th>
		<th data-options="field:'nama', width:'17', halign:'center', align:'center'">Nama</th>
		<th data-options="field:'identitas', width:'17', halign:'center', align:'center'">Identitas</th>
		<th data-options="field:'jk', width:'17', halign:'center', align:'center'">Jenis Kelamin</th>
		<th data-options="field:'tmp_lahir', width:'17', halign:'center', align:'center'">Tempat Lahir</th>
		<th data-options="field:'tgl_lahir', width:'17', halign:'center', align:'center'">Tanggal Lahir</th>
		<th data-options="field:'status', width:'17', halign:'center', align:'center'">Status</th>
		<th data-options="field:'agama', width:'17', halign:'center', align:'center'">Agama</th>
		<th data-options="field:'departement', width:'17', halign:'center', align:'center'">Departement</th>
		<th data-options="field:'pekerjaan', width:'17', halign:'center', align:'center'">Pekerjaan</th>
		<th data-options="field:'alamat', width:'17', halign:'center', align:'center'">Alamat</th>
		<th data-options="field:'kota', width:'17', halign:'center', align:'center'">Kota</th>
		<th data-options="field:'notelp', width:'17', halign:'center', align:'center'">No Telp</th>
		<th data-options="field:'tgl_daftar', width:'17', halign:'center', align:'center'">Tanggal Daftar</th>
		<th data-options="field:'jabatan_id', width:'17', halign:'center', align:'center'">Jabatan</th>
		<th data-options="field:'aktif',halign:'center', align:'center', width:'25'">Aktif</th>
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
		<input name="nama" id="nama_cari" size="22" placeholder="[Nama]" style="line-height:22px;border:1px solid #ccc;">
		<select id="aktif_cari" name="aktif" style="width:170px; height:27px" >
			<option value=""> -- Pilih Aktif --</option>			
			<option value="Y">Y</option>
			<option value="N">N</option>
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
							<td> Nama Lengkap </td>
							<td>:</td>
							<td>
								<input id="nama" name="nama" style="width:190px; height:20px" >
							</td>	
						</tr>
						<tr style="height:35px">
							<td> Identitas </td>
							<td>:</td>
							<td>
								<input id="identitas" name="identitas" style="width:190px; height:20px" >
							</td>	
						</tr>
						<tr style="height:35px">
							<td> Jenis Kelamin </td>
							<td>:</td>
							<td>
								<select id="jk" name="jk" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0" selected disabled> -- Pilih Jenis Kelamin --</option>
									<option value="L">Laki Laki</option>
									<option value="P">Perempuan</option>
								</select>
							</td>
						</tr>
						<tr style="height:35px">
							<td> Tempat Lahir </td>
							<td>:</td>
							<td>
								<input id="tmp_lahir" name="tmp_lahir" style="width:190px; height:20px" >
							</td>	
						</tr>
						<tr style="height:35px">
							<td> Tanggal Lahir </td>
							<td>:</td>
							<td>
								<input type="date" id="tgl_lahir" name="tgl_lahir" style="width:190px; height:20px" >
							</td>	
						</tr>
						<tr style="height:35px">
							<td> Status </td>
							<td>:</td>
							<td>
								<select id="status" name="status" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0" selected disabled> -- Pilih Status --</option>
									<option value="Kawin">Kawin</option>
									<option value="Cerai Hidup">Cerai Hidup</option>
									<option value="Cerai Mati">Cerai Mati</option>
									<option value="Lainnya">Lainnya</option>
								</select>
							</td>
						</tr>
						<tr style="height:35px">
							<td> Departement </td>
							<td>:</td>
							<td>
								<select id="departement" name="departement" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0" selected disabled> -- Pilih Departement --</option>
									<option value="Produksi BOPP">Produksi BOPP</option>
									<option value="Produksi Slitting">Produksi Slitting</option>
									<option value="WH">WH</option>
									<option value="QA">QA</option>
									<option value="HRD">HRD</option>
									<option value="GA">GA</option>
									<option value="Purchasing">Purchasing</option>
									<option value="Accounting">Accounting</option>
									<option value="Engineering">Engineering</option>
								</select>
							</td>
						</tr>
						<tr style="height:35px">
							<td> Pekerjaan </td>
							<td>:</td>
							<td>
								<select id="pekerjaan" name="pekerjaan" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0" selected disabled> -- Pilih Pekerjaan --</option>
									<option value="TNI">TNI</option>
									<option value="PNS">PNS</option>
									<option value="Karyawwan Swasta">Karyawwan Swasta</option>
									<option value="Guru">Guru</option>
									<option value="Buruh">Buruh</option>
									<option value="Tani">Tani</option>
									<option value="Pedagang">Pedagang</option>
									<option value="Wiraswasta">Wiraswasta</option>
									<option value="Mengurus Rumah Tangga">Mengurus Rumah Tangga</option>
									<option value="Pensiunan">Pensiunan</option>
									<option value="Penjahit">Penjahit</option>
									<option value="Lainnya">Lainnya</option>
								</select>
							</td>
						</tr>
						<tr style="height:35px">
							<td> Agama </td>
							<td>:</td>
							<td>
								<select id="agama" name="agama" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0" selected disabled> -- Pilih Agama --</option>
									<option value="Islam">Islam</option>
									<option value="Khatolik">Khatolik</option>
									<option value="Protestan">Protestan</option>
									<option value="Hindu">Hindu</option>
									<option value="Buddha">Buddha</option>
									<option value="Lainnya">Lainnya</option>
								</select>
							</td>
						</tr>
						<tr style="height:35px">
							<td> Alamat </td>
							<td>:</td>
							<td>
								<textarea id="alamat" nama="alamat" style="width:195px; height:25px"></textarea>
							</td>
						</tr>
						<tr style="height:35px">
							<td> Kota </td>
							<td>:</td>
							<td>
								<input id="kota" name="kota" style="width:190px; height:20px" >
							</td>	
						</tr>
						<tr style="height:35px">
							<td> No Telepon / HP </td>
							<td>:</td>
							<td>
								<input type="number" id="notelp" name="notelp" style="width:190px; height:20px" >
							</td>	
						</tr>
						<tr style="height:35px">
							<td> Tanggal Registrasi </td>
							<td>:</td>
							<td>
								<input type="date" id="tgl_daftar" name="tgl_daftar" style="width:190px; height:20px" >
							</td>	
						</tr>
						<tr style="height:35px">
							<td> Jabatan </td>
							<td>:</td>
							<td>
								<select id="jabatan" name="jabatan" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0" selected disabled> -- Pilih Jabatan --</option>
									<option value="1">Anggota</option>
									<option value="2">Pengurus</option>
								</select>
							</td>
						</tr>
						<tr style="height:35px">
							<td> Password </td>
							<td>:</td>
							<td>
								<input type="password" id="pass_word" name="pass_word" style="width:190px; height:20px" ><br>
								Kosongkan Password Jika tidak ingin diganti
							</td>
						</tr>
						<tr style="height:35px">
							<td>Aktif</td>
							<td>:</td>
							<td>
								<select id="aktif" name="aktif" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0" selected disabled> -- Pilih Aktif --</option>
									<option value="Y">Aktif</option>
									<option value="N">Tidak Aktif</option>
								</select>
							</td>
						</tr>
						<tr style="height:35px">
							<td> Photo </td>
							<td>:</td>
							<td>
								<input type="file" id="file_pic" name="file_pic" style="width:190px; height:20px" >
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

	url = '<?php echo site_url('anggota/create'); ?>';
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
	var data = row
	var aktif = 0
	delete data.file_pic_html
	switch(row.aktif) {
	  case 'Aktif':
	    aktif = "Y"
	    break;
	  case 'Tidak Aktif':
	    aktif = "Y"
	    break;
	}
	var jabatan = 0
	switch(row.jabatan_id) {
	  case 'Anggota':
	    jabatan = 1
	    break;
	  case 'Pengurus':
	    jabatan = 2
	    break;
	}
	data.jabatan_id = jabatan
	if(row){
		jQuery('#dialog-form').dialog('open').dialog('setTitle','Edit Data Setoran');
		jQuery('#form').form('load',row);
		url = '<?php echo site_url('anggota/update'); ?>/' + row.id;
		
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
		$.messager.confirm('Konfirmasi','Apakah Anda akan menghapus data Nama : <code>' + row.nama + '</code> ?',function(r){  
			if (r){  
				$.ajax({
					type	: "POST",
					url		: "<?php echo site_url('anggota/delete'); ?>",
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
	
	var win = window.open('<?php echo site_url("anggota/cetak_laporan/?nama=' + nama + '&aktif=' + aktif + '"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}
}
</script>