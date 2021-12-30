<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Laravel APIs Documentation

### HEADERS REQUIRED

 Make sure your request has following headers: 

'Accept' : 'application/json' <br>
'Authorization' : 'Bearer Token' <small class="text-muted">where required</small>
------------------------------------------------------------------------------------------

### API URLs

###### POST | REGISTER USER |
https://image-hosting-sharing-service.herokuapp.com/api/register

###### POST | LOGIN USER |
https://image-hosting-sharing-service.herokuapp.com/api/login

###### POST | LOGOUT USER |
https://image-hosting-sharing-service.herokuapp.com/api/logout

###### POST | FORGOT PASSWORD |
https://image-hosting-sharing-service.herokuapp.com/api/forgot-password

###### GET | USER PROFILE |
https://image-hosting-sharing-service.herokuapp.com/api/users/myprofile

###### POST| UPDATE USER PROFILE |
https://image-hosting-sharing-service.herokuapp.com/api/users/update

###### POST | UPLOAD IMAGE |
https://image-hosting-sharing-service.herokuapp.com/api/image/upload

###### DELETE | DELETE IMAGE 
https://image-hosting-sharing-service.herokuapp.com/api/image/delete/6

###### GET | FIND ALL IMAGES 
https://image-hosting-sharing-service.herokuapp.com/api/images/all

###### GET | FIND ALL IMAGES OF THE USER |
https://image-hosting-sharing-service.herokuapp.com/api/images

###### POST | CHANGE PRIVACY OF THE IMAGE | 
https://image-hosting-sharing-service.herokuapp.com/api/images/change-privacy/4

###### GET | FIND IMAGE BY ID|
https://image-hosting-sharing-service.herokuapp.com/api/images/4 

###### POST | ADD USER ACCESS |
https://image-hosting-sharing-service.herokuapp.com/api/images/addaccess

###### POST | REMOVE USER ACCESS  
https://image-hosting-sharing-service.herokuapp.com/api/images/removeaccess
---------------------------------------------------------------------------------------

### Authentication

###### • Register

URL : https://image-hosting-sharing-service.herokuapp.com/api/register

Parameters

{ <br>
            'name' : 'Test User' <br>
            'email' : 'testuser@gmail.com' <br>
            'password' : 123456 <br>
            'password_confirmation' : 123456 <br>
            'age' : '22' <br>
            'profile_picture' : base64 string <br>
} <br>


{ <br>
    "errors": false, <br>
    "data": { <br>
        "message": "User has been created successfully", <br>
        "user": { <br>
                "name": "test user", <br>
                "email": "testuser2@gmail.com", <br>
                "age": "22", <br>
                "profile_picture": "http://image-hosting-sharing-service.herokuapp.com/storage/profile-pictures/image-name.png" <br>
                } <br>
            } <br>
} <br>


###### Image References
####### Request

![Request](public/api-reference/register_request.jpg)

<img class="m-5" src="{{ asset('api-reference/register_request.jpg' ,true) }}" alt="">

####### Response

![Response](public/api-reference/register-response.jpg)