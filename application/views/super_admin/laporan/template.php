<section class="section">
	<div class="section-header">
		<h1><?= $header; ?></h1>
	</div>
	<div class="section-body">
		<div class="row">
			<div class="col-lg-4">
				<div class="card card-statistic-1">
					<div class="card-icon bg-info">
						<i class="fa fa-file fa-2x" style="color:white"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4>Total Data</h4>
							<a class="btn btn-secondary float-right"
								href="<?= base_url('super_admin/totaldata'); ?>">Detail</a>
						</div>
						<div class="card-body">
							<?= $jumlah; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
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
			<div class="col-lg-4">
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
			<div class="col-lg-6">
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
		</div>
	</div>
	<div class="section-body">
		<div class="row">
			<div class="col-12 col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<div class="col-md-6 mt-3">
							<form action="<?= base_url('super_admin/cari') ?>" method="post">
                            <input type="hidden" name="cont" value="<?= $this->uri->segment(2); ?>">
								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<select required name="ruangan" class="form-control select2 select2">
												<option value="">Ruangan</option>
												<?php
                                                    foreach ($ruangan as $value) {
                                                        $selected = ($value['id'] == $this->uri->segment(3)) ? ' selected="selected"' : "";
                                                        echo '<option value="' . $value['id'] . '" ' . $selected . '>' . $value['nama'] . '</option>';
                                                    }
                                                    ?>
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<input name="view" value="View" class="btn btn-warning btn-sm" type="submit" />
									</div>
								</div>
							</form>
						</div>
						<!-- <a href="rawbt:data:application/pdf;base64,<?= $base64 ?>" class="badge badge-success">Test</a> -->
					</div>
					<?php if ($kebanyakan != true) {?>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped" id="myTable">
								<thead>
									<tr>
										<th>No</th>
										<th>Gambar</th>
										<th>No Inventasis</th>
										<th>Nama Produk</th>
										<th>Merek Produk</th>
										<th>Deskripsi</th>
										<th>Harga Perolehan</th>
										<th>Masa Manfaat</th>
										<th>Suplier</th>
										<th>Pengguna</th>
										<th>No PO</th>
										<th>Status Perolehan</th>
										<th>Lokasi</th>
										<th>Kondisi</th>
										<th>Garansi</th>
										<th>Nomor</th>
										<th>Kendaraan</th>
									</tr>
								</thead>
								<tbody id="pp">
									<?php
                                        $no = 1;
                                        foreach ($kartu_stok_aset_ as $t) { ?>
									<tr>
										<td><?php echo $no ?></td>
										<td>
                                        <?php $gambar =  view('product', ['id' => $t['productId']], 'gambar') ?>
											<img width="80" alt="image"
												src="<?= base_url('assets/img/aset/' . $gambar) ?>" class="img-fluid"
												tabindex="0" data-toggle="popover" data-trigger="focus"
												data-content="<img class='img-responsive' src='<?= base_url('assets/img/aset/' . $gambar) ?>' width='240'>">
										</td>
										<td><?= $t['noInventaris']; ?></td>
										<td>
											<?= view('product', ['id' => $t['productId']], 'nama'); ?></td>
										<td>
											<?= view('product', ['id' => $t['productId']], 'merek'); ?></td>
										<td>
											<?= view('product', ['id' => $t['productId']], 'deskripsi'); ?></td>
										<td><?= rupiah($t['hargaPerolehan']); ?>
										</td>
										<td><?= $t['masaManfaat']; ?></td>
										<td><?= $t['supplier']; ?></td>
										<td><?= $t['pengguna']; ?></td>
										<td><?= $t['noPo']; ?></td>
										<td><?= $t['statusPerolehan']; ?></td>
										<td><?= $t['lokasi']; ?></td>
										<td><?= $t['kondisi']; ?></td>
										<td>
											<?php if ($t['isWaranty']) { ?>
											<ul>
												<li>NO :
													<?= view('kartu_garansi', ['noInventaris' => $t['noInventaris']], 'noKartuGaransi'); ?>
												</li>
												<li>Masa :
													<?= view('kartu_garansi', ['noInventaris' => $t['noInventaris']], 'masaGaransi'); ?>
												</li>
												<li>Jenis :
													<?= view('kartu_garansi', ['noInventaris' => $t['noInventaris']], 'jenisGaransi'); ?>
												</li>
											</ul>
											<?php } else { ?>
											Tidak Bergaransi
											<?php } ?>
										<td>
											<ul>
												<?php
                                                        $nomor = $this->db->get_where('ksa_nomor', ['ksa' => $t['noInventaris']])->result_array();
                                                        foreach ($nomor as $n) {
                                                            ?>
												<li><?= $n['nama'] . ' : ' . $n['nomor'] ?></li>
												<?php
                                                        } ?>
											</ul>
										</td>
										<td>
											<?php if (view('ksa_kendaraan', ['ksa' => $t['noInventaris']], 'namaStnk') != '') { ?>
											<ul>
												<li>Nama :
													<?= view('ksa_kendaraan', ['ksa' => $t['noInventaris']], 'namaStnk'); ?>
												</li>
												<li>Alamat :
													<?= view('ksa_kendaraan', ['ksa' => $t['noInventaris']], 'alamatStnk'); ?>
												</li>
											</ul>
											<?php } ?>
										</td>

									</tr>
									<?php
                                            $no++;
                                        } ?>
								</tbody>
							</table>
						</div>
					</div>
					<?php }?>
				</div>
			</div>

		</div>
	</div>
</section>

<script>
	$(function () {
		$('[data-toggle=popover]').popover({
			html: true
		})
	})

</script>
</section>

<script>
	$(function () {
		$('[data-toggle=popover]').popover({
			html: true
		})
	})

</script>
