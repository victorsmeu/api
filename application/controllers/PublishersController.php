<?php

class PublishersController extends Zend_Controller_Action
{
    public function init()
    {
        //Disable viewer output
		$this->_helper->viewRenderer->setNoRender(true);
        
        //Check url integrity: if other parameters are given, an error is given
        $params = $this->getRequest()->getParams();
        unset($params['module'], $params['controller'], $params['action'], $params['id_publisher']);
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
        if(!$model_app->validate_publisher()) {
            http_response_code(400);
            echo "Invalid input. Use max 255 alphanumeric characters";
            die();
        }
        
        $model_publishers = new Application_Model_Publishers();
        $model_publishers->insert($model_app->input);
        http_response_code(201);
        echo "Insert ok";
    }
    
    public function getAction()
    {
        $model_publishers = new Application_Model_Publishers();
        $select = $model_publishers->select();
        
        if(isset($this->_request->id_publisher)) {
            $select->where('id_publisher = ?', (int)$this->_request->id_publisher);
        }
        
        $result = $model_publishers->fetchAll($select);
        echo json_encode($result->toArray());
    }
    
    public function updateAction()
    {
        $model_publishers = new Application_Model_Publishers();
        
        if(isset($this->_request->id_publisher)) {
            
            if($model_publishers->check_if_exists("id_publisher", $this->_request->id_publisher)){
                
                $model_app = new Application_Model_App();
                $model_app->get_input_stream();
                if(!$model_app->validate_publisher()) {
                    http_response_code(400);
                    echo "Invalid input. Use max 255 alphanumeric characters";
                    die();
                }
                
                $where = $model_publishers->getAdapter()->quoteInto('id_publisher = ?', $this->_request->id_publisher);
                $model_publishers->update($model_app->input, $where);
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
        $model_publishers = new Application_Model_Publishers();
        
        if(isset($this->_request->id_publisher)) {
            
            if($model_publishers->check_if_exists("id_publisher", $this->_request->id_publisher)){
                $where = $model_publishers->getAdapter()->quoteInto('id_publisher = ?', $this->_request->id_publisher);
                $model_publishers->delete($where);
                
                $model_books = new Application_Model_Books();
                $where = $model_books->getAdapter()->quoteInto('id_publisher = ?', $this->_request->id_publisher);
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

