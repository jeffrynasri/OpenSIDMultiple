<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="card mb-2 has-background-img">
	<script>
		const KODE_KOTA = "<?= config_item('kode_kota') ?>";
		const TANGGAL = "<?= date('Y/m/d') ?>";
	</script>
	<section id="jadwal-shalat" class="py-0 bg-white">
		<div class="container mt-2 main-container">
			<div class="media border-bottom mb-0">
				<div class="media-body">
					<span class="font-weight-bold">
						<a href="https://www.natairaya.desa.id/kode" rel='noopener noreferrer' target='_blank' ><i class="material-icons icon arrow">brightness_4</i> JADWAL di <span data-name="kota">...</span></a>
					</span>
				</div>
			</div>
			<div class="row">
				<div class="card-body">
					<div class="content-color-secondary"><?= hr(date('Y-m-d'))?></div>
					<div class="row">
						<div class="col-4 px-2 py-1">
							<div class="square shalat shimmer" data-name="imsak"></div>
						</div>
						<div class="col-4 px-2 py-1">
							<div class="square shalat shimmer" data-name="subuh"></div>
						</div>
						<div class="col-4 px-2 py-1">
							<div class="square shalat shimmer" data-name="dzuhur"></div>
						</div>
						<div class="col-4 px-2 py-1">
							<div class="square shalat shimmer" data-name="ashar"></div>
						</div>
						<div class="col-4 px-2 py-1">
							<div class="square shalat shimmer" data-name="maghrib"></div>
						</div>
						<div class="col-4 px-2 py-1">
							<div class="square shalat shimmer" data-name="isya"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
