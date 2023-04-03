<?php

namespace App\Http\Controllers;

use App\Models\Announces;
use App\Models\Categories;
use App\Models\CategoryLinks;
use App\Models\Images;
use App\Models\Owner;
use DOMDocument;
use DOMXPath;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CrawlerController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function crawler() {

        try {


//            $url = "https://www.olx.ro/";
////            $ch = curl_init(); // $ch = curl_init($url);
////            curl_setopt ($ch, CURLOPT_URL, $url);
////            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // => return type = string
//
//            $timeout=5;
//            $fp = fopen('olx', 'w');
//            $ch = curl_init($url);
//
//            curl_setopt($ch, CURLOPT_FILE, $fp);
//            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
//            curl_setopt( $ch, CURLOPT_ENCODING, "" );
//            curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
//            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
//            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
//            curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
//            curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
//
//            $response = curl_exec($ch);
//            fclose($fp);
//            curl_close($ch);
//
//            $respCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//            var_dump($respCode); // return the last response code
//            var_dump(curl_getinfo($ch, CURLINFO_PRIMARY_IP));

            $dom = new domDocument;

//            @$dom->loadHTML($response);

            @$dom->loadHTMLFile('olx');
            $element = $dom->getElementsByTagName('maincategories-list');
//            var_dump($element);

//            echo 'title';
            $title = $dom->saveHtml($element[0]);
//            var_dump($title);

            $xpath = new DOMXPath($dom);
            $classname = "maincategories-list clr";
            $results = $xpath->query("//div[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");


            $divClass = "subcategories-list clr";
            $spanClass = "link block category-name";
            $divSubcategory = $xpath->query("//div[contains(concat(' ', normalize-space(@class), ' '), ' $divClass ')]");
//            $spanSubactegories = $xpath->query("//span[contains(concat(' ', normalize-space(@class), ' '), ' $spanName ')]");
            var_dump('SUBCATEGORIES');
            var_dump($divSubcategory->length);

            for ($i=1; $i<$divSubcategory->length; $i++) {

                $categoryClass = "subcategories-title";
                $category = $xpath->query("div[contains(concat(' ', normalize-space(@class), ' '), ' $categoryClass ')]/text()", $divSubcategory[$i]);

                $categoryName = trim(str_replace('în','',trim($category[2]->textContent)));
                var_dump($categoryName);
                var_dump(strlen($categoryName));

                if (strlen($categoryName) > 0) {
                    $category = new Categories();
                    $category->name = $categoryName;

                    if (Categories::where('name', $categoryName)->first()) {
                        echo 'C already exists <br>';
                    } else {
                        $category->save();
                        $savedCategory = Categories::where('name', $categoryName)->first();

                        echo 'INCEPUT SUBBBBBCATWGORIED <br>';
                    }
                }
                $spanSubcategory = $xpath->query("ul/li/a/span[contains(concat(' ', normalize-space(@class), ' '), ' $spanClass ')]/span", $divSubcategory[$i]);

                if ($spanSubcategory->length > 0)
                {
                    for ($j=0; $j<$spanSubcategory->length; $j++)
                    {
                        if (strlen(trim($spanSubcategory[$j]->textContent)) !== 0)
                        {
                            var_dump('SUBCATEGIRIESS <br>');
                        var_dump(trim($spanSubcategory[$j]->textContent));
                        $subcategoryName = trim($spanSubcategory[$j]->textContent);

                        if (Categories::where('name', $subcategoryName)->first()) {
                            echo 'S already exists <br>';
                        } else {

                            $subcategory = new Categories();
                            $subcategory->name = $subcategoryName;
                            $subcategory->save();
                        }

                            $savedCategory = Categories::where('name', $categoryName)->first();
                            $savedSubcategory = Categories::where('name', $subcategoryName)->first();

                        if (CategoryLinks::where('category_id', $savedSubcategory->id)->first()) {
                            echo 'subcategory already saved in category_links';
                        } else {
                            $categoryLink = new CategoryLinks();
                            $categoryLink->category_id = $savedSubcategory->id;
                            $categoryLink->parent_id = $savedCategory->id;
                            $categoryLink->save();
                        }
                        }
                    }
                }


            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function dropDown() {
        try {
//            $url = 'https://www.olx.ro/auto-masini-moto-ambarcatiuni/autoturisme/';
//            $timeout=5;
//            $fp = fopen('caroserie', 'w');
//            $ch = curl_init($url);
//
//            curl_setopt($ch, CURLOPT_FILE, $fp);
//            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
//            curl_setopt( $ch, CURLOPT_ENCODING, "" );
//            curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
//            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
//            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
//            curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
//            curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
//
//            curl_exec($ch);
//            fclose($fp);
//            curl_close($ch);


            $dom10 = new domDocument;
            @$dom10->loadHTMLFile('caroserie');

            $xpath = new DOMXPath($dom10);

            $bodyCarName = 'css-1odrruv';
            $bodyCars = $xpath->query("//div[contains(concat(' ', normalize-space(@class), ' '), ' $bodyCarName ')]/div/label/p/text()");

            $categName = 'css-t3rokz er34gjf0';
            $categ = $xpath->query("//p[contains(concat(' ', normalize-space(@class), ' '), ' $categName ')]/text()");

            $parentCategoryName = $categ[0]->textContent;
            var_dump($parentCategoryName);

            foreach ($bodyCars as $bodyCar) {
                if ($bodyCar->textContent === 'Vezi toate') {
                    echo 'vezi toate not good';
                }
                else {
                    var_dump($bodyCar->textContent);
                    $categoryName = trim($bodyCar->textContent);

                    if (!Categories::where('name',$categoryName)->first()) {
                        echo 'categ nu exista in bd';
                        $category = new Categories();
                        $category->name = $categoryName;
                        $category->save();
                    }
                    $categoryDB = Categories::where('name',$categoryName)->first();
                    $parentCategory = Categories::where('name',$parentCategoryName)->first();
                    var_dump($parentCategory->name);
                    if (!CategoryLinks::where('category_id',$categoryDB->id)->first()){
                        echo 'CATEGLINKS DOSENT EXISTs';
                        $categoryLinks = new CategoryLinks();
                        $categoryLinks->category_id =$categoryDB->id;
                        $categoryLinks->parent_id = $parentCategory->id;
                        $categoryLinks->save();
                    }

                }
            }


        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function announces()
    {
        try {
            $url = "https://www.olx.ro/auto-masini-moto-ambarcatiuni/autoturisme/";
//            $timeout=5;
//            $fp = fopen('auto', 'w');
//            $ch = curl_init($url);
//
//            curl_setopt($ch, CURLOPT_FILE, $fp);
//            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
//            curl_setopt( $ch, CURLOPT_ENCODING, "" );
//            curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
//            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
//            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
//            curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
//            curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
//
//            curl_exec($ch);
//            fclose($fp);
//            curl_close($ch);

            $dom10 = new domDocument;
            @$dom10->loadHTMLFile('auto');

            $xpath = new DOMXPath($dom10);

            $autoCategName = 'css-c5h5gn';
            $autoCateg = $xpath->query("//div[contains(concat(' ', normalize-space(@class), ' '), ' $autoCategName ')]/div/div/p/text()");

            $categName = 'css-1a9sj2a';
            $categUrl = $xpath->query("//div[contains(concat(' ', normalize-space(@class), ' '), ' $categName ')]");


            $divButton = $xpath->query("//div[@data-testid='flyout-toggle']");

            $event = 'css-1ee1qo5';
            $elements = $xpath->query("//div[@class='css-1wg12ds'][preceding-sibling::*[@onclick]]");
            $elementsDrop = $xpath->query("//select[@onclick]");


            $linksParentName = trim($categUrl[0]->textContent);
            var_dump($linksParentName);

            for ($i = 1; $i < 8; $i++) {
                $categoryName = trim($autoCateg[$i]->textContent);
                var_dump($categoryName);

//                if (Categories::where('name', $categoryName)->first()) {
//                    echo 'C already exists <br>';
//                    var_dump(Categories::where('name', $categoryName)->first()->name);
//                    $this->dropDown($categoryName);
//                } else {
//                    $dbCategory = new Categories();
//                    $dbCategory->name = $categoryName;
//                    $dbCategory->save();
//
//                }
                $category = Categories::where('name', $categoryName)->first();
                $linksParent = Categories::where('name', $linksParentName)->first();

                if (CategoryLinks::where('category_id', $category->id)->first()) {
                    echo 'subcategory already saved in category_links';
                } else {
                    $categoryLink = new CategoryLinks();
                    $categoryLink->category_id = $category->id;
                    $categoryLink->parent_id = $linksParent->id;
                    $categoryLink->save();
                }
            }

            // 10 announces
            $class10 = "css-oukcj3";
            $results = $xpath->query("//div[contains(concat(' ', normalize-space(@class), ' '), ' $class10 ')]");

            $linkClass = 'css-rc5s2u';
            $links = $xpath->query("div/a[contains(concat(' ', normalize-space(@class), ' '), ' $linkClass ')]/attribute::href", $results[0]);


            $files = glob("/var/www/public/announce_*");
            $totalLength = 0;
            foreach ($files as $file) {
                $totalLength++ ;
            }

            var_dump('total');
            var_dump($totalLength);

            for ($j = 0; $j < 10; $j++) {

                $href = $links[$j]->value;
                var_dump($href);

                if (str_contains($href, 'https')){
//                    $announceUrl = $href;
//
//                    $timeout=5;
//                    $fa = fopen('announce_'.$j, 'w');
//                    $ch = curl_init($announceUrl);
//
//                    curl_setopt($ch, CURLOPT_FILE, $fa);
//                    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
//                    curl_setopt( $ch, CURLOPT_ENCODING, "" );
//                    curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
//                    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
//                    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
//                    curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
//                    curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
//
//                $response = curl_exec($ch);
//                fclose($fa);
//                curl_close($ch);

                    echo 'autovit...';
                    echo $j;
                    continue;
                } else {
                    $href = 'https://www.olx.ro'.$href;
                    var_dump($href);
//
//                    $timeout=5;
//                    $fa = fopen('announce_'.$j, 'w');
//
//                    $announceUrl = $href;
//                    $ch = curl_init($announceUrl);
//
//                    curl_setopt($ch, CURLOPT_FILE, $fa);
//                    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
//                    curl_setopt( $ch, CURLOPT_ENCODING, "" );
//                    curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
//                    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
//                    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
//                    curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
//                    curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
//
//                    $response = curl_exec($ch);
//                    fclose($fa);
//                    curl_close($ch);

                }
            }


//announce
            for ($i = 0; $i < 10 ; $i++) {

                $dom = new DOMDocument();

                if ((@$dom->loadHTMLFile('announce_'.$i))) {

                    @$dom->loadHTMLFile('announce_' . $i);

                    $xpath2 = new DOMXPath($dom);

                    @$dom->loadHTMLFile('announce_' . $i);

                    $xpath = new DOMXPath($dom);

                    $ownerClass = "css-1lcz6o7 er34gjf0";
                    $ownerDivs = $xpath2->query("//h4[contains(concat(' ', normalize-space(@class), ' '), ' $ownerClass ')]");

                    $ownerName = $ownerDivs[1]->textContent;

                    $savedOwner = Owner::where('user_name', $ownerName)->first();

                    if (empty($savedOwner)) {
                        $owner = new Owner();
                        $owner->user_name = $ownerName;
                        $owner->save();
                    }

                    $announceOwner = Owner::where('user_name', $ownerName)->first();


                    $ulName = "css-sfcl1s";
                    $ulResults = $xpath2->query("//ul[contains(concat(' ', normalize-space(@class), ' '), ' $ulName ')]/li");



                    $carClsName = "css-sg1fy9";
                    $carNameUrl = $xpath2->query("//div[contains(concat(' ', normalize-space(@class), ' '), ' $carClsName ')]/h1");
                    $ulName = "css-dcwlyx";
                    $priceUrl = $xpath2->query("//div[contains(concat(' ', normalize-space(@class), ' '), ' $ulName ')]/h3/text()");

                    $parts = explode(' ',trim($carNameUrl[0]->textContent),2);
                    $carName = $parts[0];
                    $price = trim($priceUrl[0]->textContent);

                    $idName = "css-ennx8o";
                    $idUrl = $xpath2->query("//div[contains(concat(' ', normalize-space(@class), ' '), ' $idName ')]/span/text()");

                    $id = trim($idUrl[1]->textContent);

                    $subcategName = "css-jramwl";
                    $subcategUrl = $xpath2->query("//ol[contains(concat(' ', normalize-space(@class), ' '), ' $subcategName ')]");


                    $columnsT = DB::getSchemaBuilder()->getColumnListing('announces');

                    $remove = array('id', 'subcategory', 'updated_at');
                    $columns = array_diff($columnsT, $remove);


                    $array = array('gearbox' => 'Cutie de viteze:', 'model' => 'Model:', 'manufacture_year' => 'An de fabricatie:', 'engine_capacity' => 'Capacitate motor:', 'hp_power' => 'Putere:',
                        'combustible' => 'Combustibil:', 'car_body' => 'Caroserie:', 'mileage_km' => 'Rulaj:', 'color' => 'Culoare:', 'door_number' => 'Numar de usi:',
                        'status' => 'Stare:', 'steering_wheel' => 'Volan:');


                    $announce = new Announces();

                    foreach ($columns as $tableColumns) {

                        $subcategory = Categories::where('name','Autoturisme')->first();
                        $subcategoryLink = CategoryLinks::where('category_id', $subcategory->id)->first();
                        $category = Categories::where('id',$subcategoryLink->parent_id)->first();

                        $announce->id = $id;
                        $announce->owner_id = $announceOwner->id;
                        $announce->category_id = $category->id;
                        $announce->subcategory_id = $subcategory->id;
//                        $announce->car_name = $carName;

                        $announce->price = $price;

                        foreach ($array as $key => $value) {

                            foreach ($ulResults as $liResults) {

                                if (str_contains($liResults->textContent, $value)) {  // && $tableColumns === $key

                                    $sscateg = $liResults->textContent;
                                    $colName = trim(str_replace($value,'',$sscateg)); //SUV / Alb
                                    $colUpCateg = trim(str_replace(': '.$colName,'',$sscateg));
                                   
                                   
                                    $announceCategoryUp = Categories::where('name',$colUpCateg)->first();
                                    $announceCategory = Categories::where('name', $colName)->first();


                                    if (empty($announceCategoryUp)) {
                                        $categ = new Categories();
                                        $categ->name = $colUpCateg;
                                        $categ->save();
                                    }
                                    if (empty($announceCategory)) {

                                        $subcateg = new Categories();
                                        $subcateg->name = $colName;
                                        $subcateg->save();
                                    }
                                    $upCategory = Categories::where('name', $colUpCateg)->first();

                                    $subCategory = Categories::where('name', $colName)->first();
                                    $categLinks = CategoryLinks::where('parent_id', $upCategory->id)->first();

                                    if (empty($categLinks)) {
                                        $categsLink = new CategoryLinks();
                                        $categsLink->parent_id = $upCategory->id;
                                        $categsLink->category_id = $subCategory->id;
                                        $categsLink->save();
                                    }

                                    $newIdColumn = $key.'_id';

                                    if (!empty($announceCategory) && !empty($announceCategoryUp)) {
//                                        $categLinksParent = CategoryLinks::where('category_id', $announceCategory->id)->first();
//                                        var_dump($categLinksParent->parent_id);
//                                        $annParent = Categories::where('id',$categLinksParent->parent_id)->first();
//
//                                        var_dump($annParent->name);

//                                        $newIdColumn = $key.'_id';
                                        $announce->$newIdColumn = $announceCategory->id;

                                    } else { var_dump('empty');}
                          
//                                    var_dump($liResults->textContent);
//
//                                    $prop = trim(str_replace($value, '', $liResults->textContent));
//                                    echo 'PROP IN TABLE';
//                                    var_dump($tableColumns);
//                                    var_dump($prop);
//
//                                    $announce->$tableColumns = $prop;

                                }

                            }

                        }
                    }
                    $exist = Announces::where('id',$id)->first();

                    if (!empty($exist)) {
                        var_dump('salvat');
                    } else {
                        $announce->save();
                    }

                    $imgName = "swiper-zoom-container";
                    $imgResults = $xpath2->query("//div[contains(concat(' ', normalize-space(@class), ' '), ' $imgName ')]/img");

                    $idSpan = 'css-12hdxwj er34gjf0';
                    $annId = $xpath2->query("//span[contains(concat(' ', normalize-space(@class), ' '), ' $idSpan ')]/text()");

                    $fileName1 = trim($annId[1]->textContent);
                    var_dump($fileName1);

                    for ($k = 0; $k < $imgResults->length; $k++) {
                        var_dump('FORiMG'.$k);

                        $imgSrc = urldecode($imgResults[$k]->getAttribute('data-src'));
                        $imgDataSrc = urldecode($imgResults[$k]->getAttribute('src'));

                        $imagePath = 'images/'.$fileName1.$k.'.jpeg';

                            $imageCreated = Images::where('path', $imagePath)->first();
                            if (empty($imageCreated)) {

                                if (strlen($imgSrc) > 0) {

                                    $ch = curl_init ($imgSrc);
                                    curl_setopt($ch, CURLOPT_HEADER, 0);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
                                    $raw=curl_exec($ch);
                                    curl_close ($ch);
                                    if(file_exists('images/'.$fileName1.$k.'.jpeg')){
                                        unlink('images/'.$fileName1.$k.'.jpeg');
                                    }
                                    $fileName = $fileName1.$k.'.jpeg';
                                    $fp = fopen('images/'.$fileName1.$k.'.jpeg','x');
                                    fwrite($fp, $raw);
                                    fclose($fp);

                                    $image = new Images();
                                    $image->announce_id = $id;
                                    $image->path = $imagePath;

                                    $imageCreated = Images::where('path', $imagePath)->first();
                                    if (empty($imageCreated)) {
                                        var_dump('empty salveza');
                                        $image->save();
                                    }

                                }

                                if (strlen($imgDataSrc) > 0) {

                                    $ch = curl_init ($imgDataSrc);
                                    curl_setopt($ch, CURLOPT_HEADER, 0);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
                                    $raw=curl_exec($ch);
                                    curl_close ($ch);
                                    if(file_exists('images/'.$fileName1.$k.'.jpeg')){
                                        unlink('images/'.$fileName1.$k.'.jpeg');
                                    }
                                    $fileName = $fileName1.$k.'.jpeg';
                                    $imageCreated = Images::where('path', $fileName)->first();
                                    var_dump($imageCreated);
                                    $fp = fopen('images/'.$fileName1.$k.'.jpeg','x');
                                    fwrite($fp, $raw);
                                    fclose($fp);

                                    $image = new Images();
                                    $image->announce_id = $id;
                                    $image->path = $imagePath;

                                $image->save();
                            }
                        }

                    }
//                    $url2 = 'https://www.olx.ro/auto-masini-moto-ambarcatiuni/autoturisme/?currency=EUR&search%5Bfilter_enum_car_body%5D%5B0%5D=sedan&search%5Bfilter_enum_car_body%5D%5B1%5D=cabriolet';
//                    $urlSub = 'https://www.olx.ro/auto-masini-moto-ambarcatiuni/autoturisme/abarth/?currency=EUR';
//
//                    $slug = Str::slug('https://www.olx.ro/auto-masini-moto-ambarcatiuni/autoturisme/abarth/?currency=EUR','-');
//                    var_dump('slug');
//                    var_dump($slug);
//
////                    $allPrams = trim(parse_url($url2, PHP_URL_PATH), '/');
////                    var_dump($allPrams);
////                    $slugs = basename(parse_url($urlSub, PHP_URL_PATH));
////                    var_dump($slugs);
//                    //todo undersatnad slug
//
//                    $categSlugExpected = 'auto-masini-moto-ambarcatiuni';
//                    $categ = Categories::where('name','Auto, moto si ambarcatiuni')->first();
//                    $subctegory = Categories::where('name', 'Autoturisme')->first();
//
//                    $slugCateg = $categ->slug();
//                    $slugSubctegory = $subctegory->slug();
//                    var_dump($slugCateg);
//                    var_dump($slugSubctegory);
//
//                    $urlSlug = 'https://www.olx.ro/'.$slugCateg.'/'.$slugSubctegory;
//                    var_dump($urlSlug);
                }
         }

        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
