<div class="pull-right" style="vertical-align: middle;">
	<div id="filter_tgl" class="input-group" style="display: inline;">
		<button class="btn btn-default" id="daterange-btn" style="line-height:16px;border:1px solid #ccc">
			<i class="fa fa-calendar"></i> <span id="reportrange"><span> Tanggal</span></span>
			<i class="fa fa-caret-down"></i>
		</button>
	</div>
	<select id="cari_simpanan" name="cari_simpanan" style="width:170px; height:27px" >
		<option value=""> -- Tampilkan Akun --</option>			
		<?php	
		foreach ($jenis_id as $row) {
			echo '<option value="'.$row->id.'">'.$row->jns_simpan.'</option>';
		}
		?>
	</select>
	<span>Cari :</span>
	<input name="kode_transaksi" id="kode_transaksi" size="22" placeholder="[Kode Transaksi]" style="line-height:22px;border:1px solid #ccc;">
	<input name="cari_nama" id="cari_nama" size="22" placeholder="[Nama Anggota]" style="line-height:22px;border:1px solid #ccc; width:145px;">

	<a href="javascript:void(0);" id="btn_filter" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Cari</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak()">Cetak Laporan</a>
	<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Hapus Filter</a>
</div>
		
<script>
	function doSearch(){
		console.log('doSearch')
	}
	function cetak(){
		console.log('cetak')
	}
	function clearSearch(){
		console.log('clearSearch')
	}
</script>