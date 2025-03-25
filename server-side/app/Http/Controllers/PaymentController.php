<?php
namespace App\Http\Controllers;

use App\Repositories\PaymentRepository;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    protected $paymentRepository;
    use ApiResponser;

    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function va_posting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'VirtualAccount'    => 'required',
            'Amount'            => 'required',
            'Reference'         => 'nullable',
            'Tanggal'           => 'required',
        ]);

        if ($validator->fails()) {
            $respon = [
                "VirtualAccount"    => $request['VirtualAccount'] ?? "-",
                "Amount"            => $request['Amount'] ?? "-",
                "Tanggal"           => $request['Tanggal'] ?? "-",
                "Status"            => [
                    "IsError"       => true,
                    "ResponseCode"  => 12,
                    "ErrorDesc"     => $validator->errors()->first()
                ],
            ];
            return $respon;
        }

        return $this->paymentRepository->vaPosting($validator->validate());
    }


    public function payment_qr(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'billNumber'        => 'required',
            'purposetrx'        => 'string|nullable',
            'storelabel'        => 'string|nullable',
            'customerlabel'     => 'string|nullable',
            'terminalUser'      => 'string|nullable',
            'amount'            => 'required|string',
            'core_reference'    => 'string|nullable',
            'customerPan'       => 'string|nullable',
            'merchantPan'       => 'string|nullable',
            'pjsp'              => 'string|nullable',
            'invoice_number'    => 'string|nullable',
            'transactionDate'   => 'string|nullable',
        ]);

        if ($validator->fails()) {
            $respon = [
                "IsError"       => true,
                "ResponseCode"  => 412,
                "ErrorDesc"     => $validator->errors()->first()
            ];
            return $respon;
        }

        return $this->paymentRepository->PaymentQr($validator->validate());
    }

}
