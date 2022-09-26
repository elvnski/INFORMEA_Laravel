<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Collections;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class  ImportController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getTreaties(){
        $url = "http://odata.informea.org/informea.svc/Treaties";
        $xml = simplexml_load_file($url);

        $data= [];
        foreach ($xml->entry as $item) {
            $val = (string) $item->content->children('m', true)->children('d', true)->titleEnglish;
            $data[] = ["text" => $val, "value" => $val];
        }

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        return response()->json($data);
        //echo json_encode($simpleXml);
        $this->view->disable();
    }

    public function getItems(){
        $url = 'https://wedocs.unep.org/rest/collections/08702a46-5100-47db-96de-bf29a8a0e719/items/';
        $xml = file_get_contents($url);

        $data= json_decode($xml, true);

        $data2 = [];

        foreach ($data as $d){
            $data2[]= [
                'uuid'=> $d['uuid'],
                //'uuid'=> $d['uuid'],
            ];
        }

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        return response()->json($data);
        //echo json_encode($simpleXml);
        $this->view->disable();

    
    }

    public function getmetadata(){
        $url = "https://wedocs.unep.org/rest/items/2f43d1eb-e7ac-45a2-96f7-ab2803eb5bb4/metadata";
        $xml = file_get_contents($url);

        $data= json_decode($xml, true);

        $data2 = [];

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        return response()->json($data);
        //echo json_encode($simpleXml);
        $this->view->disable();
    }

    public function fetchFromUrl($url){
            $xml = file_get_contents($url);

            $data = json_decode($xml, true);
            

                return $data;
    }

    public function getCollections(Request $request){
        $config = include __DIR__ . '/../../config/config.php';
        $url = "https://wedocs.unep.org/rest/collections/71ab5219-5355-46fc-bb02-23aa84f9d50c/items/";
        $final_data = [];
        
        $xml = file_get_contents($url);

        $data = json_decode($xml, true);

        foreach ($data as $d){
            $link = "https://wedocs.unep.org".$d['link']."/metadata";
                $data2[]= [
                'link'=> $link,
                ];
                $result_data =  $this->fetchFromUrl($link);
                $final_data[]= $result_data;

                $response['data'] = $final_data;
            }
        // foreach($result_data as $temp){
        //     $data3[]=[
        //         'key'=> $temp['key'],
        //         'value'=> $temp['value'],
        //     ];
        //     $response['data'] = $data3;
        // }
        

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        return response()->json($response);

    }

    public function createCollections(Request $request){
        $url = "https://wedocs.unep.org/rest/collections/";
        $xml = file_get_contents($url);

        $data = json_decode($xml, true);

        foreach ($data as $d){
                $data2[]= [
                    'name'=> $d['name'],
                    'uuid'=> $d['uuid'],
                    'handle'=> $d['handle'],
                    'link'=> $d['link'],
                    'numberItems'=> $d['numberItems'],
                ];
                $response['data']= $data2;
            }
            
        //$response = $request->all();
        foreach($response['data'] as $row)
        {
          Collections::create($request->all([  'collection'         => $row['name'],
                                                'uuid'              => $row["uuid"],
                                                'handle'            => $row["handle"],
                                                'link'              => $row["link"],
                                                'numberitems'       => $row["numberItems"],
                                            
            ]));
        }

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        return response()->json('Added successfully');
        //$this->view->disable();
    }

    public function insertCollections(){
        $url = "https://wedocs.unep.org/rest/collections/";
        $xml = file_get_contents($url);

        $data = json_decode($xml, true);

        foreach ($data as $d){
                $data2[]= [
                    'name'=> $d['name'],
                    'uuid'=> $d['uuid'],
                    'handle'=> $d['handle'],
                    'link'=> $d['link'],
                    'numberItems'=> $d['numberItems'],
                ];
                $response['data']= $data2;
            }

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        return response()->json($response['data']);
        //echo json_encode($simpleXml);
        $this->view->disable();
    }

    public function importDecisions(){
        $url = "https://wedocs.unep.org/rest/collections/f07c193c-98b5-48e9-91a9-df4099c68242/items/";
        $xml = file_get_contents($url);

        $data = json_decode($xml, true);

        foreach ($data as $d){
                $data2[]= [
                    'name'=> $d['name'],
                    'uuid'=> $d['uuid'],
                    'handle'=> $d['handle'],
                    'link'=> $d['link'],
                   
                ];
                $response['data']= $data2;
            }

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        return response()->json($response['data']);
        //echo json_encode($simpleXml);
        $this->view->disable();
    }

    public function importContacts(){
        $url = "https://wedocs.unep.org/rest/collections/08702a46-5100-47db-96de-bf29a8a0e719/items/";
        $xml = file_get_contents($url);

        $data = json_decode($xml, true);

        foreach ($data as $d){
                $data2[]= [
                    'name'=> $d['name'],
                    'uuid'=> $d['uuid'],
                    'handle'=> $d['handle'],
                    'link'=> $d['link'],
                   
                ];
                $response['data']= $data2;
            }

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        return response()->json($response['data']);
        //echo json_encode($simpleXml);
        $this->view->disable();
    }

    public function importCountryReports(){
        $url = "https://wedocs.unep.org/rest/collections/71ab5219-5355-46fc-bb02-23aa84f9d50c/items/";
        $xml = file_get_contents($url);

        $data = json_decode($xml, true);

        foreach ($data as $d){
                $data2[]= [
                    'name'=> $d['name'],
                    'uuid'=> $d['uuid'],
                    'handle'=> $d['handle'],
                    'link'=> $d['link'],
                   
                ];
                $response['data']= $data2;
            }

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        return response()->json($response['data']);
        //echo json_encode($simpleXml);
        $this->view->disable();
    }

    public function importGeneralDocuments(){
        $url = "https://wedocs.unep.org/rest/collections/83d86625-98d5-4c68-9bde-588729a35184/items/";
        $xml = file_get_contents($url);

        $data = json_decode($xml, true);

        foreach ($data as $d){
                $data2[]= [
                    'name'=> $d['name'],
                    'uuid'=> $d['uuid'],
                    'handle'=> $d['handle'],
                    'link'=> $d['link'],
                   
                ];
                $response['data']= $data2;
            }

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        return response()->json($response['data']);
        //echo json_encode($simpleXml);
        $this->view->disable();
    }

    public function importLibraryCatalog(){
        $url = "https://wedocs.unep.org/rest/collections/56a78935-f245-45ab-943e-e056bf6e3ee4/items/";
        $xml = file_get_contents($url);

        $data = json_decode($xml, true);

        foreach ($data as $d){
                $data2[]= [
                    'name'=> $d['name'],
                    'uuid'=> $d['uuid'],
                    'handle'=> $d['handle'],
                    'link'=> $d['link'],
                   
                ];
                $response['data']= $data2;
            }

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        return response()->json($response['data']);
        //echo json_encode($simpleXml);
        $this->view->disable();
    }

    public function importPublications(){
        $url = "https://wedocs.unep.org/rest/collections/9aa4daaa-d19f-42ba-a596-32612aefd7dd/items/";
        $xml = file_get_contents($url);

        $data = json_decode($xml, true);

        foreach ($data as $d){
                $data2[]= [
                    'name'=> $d['name'],
                    'uuid'=> $d['uuid'],
                    'handle'=> $d['handle'],
                    'link'=> $d['link'],
                   
                ];
                $response['data']= $data2;
            }

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        return response()->json($response['data']);
        //echo json_encode($simpleXml);
        $this->view->disable();
    }

    //
}
