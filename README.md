Simple REST/HTTP server with simple key value json document based storage

Supports 2 types of requests
REST
    - The request must follow REST conventions;
    - requires virtual host;
    - request must be sent to
       http://&lt;domain name|ip address &gt;/&lt;storage&gt;/[&lt;key&gt;]

       i.e GET request executes read command is called if
       
       Supported calls :
           Method - GET
           URL - http://localhost/test/
           REQUEST BODY - NULL
           EXECUTES - AbstractStorage::command('readAll') 
           DESCRIPTION - returns JSON array with all records in the storage
           
           Method - GET
           URL - http://localhost/test/1
           REQUEST BODY - NULL
           EXECUTES - AbstractStorage::command('read', [1]) 
           DESCRIPTION - returns JSON object with the record with key 1 in the storage or null
           
           Method - POST
           URL - http://localhost/test/
           REQUEST BODY - {"name" : "My Name", "value": "Harry"}
           EXECUTES - AbstractStorage::command('insert', [["name" => "My Name", "value" => "Harry"]]) 
           DESCRIPTION - inserts new entry in the storage , returns the generated key or throws exception
            
           Method - PUT
           URL - http://localhost/test/1
           REQUEST BODY - {"name" : "My Name", "value": "Harry"}
           EXECUTES - AbstractStorage::command('update', [1, ["name" => "My Name", "value" => "Harry"]]) 
           DESCRIPTION - rewrites the entry at key 1 with the new data ,returns nothing or throws exception
           
           Method - DELETE
           URL - http://localhost/test/
           REQUEST BODY - {"key" : "1"}
           EXECUTES - AbstractStorage::command('delete', [1]) 
           DESCRIPTION - deletes the entry at key 1 ,returns true|false or throws exception
       
Basic HTTP  - For non REST applications, 
    - params are sent in HTTP format in the url or in the request body
    - storage , operation and key are passed as parameters in the url
    - data is sent as request body in http format i.e. param1=value1&param2=value2
    - GET and POST request methods are used
    

    Supported calls :
           Method - GET
           URL - http://localhost/?route=test/readAll
           REQUEST BODY - NULL
           EXECUTES - AbstractStorage::command('readAll') 
           DESCRIPTION - returns JSON array with all records in the storage
           
           Method - GET
           URL - http://localhost/test?route=test/read&key=1
           REQUEST BODY - NULL
           EXECUTES - AbstractStorage::command('read', [1]) 
           DESCRIPTION - returns JSON object with the record with key 1 in the storage or null
           
           Method - POST
           URL - http://localhost/test?route=test/insert
           REQUEST BODY - name=My+Name&value=Harry
           EXECUTES - AbstractStorage::command('insert', [["name" => "My Name", "value" => "Harry"]]) 
           DESCRIPTION - inserts new entry in the storage , returns the generated key or throws exception
            
           Method - POST
           URL - http://localhost/test?route=test/update&key=1
           REQUEST BODY - name=My+Name&value=Harry
           EXECUTES - AbstractStorage::command('update', [1, ["name" => "My Name", "value" => "Harry"]]) 
           DESCRIPTION - rewrites the entry at key 1 with the new data ,returns nothing or throws exception
           
           Method - GET
           URL - http://localhost/test?route=test/delete&key=1
           REQUEST BODY -NULL
           EXECUTES - AbstractStorage::command('delete', [1]) 
           DESCRIPTION - deletes the entry at key 1 ,returns true|false or throws exception

Installation via composer
        Add following code to your composer.json
        ```javascript
        "repositories": [
             {
               "type": "vcs",
               "url" : "https://github.com/bashibozuk/HttpStub"
             }
           ],
           "require": {
             "bashibozuk/httpstub":"master"
           },
           "autoload": {
             "psr-4": { "HttpStub\\" : "bashibozuk/httpstub"}
           },
           "scripts": {
             "post-install-cmd" : [
               "HttpStub\\Installer::postInstall"
             ],
             "post-update-cmd" : [
               "HttpStub\\Installer::postInstall"
             ]
           },
           "extra": {
             "HttpStub": {
               "data-root": ".data"
             }
           }```
         And run
           `composer install`
         in the root folder of your directory
           