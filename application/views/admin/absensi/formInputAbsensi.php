<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <?php echo $title ?>
        </h1>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            Input Absensi Pegawai
        </div>
        <div class="card-body">
            <form class="form-inline">
                <div class="form-group mb-2">
                    <label for="staticEmail2" class="">Bulan : </label>
                    <select class="form-control ml-2" name="bulan">
                        <option value="">--Pilih Bulan--</option>
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="form-group mb-2 ml-3">
                    <label for="staticEmail2" class="">Tahun : </label>
                    <select class="form-control ml-2" name="tahun">
                        <option value="">--Pilih Tahun--</option>
                        <?php $tahun = date('Y');
                        for ($i = 2019; $i < $tahun + 1; $i++) { ?>
                            <option value="<?php echo $i ?>">
                                <?php echo $i ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mb-2 ml-auto"><i class="fas fa-eye"></i> Generate </button>
            </form>
        </div>
    </div>

    <?php
    if ((isset($_GET['bulan']) && $_GET['bulan'] != '') && (isset($_GET['tahun']) && $_GET['tahun'] != '')) {
        $bulan = $_GET['bulan'];
        $tahun = $_GET['tahun'];
        $bulantahun = $bulan . $tahun;
    } else {
        $bulan = date('m');
        $tahun = date('Y');
        $bulantahun = $bulan . $tahun;
    }
    ?>

    <?php if (!$data_absensi_ada) { ?>
        <div class="alert alert-info">Input Data Kehadiran Pegawai Pada Bulan: <span class="font-weight-bold">
                <?php echo $bulan ?>
            </span> Tahun: <span class="font-weight-bold">
                <?php echo $tahun ?>
            </span>
        </div>

        <form method="POST" action="">
            <button class="btn btn-success mb-3" type="submit" name="submit" value="submit">SIMPAN</button>
            <table class="table table-bordered table-striped">
                <tr>
                    <td class="text-center">No</td>
                    <td class="text-center">NIK</td>
                    <td class="text-center">Nama Pegawai</td>
                    <td class="text-center">Jenis Kelamin</td>
                    <td class="text-center">Jabatan</td>
                    <td class="text-center" width="8%">Hadir</td>
                    <td class="text-center" width="8%">Sakit</td>
                    <td class="text-center" width="8%">Tidak Hadir</td>
                </tr>

                <?php $no = 1;
                foreach ($input_absensi as $a): ?>
                    <tr class="text-center">
                        <input type="hidden" name="bulan[]" class="form-control text-center" value="<?php echo $bulantahun ?>">
                        <input type="hidden" name="nik[]" class="form-control text-center" value="<?php echo $a->nik ?>">
                        <input type="hidden" name="nama_pegawai[]" class="form-control text-center"
                            value="<?php echo $a->nama_pegawai ?>">
                        <input type="hidden" name="jenis_kelamin[]" class="form-control text-center"
                            value="<?php echo $a->jenis_kelamin ?>">
                        <input type="hidden" name="nama_jabatan[]" class="form-control text-center"
                            value="<?php echo $a->nama_jabatan ?>">
                        <td>
                            <?php echo $no++ ?>
                        </td>
                        <td>
                            <?php echo $a->nik ?>
                        </td>
                        <td>
                            <?php echo $a->nama_pegawai ?>
                        </td>
                        <td>
                            <?php echo $a->jenis_kelamin ?>
                        </td>
                        <td>
                            <?php echo $a->nama_jabatan ?>
                        </td>
                        <td><input type="number" name="hadir[]" class="form-control text-center" value="0"></td>
                        <td><input type="number" name="sakit[]" class="form-control text-center" value="0"></td>
                        <td><input type="number" name="alpa[]" class="form-control text-center" value="0"></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </form>
    <?php } else { ?>
        <div class="alert alert-warning text-center"><i class="fas fa-info-circle"></i> Data absensi untuk bulan:
            <span class="font-weight-bold">
                <?php echo $bulan ?>
            </span> tahun: <span class="font-weight-bold">
                <?php echo $tahun ?>
            </span> sudah ada. Silakan pilih bulan dan tahun yang lain.
        </div>
    <?php } ?>

    <script>
        // Mendapatkan nilai bulan yang dipilih
        var bulan = document.querySelector( 'select[name="bulan"]' ).value;

        // Mendapatkan elemen tombol 'SIMPAN'
        var tombolSimpan = document.querySelector( 'button[name="submit"]' );

        // Menampilkan tombol 'SIMPAN' jika data absensi belum ada
        if ( !<?php echo $data_absensi_ada ? 'true' : 'false' ?> )
        {
            tombolSimpan.classList.remove( 'hide' );
        }

        // Menampilkan tombol 'SIMPAN' jika bulan dan tahun dipilih memiliki data absensi
        if ( bulan !== '' && !<?php echo $data_absensi_ada ? 'true' : 'false' ?> )
        {
            tombolSimpan.classList.remove( 'hide' );
        }
    </script>

    <style>
        .hide {
            display: none;
        }
    </style>
</div>