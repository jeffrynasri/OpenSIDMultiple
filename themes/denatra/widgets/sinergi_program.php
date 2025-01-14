<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
	#sinergi_program
	{
		text-align: center;
	}

	#sinergi_program table
	{
		margin: auto;
	}

	#sinergi_program img
	{
		max-width: 100%;
		max-height: 100%;
		transition: all 0.5s;
		-o-transition: all 0.5s;
		-moz-transition: all 0.5s;
		-webkit-transition: all 0.5s;
	}

	#sinergi_program img:hover
	{
		transition: all 0.3s;
		-o-transition: all 0.3s;
		-moz-transition: all 0.3s;
		-webkit-transition: all 0.3s;
		transform: scale(1.5);
		-moz-transform: scale(1.5);
		-o-transform: scale(1.5);
		-webkit-transform: scale(1.5);
		box-shadow: 2px 2px 6px rgba(0,0,0,0.5);
	}
</style>
<div class="card mb-2">
	<div class="card-header border-bottom">
		<div class="media">
			<div class="media-body">
				<h4 class="content-color-primary mb-0"><i class="material-icons icon-sm">share</i> Sinergi Program</h4>
			</div>    
		</div>
	</div>
	<div class="card-body text-center" id="sinergi_program">
		<table>
			<?php foreach($sinergi_program as $key => $program) :
				$baris[$program['baris']][$program['kolom']] = $program;
			endforeach; ?>
			<?php foreach($baris as $baris_program) : ?>
			<tr>
				<td>
					<?php $width = 100/count($baris_program)-count($baris_program)?>
					<?php foreach($baris_program as $key => $program) : ?>
					<span style="display: inline-block; width: <?= $width.'%'?>">
						<a href="<?= $program['tautan']?>">
							<img src="<?= base_url().LOKASI_GAMBAR_WIDGET.$program['gambar']?>" class="img-responsive cover" style="float:left; margin:0px 0px 0px 0px;">
						</a>
					</span>
					<?php endforeach; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>
