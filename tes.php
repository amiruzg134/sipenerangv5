<?php
	include 'config.php';
	include 'api.php';
	require 'PHPMailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;

	$query = mysqli_query($conn, "SELECT * FROM tb_pendakian WHERE pd_status = 'menunggu verifikasi' and sts_bayar = 'unpaid' LIMIT 1 ");

	while ($row = mysqli_fetch_array($query)) {

		$dataVa =  array(
	        "VirtualAccount"        => $row['va']
	    );
	    $make_call = API('POST', 'https://jatimva.bankjatim.co.id/Va/CheckStatus', json_encode($dataVa));
	    $response = json_decode($make_call, true);

	    $date = date('Y-m-d H:i:s');

		if ($response['FlagLunas'] == 'Y') {
			mysqli_query($conn, "UPDATE tb_pendakian SET pd_status = 'disetujui', sts_bayar = 'paid', pd_acc_by = '1', tgl_bayar = '$date' WHERE pd_id = '$row[pd_id]' ");
			// echo $row['pd_nama_ketua'];

			// Konfigurasi SMTP
		    $mail->SMTPDebug = 0;  
		    $mail->isSMTP();
	        $mail->Host = 'smtp.gmail.com';
	        $mail->SMTPAuth = true;
	        $mail->Username = 'tahuraradensoerjo@gmail.com';
	        $mail->Password = 'feirfifqucxcjspu';
	        $mail->SMTPSecure = 'TLS';
	        $mail->Port = 587;

		    $mail->setFrom('tahurarsoerjo.dishut@jatimprov.go.id', 'UPT Tahura Raden Soerjo');

		    // Menambahkan penerima
		    $mail->addAddress($row['pd_email'], $row['pd_nama_ketua']);

		    // Mengatur format email ke HTML
		    $mail->isHTML(true);

		    // Load file content.php
		    ob_start();
		    include "admin/main/emailberhasil.php";
		    $content = ob_get_contents(); // Ambil isi file content.php dan masukan ke variabel $content

		    ob_end_clean();

		    if ($row['keterangan'] == 'arjuno') {
		    	$mail->addStringAttachment(file_get_contents("http://$_SERVER[HTTP_HOST]/sipenerang/berkas_arjuno.php?id=".$row['pd_id']), 'e-Simaksi.pdf');
		    }
		    elseif ($row['keterangan'] == 'pundak') {
		    	$mail->addStringAttachment(file_get_contents("http://$_SERVER[HTTP_HOST]/sipenerang/berkas_pundak.php?id=".$row['pd_id']), 'e-Simaksi.pdf');
		    }

		    // Konten/isi email
		    $mail->Subject = 'Booking Online e-Simaksi UPT Tahura Raden Soerjo';
		    $mail->Body    = $content;

		    $mail->send();

			$token    = "W2mfmQtXghGtURt@b0##";
			$target   = $row['pd_no_hp'];
			$message  = 
		'
*BOOKING TELAH DISETUJUI*


Kode booking : '.$row['pd_nomor'].'
Nama ketua : '.$row['pd_nama_ketua'].'
Tujuan : '.$row['keterangan'].'
Tanggal naik : '.date('d-m-Y', strtotime($row['pd_tgl_naik'])).'
Tanggal turun : '.date('d-m-Y', strtotime($row['pd_tgl_turun'])).'


Harap diperhatikan untuk setiap pendaki :
- Mencetak atau menunjukkan berkas eSimaksi 
- Membawa KTP/KTM/SIM/Paspor yang masih berlaku
- Surat keterangan sehat khusus pendakian G. Arjuno - Welirang
- Membawa trash bag/kantong sampah
- Untuk mengurangi sampah plastik, pendaki dihimbau untuk membawa persediaan air dengan jurigen lipat.


UPT Tahura Raden Soerjo 
Dinas Kehutanan Provinsi Jawa Timur

_pesan dikirim otomatis oleh sistem_
        ';

            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.fonnte.com/send',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => array(
                'target' => $target,
                'message' => $message,
              ),
              CURLOPT_HTTPHEADER => array(
                "Authorization: $token"
              ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            echo $response;
		}

		elseif ($response['FlagLunas'] == 'N') {
			mysqli_query($conn, "UPDATE tb_pendakian SET pd_status = 'ditolak', sts_bayar = 'unpaid', pd_acc_by = '1' WHERE pd_id = '$row[pd_id]' ");

			$token    = "W2mfmQtXghGtURt@b0##";
			$target   = $row['pd_no_hp'];
			$message  = 
		'
*BOOKING DITOLAK*


Kode booking : '.$row['pd_nomor'].'

Alasan : Pembayaran tidak berhasil.


UPT Tahura Raden Soerjo 
Dinas Kehutanan Provinsi Jawa Timur

_pesan dikirim otomatis oleh sistem_
        ';

            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.fonnte.com/send',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => array(
                'target' => $target,
                'message' => $message,
              ),
              CURLOPT_HTTPHEADER => array(
                "Authorization: $token"
              ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            echo $response;
		}

	}

	// $dataVa =  array(
	//         "VirtualAccount"        => '151861010595092939'
	//     );
	//     $make_call = API('POST', 'https://jatimva.bankjatim.co.id/Va/CheckStatus', json_encode($dataVa));
	//     $response = json_decode($make_call, true);


	//    var_dump(json_encode($response))
	
?>