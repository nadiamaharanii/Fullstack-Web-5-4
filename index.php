<?php

//Koneksi Database
	$server  = "localhost";
	$user    = "root";
	$pass    = "";
	$database= "arkademy";

	$koneksi= mysqli_connect($server, $user, $pass, $database) or die (mysqli_error($koneksi));


//Jika tombol Tambah Data di klik
if(isset($_POST['tambah_data']))
{

	//Pengujian apakah data akan di edit atau di simpan baru
	if($_GET['hal']=="edit") 
	{
		//Data akan di edit
		$edit= mysqli_query($koneksi, "UPDATE produk set 
									   nama_produk= '$_POST[tnama]',
									   keterangan= '$_POST[tket]',
									   harga= '$_POST[tharga]',
									   jumlah= '$_POST[tjumlah]'
									   WHERE id_produk = '$_GET[id]'
									 ");

			if($edit) //Jika edit sukses
			{
				echo "<script>
						alert('Edit data berhasil');
						document.location='index.php';
					  </script>";
			} 
			else 
			{
				echo "<script>
						alert('Edit data gagal');
						document.location='index.php';
					  </script>";
			}

		} 
		else
		{



		//Data akan di simpan baru (Tambah Data)
		$tambahdata= mysqli_query($koneksi, "INSERT INTO produk (nama_produk, keterangan, harga, jumlah)
									 VALUES ('$_POST[tnama]',
									 		'$_POST[tket]',
									 		'$_POST[tharga]',
									 		'$_POST[tjumlah]')
									 ");

			if($tambahdata) 
			{
				echo "<script>
						alert('Data berhasil di tambah');
						document.location='index.php';
			 	 	  </script>";
			} 
			else 
			{
				echo "<script>
						alert('Gagal Menambahkan Data!');
						document.location='index.php';
			 	 	  </script>";
			}
		}
	
	}


//Pengujian jika tombol Edit dan Hapus di klik
	if(isset($_GET['hal']))
	{
		//Pengujian jika edit data
		if($_GET['hal'] == "edit")
		{
			//Tampilkan data yang akan di edit
			$tampil= mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = '$_GET[id]' ");
			$data= mysqli_fetch_array($tampil);
			if($data)
			{
				//Jika data ditemukan, maka data ditampung dalam variabel
				$vnama   = $data['nama_produk'];
				$vket    = $data['keterangan'];
				$vharga  = $data['harga'];
				$vjumlah = $data['jumlah'];
			}
		}
		else if ($_GET['hal'] == "hapus")
		{
			//Persiapan hapus data
			$hapus= mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk = '$_GET[id]' ");
			if($hapus) {
				echo "<script>
						alert('Data berhasil di hapus!');
						document.location='index.php';
			 	 	  </script>";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Arkademy</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">
  <h1 class="text-center">Input Data Barang</h1>
  <h2 class="text-center">@ITStore</h2>


<!--Awal Card Form-->
  <div class="card mt-5">
  <div class="card-header bg-primary text-white">
    Form Input Data Barang
  </div>
  <div class="card-body">
     <form method="post" action="">
       <div class="form-group">
         <label>Nama Produk</label>
         <Input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Masukkan nama produk" required>
       </div>
       <div class="form-group">
         <label>Keterangan</label>
         <textarea class="form-control" name="tket" placeholder="Masukkan deskripsi produk" required><?=@$vket?></textarea>
       </div>
       <div class="form-group">
         <label>Harga (Satuan)</label>
        <Input type="number" name="tharga" value="<?=@$vharga?>" class="form-control" placeholder="Masukkan harga produk" required>
       </div>
       <div class="form-group">
         <label>Jumlah</label>
         <Input type="number" name="tjumlah" value="<?=@$vjumlah?>" class="form-control" placeholder="Masukkan jumlah produk" required>
       </div>

       <button type="submit" class="btn btn-success" name="tambah_data">Tambah Data</button>
       <button type="reset" class="btn btn-danger" name="hapus_data">Hapus</button>
     </form>
   </div>
 </div>
<!--Akhir Card Form-->


<!--Awal Card Tabel-->
  <div class="card mt-3">
  <div class="card-header bg-primary text-white">
    Daftar Barang
  </div>
  <div class="card-body">
     <table class="table table-bordered table-striped">
     	<tr>
     		<th>No.</th>
     		<th>Nama Produk</th>
     		<th>Keterangan</th>
     		<th>Harga (Satuan)</th>
     		<th>Jumlah</th>
     		<th>Aksi</th>
     	</tr>
     	<?php 
     		$no= 1;
     		$tampil= mysqli_query($koneksi, "SELECT * from produk order by id_produk desc");
     		while ($data = mysqli_fetch_array($tampil)) :
     	?>

     	<tr>
     		<td><?=$no++;?></td>
     		<td><?=$data['nama_produk']?></td>
     		<td><?=$data['keterangan']?></td>
     		<td><?=$data['harga']?></td>
     		<td><?=$data['jumlah']?></td>
     		<td>
     			<a href="index.php?hal=edit&id=<?=$data['id_produk']?>" class="btn btn-warning">Edit</a>
     			<a href="index.php?hal=hapus&id=<?=$data['id_produk']?>" 
     			   onclick="return confirm ('Apakah Anda Yakin Ingin Menghapus Data Ini?')" class="btn btn-danger">Hapus</a>
     		</td>
     	</tr>
     	<?php endwhile; //penutup looping ?>
     </table>
  </div>
</div>
<!--Akhir Card Tabel-->

</div>


<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html> 