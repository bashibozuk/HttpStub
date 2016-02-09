HTTP
``
    - readAll   curl -G -d 'route=test/readAll' -v http://http-stub.local
    - read      curl -G -d 'route=test/read&key=1' -v http://http-stub.local
    - insert    curl  -d 'name=John Doe' -v 'http://http-stub.local/?route=test/insert'
    - update    curl  -d 'name=Jane Doe' -v 'http://http-stub.local/?route=test/update&key=1'
    - delete    curl -G -d 'route=test/delete&key=1' -v http://http-stub.local
``
    
REST
    - readAll   curl -G -v http://http-stub.local/test
    - read      curl -G http://http-stub.local/test/1
    - insert    curl  -d '{"name": "John Doe"}' -v 'http://http-stub.local/test/'
    - update    curl -X PUT -d '{"name": "Jane Doe"}' -v http://http-stub.local/test/4
    - delete    curl -G -d 'route=test/delete&key=1' -v http://http-stub.local