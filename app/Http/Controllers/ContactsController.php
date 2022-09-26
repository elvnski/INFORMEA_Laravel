<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class  ContactsController extends Controller{

    //create and update contacts
    public function fetchFromUrl($url){
        $xml = file_get_contents($url);

        $data = json_decode($xml, true);
        

            return $data;
    }

    public function importContacts(Request $request){
        $config = include __DIR__ . '/../../config/config.php';
        $url = "https://wedocs.unep.org/rest/collections/08702a46-5100-47db-96de-bf29a8a0e719/items/";
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
                    
                    if($value['key'] == "dc.contributor.author"){
                        $author = $value['value'];
                    }
                    if($value['key'] == "dc.date.accessioned"){
                        $date_accessioned = $value['value'];
                    }
                    if($value['key'] == "dc.date.available"){
                        $date_available = $value['value'];
                    }
                    if($value['key'] == "dc.identifier.uri"){
                        $identifier_uri = $value['value'];
                    }
                
                    if($value['key'] == "dc.title"){
                        $title = $value['value'];
                    }
                    if($value['key'] == "informea.contact.address"){
                        $contact_address = $value['value'];
                    }
                    if($value['key'] == "informea.contact.country"){
                        $contact_country = $value['value'];
                    }
                    if($value['key'] == "informea.contact.fax"){
                        $language = $value['value'];
                    }
                    if($value['key'] == "informea.contact.department"){
                        $contact_department = $value['value'];
                    }
                    if($value['key'] == "informea.contact.fax"){
                        $contact_fax = $value['value'];
                    }
                    if($value['key'] == "informea.contact.email"){
                        $contact_email = $value['value'];
                    }
                    if($value['key'] == "informea.contact.phone"){
                        $contact_phone = $value['value'];
                    }
                    if($value['key'] == "informea.contact.firstname"){
                        $contact_firstname = $value['value'];
                    }
                    if($value['key'] == "informea.contact.lastname"){
                        $contact_lastname = $value['value'];
                    }
                    if($value['key'] == "informea.contact.organizations"){
                        $language = $value['value'];
                    }
                    if($value['key'] == "informea.contact.position"){
                        $contact_position = $value['value'];
                    }
                    if($value['key'] == "informea.contact.prefix"){
                        $contact_prefix = $value['value'];
                    }
                    if($value['key'] == "informea.contact.type"){
                        $contact_type = $value['value'];
                    }
                    if($value['key'] == "informea.identifier.treaty"){
                        $treaty = $value['value'];
                    }
                }


                // var_dump($date_accessioned);
                // exit;

                $new_decision = Contacts::create([ 
                'author'                        =>  $author,
                'date_accessioned'              =>  $date_accessioned,
                'date_available'                =>  $date_available,
                'identifier_uri'                =>  $identifier_uri,
                'title'                         =>  $title,
                'contact_address'               =>  $contact_address,
                'contact_country'               =>  $contact_country,
                //'contact_department'            =>  $contact_department,
                //'contact_institution'           =>  $contact_institution,
                //'contact_email'                 =>  $contact_email,
                'contact_firstname'             =>  $contact_firstname,
                'contact_lastname'              =>  $contact_lastname,
                //'contact_phoneNumber'           =>  $contact_phone,
                'contact_fax'                   =>  $contact_fax,
                'contact_type'                  =>  $contact_type,
                'contact_position'              =>  $contact_position,
                'contact_prefix'                =>  $contact_prefix,
                'identifier_treaty'             =>  $treaty,
        
            ]);
                $final_data[]= $result_data;

                $response['data'] = $final_data;
            }
        

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        return response()->json($response);

    }
    
    //update contacts details
    
    public function updateContacts(Request $request, $id){
        $contacts = Contacts::find($id);
        $contacts->collection = $request->input('collection');
        $contacts->uuid =  $request->input('uuid');
        $contacts->handle = $request->input('handle');
        $contacts->link = $request->input('link');
        $contacts->numberitems = $request->input('numberitems');
        $contacts->save();
        return response()->json($contacts);
    }


    //view contacts
    public function viewContacts($id){
     $contacts =  Contacts::find($id);
            return response()->json($contacts);
    }


    //delete contacts(
    public function deleteContacts($id){
        $contacts =  Contacts::find($id);
        $contacts->delete();

        return response()->json('Removed successfully');
    }

    //list contacts
    public function index(){
        $contacts['data'] =Contacts::limit(10)->get();
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
        return response()->json($contacts);
    }

} 
?>