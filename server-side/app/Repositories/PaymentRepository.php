<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;

class PaymentRepository
{
    protected $config;

    public function __construct()
    {

    }

    public function vaPosting($request)
    {
        $data_callback = [
            "virtual_account"   => $request['VirtualAccount'],
            "amount"            => $request['Amount'],
            "reference"         => $request['Reference'],
            "tanggal"           => $request['Tanggal'],
        ];
        $send_json = json_encode($data_callback);
        $client   = new Client();
        $response = $client->request("GET", env('URL_SIPENERANG', 'https://tahurarsoerjo.dishut.jatimprov.go.id/sipenerang')."/api/callback-va.php?json=$send_json");
        $respon_sync = json_decode($response->getBody(), true);
        if ($respon_sync['error']){
            $respon = [
                'error' => true,
                'message' => $respon_sync['message'],
            ];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($respon);
            exit();
        }else{
            $respon = [
                "VirtualAccount"    => $request['VirtualAccount'] ?? "-",
                "Amount"            => $request['Amount'] ?? "-",
                "Tanggal"           => $request['Tanggal'] ?? "-",
                "Status"            => [
                    "IsError"       => false,
                    "ResponseCode"  => "00",
                    "ErrorDesc"     => "Success"
                ],
            ];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($respon);
            exit();
        }
    }

    public function PaymentQr($request)
    {
        $data_callback = [
            "pd_nomor"      => $request['billNumber'],
            "amount"        => $request['amount'],
            "tanggal"       => $request['transactionDate'],
        ];
        $send_json = json_encode($data_callback);
        $client   = new Client();
        $response = $client->request("GET", env('URL_SIPENERANG', 'https://tahurarsoerjo.dishut.jatimprov.go.id/sipenerang')."/api/callback-qris.php?json=$send_json");
        $respon_sync = json_decode($response->getBody(), true);
        if ($respon_sync['error']){
            $respon = [
                'error' => true,
                'message' => $respon_sync['message'],
            ];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($respon);
            exit();
        }else{
            $respon = [
                "responsCode"   => "00",
                "responsDesc"   => "Success",
                "billNumber"    => $request['billNumber'],
                "purposetrx"    => $request['purposetrx'],
                "storelabel"    => $request['storelabel'],
                "customerlabel" => $request['customerlabel'],
                "terminalUser"  => $request['terminalUser'],
                "amount"        => $request['amount'],
                "core_reference"    => $request['core_reference'],
                "customerPan"   => $request['customerPan'],
                "merchantPan"   => $request['merchantPan'],
                "pjsp"          => $request['pjsp'],
                "invoice_number"    => $request['invoice_number'],
                "transactionDate"   => $request['transactionDate'],
            ];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($respon);
            exit();
        }
    }
}
