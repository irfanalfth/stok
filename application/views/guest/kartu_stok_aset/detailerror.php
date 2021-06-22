  <section class="section">
      <div class="section-header">
          <h1>DATA ASET ERROR IMPORT</h1>
      </div>
      <div class="section-body">
          <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                  <div class="card">
                      <div class="card-header">
                      </div>
                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="table table-striped" id="myTable">
                                  <thead>
                                      <tr>
                                          <th>No</th>
                                              <th>C</th>
                                              <th>D</th>
                                              <th>E</th>
                                              <th>F</th>
                                              <th>G</th>
                                              <th>H</th>
                                              <th>I</th>
                                              <th>J</th>
                                              <th>K</th>
                                              <th>L</th>
                                              <th>M</th>
                                              <th>N</th>
                                              <th>O</th>
                                              <th>P</th>
                                              <th>Q</th>
                                              <th>R</th>
                                              <th>S</th>
                                              <th>T</th>
                                              <th>U</th>
                                              <th>V</th>
                                              <th>W</th>
                                              <th>X</th>
                                      </tr>
                                  </thead>
                                  <tbody id="pp">
                                      <?php
                                        $no = 1;
                                        foreach ($data as $t) { ?>
                                          <tr>
                                              <td><?php echo $no; ?></td>
                                              <td><?php echo $t['C']; ?></td>
                                              <td><?php echo $t['D']; ?></td>
                                              <td><?php echo $t['E']; ?></td>
                                              <td><?php echo $t['F']; ?></td>
                                              <td><?php echo $t['G']; ?></td>
                                              <td><?php echo $t['H']; ?></td>
                                              <td><?php echo $t['I']; ?></td>
                                              <td><?php echo $t['J']; ?></td>
                                              <td><?php echo $t['K']; ?></td>
                                              <td><?php echo $t['L']; ?></td>
                                              <td><?php echo $t['M']; ?></td>
                                              <td><?php echo $t['N']; ?></td>
                                              <td><?php echo $t['O']; ?></td>
                                              <td><?php echo $t['P']; ?></td>
                                              <td><?php echo $t['Q']; ?></td>
                                              <td><?php echo $t['R']; ?></td>
                                              <td><?php echo $t['S']; ?></td>
                                              <td><?php echo $t['T']; ?></td>
                                              <td><?php echo $t['U']; ?></td>
                                              <td><?php echo $t['V']; ?></td>
                                              <td><?php echo $t['W']; ?></td>
                                              <td><?php echo $t['X']; ?></td>
                                          </tr>
                                      <?php
                                            $no++;
                                        } ?>
                                  </tbody>
                              </table>
                          </div>
                      </div>
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