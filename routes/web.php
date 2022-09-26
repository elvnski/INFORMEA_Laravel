<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {



//the route below is for creating and updating data
$router->get('collections/import', 'CollectionsController@importCollections');
$router->get('contacts/import', 'ContactsController@importContacts');
$router->get('country-reports/import', 'CountryReportsController@importCountryReports');
$router->get('library-catalog/import', 'LibraryCatalogController@importLibraryCatalog');
$router->get('meetings/import', 'MeetingsController@importMeetings');
$router->get('publications/import', 'PublicationsController@importPublications');
$router->get('treaties/import', 'TreatiesController@importTreaties');
$router->get('decisions/import', 'DecisionsController@importDecisions');
$router->get('general-documents/import', 'GeneralDocumentsController@importGeneralDocuments');

// $router->post('collections/import', 'CollectionsController@importCollections');
// $router->post('contacts/import', 'ContactsController@importContacts');
// $router->post('country-reports/import', 'CountryReportsController@importCountryReports');
// $router->post('library-catalog/import', 'LibraryCatalogController@importLibraryCatalog');
// $router->post('meetings/import', 'MeetingsController@importMeetings');
// $router->post('publications/import', 'PublicationsController@importPublications');
// $router->post('treaties/import', 'TreatiesController@importTreaties');



//the route below is for viewing one data
$router->get('collections/view/{id}', 'CollectionsController@viewCollections');
$router->get('contacts/view/{id}', 'ContactsController@viewContacts');
$router->get('country-reports/view/{id}', 'CountryReportsController@viewCountryReports');
$router->get('library-catalog/view/{id}', 'LibraryCatalogController@viewLibraryCatalog');
$router->get('meetings/view/{id}', 'MeetingsController@viewMeetings');
$router->get('publications/view/{id}', 'PublicationsController@viewPublications');
$router->get('treaties/view/{id}', 'TreatiesController@viewTreaties');



//the route below is for updating the information of data
$router->put('collections/edit/{id}', 'CollectionsController@updateCollections');
$router->put('contacts/edit/{id}', 'ContactsController@updateContacts');
$router->put('country-reports/edit/{id}', 'CountryReportsController@updateCountryReports');
$router->put('library-catalog/edit/{id}', 'LibraryCatalogController@updateLibraryCatalog');
$router->put('meetings/edit/{id}', 'MeetingsController@updateMeetings');
$router->put('publications/edit/{id}', 'PublicationsController@updatePublications');
$router->put('treaties/edit/{id}', 'TreatiesController@updateTreaties');


//the route below is for deleting a user from the database
$router->delete('collections/delete/{id}', 'CollectionsController@deleteCollections');
$router->delete('contacts/delete/{id}', 'ContactsController@deleteContacts');
$router->delete('country-reports/delete/{id}', 'CountryReportsController@deleteCountryReports');
$router->delete('library-catalog/delete/{id}', 'LibraryCatalogController@deleteLibraryCatalog');
$router->delete('meetings/delete/{id}', 'MeetingsController@deleteMeetings');
$router->delete('publications/delete/{id}', 'PublicationsController@deletePublications');
$router->delete('treaties/delete/{id}', 'TreatiesController@deleteTreaties');


//the route below is for viewing all users
$router->get('collections/index', 'CollectionsController@index');
$router->get('contacts/index', 'ContactsController@index');
$router->get('country-reports/index', 'CountryReportsController@index');
$router->get('library-catalog/index', 'LibraryCatalogController@index');
$router->get('meetings/index', 'MeetingsController@index');
$router->get('publications/index', 'PublicationsController@index');
$router->get('general-documents/index', 'GeneralDocumentsController@index');
$router->get('decisions/index', 'DecisionsController@index');
$router->get('treaties/index', 'TreatiesController@index');

$router->get('import/treaties', 'ImportController@getTreaties');
$router->get('import/items', 'ImportController@getItems');
$router->get('import/metadata', 'ImportController@getmetadata');
$router->get('import/collections', 'ImportController@getCollections');
$router->get('import/insert', 'ImportController@insertCollections');
$router->get('import/contacts', 'ImportController@importContacts');
$router->get('import/decisions', 'ImportController@importDecisions');
$router->get('import/countryreports', 'ImportController@importCountryReports');
$router->get('import/librarycatalog', 'ImportController@importLibraryCatalog');


});