<?php 
  	//Koneksi Database
	$server = "localhost";
	$user = "id15469628_irfan";
	$pass = "}rO5f-APpipe0kRJ";
	$database = "id15469628_crud";

	$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

	//jika tombol simpan diklik
	if(isset($_POST['bsimpan']))
	{
		//Pengujian Apakah data akan diedit atau disimpan baru
		if($_GET['hal'] == "edit")
		{
			//Data akan di edit
			$edit = mysqli_query($koneksi, "UPDATE tmhs set
											 	nis = '$_POST[tnis]',
											 	nama = '$_POST[tnama]',
												alamat = '$_POST[talamat]',
											 	prodi = '$_POST[tprodi]'
											 WHERE id_mhs = '$_GET[id]'
										   ");
			if($edit) //jika edit sukses
			{
				echo "<script>
						alert('Edit data suksess!');
						document.location='index.php';
				     </script>";
			}
			else
			{
				echo "<script>
						alert('Edit data GAGAL!!');
						document.location='index.php';
				     </script>";
			}
		}
		else
		{
			//Data akan disimpan Baru
			$simpan = mysqli_query($koneksi, "INSERT INTO tmhs (nis, nama, alamat, prodi)
										  VALUES ('$_POST[tnis]', 
										  		 '$_POST[tnama]', 
										  		 '$_POST[talamat]', 
										  		 '$_POST[tprodi]')
										 ");
			if($simpan) //jika simpan sukses
			{
				echo "<script>
						alert('Simpan data suksess!');
						document.location='index.php';
				     </script>";
			}
			else
			{
				echo "<script>
						alert('Simpan data GAGAL!!');
						document.location='index.php';
				     </script>";
			}
		}


		
	}


	//Pengujian jika tombol Edit / Hapus di klik
	if(isset($_GET['hal']))
	{
		//Pengujian jika edit Data
		if($_GET['hal'] == "edit")
		{
			//Tampilkan Data yang akan diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM tmhs WHERE id_mhs = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//Jika data ditemukan, maka data ditampung ke dalam variabel
				$vnis = $data['nis'];
				$vnama = $data['nama'];
				$valamat = $data['alamat'];
				$vprodi = $data['prodi'];
			}
		}
		else if ($_GET['hal'] == "hapus")
		{
			//Persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_mhs = '$_GET[id]' ");
			if($hapus){
				echo "<script>
						alert('Hapus Data Suksess!!');
						document.location='index.php';
				     </script>";
			}
		}
	}



 ?>


<!DOCTYPE html>
<html>
<head>
	<title>CRUD & MySQL</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">
	<h1 class="text-center">CRUD PHP & MySQL</h1>
	<h2 class="text-center">@muzaky.i</h2>

	<!--awal card from-->
	<div class="card mt-3">
	  <div class="card-header bg-primary text-white">
	    Form Innput Data Siswa SMK Telkom
	  </div>
	  <div class="card-body">
	    <form method="post" action="" >
	    	<div class="form-group">
	    		<label>Nis</label>
	    		<input type="text" name="tnis" value="<?=@$vnis?>" class="form-control" placeholder="Input Nis Anda Disini" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Nama</label>
	    		<input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Input Nama Anda Disini" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Alamat</label>
	    		<textarea class="form-control" name="talamat" placeholder="Input Alamat Anda Disini"><?=@$valamat?></textarea>
	    	</div>
	    	<div class="form-group"> 
	    		<label>Jurusan</label>
	    		<select class=" form-control" name="tprodi">
	    			<option value="<?=@$vprodi?>"><?=@$vprodi?></option>
	    			<option value="RPL">RPL</option>
	    			<option value="TKJ">TKJ</option>
	    			<option value="TJA">TJA</option>
	    		</select>
	    	</div>

	    	<button type="submit" class="btn-success" name="bsimpan">Simpan</button>
	    	<button type="reset" class="btn-danger" name="breset">Kosongkan</button>
	    </form>
	  </div>
	</div>
	<!--akhir card from-->

    <!--awal card tabel-->
	<div class="card mt-3">
	  <div class="card-header bg-success text-white">
	    Daftaar Siswa SMK Telkom 
	  </div>
	  <div class="card-body">
	  	<table class="table table-bordered table-striped">
	  		<tr>
	  			<th>NO</th>
	  			<th>Nis</th>
	  			<th>Nama</th>
	  			<th>Alamat</th>
	  			<th>Jurusan</th>
	  			<th>Aksi</th>
	  		</tr>
	  		<?php
	    		$no = 1;
	    		$tampil = mysqli_query($koneksi, "SELECT * from tmhs order by id_mhs desc");
	    		while($data = mysqli_fetch_array($tampil)) :

	    	?>
	    	<tr>
	    		<td><?=$no++;?></td>
	    		<td><?=$data['nis']?></td>
	    		<td><?=$data['nama']?></td>
	    		<td><?=$data['alamat']?></td>
	    		<td><?=$data['prodi']?></td>
	    		<td>
	    			<a href="index.php?hal=edit&id=<?=$data['id_mhs']?>" class="btn btn-warning"> Edit </a>
	    			<a href="index.php?hal=hapus&id=<?=$data['id_mhs']?>" 
	    			   onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger"> Hapus </a>
	    		</td>
	    		
	    	</tr>
	    <?php endwhile; //penutup perulangan while ?>
	  	</table>
	  </div>
	</div>
	<!--akhir card tabel-->


</div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>