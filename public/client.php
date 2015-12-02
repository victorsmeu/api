<?php
$basepath = "http://localhost/";

//1. Basic test 
$url = $basepath;

//2. Add author
/*$url = $basepath."/authors/add/";  
$author = array(
                "first_name" => "Mark", 
                "last_name" => "Twain"
                );
$json_input = json_encode($author);                    
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_input);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true ); 
curl_setopt($ch, CURLOPT_VERBOSE, 0);                                                                    
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                     
                                        'Content-Type: application/json',
                                        'Content-Length: ' . strlen($json_input))
);*/ 

//3. Get author
/*
$url = $basepath."/authors/get/";                   
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );                                                                    
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
*/

//4. Update author
$url = $basepath."/authors/update/id_author/9";  
$author = array(
                "first_name" => "Mark", 
                "last_name" => "Twai"
                );
$json_input = json_encode($author);                    
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_input);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true ); 
curl_setopt($ch, CURLOPT_VERBOSE, 0);                                                                    
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                     
                                        'Content-Type: application/json',
                                        'Content-Length: ' . strlen($json_input))
); 


//5. Add collections
/*
$url = $basepath."/collections/add/";  
$author = array(
                "collection_name" => "Russian Authors"
                );
$json_input = json_encode($author);                    
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_input);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true ); 
curl_setopt($ch, CURLOPT_VERBOSE, 0);                                                                    
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                     
                                        'Content-Type: application/json',
                                        'Content-Length: ' . strlen($json_input))
);*/

//6. Add book
/*
$url = $basepath."/books/add/";  
$author = array(
                "id_author" => "1",
                "id_publisher" => "2",
                "id_collection" => "2",
                "book_name" => "Random Book2",
                "description" => "Lorem Ipsum dolor sit"
                );
$json_input = json_encode($author);                    
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_input);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true ); 
curl_setopt($ch, CURLOPT_VERBOSE, 0);                                                                    
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                     
                                        'Content-Type: application/json',
                                        'Content-Length: ' . strlen($json_input))
);
*/

//7. Get book
/*
$url = $basepath."/books/get/collection/".urlencode('Classical Books');  
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );                                                                    
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
*/

$result = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
print_r($httpcode.": ".$result);
