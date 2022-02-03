<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h3>Data belanjaan</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Subharga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>x</td>
                    <td>x</td>
                    <td>x</td>
                    <td>x</td>
                </tr>
            </tbody>
        </table>

        <h3>Alamat</h3>
        <form method="post">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Provinsi</label>
                        <select class="form-control" name="nama_provinsi"></select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Distrik</label>
                        <select class="form-control" name="nama_distrik"></select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Ekspedisi</label>
                        <select class="form-control" name="nama_ekspedisi"></select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Paket</label>
                        <select class="form-control" name="nama_paket"></select>
                    </div>
                </div>
            </div>
            <input type="text" name="total_berat" value="1200">
            <input type="text" name="provinsi">
            <input type="text" name="distrik">
            <input type="text" name="tipe">
            <input type="text" name="kodepos">
            <input type="text" name="ekspedisi">
            <input type="text" name="paket">
            <input type="text" name="ongkir">
            <input type="text" name="estimasi">
        </form>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                type: 'post',
                url: 'dataprovinsi.php',
                success: function(hasil_provinsi) {
                    $("select[name=nama_provinsi]").html(hasil_provinsi);
                }
            });

            $("select[name=nama_provinsi]").on("change", function() {
                //Ambil id_provinsi yang dipilih (dari atribut pribadi/bid'ah)
                var id_provinsi_terpilih = $("option:selected", this).attr("id_provinsi");
                $.ajax({
                    type: 'post',
                    url: 'datadistrik.php',
                    data: 'id_provinsi=' + id_provinsi_terpilih,
                    success: function(hasil_distrik) {
                        $("select[name=nama_distrik]").html(hasil_distrik);
                    }
                });
            });

            $.ajax({
                type: 'post',
                url: 'dataekspedisi.php',
                success:function(hasil_ekspedisi) {
                    $("select[name=nama_ekspedisi]").html(hasil_ekspedisi);
                }
            });

            $("select[name=nama_ekspedisi]").on("change",function() {
                //Mendapatkan data ongkos kirim
                var ekspedisi_terpilih = $("select[name=nama_ekspedisi]").val();
                //Mendapatkan id_distrik yang dipilih pengguna
                //Mendapatkan ekspedisi yang dipilih
                var distrik_terpilih = $("option:selected","select[name=nama_distrik]").attr("id_distrik");
                //Mendapatkan total_berat dari inputan
                var total_berat = $("input[name=total_berat]").val();
                $.ajax({
                    type: 'post',
                    url: 'datapaket.php',
                    data: 'ekspedisi='+ekspedisi_terpilih+'&distrik='+distrik_terpilih+'&berat='+total_berat,
                    success:function(hasil_paket) {
                        $("select[name=nama_paket]").html(hasil_paket);

                        //Letakkan nama ekspedisi terpilih di input ekspedisi
                        $("input[name=ekspedisi]").val(ekspedisi_terpilih);
                    }
                })
            });

            $("select[name=nama_distrik]").on("change",function() {
                var prov = $("option:selected", this).attr("nama_provinsi");
                var dist = $("option:selected", this).attr("nama_distrik");
                var tipe = $("option:selected", this).attr("tipe_distrik");
                var kodepos = $("option:selected", this).attr("kodepos");

                $("input[name=provinsi]").val(prov);
                $("input[name=distrik]").val(dist);
                $("input[name=tipe]").val(tipe);
                $("input[name=kodepos]").val(kodepos);
            });

            $("select[name=nama_paket]").on("change", function() {
                var paket = $("option:selected", this).attr("paket");
                var ongkir = $("option:selected", this).attr("ongkir");
                var etd = $("option:selected", this).attr("etd");

                $("input[name=paket]").val(paket);
                $("input[name=ongkir]").val(ongkir);
                $("input[name=estimasi]").val(etd);
            })
        });
    </script>
</body>

</html>