<script src="<?php echo base_url(); ?>assets/js/instascan.min.js"></script>

<div class="section-body">
	<div class="row">
		<div class="col-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="card-header">
					<div class="col-md-6 mt-3">
						<h3>Hide Barang</h3>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-lg-6 col-md-12">
							<form action="<?= base_url('hide/hidebarang'); ?>" method="post">
								<input type="hidden" name="nilai" value="txtarea">
								<label><b class="text-danger">*</b><span>Masukan No. INV Lengkap! <b>
											(0000-DEPT-M-Y-SA)</b></span></label>
								<div class="form-group">
									<textarea class="form-control" name="kode" rows="4" style="height: 30%;"
										placeholder="Data akan dibaca perbaris"></textarea>
									<span class="text-danger"><?php echo form_error('kode'); ?></span>
								</div>
								<button type="submit" class="btn btn-danger"><i class="fas fa-eye-slash"> </i> Hide</button>
							</form>
						</div>
						<div class="col-lg-6 col-md-12">
							<label>
								<b class="text-danger">*</b>
								<span>Masukan rentang data.
									<div class="form-group">
										<form action="<?= base_url('hide/hidebarang'); ?>" method="post">
										<input type="hidden" name="nilai" value="range">
											<div class="input-group">
												<input type="number" id="no_inv" name="no_inv" placeholder="0000"
													class="form-control mt-2">
												<input type="text" id="dept" name="dept" placeholder="Dept"
													onchange="Dept(this)"
													onkeyup="this.value = this.value.toUpperCase()"
													class="form-control mt-2">
												<input type="text" id="bulan" name="bulan" placeholder="Bulan"
													onchange="Bulan(this)"
													onkeyup="this.value = this.value.toUpperCase()"
													class="form-control mt-2">
												<input type="text" id="tahun" name="tahun" class="form-control mt-2"
													value="2021" disabled>
												<input type="text" id="sa" name="sa" class="form-control mt-2"
													value="SA" disabled>
											</div>
											- sampai -
											<div class="input-group">
												<input type="text" id="no_inv1" name="no_inv1" placeholder="0000"
													class="form-control">
												<input type="text" id="dept1" name="dept1" placeholder="Dept"
													class="form-control" disabled>
												<input type="text" id="bulan1" name="bulan1" placeholder="Bulan"
													class="form-control" disabled>
												<input type="text" id="tahun" name="tahun" class="form-control"
													value="2021" disabled>
												<input type="text" id="sa" name="sa" class="form-control" value="SA"
													disabled>
												<span class="text-danger"><?php echo form_error('no_inv'); ?></span>
												<script type="text/javascript">
													function Dept(dept) {
														let dept1 = document.getElementById('dept1');
														dept1.value = dept.value;
													}

													function Bulan(bulan) {
														let bulan1 = document.getElementById('bulan1');
														bulan1.value = bulan.value;
													}
												</script>
											</div>
									</div>
									<button type="submit" class="btn btn-danger"><i class="fas fa-eye-slash"> </i> Hide</button>
									</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
