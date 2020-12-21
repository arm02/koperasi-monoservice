<!-- search form -->
<a href="<?php echo site_url();?>" class="logo">
			<!-- Add the class icon to your logo image or logo icon to add the margining -->
			 <div style="text-align:center;"><img height="52" src="<?php echo base_url().'assets/theme_admin/img/logo2.png'; ?>"></div>
		</a>
<!-- /.search form -->

<ul class="sidebar-menu">
<li class="<?php 
	 $menu_home_arr= array('home', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>home">
			<img height="20" src="<?php echo base_url().'assets/theme_admin/img/home.png'; ?>"> <span>Beranda</span>
		</a>
</li>

<!-- Menu Transaksi -->
<?php if($level != 'pinjaman') { ?>
<li  class="treeview <?php 
	 $menu_trans_arr= array('pemasukan_kas','pengeluaran_kas', 'transfer_kas', 'biaya_umum');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<img height="20" src="<?php echo base_url().'assets/theme_admin/img/transaksi.png'; ?>">
		<span>Transaksi Kas</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
		<li class="<?php if ($this->uri->segment(1) == 'pemasukan_kas') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>pemasukan_kas"> <i class="fa fa-folder-open-o"></i> Pemasukan </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'pengeluaran_kas') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>pengeluaran_kas"> <i class="fa fa-folder-open-o"></i> Pengeluaran </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'transfer_kas') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>transfer_kas"> <i class="fa fa-folder-open-o"></i> Transfer </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'biaya_umum') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>biaya_umum"> <i class="fa fa-folder-open-o"></i> Biaya Umum </a></li>
	</ul>
</li>
<?php } ?>

<?php if($level != 'pinjaman') { ?>
<!-- Menu Simpanan -->
<li  class="treeview <?php 
	 $menu_trans_arr= array('simpanan','penarikan');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<img height="20" src="<?php echo base_url().'assets/theme_admin/img/uang.png'; ?>">
		<span>Simpanan</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
		<li class="<?php if ($this->uri->segment(1) == 'simpanan') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>simpanan"> <i class="fa fa-folder-open-o"></i> Setoran Tunai </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'penarikan') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>penarikan"> <i class="fa fa-folder-open-o"></i> Penarikan Tunai</a></li>
	</ul>
</li>
<?php } ?>

<!-- menu pinjaman -->
<li  class="treeview <?php 
$menu_pinjam_arr= array('pengajuan','pinjaman','bayar','pelunasan', 'angsuran','angsuran_detail','angsuran_lunas');
if(in_array($this->uri->segment(1), $menu_pinjam_arr)) {echo "active";}?>">

<a href="#">
	<img height="20" src="<?php echo base_url().'assets/theme_admin/img/pinjam.png'; ?>">
	<span>Pinjaman</span>
	<i class="fa fa-angle-left pull-right"></i>
</a>
<ul class="treeview-menu">
	<li class="<?php if ($this->uri->segment(1) == 'pengajuan' || $this->uri->segment(1) == 'pengajuan'){ echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>pengajuan"> <i class="fa fa-folder-open-o"></i> Data Pengajuan </a></li>
	<?php if($level != 'pinjaman') { ?>
	<li class="<?php if ($this->uri->segment(1) == 'pinjaman' || $this->uri->segment(1) == 'angsuran_detail'){ echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>pinjaman"> <i class="fa fa-folder-open-o"></i> Data Pinjaman </a></li>  
	<li class="<?php if ($this->uri->segment(1) == 'bayar' || $this->uri->segment(1) == 'angsuran') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>bayar"> <i class="fa fa-folder-open-o"></i> Bayar Angsuran</a></li> 

	<li class="<?php if ($this->uri->segment(1) == 'pelunasan' || $this->uri->segment(1) == 'angsuran_lunas') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>pelunasan"> <i class="fa fa-folder-open-o"></i> Pinjaman Lunas </a></li>
	<?php } ?>
</ul>
</li>

<!-- laporan -->
<!-- <li  class="treeview <?php 
	 $menu_lap_arr= array('lap_anggota','lap_kas_anggota','lap_simpanan','lap_kas_pinjaman','lap_tempo','lap_macet','lap_trans_kas','lap_buku_besar','lap_neraca','lap_saldo','lap_laba','lap_shu','lap_summary_kas','lap_detail_setoran');
	 if(in_array($this->uri->segment(1), $menu_lap_arr)) {echo "active";}?>">


	<a href="#">
		<img height="20" src="<?php echo base_url().'assets/theme_admin/img/laporan.png'; ?>">
		<span>Laporan Lama</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
		<li  class="treeview <?php 
		 $menu_lap_arr= array('lap_anggota');
		 if(in_array($this->uri->segment(1), $menu_lap_arr)) {echo "active";}?>">
			<a href="#">
				<i class="fa fa-folder-open-o"></i>
				<span>Laporan Anggota</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
		 	<ul class="treeview-menu">
		 		<?php if($level != 'pinjaman') { ?>
					<li class="<?php if ($this->uri->segment(1) == 'lap_anggota') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_anggota"><i class="fa fa-folder-open-o"></i> Data Anggota </a></li>
				<?php } ?>
		 	</ul>
		</li>
		<li  class="treeview <?php 
		 $menu_lap_arr= array('lap_kas_anggota','lap_simpanan','lap_kas_pinjaman','lap_tempo','lap_macet','lap_trans_kas','lap_buku_besar','lap_neraca','lap_saldo','lap_laba','lap_shu','lap_summary_kas','lap_detail_setoran');
		 if(in_array($this->uri->segment(1), $menu_lap_arr)) {echo "active";}?>">
			<a href="#">
				<i class="fa fa-folder-open-o"></i>
				<span>Laporan Akutansi</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
		 	<ul class="treeview-menu">
		 		<li class="<?php if ($this->uri->segment(1) == 'lap_kas_anggota') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>lap_kas_anggota"> <i class="fa fa-folder-open-o"></i> Kas Anggota </a></li>
		 		<?php if($level != 'pinjaman') { ?>
					<li class="<?php if ($this->uri->segment(1) == 'lap_tempo') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_tempo"><i class="fa fa-folder-open-o"></i> Jatuh Tempo </a></li>

					<li class="<?php if ($this->uri->segment(1) == 'lap_macet') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_macet"><i class="fa fa-folder-open-o"></i> Kredit Macet</a></li> 

					<li class="<?php if ($this->uri->segment(1) == 'lap_trans_kas') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_trans_kas"><i class="fa fa-folder-open-o"></i> Transaksi Kas</a></li>
					
					<li class="<?php if ($this->uri->segment(1) == 'lap_buku_besar') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_buku_besar"><i class="fa fa-folder-open-o"></i> Buku Besar</a></li>

					<li class="<?php if ($this->uri->segment(1) == 'lap_neraca') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_neraca"><i class="fa fa-folder-open-o"></i> Neraca Saldo</a></li>

					<li class="<?php if ($this->uri->segment(1) == 'lap_simpanan') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>lap_simpanan"> <i class="fa fa-folder-open-o"></i> Kas Simpanan </a></li>

					<li class="<?php if ($this->uri->segment(1) == 'lap_kas_pinjaman') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>lap_kas_pinjaman"> <i class="fa fa-folder-open-o"></i> Kas Pinjaman </a></li>

					<li class="<?php if ($this->uri->segment(1) == 'lap_saldo') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_saldo"><i class="fa fa-folder-open-o"></i> Saldo Kas </a></li>

					<li class="<?php if ($this->uri->segment(1) == 'lap_laba') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_laba"><i class="fa fa-folder-open-o"></i> Laba Rugi </a></li>

					<li class="<?php if ($this->uri->segment(1) == 'lap_shu') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_shu"><i class="fa fa-folder-open-o"></i> SHU </a></li>

					<li class="<?php if ($this->uri->segment(1) == 'lap_summary_kas') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_summary_kas"><i class="fa fa-folder-open-o"></i> Summary Kas </a></li>

					<li class="<?php if ($this->uri->segment(1) == 'lap_detail_setoran') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_detail_setoran"><i class="fa fa-folder-open-o"></i> Detail Setoran </a></li>
				<?php } ?>
		 	</ul>
		</li>
	</ul>
</li> -->

<li  class="treeview <?php 
	 $menu_lap_arr= array(
	 	'Lapb_anggota_rekap_keseluruhan','lapb_anggota_rekap_simpanan_pokok', 'lapb_anggota_rekap_simpanan_wajib','Lapb_anggota_rekap_perbulan',
	 	'lapb_keuangan_tagihan','lapb_keuangan_pinjaman','lapb_keuangan_rugi_laba','lapb_keuangan_shu_pinjaman','lapb_keuangan_shu_pinjaman','lapb_keuangan_neraca','lapb_keuangan_penjelasan_neraca','lapb_keuangan_total_shu','lapb_keuangan_rekap_sukarela','lapb_keuangan_rekap_simpanan_total','lapb_keuangan_dana_cadangan',
	 	'lapb_koperasi_pinjaman_barang','lapb_koperasi_pinjaman_berjangka','lapb_koperasi_pinjaman_konsumtif','lapb_koperasi_pinjaman_perbulan','lapb_koperasi_piutang','lapb_koperasi_rekap_jasa_barang','lapb_koperasi_rekap_jasa_berjangka','lapb_koperasi_rekap_jasa_konsumtif','lapb_koperasi_tagihan_barang','lapb_koperasi_tagihan_berjangka','lapb_koperasi_tagihan_konsumtif'
	 );
	 if(in_array($this->uri->segment(1), $menu_lap_arr)) {echo "active";}?>">


	<a href="#">
		<img height="20" src="<?php echo base_url().'assets/theme_admin/img/laporan.png'; ?>">
		<span>Laporan</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
		<li  class="treeview <?php 
		 $menu_lap_arr= array('Lapb_anggota_rekap_keseluruhan','lapb_anggota_rekap_simpanan_pokok', 'lapb_anggota_rekap_simpanan_wajib','Lapb_anggota_rekap_perbulan');
		 if(in_array($this->uri->segment(1), $menu_lap_arr)) {echo "active";}?>">
			<a href="#">
				<i class="fa fa-folder-open-o"></i>
				<span>Laporan Anggota</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
		 	<ul class="treeview-menu">
				<li class="<?php if ($this->uri->segment(1) == 'Lapb_anggota_rekap_keseluruhan') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>Lapb_anggota_rekap_keseluruhan"><i class="fa fa-folder-open-o"></i> Rekap Keseluruhan </a></li>
				<li class="<?php if ($this->uri->segment(1) == 'lapb_anggota_rekap_simpanan_pokok') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lapb_anggota_rekap_simpanan_pokok"><i class="fa fa-folder-open-o"></i> Rekap Simpanan Pokok </a></li>
				<li class="<?php if ($this->uri->segment(1) == 'lapb_anggota_rekap_simpanan_wajib') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lapb_anggota_rekap_simpanan_wajib"><i class="fa fa-folder-open-o"></i> Rekap Simpanan Wajib </a></li>
				<li class="<?php if ($this->uri->segment(1) == 'Lapb_anggota_rekap_perbulan') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>Lapb_anggota_rekap_perbulan"><i class="fa fa-folder-open-o"></i> Rekap Perbulan </a></li>
		 	</ul>
		</li>
		<li  class="treeview <?php 
		 $menu_lap_arr= array('lapb_keuangan_tagihan','lapb_keuangan_pinjaman','lapb_keuangan_rugi_laba','lapb_keuangan_shu_pinjaman','lapb_keuangan_shu_pinjaman','lapb_keuangan_neraca','lapb_keuangan_penjelasan_neraca','lapb_keuangan_total_shu','lapb_keuangan_rekap_sukarela','lapb_keuangan_rekap_simpanan_total','lapb_keuangan_dana_cadangan');
		 if(in_array($this->uri->segment(1), $menu_lap_arr)) {echo "active";}?>">
			<a href="#">
				<i class="fa fa-folder-open-o"></i>
				<span>Laporan Keuangan</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
		 	<ul class="treeview-menu">
				<li class="<?php if ($this->uri->segment(1) == 'lapb_keuangan_tagihan') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lapb_keuangan_tagihan"><i class="fa fa-folder-open-o"></i> Tagihan </a></li>
				<li class="<?php if ($this->uri->segment(1) == 'lapb_keuangan_pinjaman') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lapb_keuangan_pinjaman"><i class="fa fa-folder-open-o"></i> Pinjaman </a></li>
				<li class="<?php if ($this->uri->segment(1) == 'lapb_keuangan_rugi_laba') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lapb_keuangan_rugi_laba"><i class="fa fa-folder-open-o"></i> Rugi Laba </a></li>
				<li class="<?php if ($this->uri->segment(1) == 'lapb_keuangan_shu_pinjaman') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lapb_keuangan_shu_pinjaman"><i class="fa fa-folder-open-o"></i> SHU Pinjaman </a></li>
				<li class="<?php if ($this->uri->segment(1) == 'lapb_keuangan_shu_simpanan') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lapb_keuangan_shu_simpanan"><i class="fa fa-folder-open-o"></i> SHU Simpanan </a></li>
				<li class="<?php if ($this->uri->segment(1) == 'lapb_keuangan_neraca') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lapb_keuangan_neraca"><i class="fa fa-folder-open-o"></i> Neraca </a></li>
				<li class="<?php if ($this->uri->segment(1) == 'lapb_keuangan_penjelasan_neraca') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lapb_keuangan_penjelasan_neraca"><i class="fa fa-folder-open-o"></i> Penjelasan Neraca </a></li>
				<li class="<?php if ($this->uri->segment(1) == 'lapb_keuangan_total_shu') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lapb_keuangan_total_shu"><i class="fa fa-folder-open-o"></i> Total SHU </a></li>
				<li class="<?php if ($this->uri->segment(1) == 'lapb_keuangan_rekap_sukarela') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lapb_keuangan_rekap_sukarela"><i class="fa fa-folder-open-o"></i> Rekap Sukarela </a></li>
				<li class="<?php if ($this->uri->segment(1) == 'lapb_keuangan_rekap_simpanan_total') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lapb_keuangan_rekap_simpanan_total"><i class="fa fa-folder-open-o"></i> Rekap Simpanan Total </a></li>
				<li class="<?php if ($this->uri->segment(1) == 'lapb_keuangan_dana_cadangan') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lapb_keuangan_dana_cadangan"><i class="fa fa-folder-open-o"></i> Dana Cadangan </a></li>

		 	</ul>
		</li>
		<li  class="treeview <?php 
		 $menu_lap_arr= array('lapb_koperasi_pinjaman_barang','lapb_koperasi_pinjaman_berjangka','lapb_koperasi_pinjaman_konsumtif','lapb_koperasi_pinjaman_perbulan','lapb_koperasi_piutang','lapb_koperasi_rekap_jasa_barang','lapb_koperasi_rekap_jasa_berjangka','lapb_koperasi_rekap_jasa_konsumtif','lapb_koperasi_tagihan_barang','lapb_koperasi_tagihan_berjangka','lapb_koperasi_tagihan_konsumtif');
		 if(in_array($this->uri->segment(1), $menu_lap_arr)) {echo "active";}?>">
			<a href="#">
				<i class="fa fa-folder-open-o"></i>
				<span>Laporan Koperasi</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
		 	<ul class="treeview-menu">
		 		<li class="<?php if ($this->uri->segment(1) == 'lapb_koperasi_pinjaman_barang') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>lapb_koperasi_pinjaman_barang"> <i class="fa fa-folder-open-o"></i> Pinjaman Barang </a></li>
		 		<li class="<?php if ($this->uri->segment(1) == 'lapb_koperasi_pinjaman_berjangka') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>lapb_koperasi_pinjaman_berjangka"> <i class="fa fa-folder-open-o"></i> Pinjaman Berjangka </a></li>
		 		<li class="<?php if ($this->uri->segment(1) == 'lapb_koperasi_pinjaman_konsumtif') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>lapb_koperasi_pinjaman_konsumtif"> <i class="fa fa-folder-open-o"></i> Pinjaman Konsumtif </a></li>
		 		<li class="<?php if ($this->uri->segment(1) == 'lapb_koperasi_pinjaman_perbulan') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>lapb_koperasi_pinjaman_perbulan"> <i class="fa fa-folder-open-o"></i> Pinjaman Perbulan </a></li>
		 		<li class="<?php if ($this->uri->segment(1) == 'lapb_koperasi_piutang') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>lapb_koperasi_piutang"> <i class="fa fa-folder-open-o"></i> Piutang </a></li>
		 		<li class="<?php if ($this->uri->segment(1) == 'lapb_koperasi_rekap_jasa_barang') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>lapb_koperasi_rekap_jasa_barang"> <i class="fa fa-folder-open-o"></i> Rekap Jasa Barang </a></li>
		 		<li class="<?php if ($this->uri->segment(1) == 'lapb_koperasi_rekap_jasa_berjangka') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>lapb_koperasi_rekap_jasa_berjangka"> <i class="fa fa-folder-open-o"></i> Rekap Jasa Berjangka </a></li>
		 		<li class="<?php if ($this->uri->segment(1) == 'lapb_koperasi_rekap_jasa_konsumtif') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>lapb_koperasi_rekap_jasa_konsumtif"> <i class="fa fa-folder-open-o"></i> Rekap Jasa Konsumtif </a></li>
		 		<li class="<?php if ($this->uri->segment(1) == 'lapb_koperasi_tagihan_barang') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>lapb_koperasi_tagihan_barang"> <i class="fa fa-folder-open-o"></i> Tagihan Barang </a></li>
		 		<li class="<?php if ($this->uri->segment(1) == 'lapb_koperasi_tagihan_berjangka') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>lapb_koperasi_tagihan_berjangka"> <i class="fa fa-folder-open-o"></i> Tagihan Berjangka </a></li>
		 		<li class="<?php if ($this->uri->segment(1) == 'lapb_koperasi_tagihan_konsumtif') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>lapb_koperasi_tagihan_konsumtif"> <i class="fa fa-folder-open-o"></i> Tagihan Konsumtif </a></li>
		 	</ul>
		</li>
	</ul>
</li>

<?php if($level != 'pinjaman') { ?>
<!-- Master data -->
<li  class="treeview <?php 
$menu_data_arr= array('jenis_simpanan','jenis_akun','jenis_kas','jenis_angsuran','jenis_pinjaman','anggota','user');
if(in_array($this->uri->segment(1), $menu_data_arr)) {echo "active";}?>">

<a href="#">
	<img height="20" src="<?php echo base_url().'assets/theme_admin/img/data.png'; ?>">
	<span>Master Data</span>
	<i class="fa fa-angle-left pull-right"></i>
</a>
<ul class="treeview-menu">
	<?php if($level == 'admin') { ?>
		<li class="<?php if ($this->uri->segment(1) == 'jenis_simpanan') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>jenis_simpanan"> <i class="fa fa-folder-open-o"></i> Jenis Simpanan </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'jenis_akun') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>jenis_akun"> <i class="fa fa-folder-open-o"></i> Jenis Akun </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'jenis_kas') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>jenis_kas"> <i class="fa fa-folder-open-o"></i> Data Kas </a></li>   

		<li class="<?php if ($this->uri->segment(1) == 'jenis_angsuran') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>jenis_angsuran"> <i class="fa fa-folder-open-o"></i> Lama Angsuran </a></li>
	<?php } ?>
	<li class="<?php if ($this->uri->segment(1) == 'jenis_pinjaman') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>jenis_pinjaman"> <i class="fa fa-folder-open-o"></i> Jenis Pinjaman </a></li>

	<li class="<?php if ($this->uri->segment(1) == 'anggota') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>anggota"> <i class="fa fa-folder-open-o"></i> Data Anggota</a></li>
	<?php if($level == 'admin') { ?>
		<li class="<?php if ($this->uri->segment(1) == 'user') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>user"> <i class="fa fa-folder-open-o"></i> Data Pengguna </a></li> 
	<?php } ?>
</ul>
</li>
<?php } ?>

<!-- MENU Setting -->
<?php if($level == 'admin') { ?>
<li  class="treeview <?php 
$menu_sett_arr= array('profil','suku_bunga','pembagian_shu_labarugi','setting_type_neraca','setting_neraca','backup','restore');
if(in_array($this->uri->segment(1), $menu_sett_arr)) {echo "active";}?>">

<a href="#">
	<img height="20" src="<?php echo base_url().'assets/theme_admin/img/settings.png'; ?>">
	<span>Setting</span>
	<i class="fa fa-angle-left pull-right"></i>
</a>

<ul class="treeview-menu">          
	<li class="<?php if ($this->uri->segment(1) == 'profil') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>profil"> <i class="fa fa-folder-open-o"></i> Identitas Koperasi </a></li>

	<li class="<?php if ($this->uri->segment(1) == 'suku_bunga') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>suku_bunga"> <i class="fa fa-folder-open-o"></i> Suku Bunga </a></li>

	<li class="<?php if ($this->uri->segment(1) == 'pembagian_shu_labarugi') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>pembagian_shu_labarugi"> <i class="fa fa-folder-open-o"></i> Pembagian SHU Laba Rugi </a></li>

	<li  class="treeview <?php 
	 $menu_lap_arr= array('setting_type_neraca','setting_neraca');
	 if(in_array($this->uri->segment(1), $menu_lap_arr)) {echo "active";}?>">
		<a href="#">
			<i class="fa fa-folder-open-o"></i>
			<span>Neraca</span>
			<i class="fa fa-angle-left pull-right"></i>
		</a>
	 	<ul class="treeview-menu">
			<li class="<?php if ($this->uri->segment(1) == 'setting_type_neraca') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>setting_type_neraca"><i class="fa fa-folder-open-o"></i> Type Neraca </a></li>
			<li class="<?php if ($this->uri->segment(1) == 'setting_neraca') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>setting_neraca"><i class="fa fa-folder-open-o"></i> Penjelasan Neraca </a></li>

	 	</ul>
	</li>

	<li class="<?php if ($this->uri->segment(1) == 'backup') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>backup"> <i class="fa fa-folder-open-o"></i> Backup Data </a></li>

	<li class="<?php if ($this->uri->segment(1) == 'restore') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>restore"> <i class="fa fa-folder-open-o"></i> Restore Data </a></li>
</ul>
</li>
<?php } ?>

</ul>