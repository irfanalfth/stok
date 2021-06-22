  <section class="section">
      <div class="section-header">
          <h1>DATA KARTU STOK ASET</h1>
      </div>
      <div class="section-body">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fa fa-file fa-2x" style="color:white"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Data Aset</h4>
                        </div>
                        <div class="card-body">
                            <?= $jumlah; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fa fa-upload fa-2x" style="color:white"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Berhasil Import</h4>
                        </div>
                        <div class="card-body">
                            <?= $berhasil; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fa fa-cogs fa-2x" style="color:white"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Error</h4>
                        </div>
                        <div class="card-body">
                            <?= $error; ?>
                        </div>
                        <a href="<?=base_url('kartu_stok_aset/detailerror')?>">Detail</a>
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
                          <a href="<?= base_url('kartu_stok_aset/add') ?>" class="badge badge-success">Tambah</a>
                          <div class="col-md-6 mt-3">
                              <form action="<?= base_url('cetak') ?>" method="post">
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
                                          <!--<input name="print" value="Cetak" class="btn btn-info btn-sm" type="submit" />-->
                                          <input name="view" value="View" class="btn btn-warning btn-sm" type="submit" />
                                      </div>
                                  </div>
                              </form>
                          </div>
                          <!-- <a href="rawbt:data:application/pdf;base64,<?= $base64 ?>" class="badge badge-success">Test</a> -->
                      </div>
                      <?php if($kebanyakan != true){?> 
                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="table table-striped" id="myTable">
                                  <thead>
                                      <tr>
                                          <th>No</th>
                                          <th>Keberadaaan</th>
                                          <th>QRCode</th>
                                          <th>Gambar</th>
                                          <th>No Inventasis</th>
                                          <th>Nama Produk</th>
                                          <th>Merek Produk</th>
                                          <th>Deskripsi</th>
                                          <th>Action</th>
                                          <th>harga Perolehan</th>
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
                                          <th>Actions</th>
                                      </tr>
                                  </thead>
                                  <tbody id="pp">
                                      <?php
                                        $no = 1;
                                        foreach ($kartu_stok_aset_ as $t) { ?>
                                        <?php $bgc = $t['status'] == 'ilim' || $t['status'] == 'reinvilim'  ? 'bg-danger text-white' :''?> 
                                          <tr>
                                              <td class="<?=$bgc?>"><?php echo $no ?></td>
                                              <td class="<?=$bgc?>">
                                              <?php if ($t['status'] == 'import') { ?>
                                              <a href="<?php echo base_url() . 'kartu_stok_aset/keberadaan/n/' . $t['noInventaris'] ?>" class="btn btn-sm btn-danger m-1">Ilim</a>
                                              <?php } else {?>
                                              <a href="<?php echo base_url() . 'kartu_stok_aset/keberadaan/y/' . $t['noInventaris'] ?>" class="btn btn-sm btn-success m-1">Ada Ding</a>
                                              <?php }?>  
                                              <td class="<?=$bgc?>">
                                                  <button type="button" class="btn btn-primary btn-sm m-1" tabindex="0" data-toggle="popover" data-trigger="focus" title="<?= $t['noInventaris']; ?>" data-content="<img class='img-responsive' src='<?= base_url('assets/img/' . $t['noInventaris'] . '.png') ?>'>">Detail</button>
                                                  <a href="javascript:void(0)" data-id="<?= $t['noInventaris'] ?>" class="btn btn-sm btn-warning m-1 cetak">Cetak</a>
                                                  <a href="<?php echo base_url() . 'kartu_stok_aset/file_download/' . $t['noInventaris'] ?>" class="btn btn-sm btn-success m-1">Unduh</a>
                                              </td>
                                              <td class="<?=$bgc?>">
                                                  <?php $gambar =  view('product', ['id' => $t['productId']], 'gambar') ?>
                                                  <?php if ($gambar == '-') { ?>
                                                      <?= form_open_multipart('kartu_stok_aset/uploadgambar/' . $t['productId'].'/'.$this->uri->segment(3)); ?>
                                                      <label class="selectgroup-item">
                                                          <input onchange="this.form.submit();" type="file" name="gambar" capture="camera" class="selectgroup-input" accept="image/*">
                                                          <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-camera"></i></span>
                                                      </label>
                                                      <?= form_close(); ?>
                                                  <?php } else { ?>
                                                      <img width="80" alt="image" src="<?= base_url('assets/img/aset/' . $gambar) ?>" class="img-fluid" tabindex="0" data-toggle="popover" data-trigger="focus" data-content="<img class='img-responsive' src='<?= base_url('assets/img/aset/' . $gambar) ?>' width='240'>">
                                                      <?= form_open_multipart('kartu_stok_aset/uploadgambar/' . $t['productId'].'/'.$this->uri->segment(3)); ?>
                                                      <label class="selectgroup-item">
                                                          <input onchange="this.form.submit();" type="file" name="gambar" capture="camera" class="selectgroup-input" accept="image/*">
                                                          <span class="mt-2 badge badge-warning">
                                                              Upload ulang
                                                          </span>
                                                      </label>
                                                      <?= form_close(); ?>
                                                  <?php } ?>
                                              </td>
                                              <td class="<?=$bgc?>"><?= $t['noInventaris']; ?></td>

                                              <td class="<?=$bgc?>"> <?= view('product', ['id' => $t['productId']], 'nama'); ?></td>
                                              <td class="<?=$bgc?>"> <?= view('product', ['id' => $t['productId']], 'merek'); ?></td>
                                              <td class="<?=$bgc?>"> <?= view('product', ['id' => $t['productId']], 'deskripsi'); ?></td>
                                              <td class="<?=$bgc?>"> <a href="<?= base_url('produk/edit/'.$t['productId']); ?>" class="badge badge-warning">Edit Product</a></td>
                                              <td class="<?=$bgc?>"><?= 'Rp ' . number_format($t['hargaPerolehan']); ?></td>
                                              <td class="<?=$bgc?>"><?= $t['masaManfaat']; ?></td>
                                              <td class="<?=$bgc?>"><?= $t['supplier']; ?></td>
                                              <td class="<?=$bgc?>"><?= $t['pengguna']; ?></td>
                                              <td class="<?=$bgc?>"><?= $t['noPo']; ?></td>
                                              <td class="<?=$bgc?>"><?= $t['statusPerolehan']; ?></td>
                                              <td class="<?=$bgc?>"><?= $t['lokasi']; ?></td>
                                              <td class="<?=$bgc?>"><?= $t['kondisi']; ?></td>
                                              <td class="<?=$bgc?>">
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
                                              <td class="<?=$bgc?>">
                                                  <ul>
                                                      <?php
                                                        $nomor = $this->db->get_where('ksa_nomor', ['ksa' => $t['noInventaris']])->result_array();
                                                        foreach ($nomor as $n) {
                                                        ?>
                                                          <li><?= $n['nama'] . ' : ' . $n['nomor'] ?></li>
                                                      <?php } ?>
                                                  </ul>
                                              </td>
                                              <td class="<?=$bgc?>"><?php if (view('ksa_kendaraan', ['ksa' => $t['noInventaris']], 'namaStnk') != '') { ?>
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
                                              <td class="<?=$bgc?>">
                                                  <a href="<?php echo base_url('kartu_stok_aset/edit/' . $t['noInventaris']); ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-pen"></span></a>
                                                  <a href="<?php echo base_url('kartu_stok_aset/remove/' . $t['noInventaris']); ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete"><span class="fa fa-trash"></span></a>
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
      $(function() {
          $('[data-toggle=popover]').popover({
              html: true
          })
      })
  </script>