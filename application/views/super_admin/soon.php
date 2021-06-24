<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Admin Page</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- CSS Libraries -->
    <!-- <link rel="stylesheet" href="../node_modules/jqvmap/dist/jqvmap.min.css">
    <link rel="stylesheet" href="../node_modules/summernote/dist/summernote-bs4.css">
    <link rel="stylesheet" href="../node_modules/owl.carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="../node_modules/owl.carousel/dist/assets/owl.theme.default.min.css"> -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />
    <!-- Template CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/select2.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/components.css">

</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="page-error">
          <div class="page-inner">
            <h2>Coming Soon ;)</h2>
            <div class="page-search">
              <div class="mt-3">
                <a href="<?= base_url('super_admin'); ?>">Kembali</a>
              </div>
            </div>
          </div>
        </div>
        <div class="simple-footer mt-5">
          Copyright &copy; UACAK 2021
        </div>
      </div>
    </section>
  </div>

    <!-- General JS Scripts -->

    <!-- <script src="<?php echo base_url(); ?>assets/js/stisla.js"></script> -->

    <!-- JS Libraies -->
    <!-- <script src="../node_modules/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="../node_modules/chart.js/dist/Chart.min.js"></script>
    <script src="../node_modules/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="../node_modules/summernote/dist/summernote-bs4.js"></script>
    <script src="../node_modules/chocolat/dist/js/jquery.chocolat.min.js"></script> -->
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <!-- Template JS File -->
    <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/select2.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/advance-form.js"></script>

</body>

</html>