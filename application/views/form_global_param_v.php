<div class="row">
	<div class="col-md-12">
		<div class="box box-solid box-primary">
			<div class="box-header">
				<h3 class="box-title">Biaya dan Administrasi</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<?php if ($tersimpan == 'Y') { ?>
					<div class="box-body">
						<div class="alert alert-success alert-dismissable">
                <i class="fa fa-check"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                Data berhasil disimpan.
            </div>
					</div>
				<?php } ?>

				<?php if ($tersimpan == 'N') { ?>
					<div class="box-body">
						<div class="alert alert-danger alert-dismissable">
                <i class="fa fa-warning"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                Data tidak berhasil disimpan, silahkan ulangi beberapa saat lagi.
            </div>
					</div>
				<?php } ?>
		<div class="form-group">
		<?php 
    echo form_open('');
    echo '
			<table width="80%">
			<tr> 
			  <td>';
		// tipe bunga
    $options = array(
      'A' => 'A: Persen Bunga dikali angsuran bln',
      'B' => 'B: Persen Bunga dikali total pinjaman'
			//'C'  => 'C: Bunga Menurun = Persen Bunga dikali sisa pinjaman'
    );
    echo form_label('Tipe Pinjaman Bunga', 'pinjaman_bunga_tipe');
    echo form_dropdown('pinjaman_bunga_tipe', $options, $pinjaman_bunga_tipe, 'id="pinjaman_bunga_tipe" class="form-control"');
    echo '
				</td>
				<td>';
		//dana anggota usaha 
    $data = array(
      'name' => 'dana_cadangan',
      'id' => 'dana_cadangan',
      'class' => 'form-control',
      'value' => $dana_cadangan,
      'maxlength' => '255',
      'style' => 'width: 50%'
    );
    echo form_label('Dana Cadangan (%)', 'dana_cadangan');
    echo form_input($data);
    echo '
				</td>
			</tr>';
    echo '
			<tr>
				<td>';
		//bunga pinjman
    $data = array(
      'name' => 'bg_pinjam',
      'id' => 'bg_pinjam',
      'class' => 'form-control',
      'value' => $bg_pinjam,
      'maxlength' => '255',
      'style' => 'width: 50%'
    );
    echo form_label('Suku Bunga Pinjaman (%)', 'bg_pinjam');
    echo form_input($data);
    echo '
				</td>
				<td>';
		//dana anggota modal 
    $data = array(
      'name' => 'bagian_anggota',
      'id' => 'bagian_anggota',
      'class' => 'form-control',
      'value' => $bagian_anggota,
      'maxlength' => '255',
      'style' => 'width: 50%'
    );
    echo form_label('Bagian Anggota (%)', 'bagian_anggota');
    echo form_input($data);
    echo '
				</td>
			</tr>';
    echo '
			<tr>
				<td>';
    //biaya admin
    $data = array(
      'name' => 'biaya_adm',
      'id' => 'biaya_adm',
      'class' => 'form-control',
      'value' => $biaya_adm,
      'maxlength' => '255',
      'style' => 'width: 50%'
    );
    echo form_label('Biaya Administrasi (Rp)', 'biaya_adm');
    echo form_input($data);
    echo '
				</td>
				<td>';			
		//dana pengurus 
    $data = array(
      'name' => 'dana_pengurus',
      'id' => 'dana_pengurus',
      'class' => 'form-control',
      'value' => $dana_pengurus,
      'maxlength' => '255',
      'style' => 'width: 50%'
    );
    echo form_label('Dana Pengurus (%)', 'dana_pengurus');
    echo form_input($data);
    echo '
				</td>
			</tr>';
    echo '
			<tr>
				<td>';
    //biaya denda
    $data = array(
      'name' => 'denda',
      'id' => 'denda',
      'class' => 'form-control',
      'value' => $denda,
      'maxlength' => '255',
      'style' => 'width: 50%'
    );
    echo form_label('Biaya Denda (Rp)', 'denda');
    echo form_input($data);
    echo '
				</td>
        <td>';
    //dana kesejahteraan karyawan 
    $data = array(
      'name' => 'dana_pendidikan',
      'id' => 'dana_pendidikan',
      'class' => 'form-control',
      'value' => $dana_pendidikan,
      'maxlength' => '255',
      'style' => 'width: 50%'
    );
    echo form_label('Dana Pendidikan (%)', 'dana_pendidikan');
    echo form_input($data);
    echo '
				</td>
			</tr>';
    echo '
      <tr>
        <td>';
    //jumlah denda hari
    $data = array(
      'name' => 'denda_hari',
      'id' => 'denda_hari',
      'class' => 'form-control',
      'value' => $denda_hari,
      'maxlength' => '25',
      'style' => 'width: 50%'
    );
    echo form_label('Tempo Tanggal Pembayaran', 'denda_hari');
    echo form_input($data);
    echo '
				</td>
				<td>';
		//dana pembangunan daerah kerja
    $data = array(
      'name' => 'dana_pembangunan',
      'id' => 'dana_pembangunan',
      'class' => 'form-control',
      'value' => $dana_pembangunan,
      'maxlength' => '25',
      'style' => 'width: 50%'
    );
    echo form_label('Dana Pembangunan (%)', 'dana_pembangunan');
    echo form_input($data);
    echo '
				</td>
			</tr>';
    echo '
      <tr>
        <td>';
    //pjk pph 
    $data = array(
      'name' => 'pjk_pph',
      'id' => 'pjk_pph',
      'class' => 'form-control',
      'value' => $pjk_pph,
      'maxlength' => '255',
      'style' => 'width: 50%'
    );
    echo form_label('Pajak PPh (%)', 'pjk_pph');
    echo form_input($data);
    echo '
        </td>
				<td>';
		//dana pendidikan
    $data = array(
      'name' => 'dana_sosial',
      'id' => 'dana_sosial',
      'class' => 'form-control',
      'value' => $dana_sosial,
      'maxlength' => '25',
      'style' => 'width: 50%'
    );
    echo form_label('Dana Sosial (%)', 'dana_sosial');
    echo form_input($data);
    echo '
				</td>
			</tr>';
    echo '
      <tr>
        <td></td>
				<td>';
    //dana sosial 
    $data = array(
      'name' => 'simpanan_anggota',
      'id' => 'simpanan_anggota',
      'class' => 'form-control',
      'value' => $simpanan_anggota,
      'maxlength' => '255',
      'style' => 'width: 50%'
    );
    echo form_label('Dana Simpanan Anggota (%)', 'simpanan_anggota');
    echo form_input($data);
    echo '
				</td>
      </tr>';
    echo '
      <tr>
        <td></td>
        <td>';
		//dana cadangan 
    $data = array(
      'name' => 'pinjaman_anggota',
      'id' => 'pinjaman_anggota',
      'class' => 'form-control',
      'value' => $pinjaman_anggota,
      'maxlength' => '255',
      'style' => 'width: 50%'
    );
    echo form_label('Dana Pinjaman Anggota (%)', 'pinjaman_anggota');
    echo form_input($data);
    echo '    
        </td>
      </tr>
		</table>';
		// submit
    $data = array(
      'name' => 'submit',
      'id' => 'submit',
      'class' => 'btn btn-primary',
      'value' => 'true',
      'type' => 'submit',
      'content' => 'Update',
      'style' =>'margin-bottom:20px'
    );
    echo '<br>';
    echo form_button($data);
    echo form_close();
    ?>
				</div>
			</div><!-- /.box-body -->
		</div>
	</div>
</div>