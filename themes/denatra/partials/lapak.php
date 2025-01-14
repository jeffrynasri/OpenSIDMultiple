<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
.map {
  width:100%;
  height:70vh;
}
#qrcode .panel-body-lg {
  margin-right: 5px;
  margin-bottom: 20px;
  pointer-events: visiblePainted;
	pointer-events: auto;
  position: relative;
  z-index: 800;
}
.leaflet-popup-content {
  height: auto;
  width: 225px;
  overflow-y: scroll;
}
</style>
<div class="mt-0 mb-0 z-index-2">
    <div class="card-header pink-gradient font-weight-bold text-center">
        Lapak Online <?= ucwords($this->setting->sebutan_desa); ?>
    </div>
    <div class="card mb-0 fullscreen has-background-img">
        <div class="container-fluid">
			<?php if ($produk): ?>
			<div class="row">
				<?php shuffle($produk); foreach ($produk as $in => $pro): ?>
				<?php $foto = json_decode($pro->foto); ?>
				<div class="col-12 col-lg-3 col-md-3 order-2 order-md-1">
					<div class="card mb-2 mt-2">
						<div class="card-header border-bottom">
							<div class="media">
								<div class="media-body">
									<h4 class="mb-0 header-color-primary"><?= $pro->nama; ?></h4>
								</div>
							</div>
						</div>
						<div class="card-body py-0">
						    <div class="row border-bottom">
						        <?php if ($pro->foto): ?>
								<div class="row">
									<div class="col-md-12">
										<div id="foto-produk-<?= $in; ?>" class="carousel slide" data-ride="carousel">
											<div class="carousel-inner">
												<?php for ($i = 0; $i < $this->setting->banyak_foto_tiap_produk; $i++): ?>
												<?php if ($foto[$i]): ?>
												<div class="carousel-item <?= jecho($i, 0, 'active'); ?>">
												    <a data-fancybox="gallery" href="<?= base_url(LOKASI_PRODUK . $foto[$i]); ?>">
														<img class="mw-100" height="200" loading="lazy" src="<?= is_file(LOKASI_PRODUK . $foto[$i]) == TRUE ? base_url(LOKASI_PRODUK . $foto[$i]) : base_url('assets/images/404-image-not-found.jpg') ?>">
													</a>
												</div>
												<a class="carousel-control-prev" href="#foto-produk-<?= $in; ?>" role="button" data-slide="prev">
													<span class="carousel-control-prev-icon" aria-hidden="true"></span>
													<span class="sr-only">Previous</span>
												</a>
												<a class="carousel-control-next" href="#foto-produk-<?= $in; ?>" role="button" data-slide="next">
													<span class="carousel-control-next-icon" aria-hidden="true"></span>
													<span class="sr-only">Next</span>
												</a>
												<?php endif; ?>
												<?php endfor; ?>
											</div>
										</div>										
									</div>
								</div>
								<?php else: ?>
								<img src="<?= base_url('assets/images/404-image-not-found.jpg') ?>" class="mw-100" height="200" loading="lazy"/>
								<?php endif; ?>
								<div class="card-body">
								    <?php $harga_potongan = ($pro->tipe_potongan == 1) ? ($pro->harga * ($pro->potongan / 100)) : $pro->potongan; ?>
									<span class="text-success"><b><?= rupiah($pro->harga - $harga_potongan); ?><small>/<?= $pro->satuan ?></small></b>
									<?php if ($pro->potongan != 0): ?>
									<small style="color:red; text-decoration: line-through red;">(<?= persen(($pro->tipe_potongan == 1) ? $pro->potongan/100 : $pro->potongan / $pro->harga); ?>)</small>
									<?php endif; ?></span>
									<div class="d-flex justify-content-between align-items-center mt-2">
										<div class="btn-group">
										<?php if ($pro->telepon): ?>
										<?php $pesan = strReplaceArrayRecursive(['[nama_produk]' => $pro->nama, '[link_web]' => base_url('lapak'), '<br />' => "%0A"], nl2br($this->setting->pesan_singkat_wa)); ?>
										<a class="btn btn-sm btn-success" href="https://api.whatsapp.com/send?phone=<?=format_telpon($pro->telepon);?>&amp;text=<?= $pesan; ?>" rel="noopener noreferrer" target="_blank" title="WhatsApp"><i class="fa fa-whatsapp"></i> Beli</a>
										<?php endif; ?>
										<a class="btn btn-sm btn-danger text-white" data-remote="false" data-toggle="modal" data-target="#modalBesar<?= $pro->id; ?>" title="Lokasi"><i class="fa fa-map"></i> Lokasi</a>
										<a class="btn btn-sm btn-primary text-white" data-remote="false" data-toggle="modal" data-target="#descModal<?= $pro->id; ?>" title="Deskripsi"><i class="fa fa-info-circle"></i> Deskripsi</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
	    		<?php endforeach; ?>
    		</div>
			<?php
				$paging_page = 'lapak';
				if ($paging->num_rows > $paging->per_page):
			?>
			<div class="pagination_area">
				<div>Halaman <?= $paging->page ?> dari <?= $paging->end_link ?></div>
				<ul class="pagination pagination-sm no-margin">
					<?php if ($paging->start_link): ?>
						<li class="page-item "><a class="page-link" href="<?= site_url($paging_page."/$paging->start_link" . $paging->suffix) ?>" title="Halaman Pertama"><i class="fa fa-fast-backward"></i>&nbsp;</a></li>
					<?php endif; ?>
					<?php if ($paging->prev): ?>
						<li class="page-item"><a class="page-link" href="<?= site_url($paging_page."/$paging->prev" . $paging->suffix) ?>" title="Halaman Sebelumnya"><i class="fa fa-backward"></i>&nbsp;</a></li>
					<?php endif; ?>
						<?php foreach ($pages as $i): ?>
						<li <?= jecho($paging->page, $i, 'class="page-item active"'); ?>>
							<a class="page-link" href="<?= site_url($paging_page."/$i" . $paging->suffix) ?>" title="Halaman <?= $i ?>"><?= $i ?></a>
						</li>
					<?php endforeach; ?>
						<?php if ($paging->next): ?>
						<li class="page-item"><a class="page-link" href="<?= site_url($paging_page."/$paging->next" . $paging->suffix) ?>" title="Halaman Selanjutnya"><i class="fa fa-forward"></i>&nbsp;</a></li>
					<?php endif; ?>
					<?php if ($paging->end_link): ?>
						<li class="page-item"><a class="page-link" href="<?= site_url($paging_page."/$paging->end_link" . $paging->suffix) ?>" title="Halaman Terakhir"><i class="fa fa-fast-forward"></i>&nbsp;</a></li>
					<?php endif; ?>
				</ul>
			</div>
			<?php endif; ?>
    		<?php else: ?>
			<div class="font-weight-bold text-center mt-4 mb-4">
				<h5>Belum ada produk yang ditawarkan pada halaman ini.</h5>
			</div>
    		<?php endif;?>
		</div>
	</div>
</div>
<?php foreach ($produk as $in => $pro): ?>
<div class="modal fade" id="modalBesar<?= $pro->id; ?>" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class='modal-content'>
			<div class='modal-header'>
				<h6 class='modal-title' id='myModalLabel'><?= $pro->nama; ?></h6>
				<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
			</div>
			<div class='modal-body'>
				<div class="map" id="map_canvas<?= $pro->id; ?>">
					<div class="leaflet-bottom leaflet-right">
						<div id="qrcode">
							<div class="panel-body-lg">
								<a href="https://github.com/OpenSID/OpenSID">
									<img src="<?= base_url()?>assets/images/opensid.png" alt="OpenSID">
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="descModal<?= $pro->id; ?>" tabindex="-1" role="dialog" aria-labelledby="descModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="descModalLabel"><?= $pro->nama; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5><i class="fa fa-user"></i>&nbsp;<?= $pro->pelapak ?? 'ADMIN'; ?></h5>
                <?= nl2br($pro->deskripsi); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Keluar</button>
                <a class="btn btn-sm btn-danger" href="https://www.google.com/maps/dir//<?= $pro->lat?>,<?= $pro->lng?>" rel="noopener noreferrer" target="_blank" title="Arah Tujuan"><i class="fa fa-map-marker"></i> Arah Lokasi</a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<script>
$(document).ready(function(){
<?php foreach ($produk as $in => $pro): ?>
<?php $foto = json_decode($pro->foto); ?>
  $('#modalBesar<?= $pro->id; ?>').on('shown.bs.modal', function(){
    var container = L.DomUtil.get('map<?= $pro->id; ?>'); if(container != null){ container._leaflet_id = null; }
    var map<?= $pro->id; ?> = L.map('map_canvas<?= $pro->id; ?>').setView([<?= $pro->lat; ?>,<?= $pro->lng; ?>], 15);
    var logo = L.icon({
      iconUrl: '<?= base_url()?>assets/images/gis/point/fastfood.png',
      iconSize:     [32, 32], // size of the icon
      iconAnchor:   [16, 16], // point of the icon which will correspond to marker's location
      popupAnchor:  [-1,1] // point from which the popup should open relative to the iconAnchor
    });
    var foto =
    '<?php if ($pro->foto): ?>'
	+' <div id="foto-popup-<?= $in; ?>" class="carousel slide" data-ride="carousel">'
	+' <div class="carousel-inner">'
	+' <?php for ($i = 0; $i < $this->setting->banyak_foto_tiap_produk; $i++): ?>'
	+' <?php if ($foto[$i]): ?>'
	+' <div class="carousel-item <?= jecho($i, 0, "active"); ?>">'
	+' <?php if (is_file(LOKASI_PRODUK . $foto[$i])): ?>'
	+' <a data-fancybox="gallery" href="<?= base_url(LOKASI_PRODUK . $foto[$i]); ?>">'
	+' <img src="<?= base_url(LOKASI_PRODUK . $foto[$i]); ?>" class="mw-100" style="border-radius:1px;-moz-border-radius:3px;-webkit-border-radius:1px;"/>'
	+' </a>'
	+' <?php else: ?>'
	+' <img src="<?= base_url("assets/images/404-image-not-found.jpg") ?>" class="mw-100" style="border-radius:1px;-moz-border-radius:3px;-webkit-border-radius:1px;"/>'
	+' <?php endif; ?>'
	+' </div>'
	+' <a class="carousel-control-prev" href="#foto-popup-<?= $in; ?>" role="button" data-slide="prev">'
	+' <span class="carousel-control-prev-icon" aria-hidden="true"></span>'
	+' <span class="sr-only">Previous</span>'
	+' </a>'
	+' <a class="carousel-control-next" href="#foto-popup-<?= $in; ?>" role="button" data-slide="next">'
	+' <span class="carousel-control-next-icon" aria-hidden="true"></span>'
	+' <span class="sr-only">Next</span>'
	+' </a>'
	+' <?php endif; ?>'
	+' <?php endfor; ?>'
	+' </div>'
	+' </div>										'
	+' <?php endif; ?>';
    
    var info_tempat =
    '<div id="content">'
    + '<h6><b style="color:red"><center>' + <?= json_encode($pro->nama) ?> + '</center></b></h6>'
    + '<div id="bodyContent" class="mb-2 text-center">'+ foto + '</div>'
    + '<table>'
    + '<tr>'
    + '<td width="60px">Harga</td>'
    + '<td width="10px">:</td>'
    + '<td><span class="text-success"><b>' + <?= json_encode(rupiah($pro->harga - (($pro->potongan/100) * $pro->harga))) ?> + '</b></span></td>'
    + '</tr>'
    + '<tr>'
    + '<td width="60px">Kontak</td>'
    + '<td width="10px">:</td>'
    + '<td>'
    + <?= json_encode($pro->telepon) ?>
    + '</td>'
    + '</tr>'
    + '<tr>'
    + '<td width="60px" valign="top">Pelapak</td>'
    + '<td width="10px" valign="top">:</td>'
    + '<td><b style="color:red">' + <?= json_encode($pro->pelapak) ?? 'ADMIN'; ?> + '</b></td>'
    + '</tr>'
    + '<tr>'
    + '<td width="60px">Tujuan</td>'
    + '<td width="10px">:</td>'
    + '<td><a class="btn btn-sm btn-danger danger-gradient mt-0" target="_blank" rel="noopener noreferrer" href="https://www.google.com/maps/dir//'+<?= $pro->lat; ?> +','+<?= $pro->lng; ?>+'/"><i class="fa fa-map-marker"></i> Arah ke Lokasi</a></td>'
    + '</tr>'
    + '</table>'
    + '</div>';
    var lapakmark = L.marker([<?= $pro->lat; ?>,<?= $pro->lng; ?>],{icon:logo}).addTo(map<?= $pro->id; ?>)
    .bindPopup(info_tempat).openPopup();
    L.control.scale().addTo(map<?= $pro->id; ?>);
  	var baseLayers = getBaseLayers(map<?= $pro->id; ?>, '<?=$this->setting->mapbox_key?>');
  	L.control.layers(baseLayers, null, {position: 'topright', collapsed: true}).addTo(map<?= $pro->id; ?>);
    map<?= $pro->id; ?>.invalidateSize();
  });
  <?php endforeach; ?>
});
</script>
