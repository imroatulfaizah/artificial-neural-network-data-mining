<?php include 'header.php'; ?>

<h3><span class="glyphicon glyphicon-briefcase"></span>  Data Dealer</h3>
<button style="margin-bottom:20px" data-toggle="modal" data-target="#myModal" class="btn btn-info col-md-2"><span class="glyphicon glyphicon-plus"></span>Tambah Data</button>
<br/>
<br/>


<?php 
$per_hal=10;
$jumlah_record=mysql_query("SELECT COUNT(*) from dataset");
$jum=mysql_result($jumlah_record, 0);
$halaman=ceil($jum / $per_hal);
$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_hal;
?>
<div class="col-md-12">
	<table class="col-md-2">
		<tr>
			<td>Jumlah Dealer</td>		
			<td><?php echo $jum; ?></td>
		</tr>
		<tr>
			<td>Jumlah Halaman</td>	
			<td><?php echo $halaman; ?></td>
		</tr>
	</table>
	<a style="margin-bottom:10px" href="lap_barang.php" target="_blank" class="btn btn-default pull-right"><span class='glyphicon glyphicon-print'></span>  Cetak</a>
</div>
<form action="cari_act.php" method="get">
	<div class="input-group col-md-5 col-md-offset-7">
		<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span></span>
		<input type="text" class="form-control" placeholder="Cari barang di sini .." aria-describedby="basic-addon1" name="cari">	
	</div>
</form>
<br/>
<table class="table table-hover">
	<tr>
		<th class="col-md-2">Row Index</th>
		<th class="col-md-2">Output</th>
		<th class="col-md-3">Opsi</th>
	</tr>
	<?php 
	if(isset($_GET['cari'])){
		$cari=mysql_real_escape_string($_GET['cari']);
		$brg=mysql_query("select * from dataset where nama like '$cari' or jenis like '$cari'");
	}else{
		$brg=mysql_query("SELECT Dataset.RowIndex, SIGMOID(SUM(Weight * CellValue)) as Output FROM Dataset CROSS JOIN Parameters ON Dataset.ColumnIndex = Parameters.RowIndex GROUP BY Dataset.RowIndex, Parameters.ColumnIndex order by output asc");
	}
	$no=1;
	while($b=mysql_fetch_array($brg)){

		?>
		<tr>
			<td><?php echo $b['RowIndex'] ?></td>
			<td><?php echo $b['Output'] ?></td>
			<td>
				<a href="detail_dealer.php?id_dealer=<?php echo $b['id_dealer']; ?>" class="btn btn-info">Detail</a>
				<a href="edit_dealer.php?id_dealer=<?php echo $b['id_dealer']; ?>" class="btn btn-warning">Edit</a>
				<a onclick="if(confirm('Apakah anda yakin ingin menghapus data ini ??')){ location.href='hapus_dealer.php?id_dealer=<?php echo $b['id_dealer']; ?>' }" class="btn btn-danger">Hapus</a>
			</td>
		</tr>		
		<?php 
	}
	?>
	
</table>
<ul class="pagination">			
			<?php 
			for($x=1;$x<=$halaman;$x++){
				?>
				<li><a href="?page=<?php echo $x ?>"><?php echo $x ?></a></li>
				<?php
			}
			?>						
		</ul>
<!-- modal input -->
<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Tambah Data Dealer</h4>
			</div>
			<div class="modal-body">
				<form action="tambah_dealer.php" method="post">
					<div class="form-group">
						<label>Id Dealer</label>
						<input name="id_dealer" type="text" class="form-control" placeholder="Id Dealer ..">
					</div>
					<div class="form-group">
						<label>Nama Dealer</label>
						<input name="nama_dealer" type="text" class="form-control" placeholder="Nama Dealer ..">
					</div>
					<div class="form-group">
							<label>Nama Merk</label>								
							<select class="form-control" name="id_merk">
								<?php 
								$merk=mysql_query("select * from merk");
								while($b=mysql_fetch_array($merk)){
									?>	
									<option value="<?php echo $b['id_merk']; ?>"><?php echo $b['nama_merk'] ?></option>
									<?php 
								}
								?>
							</select>

						</div>	
					<div class="form-group">
							<label>Nama Type</label>								
							<select class="form-control" name="id_type">
								<?php 
								$type=mysql_query("select * from type");
								while($b=mysql_fetch_array($type)){
									?>	
									<option value="<?php echo $b['id_type']; ?>"><?php echo $b['nama_type'] ?></option>
									<?php 
								}
								?>
							</select>

						</div>			
					<div class="form-group">
						<label>Alamat</label>
						<input name="alamat" type="text" class="form-control" placeholder="Alamat">
					</div>	
					<div class="form-group">
						<label>Nomor Telepon</label>
						<input name="no_telp" type="text" class="form-control" placeholder="Nomor Telepon">
					</div>	
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<input type="submit" class="btn btn-primary" value="Simpan">
				</div>
			</form>
		</div>
	</div>
</div>



<?php 
include 'footer.php';

?>