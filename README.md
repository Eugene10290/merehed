#merehead tes

To install run
* ``docker-compose up --build `` 
* cd /src ``npm install && mpm run dev`` // I didn`t use node container
* ``docker-compose exec web bash => php artisan migrate``
* visit ``127.0.0.1:8080/api``

Postman collection export located in ```./merehead.postman_collection.json```
I got an error when I tried to share my collection "Something went wrong while generating a shareable link for your collection. Try again after sometime." So I used this way