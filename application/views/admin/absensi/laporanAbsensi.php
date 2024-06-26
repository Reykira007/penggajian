<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card mx-auto" style="width: 35%">
        <div class="card-header bg-primary text-white text-center">
            Filter Laporan Absensi Pegawai
        </div>

        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger mt-3">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

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

        // Mengambil tahun saat ini
        $tahun_sekarang = date('Y');
        ?>

        <form method="POST" action="<?php echo base_url('admin/laporanAbsensi/cetakLaporanAbsensi') ?>">
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Bulan</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="bulan">
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
                </div>

                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Tahun</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="tahun">
                            <option value="">--Pilih Tahun--</option>
                            <?php for ($i = $tahun_sekarang - 4; $i <= $tahun_sekarang + 0; $i++) { ?>
                                <option value="<?php echo $i ?>">
                                    <?php echo $i ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <button style="width: 100%" type="submit" class="btn btn-primary"><i class="fas fa-print"></i>Cetak Laporan Absensi</button>
            </div>
        </form>
    </div>
    <!-- /.container-fluid -->
</div>