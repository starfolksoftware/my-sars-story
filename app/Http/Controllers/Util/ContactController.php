<?php

namespace App\Http\Controllers\Util;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Mail;
use App\Models\Util\CurrentTenant;

class ContactController extends Controller
{
  /**
    *
    * @return \Illuminate\Http\Response
    */
  public function __invoke(Request $request): JsonResponse {
    $currentTenant = new CurrentTenant();
    $platform = $currentTenant->getPlatform();
    $platformEmail = $platform->email;

    $data = [
      'first_name' => request('first_name'),
      'last_name' => request('last_name'),
      'email' => request('email'),
      'phone_number' => request('phone_number'),
      'messagex' => request('message')
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'first_name' => 'required',
      'last_name' => 'required',
      'email' => 'required',
      'phone_number' => 'required',
      'messagex' => 'required'
    ], $messages)->validate();

    if (filter_var($platformEmail, FILTER_VALIDATE_EMAIL)) {
      Mail::send('mail.contact', $data, function ($message) use ($data, $platformEmail) {
        $message->from(env('MAIL_FROM_ADDRESS'), $data['first_name']. ' ' .$data['last_name']);
        $message->to($platformEmail, env('APP_NAME') . ' - Contact')
          ->subject($data['first_name']. ' ' .$data['last_name']. ' - New Message From Contact Us Page');
      });

      return response()->json(["success" => 1, "message" => "message sent"], 200);
    }

    return response()->json(["success" => 0, "message" => "message not sent"], 500);
  }
}
