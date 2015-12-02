<?php

class BooksController extends Zend_Controller_Action
{
    public function init()
    {
        //Disable viewer output
		$this->_helper->viewRenderer->setNoRender(true);
        
        //Check url integrity: if other parameters are given, an error is given
        $params = $this->getRequest()->getParams();
        unset($params['module'], $params['controller'], $params['action'], $params['id_book'], $params['id_author'], $params['collection']);
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
        if(!$model_app->validate_book()) {
            http_response_code(400);
            echo "Invalid input format";
            die();
        }
        
        $model_books = new Application_Model_Books();
        $model_books->insert($model_app->input);
        http_response_code(201);
        echo "Insert ok";
    }
    
    public function getAction()
    {
        $model_books = new Application_Model_Books();
        $select = $model_books->select()
                              ->from(array('a' => 'books'))
                              ->setIntegrityCheck(false) 
                              ->joinLeft(array('b' => 'collections'), 
                                        'b.id_collection = a.id_collection', 
                                        array('collection' => 'collection_name')
                                        )
                              ->joinLeft(array('c' => 'authors'), 
                                        'c.id_author = a.id_author', 
                                        array('author' => 'CONCAT(first_name," ",last_name)')
                                        )
                              ->joinLeft(array('d' => 'publishers'), 
                                        'd.id_publisher = a.id_publisher', 
                                        array('publisher' => 'publisher_name')
                                        );
        
        if(isset($this->_request->id_book)) {
            $select->where('id_book = ?', (int)$this->_request->id_book);
        }
        
        if(isset($this->_request->id_author)) {
            $select->where('id_author = ?', (int)$this->_request->id_author);
        }
        
        if(isset($this->_request->collection)) {
            $collection = htmlentities(urldecode($this->_request->collection));
            $select->where('b.collection_name = ?', $collection);
        }
        
        $result = $model_books->fetchAll($select);
        echo json_encode($result->toArray());
    }
    
    public function updateAction()
    {
        $model_books = new Application_Model_Books();
        
        if(isset($this->_request->id_book)) {
            
            if($model_books->check_if_exists("id_book", $this->_request->id_book)){
                
                $model_app = new Application_Model_App();
                $model_app->get_input_stream();
                if(!$model_app->validate_book()) {
                    http_response_code(400);
                    echo "Invalid input format";
                    die();
                }
                
                $where = $model_books->getAdapter()->quoteInto('id_book = ?', $this->_request->id_book);
                $model_books->update($model_app->input, $where);
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
        $model_books = new Application_Model_Books();
        
        if(isset($this->_request->id_book)) {
            
            if($model_books->check_if_exists("id_book", $this->_request->id_book)){
                $where = $model_books->getAdapter()->quoteInto('id_book = ?', $this->_request->id_book);
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

