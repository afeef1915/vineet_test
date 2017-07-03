<?php

namespace Acme\Bundle\BitcoinBundle\Controller;

header('Access-Control-Allow-Origin: *');

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Cookie;
//use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request; //inheriting the Request class
use \DateTime;

class BitCoinApiController extends Controller {
    /* localbitcoin data buyer api */

    public function LocalBitcoinBuyAction() {
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type:         application/json'));
        curl_setopt($c, CURLOPT_URL, 'https://localbitcoins.com/buy-bitcoins-online/in/india/national-bank-transfer/.json');

        $data = curl_exec($c);
        curl_close($c);

        $obj = json_decode($data);
        $data = json_encode($obj);
        print_r($data);
        die;
    }
     public function LocalBitcoinSellAction() {
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type:         application/json'));
        curl_setopt($c, CURLOPT_URL, 'https://localbitcoins.com/sell-bitcoins-online/in/india/.json');

        $data = curl_exec($c);
        curl_close($c);

        $obj = json_decode($data);
        $data = json_encode($obj);
        print_r($data);
        die;
    }
    

}
