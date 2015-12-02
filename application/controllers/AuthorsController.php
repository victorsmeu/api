<?php

class AuthorsController extends Zend_Controller_Action
{
    public function init()
    {
        //Disable viewer output
		$this->_helper->viewRenderer->setNoRender(true);
        
        //Check url integrity: if other parameters are given, an error is given
        $params = $this->getRequest()->getParams();
        unset($params['module'], $params['controller'], $params['action'], $params['id_author']);
        if(count($params)>0) 
        {
            http_response_code(405);
            echo "Invalid url path";
            die();
        }
    }

    public function indexAction()
    {
        http_response_code(405); //Nothing here
    }
    
    public function addAction()
    {
        $model_app = new Application_Model_App();
        $model_app->get_input_stream();
        if(!$model_app->validate_author()) {
            http_response_code(400);
            echo "Invalid input. Use max 255 alphanumeric characters";
            die();
        }
        
        $model_authors = new Application_Model_Authors();
        $model_authors->insert($model_app->input);
        http_response_code(201);
        echo "Insert ok";
    }
    
    public function getAction()
    {
        $model_authors = new Application_Model_Authors();
        $select = $model_authors->select();
        
        if(isset($this->_request->id_author)) {
            $select->where('id_author = ?', (int)$this->_request->id_author);
        }
        
        $result = $model_authors->fetchAll($select);
        echo json_encode($result->toArray());
    }
    
    public function updateAction()
    {
        $model_authors = new Application_Model_Authors();
        
        if(isset($this->_request->id_author)) {
            
            if($model_authors->check_if_exists("id_author", $this->_request->id_author)){
                
                $model_app = new Application_Model_App();
                $model_app->get_input_stream();
                if(!$model_app->validate_author()) {
                    http_response_code(400);
                    echo "Invalid input. Use max 255 alphanumeric characters";
                    die();
                }
                
                $where = $model_authors->getAdapter()->quoteInto('id_author = ?', $this->_request->id_author);
                $model_authors->update($model_app->input, $where);
                http_response_code(201);
                echo "Update ok";
            } else {
                http_response_code(400);
                echo "Bad id given";
            }
        } else {
            http_response_code(400);
            echo "No id given";
        }
    }
    
    public function deleteAction()
    {
        $model_authors = new Application_Model_Authors();
        
        if(isset($this->_request->id_author)) {
            
            if($model_authors->check_if_exists("id_author", $this->_request->id_author)){
                $where = $model_authors->getAdapter()->quoteInto('id_author = ?', $this->_request->id_author);
                $model_authors->delete($where);
                
                $model_books = new Application_Model_Books();
                $where = $model_books->getAdapter()->quoteInto('id_author = ?', $this->_request->id_author);
                $model_books->delete($where);
                http_response_code(201);
                echo "Delete ok";
            } else {
                http_response_code(400);
                echo "Bad id given";
            }
        } else {
            http_response_code(400);
            echo "No id given";
        }
    }

}