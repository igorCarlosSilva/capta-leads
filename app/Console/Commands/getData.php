<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\captaleads;
use App\dadoslead;

use App\Http\Controllers\HttpRequest;
use DOMDocument;
use DOMXPath;

class getData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getdata:emails';

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
        $urls = captaleads::where('id','>','28577')->get();
        $request = new HttpRequest();

        foreach($urls as $url){
            
            echo "\n" . $url->id;
            
            $request->url = "http://mailing.ecommercebrasil.com.br".$url->url;
            $request->data = null;
            $request->headers = array(
                "Cookie: PHPSESSID=228tgdc24u0m9g9rd6f7g1ikj2"
            );
            $response = $request->post();

            libxml_use_internal_errors(true);

            
            $dom = new DOMDocument;
            $dom->loadHTML($response);
            $xpath = new DOMXPath($dom);
            
            foreach($xpath->query('//div[@class="pages"]') as $element){
                $thead['nome'] = (isset($element->getElementsByTagName('span')->item(0)->textContent)) ? $element->getElementsByTagName('span')->item(0)->textContent : '';
                $thead['email'] = (isset($element->getElementsByTagName('span')->item(1)->textContent)) ? $element->getElementsByTagName('span')->item(1)->textContent : '';
                $thead['sexo'] = (isset($element->getElementsByTagName('span')->item(2)->textContent)) ? $element->getElementsByTagName('span')->item(2)->textContent : '';
                $thead['telefone'] = (isset($element->getElementsByTagName('span')->item(3)->textContent)) ? $element->getElementsByTagName('span')->item(3)->textContent : '';
                $thead['cidade'] = (isset($element->getElementsByTagName('span')->item(4)->textContent)) ? $element->getElementsByTagName('span')->item(4)->textContent : '';
                $thead['estado'] = (isset($element->getElementsByTagName('span')->item(5)->textContent)) ? $element->getElementsByTagName('span')->item(5)->textContent : '';
                $thead['nomeempresa'] = (isset($element->getElementsByTagName('span')->item(6)->textContent)) ? $element->getElementsByTagName('span')->item(6)->textContent : '';
                $thead['cargo'] = (isset($element->getElementsByTagName('span')->item(7)->textContent)) ? $element->getElementsByTagName('span')->item(7)->textContent : '';
                $thead['origemcad'] = (isset($element->getElementsByTagName('span')->item(8)->textContent)) ? $element->getElementsByTagName('span')->item(8)->textContent : '';
                
                
                dadoslead::create($thead);
                
                
                /*$newEl = $element->removeChild($thead);
                $links=$element->getElementsByTagName('a');*/
                
                /*foreach($thead as $content){
                    echo $content->nodeValue;
                }*/

                /*foreach($links as $a) {
                    $arr['url'] = $a->getAttribute('href') ;

                    //captaleads::create($arr);

                    echo "\n .";
                }*/
            }
        }   
    }
}
