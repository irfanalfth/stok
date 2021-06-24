<section class="section">
	<div class="section-header">
		<h1>DASHBOARD STOK ASET</h1>
	</div>
	<div class="section-body">
		<div class="row">
			<div class="col-lg-6">
				<div class="card card-statistic-1">
					<div class="card-icon bg-info">
						<i class="fa fa-file fa-2x" style="color:white"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4>Total Data</h4>
							<a class="btn btn-secondary float-right" href="<?= base_url('super_admin/totaldata'); ?>">Detail</a>
						</div>
						<div class="card-body">
							<?= $jumlah; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card card-statistic-1">
					<div class="card-icon bg-success">
						<i class="fa fa-upload fa-2x" style="color:white"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4>Total Selesai</h4>
							<a class="btn btn-secondary float-right" href="<?= base_url('super_admin/totaldone'); ?>">Detail</a>
						</div>
						<div class="card-body">
							<?= $selesai; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card card-statistic-1">
					<div class="card-icon bg-danger">
						<i class="fa fa-exclamation fa-2x" style="color:white"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4>Total Tidak Ada</h4>
							<a class="btn btn-secondary float-right" href="<?= base_url('super_admin/totalgone'); ?>">Detail</a>
						</div>
						<div class="card-body">
							<?= $tidak_ada; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card card-statistic-1">
					<div class="card-icon bg-warning">
						<i class="fa fa-plus fa-2x" style="color:white"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4>Total Data Baru</h4>
							<a class="btn btn-secondary float-right" href="<?= base_url('super_admin/totalnew'); ?>">Detail</a>
						</div>
						<div class="card-body">
							<?= $baru; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="card card-statistic-1">
					<div class="card-icon bg-primary">
						<i class="fa fa-dollar-sign fa-2x" style="color:white"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4 class="mb-2">Total Harga Perolehan</h4>
							<span class="btn-success p-2"><?= rupiah($harga[0]['hargaPerolehan']); ?></span>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="card">
					<div class="card-header">
						<h4>Aktivitas Terbaru</h4>
					</div>
					<div class="card-body">
						<ul class="list-unstyled list-unstyled-border">
							<?php foreach ($history as $h) { ?>
							<li class="media">
								<div class="media-body">
									<div class="media-title">
										<?php echo ucfirst($h['first_name'] . " " . $h['last_name']); ?></div>
									<span class="text-small text-muted"><?php echo $h['query']; ?></span>
								</div>
							</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
