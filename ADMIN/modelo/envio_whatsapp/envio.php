<?php

require 'vendor/autoload.php';

class whatsapp
{
  function enviar_mensaje($sms){
    $token =  "GA230521082419";
    $client = new GuzzleHttp\Client(['verify' => false]);

    $payload = array(
      "op" => "registermessage",
      "token_qr" => $token,
      "mensajes" => $sms
    );

    $res = $client->request('POST', 'https://script.google.com/macros/s/AKfycbyoBhxuklU5D3LTguTcYAS85klwFINHxxd-FroauC4CmFVvS0ua/exec', [
      'headers' => [
        'Content-Type'     => 'application/json',
        'Accept' => 'application/json'
      ], 'json' =>  $payload
    ]);

    echo $res->getStatusCode() . "<br>";
    echo $res->getBody();
  }
}
