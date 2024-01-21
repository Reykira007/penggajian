<!DOCTYPE html>
<html>

<head>
    <title><?php echo $title ?></title>
    <style type="text/css">
        body {
            font-family: Arial;
            color: black;
        }
    </style>
</head>

<body>
    <center>
        <h1>PT. Indonesia Bangkit</h1>
        <h2>Daftar Gaji Pegawai</h2>
    </center>

    <?php
    $bulan = $this->input->post('bulan') ? $this->input->post('bulan') : date('m');
    $tahun = $this->input->post('tahun') ? $this->input->post('tahun') : date('Y');
    ?>

    <table>
        <tr>
            <td>Bulan</td>
            <td>:</td>
            <td><?php echo $bulan ?></td>
        </tr>
        <tr>
            <td>Tahun</td>
            <td>:</td>
            <td><?php echo $tahun ?></td>
        </tr>
    </table>
    <table class="table table-bordered table-striped">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">NIK</th>
            <th class="text-center">Nama Pegawai</th>
            <th class="text-center">Jenis Kelamin</th>
            <th class="text-center">Jabatan</th>
            <th class="text-center">Gaji Pokok</th>
            <th class="text-center">Tj. Transport</th>
            <th class="text-center">Uang Makan</th>
            <th class="text-center">Potongan Sakit</th>
            <th class="text-center">Potongan Alpa</th>
            <th class="text-center">Total Gaji</th>
        </tr>

        <?php
        $no = 1;
        foreach ($cetak_gaji as $g) :
            $potongan_sakit = $this->penggajianModel->getPotonganGajiByJenis('sakit')->jml_potongan * $g->sakit;
            $potongan_alpa = $this->penggajianModel->getPotonganGajiByJenis('alpa')->jml_potongan * $g->alpa;
            $total_gaji = $g->gaji_pokok + $g->tj_transport + $g->uang_makan - $potongan_sakit - $potongan_alpa;
        ?>
            <tr>
                <td class="text-center"><?php echo $no++ ?></td>
                <td class="text-center"><?php echo $g->nik ?></td>
                <td class="text-center"><?php echo $g->nama_pegawai ?></td>
                <td class="text-center"><?php echo $g->jenis_kelamin ?></td>
                <td class="text-center"><?php echo $g->nama_jabatan ?></td>
                <td>Rp.<?php echo number_format($g->gaji_pokok, 0, ',', '.') ?></td>
                <td>Rp.<?php echo number_format($g->tj_transport, 0, ',', '.') ?></td>
                <td>Rp.<?php echo number_format($g->uang_makan, 0, ',', '.') ?></td>
                <td>Rp.<?php echo number_format($potongan_sakit, 0, ',', '.') ?></td>
                <td>Rp.<?php echo number_format($potongan_alpa, 0, ',', '.') ?></td>
                <td>Rp.<?php echo number_format($total_gaji, 0, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <table width="100%">
        <tr>
            <td></td>
            <td width="250px">
                <p>Pangkalpinang, <?php echo date("d M Y") ?> <br> Finance</p>
                <br>
                <br>
                <p>_____________________</p>
            </td>
        </tr>
    </table>
</body>

</html>

<script type="text/javascript">
    window.print();
</script>