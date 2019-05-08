<?php

namespace App\Http\Requesters;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;

class LiquidRequester
{
  private $client;
  
  public function __construct(){
      $this->client = new Client([
          'base_uri' => "https://api.liquid.com",
        ]);
  }

  private function public_get_request($path){

        $response = $this->client->request('GET', $path,
            [
                'allow_redirects' => true,
            ]);
        return $response_body = (string) $response->getBody();
  }
  
  private function sign($path){
      $auth_payload = [
          'path' => $path,
          'nonce' => time(),
          'token_id' => config('liquidtoken.token_id')
      ];
      
      $signature = JWT::encode($auth_payload, config('liquidtoken.secret_key'));
      return $signature;
  }
  
  private function authenticated_request($path, $body_json, $http_method){
      $headers = [
          'X-Quoine-API-Version' => '2',
          'X-Quoine-Auth' => $this->sign($path),
          'Content-Type' => 'application/json',
      ];
      $response;
      switch($http_method){
          case 'POST':
          case 'PUT':
            $response = $this->client->request($http_method, $path, [
              'headers' => $headers,
              'body' => $body_json
            ]);
            break;
          case 'GET':
            $response = $this->client->request($http_method, $path, [
              'headers' => $headers
            ]);
      }
      return $response_body = (string) $response->getBody();
  }

  public function get_products(){
      return $this->public_get_request('/products');
  }

  public function get_orders($funding_currency = null, $product_id = null, $status = null, $with_details = null){
      $path = '/orders';
      $params = '';
      if($funding_currency != null){
          if($params == ''){
              $params .= '?';
          }
          $params .= 'funding_currency=' . $funding_currency;
      }
      if($product_id != null){
          if($params == ''){
              $params .= '?';
          }else{
              $params .= '&';
          }
          $params .= 'product_id=' . $product_id;
      }
      if($status != null){
          if($params == ''){
              $params .= '?';
          }else{
              $params .= '&';
          }
          $params .= 'status=' . $status;
      }
      if($with_details != null){
          if($params == ''){
              $params .= '?';
          }else{
              $params .= '&';
          }
          $params .= 'with_details=' . $with_details;
      }
      if($params != ''){
          $path .= $params;
      }
      return $this->authenticated_request($path,null,'GET');
  }
  
  public function get_order_by_id($id){
      $path = '/orders/' . $id;
      return $this->authenticated_request($path,null,'GET');
  }

  public function get_fiat_accounts(){
      $path = '/fiat_accounts';
      return $this->authenticated_request($path,null,'GET');
  }
  
  public function create_order($order_type, $product_id, $side, $quantity, $price, $price_range = null){
      $path = '/orders/';
      $params = [
          'order_type' => $order_type,
          'product_id' => $product_id,
          'side' => $side,
          'quantity' => $quantity,
          'price' => $price,
          ];
      if($order_type == 'market_with_range'){
          $params['price_range'] = $price_range;
      }
      
      return $this->authenticated_request($path,json_encode($params),'POST');      
  }
  
  public function create_fiat_account($currency){
      $path = '/fiat_accounts';
      $params = [
          'currency' => $currency
          ];
      return $this->authenticated_request($path,json_encode($params),'POST');
  }
  
  public function cancel_order($id){
      $path = '/orders/' .$id . '/cancel';
      return $this -> authenticated_request($path, null, 'PUT');
  }
}
