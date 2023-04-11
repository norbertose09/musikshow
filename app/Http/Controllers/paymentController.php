<?php

namespace App\Http\Controllers;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Http\Request;
use App\Models\Payment;

class paymentController extends Controller
{
    public function index(){
        return view('pages.index');
    }

    public function callBack(){
         $response = json_decode($this->verifyPayment(request('reference')));
        if($response){
            if($response->status){
                $data = $response->data;
                // console.log($data);
             return view('pages.callback')->with(compact(['data']));

            }
            else {
                return back()->withError($response->message);
            }
        }

        else {
            return back()->withError("something is wrong");
        }
      
    }

    public function makePayment(Request $request){
        $formData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            
        ]);
        Payment::create($formData);

        $formData2 = [
            'name' => request('name'),
            'email' => request('email'),
            'number' => request('phone_number'),
            'amount' => '4000' *100,
            'callback_url' => route('pages.callback')
        ];

        $pay = json_decode($this->initiatePayment($formData2));

        if($pay){
            if($pay->status){
                return redirect($pay->data->authorization_url);
              }
  
              else {
                  return back()->withError($pay->message);
              }

        }
        else{
            return back()->withError("Something is wrong");
        }
    }

    public function initiatePayment($formData2){
        $url = 'https://api.paystack.co/transaction/initialize';

        $fieldString = http_build_query($formData2);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldString);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer sk_test_11a1a9af957a0c0432437224fe37952981aa6030",
            "Cache-Control: no-cache"
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;

    }
    public function verifyPayment($reference){
        $curl= curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verif21=y/$reference",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer sk_test_11a1a9af957a0c0432437224fe37952981aa6030",
            "Cache-Control: no-cache"
            )
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            return $response;
    }

             public function sendTicket(){
             $formEmail = [
             $email = request('email')];
             require 'PHPMailer/vendor/autoload.php';
             $mail = new PHPMailer(true);
             $mail->isSMTP();
             $mail->SMTPDebug = 0;
             $mail->Host = 'smtp.gmail.com';
             $mail->SMTPAuth = true;
             $mail->Username = 'norbert99301@gmail.com';
             $mail->Password = 'ubupjwwruwxjttha';
             $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
             $mail->Port = 587;
             $mail->setFrom('The Fela Show');
             $mail->addAddress($email);
             $mail->isHTML(true);
             $mail->Subject = 'Your Ticket ID';
             $ticketID = rand(000000000000, 999999999999);
             $message = 'Hello there, this is your ticket ID, please do not share, it would be needed on entering the venue of the concert'.$ticketID;
             $mail->Body = $message;
             $mail->send();
    }

}
