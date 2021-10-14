<style type="text/css">
	table{
		border-collapse: collapse;
	}
	tr>th,tr>td{
		padding: 5px;
	}
</style>
<h2><?php echo $title_page ;?></h2>
<br>

<table>
	<tr>
		<td>ID UJI</td>
		<td>:</td>
		<td><?php echo $id; ?></td>	
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td>Tanggal UJI</td>
		<td>:</td>
		<td><?php echo $tgl; ?></td>
	</tr>
	<tr>
		<td>Nama</td>
		<td>:</td>
		<td><?php echo $nama; ?></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td>Pegawai</td>
		<td>:</td>
		<td><?php echo $pegawai; ?></td>
	</tr>
</table>

<table border="1">
	<tr>
		<th>No.</th>
		<th>Atr</th>
		<th>val</th>
		<th>Keterangan</th>
	</tr>
	<?php 
	$no=1;
	$i =0;
	foreach ($data_bumil as $key){
		if ($i>2) {
			echo '
			<tr>
				<td>'.$no.'</td>
				<td>'.$key['atr'].'</td>
				<td>'.$key['val'].'</td>
				<td></td>
				
			</tr>
		';
		$no++;
		}
		$i++;
	}
	?>	
</table>
