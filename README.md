Library API
-----------

The api is built with Zend Framework 1. The choice is based on my personal experience with the framework and was used to tackle automatically problems like db interactions, file/folder structure and url rewrite.


I did not output results in viewers, except for the main index where I have the api url structure. 
All relevant code is inside /application/controllers and /application/models, the rest is default ZF1 default structure
I chose to comment only the code used to handle api logic, where that logic is not self explaining.
No unit testing is in place, I only went with usage tests.

----

Setting up:

Root url should go to /api/public/

/api/public/client.php is a client used to access the api; I did not go with javascript api calls, but using ajax to access the api should be straight-forward

/api/public/db.sql is the dump of the database

/application/configs/application.ini contains application settings, including db; the following lines should be changed:
resources.db.params.host = "localhost"
resources.db.params.username = "root"
resources.db.params.password = ""
resources.db.params.dbname = "library"




Usage:

BASEPATH/books/add [(int)"id_author",(int)"id_publisher",(int)"id_collection",(varchar)"book_name",(text)"description"] - adds a books
BASEPATH/books/get - returns all books
BASEPATH/books/get/id_book/ID_BOOK - returns book by id
BASEPATH/books/get/id_author/ID_AUTHOR - returns all books by author id
BASEPATH/books/get/collection/COLLECTION_NAME - returns all books by collection name
BASEPATH/books/update/id_book/ID_BOOK [(int)"id_author",(int)"id_publisher",(int)"id_collection",(varchar)"book_name",(text)"description"] - updates a book by id
BASEPATH/books/delete/id_book/ID_BOOK

BASEPATH/authors/add [(varchar)first_name, (varchar)last_name] - adds an author
BASEPATH/authors/get - returns all authors
BASEPATH/authors/get/id_author/ID_AUTHOR - returns author by id
BASEPATH/authors/update/id_author/ID_AUTHOR [(varchar)first_name, (varchar)last_name] - updates an author by id
BASEPATH/authors/delete/id_author/ID_AUTHOR - deletes an author by id

BASEPATH/publishers/add [(varchar)publisher_name] - adds a publisher
BASEPATH/publishers/get - returns all publishers
BASEPATH/publishers/get/id_publisher/ID_PUBLISHER - returns publisher by id
BASEPATH/publishers/update/id_publisher/ID_PUBLISHER [(varchar)publisher_name] - updates a publisher by id
BASEPATH/publishers/delete/id_publisher/ID_PUBLISHER - deletes a publisher by id

BASEPATH/collections/add [(varchar)publisher_name] - adds a collection
BASEPATH/collections/get - returns all collections
BASEPATH/collections/get/id_collection/ID_COLLECTION - returns collection by id
BASEPATH/collections/update/id_collection/ID_COLLECTION [(varchar)publisher_name] - updates a collection by id
BASEPATH/collections/delete/id_collection/ID_COLLECTION - deletes a collection by id
