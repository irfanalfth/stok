<section class="section">
	<div class="section-header">
		<h1>UBAH DATA SUB SUB KATEGORI</h1>
	</div>
	<div class="section-body">
		<div class="row">
			<div class="col-12 col-md-12 col-lg-12">
				<div class="card">
					<div class="card-body">
						<?php echo form_open('barang/edit/' . $this->uri->segment(3)); ?>
						<div class="row">
							<div class="col-md-6">
								<label for="namaBarang" class="control-label"><span class="text-danger">*</span>Sub Sub Kategori</label>
								<div class="form-group">
									<input type="text" name="namaBarang" value="<?php echo ($this->input->post('namaBarang') ? $this->input->post('namaBarang') : $barang['namaBarang']); ?>" class="form-control" id="namaBarang" />
									<span class="text-danger"><?php echo form_error('namaBarang'); ?></span>
								</div>
							</div>
							<div class="col-md-6">
								<label for="kodeSub" class="control-label"><span class="text-danger">*</span>Sub Kategori</label>
								<div class="form-group">
									<select name="kodeSub" class="form-control select2">
										<?php

										foreach ($subkelompok_ as $value) {
											$selected = ($value['id'] == $barang['kodeSub']) ? ' selected="selected"' : "";

											echo '<option value="' . $value['id'] . '" ' . $selected . '>' . $value['namaSub'] . '</option>';
										}
										?>
									</select>
									<span class="text-danger"><?php echo form_error('kodeSub'); ?></span>
								</div>
							</div>
						</div>
						<button type="button" onclick="goBack()" class="btn btn-danger btn-sm">
							<i class="fas fa-arrow-left"></i> Kembali
						</button>
						<button type="submit" class="btn btn-success btn-sm">
							<i class="fa fa-check"></i> Simpan
						</button>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>