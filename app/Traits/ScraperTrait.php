<?php

namespace App\Traits;
use Carbon\Carbon;

use Goutte\Client;

use App\Models\Kurs;
use App\Models\Icp;
use App\Models\Hba;

trait ScraperTrait
{
    /**
     * Send a JSON response with success message.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $status
     * @return \Illuminate\Http\JsonResponse
     */

    public function genscraper(){
        $this->genicp();
        $this->genhba();
        $this->genkurs();
    }

     public function genicp()
     {
         $client = new Client();
         
         $website = $client->request('GET', 'https://www.esdm.go.id/en/media-center/news-archives/february-icp-set-at-usd9572-per-barrel');
         $data = $website->filter('h4')->each(function ($node) {
             return $node->text();
         });
         $arr = explode(" ",$data[0]);
         $keyword = "USD";
         $icp = "";
         foreach($arr as $index => $string) {
             if (strpos($string, $keyword) !== FALSE){
                 $icp = $string;
             }
         }
 
         list($us,$icpvalue)=explode("D",$icp);
 
         $insert = array(
             "month_name" => date("F"),
             "month"      => date("m"),
             "year"       => date("Y"),
             "icp"        => $icpvalue,
             "icpusd"     => $icp,
             "fulltext"   => $data[0],
             "date"       => date("Y-m-d")        
         );
 
         Icp::create($insert);
         return response()->json($insert);
     }
 
     public function genhba()
     {
         $client = new Client();
 
         $website = $client->request('GET', 'https://www.minerba.esdm.go.id/harga_acuan');
       
         $table = $website->filter('table')->filter('tr')->each(function ($tr, $i) {
             return $tr->filter('td')->each(function ($td, $i) {
                 return $td->text();
             });
         });
         $total_rows = count($table[1]);
         $hba = $table[1][$total_rows-1];
         $insert = array(
             "month_name" => date("F"),
             "month"      => date("m"),
             "year"       => date("Y"),
             "hba"        => $hba    
         );
 
         Hba::create($insert);
 
         return response()->json($insert);
     }
 
     public function genkurs()
     {
         $client = new Client();
 
         $website = $client->request('GET', 'https://www.bi.go.id/id/statistik/informasi-kurs/transaksi-bi/Default.aspx');
       
         $table = $website->filter('table')->filter('tr')->each(function ($tr, $i) {
             return $tr->filter('td')->each(function ($td, $i) {
                 return $td->text();
             });
         });
 
         $mata_uang = preg_replace('/\s+/', '', $table[50][0]);
         $jual = preg_replace('/\s+/', '', str_replace(".","",$table[50][2]));
         $beli = preg_replace('/\s+/', '', str_replace(".","",$table[50][3]));
         
         $kurs_jual = preg_replace('/\s+/', '', str_replace(",",".",$jual));
         $kurs_beli = preg_replace('/\s+/', '', str_replace(",",".",$beli));
         $total = (float) $kurs_jual+ (float)$kurs_beli;
         $kurs_tengah = $total/2;
         $insert = array(
             "currency" => $mata_uang,
             "rate"     => $kurs_jual,
             "kurs_jual" => $kurs_jual,
             "kurs_beli" => $kurs_beli,
             "kurs_tengah" => $kurs_tengah,
             "date"       => date("Y-m-d H:i:s")
         );
 
         Kurs::create($insert);
         return response()->json($insert);
         
     }
 


}
