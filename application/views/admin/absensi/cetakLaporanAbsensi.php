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
        <h2>Laporan Kehadiran Pegawai</h2>
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

    <table class="table table-bordered table-triped">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">NIK</th>
            <th class="text-center">Nama Pegawai</th>
            <th class="text-center">Jabatan</th>
            <th class="text-center">Hadir</th>
            <th class="text-center">Sakit</th>
            <th class="text-center">Alpha</th>
        </tr>
        <?php $no = 1;
        foreach ($lap_kehadiran as $l) : ?>
            <tr>
                <td class="text-center"><?php echo $no++ ?></td>
                <td class="text-center"><?php echo $l->nik ?></td>
                <td class="text-center"><?php echo $l->nama_pegawai ?></td>
                <td class="text-center"><?php echo $l->nama_jabatan ?></td>
                <td class="text-center"><?php echo $l->hadir ?></td>
                <td class="text-center"><?php echo $l->sakit ?></td>
                <td class="text-center"><?php echo $l->alpa ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>

<script type="text/javascript">
    window.print();
</script>