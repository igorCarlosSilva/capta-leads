<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\HttpRequest;
use DOMDocument;
use DOMXPath;
use App\captaleads;
class appController extends Controller
{
    public function index($page){

        $request = new HttpRequest();


            $request->url = "http://mailing.ecommercebrasil.com.br/cadastro/index?Cadastro_page=".$page."&ajax=cadastro-grid";
            $request->data = null;
            $request->headers = array(
                "Cookie: PHPSESSID=uvjd6j9oii5qk899peejkh8450"
            );
            $response = $request->post();

            libxml_use_internal_errors(true);

            $dom = new DOMDocument;
            $dom->loadHTML($response);
            $xpath = new DOMXPath($dom);

            foreach($xpath->query('//table[@class="items"]') as $element){
                $thead = $element->getElementsByTagName('thead')->item(0);
                $newEl = $element->removeChild($thead);
                $links=$element->getElementsByTagName('a');
                foreach($links as $a) {
                    $arr['url'] = $a->getAttribute('href');

                    captaleads::create($arr);
                    //echo $a->getAttribute('href').'<br>';
                }
            }


        /*if($page < 1211){
            $nextPage = $page + 1;
            echo $page;
            //sleep(60);
            //return redirect(route('next', ['page' => $nextPage]));

            echo "<script>setTimeout(function(){ window.location.href = '/getEmails/".$nextPage."' }, 2000)</script>";
        }else{
            echo "finished";
        }*/



    }

    public function getData(){
        $request = new HttpRequest();


        $request->url = "http://mailing.ecommercebrasil.com.br/cadastro/2293";
        $request->data = null;
        $request->headers = array(
            "Cookie: PHPSESSID=uvjd6j9oii5qk899peejkh8450"
        );
        $response = $request->post();

        echo $response;
        /*libxml_use_internal_errors(true);

        $dom = new DOMDocument;
        $dom->loadHTML($response);
        $xpath = new DOMXPath($dom);

        foreach($xpath->query('//table[@class="items"]') as $element){
            $thead = $element->getElementsByTagName('thead')->item(0);
            $newEl = $element->removeChild($thead);
            $links=$element->getElementsByTagName('a');
            foreach($links as $a) {
                $arr['url'] = $a->getAttribute('href');

                captaleads::create($arr);
                //echo $a->getAttribute('href').'<br>';
            }
        }*/

    }
}
