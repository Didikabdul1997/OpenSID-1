
<div class="content-wrapper">
	<section class="content-header">
		<h1>Pengelolaan Data Persil <?=ucwords($this->setting->sebutan_desa)?> <?= $desa["nama_desa"];?></h1>
		<ol class="breadcrumb">
			<li><a href="<?=site_url('hom_sid')?>"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?=site_url('data_persil/clear')?>"> Daftar Persil</a></li>
			<li class="active">Pengelolaan Data Persil</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<div class="row">
			<div class="col-md-3">
				<?php $this->load->view('data_persil/menu_kiri.php')?>
			</div>
			<div class="col-md-9">
				<div class="box box-info">
					<div class="box-body">
						<div class="box-header with-border">
							<a href="<?= site_url('data_persil/clear')?>" class="btn btn-social btn-flat btn-primary btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Kembali Ke Daftar Persil"><i class="fa fa-arrow-circle-o-left"></i> Kembali Ke Daftar Persil</a>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<form action="" id="main" name="main" method="POST" class="form-horizontal">
									<div class="box-body">
										<div class="form-group">
											<label class="col-sm-3 control-label" >Cari Nama Pemilik 1</label>
											<div class="col-sm-8">
												<select class="form-control input-sm select2" style="width: 100%;" id="nik" name="nik" onchange="$('#'+'main').submit();">
													<option value>-- Silakan Masukan NIK / Nama --</option>
													<?php foreach ($penduduk as $item): ?>
														<option value="<?= $item['id']?>" <?php selected($pemilik['nik'], $item['id'])?>>Nama : <?= $item['nama']." Alamat : ".$item['info']?></option>
													<?php endforeach;?>
												</select>
											</div>
										</div>
										<?php if ($pemilik): ?>
											<div class="form-group">
												<label for="nama" class="col-sm-3 control-label">Pemilik</label>
												<div class="col-sm-8">
													<div class="form-group">
														<label class="col-sm-3 control-label">Nama Penduduk</label>
														<div class="col-sm-9">
															<input  class="form-control input-sm" type="text" placeholder="Nama Pemilik" value="<?= $pemilik["nama"] ?>" disabled >
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">NIK Pemilik</label>
														<div class="col-sm-9">
															<input  class="form-control input-sm" type="text" placeholder="NIK Pemilik" value="<?= $pemilik["nik"] ?>" disabled >
														</div>
													</div>
													<div class="form-group">
														<label for="alamat"  class="col-sm-3 control-label">Alamat Pemilik</label>
														<div class="col-sm-9">
															<textarea  class="form-control input-sm" placeholder="Alamat Pemilik" disabled><?= "RT ".$pemilik["rt"]." / RT ".$pemilik["rw"]." - ".strtoupper($pemilik["dusun"]) ?></textarea>
														</div>
													</div>
												</div>
											</div>
										<?php endif; ?>
									</div>
								</form>
								<form name='mainform' action="<?= site_url('cdesa/simpan_cdesa')?>" method="POST"  id="validasi" class="form-horizontal">
									<div class="box-body">
										<input name="jenis_pemilik" type="hidden" value="1">
										<input type="hidden" name="nik_lama" value="<?= $pemilik["nik_lama"] ?>"/>
										<input type="hidden" name="nik" value="<?= $pemilik["nik"] ?>"/>
										<input type="hidden" name="id_pend" value="<?= $pemilik["id"] ?>"/>
										<?php if ($cdesa): ?>
											<input type="hidden" name="id" value="<?= $cdesa["id"] ?>"/>
										<?php endif; ?>
										<input type="hidden" name="c_desa" value="<?= $cdesa["c_desa"] ?>"/>
										<div class="form-group">
											<label for="c_desa"  class="col-sm-3 control-label">Nomor C-DESA</label>
											<div class="col-sm-8">
												<input class="form-control input-sm angka required" type="text" placeholder="Nomor Surat C-DESA" name="c_desa" value="<?= ($cdesa["nomor"])?>" <?php !$pemilik and print('disabled') ?>>
											</div>
										</div>
										<div class="form-group">
											<label for="nama_kepemilikan"  class="col-sm-3 control-label">Nama Kepemilikan</label>
											<div class="col-sm-8">
												<input class="form-control input-sm nama required" type="text" placeholder="Nama pemilik di Surat C-DESA" name="nama_kepemilikan" value="<?= ($cdesa["nama_kepemilikan"])?sprintf("%04s", $cdesa["nama_kepemilikan"]): NULL ?>" <?php !$pemilik and print('disabled') ?>>
											</div>
										</div>
									</div>
									<div class="box-footer">
										<div class="col-xs-12">
											<button type="reset" class="btn btn-social btn-flat btn-danger btn-sm"><i class="fa fa-times"></i> Batal</button>
											<button type="submit" class="btn btn-social btn-flat btn-info btn-sm pull-right"><i class="fa fa-check"></i> Simpan</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<script>
	$(document).ready(function(){
		$('#tipe').change(function(){ 
			var id=$(this).val();
			$.ajax({
				url : "<?=site_url('data_persil/kelasid')?>",
				method : "POST",
				data : {id: id},
				async : true,
				dataType : 'json',
				success: function(data){
					var html = '';
					var i;
					for(i=0; i<data.length; i++){
						html += '<option value='+data[i].id+'>'+data[i].kode+' '+data[i].ndesc+'</option>';
					}
					$('#kelas').html(html);
				}
			});
			return false;
		}); 
	});

	function pilih_lokasi(pilih)
	{
		if (pilih == 1)
		{
			$("#manual").hide();
			$("#pilih").show();
		}
		else
		{
			$("#manual").removeClass('hidden');
			$("#manual").show();
			$("#pilih").hide();
		}
	}
</script>

