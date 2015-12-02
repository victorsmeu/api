<?php

class CollectionsController extends Zend_Controller_Action
{
    public function init()
    {
        //Disable viewer output
		$this->_helper->viewRenderer->setNoRender(true);
        
        //Check url integrity: if other parameters are given, an error is given
        $params = $this->getRequest()->getParams();
        unset($params['module'], $params['controller'], $params['action'], $params['id_collection']);
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
        if(!$model_app->validate_collection()) {
            http_response_code(400);
            echo "Invalid input. Use max 255 alphanumeric characters";
            die();
        }
        
        $model_collections = new Application_Model_Collections();
        $model_collections->insert($model_app->input);
        http_response_code(201);
        echo "Insert ok";
    }
    
    public function getAction()
    {
        $model_collections = new Application_Model_Collections();
        $select = $model_collections->select();
        
        if(isset($this->_request->id_collection)) {
            $select->where('id_collection = ?', (int)$this->_request->id_collection);
        }
        
        $result = $model_collections->fetchAll($select);
        echo json_encode($result->toArray());
    }
    
    public function updateAction()
    {
        $model_collections = new Application_Model_Collections();
        
        if(isset($this->_request->id_collection)) {
            
            if($model_collections->check_if_exists("id_collection", $this->_request->id_collection)){
                
                $model_app = new Application_Model_App();
                $model_app->get_input_stream();
                if(!$model_app->validate_collection()) {
                    http_response_code(400);
                    echo "Invalid input. Use max 255 alphanumeric characters";
                    die();
                }
                
                $where = $model_collections->getAdapter()->quoteInto('id_collection = ?', $this->_request->id_collection);
                $model_collections->update($model_app->input, $where);
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
        $model_collections = new Application_Model_Collections();
        
        if(isset($this->_request->id_collection)) {
            
            if($model_collections->check_if_exists("id_collection", $this->_request->id_collection)){
                $where = $model_collections->getAdapter()->quoteInto('id_collection = ?', $this->_request->id_collection);
                $model_collections->delete($where);
                
                $model_books = new Application_Model_Books();
                $where = $model_books->getAdapter()->quoteInto('id_collection = ?', $this->_request->id_collection);
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

