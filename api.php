<?php
    function API($method, $url, $data){
        $curl = curl_init();
        switch ($method){
           case "POST":
              curl_setopt($curl, CURLOPT_POST, 1);
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
              break;
           case "PUT":
              curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
              break;
           default:
              if ($data)
                 $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        
        $result = curl_exec($curl);
        
        if(!$result){ die("Connection Failure" ) ;}
        curl_close($curl);
        return $result;
     }

      // registrasi VA  
      //    $data_array =  array(
      //       "VirtualAccount"        => '151861010175112345',
      //       "Nama"                  => 'Amiruzzuhhad Gunes',
      //       "TotalTagihan"          => 5000000,
      //       "TanggalExp"            => "20220210",
      //       "Berita1"               => "Contoh tagihan pendakian 1",
      //       "Berita2"               => "",
      //       "Berita3"               => "",
      //       "Berita4"               => "",
      //       "Berita5"               => "",
      //       "FlagProses"            => "1"
      //    );

      //    $make_call = API('POST', 'https://jatimva.bankjatim.co.id/Va/RegPen', json_encode($data_array));
      //    $response = json_decode($make_call, true);
         
      //    var_dump(json_encode($response));

      // // Inquiry
      //    $data_array =  array(
      //       "VirtualAccount"        => '151861010175112345',
      //    );

      //    $make_call = API('POST', 'https://jatimva.bankjatim.co.id/Va/CheckStatus', json_encode($data_array));
      //    $response = json_decode($make_call, true);
         
      //    var_dump(json_encode($response));

      // // posting
      //    $data_array =  array(
      //       "VirtualAccount"    => "151861010175112345",
      //       "Amount"            => 5000000,
      //       "Reference"         => "000000000003",
      //       "Tanggal"           => date('Y-m-d H:i:s')
      //    );

      //    $make_call = API('POST', 'https://sipenerang.tahuraradensoerjo.or.id/posting.php', json_encode($data_array));
      //    $response = json_decode($make_call, true);
         
      //    var_dump(json_encode($response));
      //    echo 'aa';
?>