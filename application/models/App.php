<?php

/**
 * Application_Model_App - Class used to define functions used throughout the application
 * 
 * @package api
 * @author Victor Smeu
 * @copyright 2015
 * @version 1
 * @access public
 */
class Application_Model_App
{
    public $input;
    
    /**
     * Application_Model_App::get_input_stream() - gets posted data from the client
     * 
     * @return void
     */
    public function get_input_stream()
    {
        $input_file = fopen('php://input', 'r');
        $this->input = json_decode(stream_get_contents($input_file), true);
    }
    
    /*The next functions will define the input structure for each of the input areas: author, collection, publisher, books*/
    
    public function validate_author()
    {
        $valid_array = array(
                            "first_name" => "validate_varchar", 
                            "last_name" => "validate_varchar"
                            );
        return $this->check_valid($valid_array);
    }
    
    
    public function validate_collection()
    {
        $valid_array = array(
                            "collection_name" => "validate_varchar"
                            );
        return $this->check_valid($valid_array);
    }
    
    
    public function validate_publisher()
    {
        $valid_array = array(
                            "publisher_name" => "validate_varchar"
                            );
        return $this->check_valid($valid_array);
    }
    
    
    public function validate_book()
    {
        $valid_array = array(
                            "id_author" => "validate_int",
                            "id_publisher" => "validate_int",
                            "id_collection" => "validate_int",
                            "book_name" => "validate_varchar",
                            "description" => "validate_text"
                            );
        return $this->check_valid($valid_array);
    }
    
    /*END definition of input stucture*/
    
    
    /**
     * Application_Model_App::check_valid() - checks to see if the posted data has a correct structure and, for
     * each fields, triggers the specific checks (if int, varchar or text)
     * 
     * @param mixed $valid_array
     * @return
     */
    private function check_valid($valid_array)
    {
        if(count($valid_array) != count($this->input) || count(array_diff_key($valid_array, $this->input)))
        {
            return false;
        }
        
        foreach($valid_array as $key => $value)
        {
            if(!$this->$value($this->input[$key]))
            {
                return false;
            }
        }
        return true;
    }
    
    
    /* The next functions will validate the 3 data types allowed as input */
    
    private function validate_varchar($data)
    {
        if($data == "" || strlen($data) > 255 || htmlentities($data) !== $data) {
            return false;
        } else {
            return true;
        }
    }
    
    
    private function validate_int($data)
    {
        if($data == "" ||  (int)$data != $data) {
            return false;
        } else {
            return true;
        }
    }
    
    
    private function validate_text($data)
    {
        if($data == "" || htmlentities($data) !== $data) {
            return false;
        } else {
            return true;
        }
    }
    
    /* END validity check functions */
}