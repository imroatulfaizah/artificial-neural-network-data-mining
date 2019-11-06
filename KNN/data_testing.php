<?php include 'header.php'; ?>

<h3><span class="glyphicon glyphicon-briefcase"></span>  Data Testing</h3>
<button style="margin-bottom:20px" data-toggle="modal" data-target="#myModal" class="btn btn-info col-md-2"><span class="glyphicon glyphicon-plus"></span>Tambah Data</button>
<br/>
<br/>


<?php 
$per_hal=10;
$jumlah_record=mysql_query("SELECT COUNT(*) from data_testing");
$jum=mysql_result($jumlah_record, 0);
$halaman=ceil($jum / $per_hal);
$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_hal;
?>
<div class="col-md-12">
	<table class="col-md-2">
		<tr>
			<td>Jumlah Data Training</td>		
			<td><?php echo $jum; ?></td>
		</tr>
		<tr>
			<td>Jumlah Halaman</td>	
			<td><?php echo $halaman; ?></td>
		</tr>
	</table>


	
</div>
<form action="cari_act.php" method="get">
	<div class="input-group col-md-5 col-md-offset-7">
		<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span></span>
		<input type="text" class="form-control" placeholder="Cari data di sini .." aria-describedby="basic-addon1" name="cari">	
	</div>
</form>
<br/>
<table class="table table-hover">
	<tr>
		<th class="col-md-1">Id</th>
		<th class="col-md-1">Nama Dealer</th>
		<th class="col-md-2">Nama Merk</th>
		<th class="col-md-2">Nama Type</th>
		<th class="col-md-2">DP</th>
		<th class="col-md-1">Kontribusi</th>
		<th class="col-md-4">Opsi</th>
	</tr>
	<?php 


	if(isset($_GET['cari'])){
		$cari=mysql_real_escape_string($_GET['cari']);
		$brg=mysql_query("select * from data_training where nama like '$cari' or jenis like '$cari'");
	}else{
		
	}			
	//include("config.php");
				$sql="SELECT ts.id, ts.dp, ts.kontribusi, td.nama_dealer, tt.nama_type, tm.nama_merk FROM data_testing ts, dealer td, type tt, merk tm where ts.id_dealer=td.id_dealer && td.id_merk=tm.id_merk && tm.id_merk=tt.id_merk && td.id_type=tt.id_type order by id asc";
				$query = mysql_query($sql);
											
				$result = array(); 
				while ($data = mysql_fetch_array($query)){                                                          
            ?>
         
            	<tr>
                	<td><?php echo $data['id'] ?></td>
					<td><?php echo $data['nama_dealer'] ?></td>
					<td><?php echo $data['nama_merk'] ?></td>
					<td><?php echo $data['nama_type'] ?></td>
					<td><?php echo $data['dp'] ?></td>
					<td><?php echo $data['kontribusi'] ?></td>
				
			<td>
				<a href="edit_testing.php?id=<?php echo $data['id']; ?>" class="btn btn-warning">Edit</a>
				<a onclick="if(confirm('Apakah anda yakin ingin menghapus data ini ??')){ location.href='hapus_testing.php?id=<?php echo $data['id']; ?>' }" class="btn btn-danger">Hapus</a>
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
				<h4 class="modal-title">Tambah Data Testing</h4>
			</div>
			<div class="modal-body">
				<form action="tambah_testing.php" method="post">
					
					<div class="form-group">
						<label></label>
						<input name="id" type="hidden" class="form-control" placeholder="ID">
					</div>
					<div class="form-group">
							<label>Nama Dealer</label>								
							<select class="form-control" name="id_dealer">
								<?php 
								$dealer=mysql_query("select * from dealer");
								while($b=mysql_fetch_array($dealer)){
									?>	
									<option value="<?php echo $b['id_dealer']; ?>"><?php echo $b['nama_dealer'] ?></option>
									<?php 
								}
								?>
							</select>

						</div>
						
					<div class="form-group">
						<label>DP</label>
						<input name="dp" type="text" class="form-control" placeholder="Rp.">
					</div>						
					<div class="form-group">
						<label>Kontribusi</label>
						<input name="kontribusi" type="text" class="form-control" placeholder="kontribusi">
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