<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Controllers\HttpRequest;

use DOMDocument;
use DOMXPath;
use App\captaleads;

class getUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:urls';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $request = new HttpRequest();
        $continue = 1;
        $j = 1;

        while($j == 1){
            $request->url = "http://mailing.ecommercebrasil.com.br/cadastro/index?Cadastro_page=".$continue."&ajax=cadastro-grid";
            $request->data = null;
            $request->headers = array(
                "Cookie: PHPSESSID=c89lj4p6n9n8uv42acidtghj07"
            );
            $response = $request->post();

            libxml_use_internal_errors(true);



            $dom = new DOMDocument;
            $dom->loadHTML($response);
            $xpath = new DOMXPath($dom);

            foreach($xpath->query('//span[@class="empty"]') as $element) {

                if($element->nodeValue == "Nenhum resultado encontrado."){
                    $j == 2;

                    return;
                }
            }

            foreach($xpath->query('//table[@class="items"]') as $element){
                $thead = $element->getElementsByTagName('thead')->item(0);
                $newEl = $element->removeChild($thead);
                $links=$element->getElementsByTagName('a');


                foreach($links as $a) {
                    $arr['url'] = $a->getAttribute('href') ;

                    captaleads::create($arr);

                    echo '.';
                }
                $continue++;
            }

        }


    }
}
