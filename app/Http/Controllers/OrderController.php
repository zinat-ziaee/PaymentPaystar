<?php

namespace App\Http\Controllers;

use GuzzleHttp\Pool;
use App\Models\Order;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function createPayment()
    {
      $client = new Client();

      $headers = [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer 0yovdk2l6e143'
      ];

      $body = [
        "card_number"=>Auth()->user()->card_number,
        "amount"=> 10000,
        "order_id"=> "123456",
        "callback"=> route('payment.callback'),
        "sign"=> "108ab24828a43f30573d682bcc7d9525187dd4ff6f9b022f527b4510c53f0636b12df0faba225b87b0ac23e8975a3fe82c4c57d6ce2cfc0420cdb8b1084f5302"
       ];

      $request = new GuzzleRequest('POST', 'https://core.paystar.ir/api/pardakht/create', $headers, json_encode($body));
      $res = $client->sendAsync($request)->wait();
      $responseData = json_decode($res->getBody(), true);

      $token = $responseData['data']['token'];
      $ref_num = $responseData['data']['ref_num'];
      $refSave=Order::firstOrNew([
        'user_id'=>auth()->user()->id,
        'status'=>'',
        'tracking_code'=>'',
        'ref_num'=>$ref_num
      ]);
      $refSave->save();

      echo $ref_num;

      return view('complete_buy',['token'=>$token]);
    }

    public function callbackPayment(Request $request){
      dd($request->input());
      $client = new Client();
      $headers = [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer 0yovdk2l6e143'
      ];
      // $string = 10000."#".$request->input('ref_num')."#"."6037701147303793"."#".$request->input('tracking_code');
      // $sign = hash_hmac("sha512",$string,"9A3EC03483556C73714510C507529DF70A1228C83477D1455E0511BD72C5AAB8A6715A414AA48B7C905FCEF45868BD26DA58196EF29C77C194C9F14A4B47456CC6454E9D50B388D6FC5AC91BB08B234A8060FDC85B1CEC32CA036DC907F8A4A635D9CBB9CAA31B42549B8D70B2CE5EDE8274FFB55DABFE92D76BC42D91696FAF");
      $body = [
        "ref_num"=> $request->input('ref_num'),
        "amount"=> 10000,
        "sign"=> "6df5543c70bda801bd5b5b696d063775521a89b014c48adbdf19af9f4dfca0261449759bc356d10a609ab6485a19e1ddba7b14c3055b4fa13132d2d4053c7a9f"
      ];
      $request = new GuzzleRequest('POST', 'https://core.paystar.ir/api/pardakht/verify', $headers, json_encode($body));
      $res = $client->sendAsync($request)->wait();
      $responseData = json_decode($res->getBody(), true);
      echo $responseData;
      // return view('callback');
    }
}
