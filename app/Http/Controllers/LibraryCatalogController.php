<?php

namespace App\Http\Controllers;

use App\Models\Library_catalog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class  LibraryCatalogController extends Controller{

    //create and update library catalog
    public function fetchFromUrl($url){
        $xml = file_get_contents($url);

        $data = json_decode($xml, true);
        

            return $data;
    }

    public function importLibraryCatalog(Request $request){
        $config = include __DIR__ . '/../../config/config.php';
        $url = "https://wedocs.unep.org/rest/collections/56a78935-f245-45ab-943e-e056bf6e3ee4/items/";
        $final_data = [];
        
        $xml = file_get_contents($url);

        $data = json_decode($xml, true);

        foreach ($data as $d){
            $link = "https://wedocs.unep.org".$d['link']."/metadata";
                $data2[]= [
                'link'=> $link,
                ];
                $result_data =  $this->fetchFromUrl($link);

                foreach($result_data as $key => $value){
                    
                    if($value['key'] == "dc.contributor"){
                        $contributor = $value['value'];
                    }
                    if($value['key'] == "dc.date.accessioned"){
                        $date_accessioned = $value['value'];
                    }
                    if($value['key'] == "dc.date.available"){
                        $date_available = $value['value'];
                    }
                    if($value['key'] == "dc.date.issued"){
                        $date_issued = $value['value'];
                    }
                    if($value['key'] == "dc.identifier.uri"){
                        $identifier_uri = $value['value'];
                    }
                    if($value['key'] == "dc.publisher"){
                        $publisher = $value['value'];
                    }
                    if($value['key'] == "dc.title"){
                        $title = $value['value'];
                    }
                    if($value['key'] == "dc.type"){
                        $type = $value['value'];
                    }
                    if($value['key'] == "dc.description.version"){
                        $version = $value['value'];
                    }
                    if($value['key'] == "unepmap.descriptors"){
                        $descriptors = $value['value'];
                    }
                    if($value['key'] == "unepmap.identifier.author"){
                        $author = $value['value'];
                    }
                    if($value['key'] == "unepmap.identifier.category"){
                        $category = $value['value'];
                    }
                    if($value['key'] == "unepmap.identifier.class"){
                        $class = $value['value'];
                    }
                    if($value['key'] == "unepmap.unepmap.identifier.link"){
                        $identifier_link = $value['value'];
                    }
                    if($value['key'] == "unepmap.identifier.series"){
                        $identifier_series = $value['value'];
                    }
                    if($value['key'] == "unepmap.identifier.place"){
                        $identifier_place = $value['value'];
                    }
                }


                // var_dump($date_accessioned);
                // exit;

                $new_librarycatalog = Library_catalog::create([ 
                'contributor'                   =>  $contributor,
                'date_accessioned'              =>  $date_accessioned,
                'date_available'                =>  $date_available,
                'date_issued'                   =>  $date_issued,
                'identifier_uri'                =>  $identifier_uri,
                'publisher'                     =>  $publisher,
                'title'                         =>  $title,
                //'type'                          =>  $type,
                'version'                       =>  $version,
                'descriptors'                   =>  $descriptors,
                'author'                        =>  $author,
                'category'                      =>  $category,
                'class'                         =>  $class,
                //'identifier_link'               =>  $identifier_link,
                //'identifier_series'             =>  $identifier_series,
                'identifier_place'              =>  $identifier_place,
        
            ]);
                $final_data[]= $result_data;

                $response['data'] = $final_data;
            }

        

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        return response()->json($response);

    }
    
    //update Library catalog details
    
    public function updateLibraryCatalog(Request $request, $id){
        $library_catalog = Library_catalog::find($id);
        $library_catalog->collection = $request->input('collection');
        $library_catalog->uuid =  $request->input('uuid');
        $library_catalog->handle = $request->input('handle');
        $library_catalog->link = $request->input('link');
        $library_catalog->numberitems = $request->input('numberitems');
        $library_catalog->save();
        return response()->json($library_catalog);
    }


    //view Library catalog
    public function viewLibraryCatalog($id){
        $library_catalog =  Library_catalog::find($id);
            return response()->json($library_catalog);
    }


    //delete Library catalog(
    public function deleteLibraryCatalog($id){
        $library_catalog =  Library_catalog::find($id);
        $library_catalog->delete();

        return response()->json('Removed successfully');
    }

    //list library catalog
    public function index(){
        $library_catalog["data"] = Library_catalog::limit(10)->get();
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
        return response()->json($library_catalog);
    }

} 
?>