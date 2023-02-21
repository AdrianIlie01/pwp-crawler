<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use DOMDocument;
use DOMXPath;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ScrapingController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function scraping() {

        try {
            $url = "https://www.emag.ro/";
//            $ch = curl_init();
//            curl_setopt ($ch, CURLOPT_URL, $url);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $timeout=5;
            $fp = fopen('emag', 'w');
            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt( $ch, CURLOPT_ENCODING, "" );
            curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
            curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
            curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );

            $response = curl_exec($ch);
            fclose($fp);

            curl_close($ch);
//            var_dump($response);


            $dom = new domDocument;

            @$dom->loadHTMLFile('emag');

            $xpath = new DOMXPath($dom);

            $className = "megamenu-list-department js-megamenu-list-department";
            $results = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $className ')]");

            var_dump($results->length);
            var_dump(trim($results[0]->nodeValue));

            $count = 0;
            for ( $i=0; $i<$results->length; $i++) {
                        $count++;
//                echo $count;
                        $category = new Categories();
                        $category->name = trim($results[$i]->nodeValue);
                        if (Categories::where('name', trim($results[$i]->nodeValue))->first()) {
                            echo 'already exists ';
//                    return 0;
                }
                $category->save();
            }

// 2
//            $classname = "megamenu-details-department-title";
//            $ulResult = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
//
//            var_dump($ulResult->length);
//
//            for ( $i=0; $i<$ulResult->length; $i++) {
//
//                $category = new Categories();
//                $category->name = trim($ulResult[$i]->textContent);
//                if (Categories::where('name', trim($ulResult[$i]->textContent))->first()) {
//                    echo 'already exists ';
////                    return 0;
//                }
//                $category->save();
//            }

            $class1 = "megamenu-details-department-items";
            $subcategory = $xpath->query("//div[contains(concat(' ', normalize-space(@class), ' '), ' $class1 ')]");

            var_dump($subcategory->length);
            var_dump($subcategory[0]);
            var_dump($subcategory[1]);
            var_dump($subcategory[11]);

//            foreach ($navResult as $outerDiv) {
//                $class2 = "megamenu-column";
//                $innerUl = $xpath->query("//li[contains(concat(' ', normalize-space(@class), ' '), ' $class2 ')]");
//
//                var_dump("INNER UL");
//                var_dump($innerUl->length);
//                var_dump($innerUl);
//
//            }

//            for ( $i=0; $i<$navResult->length; $i++) {
//
//                $category = new Categories();
//                $category->name = trim($navResult[$i]->textContent);
//                if (Categories::where('name', trim($navResult[$i]->textContent))->first()) {
//                    echo 'already exists ';
////                    return 0;
//                }
//                $category->save();
//            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}
