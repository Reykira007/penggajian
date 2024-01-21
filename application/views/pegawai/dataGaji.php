<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
	</div>

	<table class="table table-striped table-bordered">
		<tr>
			<th>Bulan/Tahun</th>
			<th>Gaji Pokok</th>
			<th>Tunjangan Transportasi</th>
			<th>Uang Makan</th>
			<th>Potongan</th>
			<th>Total Gaji</th>
			<th>Cetak Slip</th>
		</tr>

		<?php foreach ($gaji as $g) :
			$total_potongan = 0;

			// Menghitung potongan gaji untuk sakit
			$potongan_sakit = $this->penggajianModel->getPotonganGajiByJenis('sakit');
			$total_potongan += $potongan_sakit->jml_potongan * $g->sakit;

			// Menghitung potongan gaji untuk alpa
			$potongan_alpa = $this->penggajianModel->getPotonganGajiByJenis('alpa');
			$total_potongan += $potongan_alpa->jml_potongan * $g->alpa;

			$total_gaji = $g->gaji_pokok + $g->tj_transport + $g->uang_makan - $total_potongan;
		?>
			<tr>
				<td><?php echo date('F Y', strtotime($g->bulan)) ?></td>
				<td>Rp.<?php echo number_format($g->gaji_pokok, 0, ',', '.') ?></td>
				<td>Rp.<?php echo number_format($g->tj_transport, 0, ',', '.') ?></td>
				<td>Rp.<?php echo number_format($g->uang_makan, 0, ',', '.') ?></td>
				<td>Rp.<?php echo number_format($total_potongan, 0, ',', '.') ?></td>
				<td>Rp.<?php echo number_format($total_gaji, 0, ',', '.') ?></td>
				<td>
					<center>
						<a class="btn btn-sm btn-primary" href="<?php echo base_url('pegawai/dataGaji/cetakSlip/' . $g->id_kehadiran) ?>"><i class="fas fa-print"></i></a>
					</center>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>

</div>
<!-- /.container-fluid -->