<?php

namespace App\Models;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Widget extends Model
{


    public function widgettype()
    {
        return $this->belongsTo(Widgettype::class);
    }
    public function getSupply()
    {

        $client = new Client();
        $url = Config::get('app.backend_server');
        $response = $client->get($url . '/supply');

        $supply = (string) $response->getBody();

        return (int) $supply;
    }
}
