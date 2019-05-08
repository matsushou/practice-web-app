<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requesters\LiquidRequester;

class LiquidApiController extends Controller
{

  private $requester;
  
  public function __construct(){
      $this->requester = new LiquidRequester();
  }

    public function index () 
    {

        $requester->cancel_order(1027277701);
        // $requester->get_fiat_accounts();
        // $requester->get_order_by_id(689869887);
        // $requester->get_orders(null,5);
        // $requester->create_fiat_account('USD');
        return view('liquid_api');
    }
    
    public function get_products()
    {
        return $this->requester->get_products();
    }
}
