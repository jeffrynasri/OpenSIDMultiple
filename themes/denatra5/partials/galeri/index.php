<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="card mb-2 fullscreen has-background-img ">
	<div class="card-header border-bottom">
		<div class="media">
			<div class="icon-circle icon-40 bg-light-primary mr-3">
				<i class="material-icons icon-sm">insert_photo</i>
			</div>
			<div class="media-body">
				<h6 class="my-0 content-color-primary">Album Galeri</h6>
				<p class="small mb-0"><i class="material-icons icon-sm">date_range</i> <?= ucwords($this->setting->sebutan_desa)." ".$desa['nama_desa']?></p>
			</div>
		</div>
	</div>
	<div class="card-body">
		<?php if ($gallery): ?>
		<div class="container main-container mb-2">
			<div class="row">
			<?php $i = 1 ?>
			<?php foreach($gallery as $data) : ?>
			<div class="col-12 col-lg-6 col-md-6">
				<div class="card entry text-center mb-2">
					<a data-fancybox="gallery" href="<?= AmbilGaleri($data['gambar'], 'sedang') ?>" title="Album : <?= $data['nama'] ?>">
						<img class="mw-100 border" height="200" loading="lazy" src="<?= is_file(LOKASI_GALERI."sedang_{$data['gambar']}") == TRUE ? base_url() . LOKASI_GALERI."sedang_{$data['gambar']}" : base_url("$this->theme_folder/$this->theme/assets/image/noimage.png") ?>">
					</a>
					<a class="btn btn-sm btn-purple pink-gradient" href="<?= site_url("first/sub_gallery/{$data['id']}") ?>" title="Album : <?= $data['nama'] ?>">Lihat Album</a>
				</div>
			</div>
			<div class="<?php fmod($i, 2) == 0 and print('clearboth') ?>"></div>
			<?php $i++ ?>
			<?php endforeach ?>
			</div>
		</div>
		<?php $data['paging_page'] = 'first/gallery'; ?>
		<?php $this->load->view("$folder_themes/commons/paging", $data); ?>
		<?php else: ?>
		<div class="font-weight-bold text-center mt-4 mb-4">
			<h5>Album galeri belum tersedia.</h5>
		</div>
		<?php endif; ?>
	</div>
</div>
