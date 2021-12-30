<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Laravel APIs Documentation

### HEADERS REQUIRED

 Make sure your request has following headers: 

###### 'Accept' : 'application/json'
###### 'Authorization' : 'Bearer Token'
------------------------------------------------------------------------------------------

### API URLs

###### POST | REGISTER USER
https://image-hosting-sharing-service.herokuapp.com/api/register

###### POST | LOGIN USER
https://image-hosting-sharing-service.herokuapp.com/api/login

###### POST | LOGOUT USER
https://image-hosting-sharing-service.herokuapp.com/api/logout

###### POST | FORGOT PASSWORD
https://image-hosting-sharing-service.herokuapp.com/api/forgot-password

###### GET | USER PROFILE
https://image-hosting-sharing-service.herokuapp.com/api/users/myprofile

###### POST| UPDATE USER PROFILE
https://image-hosting-sharing-service.herokuapp.com/api/users/update

###### POST | UPLOAD IMAGE
https://image-hosting-sharing-service.herokuapp.com/api/image/upload

###### DELETE | DELETE IMAGE 
https://image-hosting-sharing-service.herokuapp.com/api/image/delete/6

###### GET | FIND ALL IMAGES 
https://image-hosting-sharing-service.herokuapp.com/api/images/all

###### GET | FIND ALL IMAGES OF THE USER
https://image-hosting-sharing-service.herokuapp.com/api/images

###### POST | CHANGE PRIVACY OF THE IMAGE
https://image-hosting-sharing-service.herokuapp.com/api/images/change-privacy/4

###### GET | FIND IMAGE BY ID
https://image-hosting-sharing-service.herokuapp.com/api/images/4 

###### POST | ADD USER ACCESS
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

###### Request

![Request](public/api-reference/register_request.jpg)

###### Response

![Response](public/api-reference/register-response.jpg)
---------------------------------------------------------------------------------------


###### • Login

URL : https://image-hosting-sharing-service.herokuapp.com/api/login

{
'email' : 'testuser@gmail.com' <br>
'password' : 123456 <br>
}

Response: <br>
{ <br>
"errors": false, <br>
"data": { <br>
"message": "Logged in successfully", <br>
"user": { <br>
"name": "test user", <br>
"email": "testuser@gmail.com", <br>
"age": "22" <br>
"profile_picture": "http://image-hosting-sharing-service.herokuapp.com/storage/profile-pictures/image-name.png" <br>
}, <br>
"token": "bnasbmasdnmasbm.MDAwMCwiZGF0YSI6MX0.rOwCjuny9TLSsf9Lc
MzeSuGzGU8Yez1kzWW3jzsViA4" <br>
} <br>
} <br>


###### Image References

Request:

![Request](public/api-reference/login_request.jpg)

Response:

![Response](public/api-reference/login_response.jpg)
--------------------------------------------------------------------------------------

###### • Logout

Image References

![Request](public/api-reference/logout_request_response.jpg)
--------------------------------------------------------------------------------------

###### • Forgot Password

Image References

Request:

![Request](public/api-reference/forgot_password_request.jpg)

Response:

![Response](public/api-reference/forgot_password_response.jpg)
---------------------------------------------------------------------------------------

###### • My Profile

![Request&Response](public/api-reference/myprofile.jpg)


###### • Update Profile

Image References

Request: 
![Request](public/api-reference/user_update_request.jpg)

Response:

![Response](public/api-reference/user_update_response.jpg)

###### • Upload Images

Image References

Request:

![Request](public/api-reference/image_upload_request.jpg)

Response:

![Request](public/api-reference/image_upload_response.jpg)
--------------------------------------------------------------------------------------

###### • Image Delete

Image References

![Request&Response](public/api-reference/image_delete.jpg)
--------------------------------------------------------------------------------------

###### • All Images

Image References

![Request&Response](public/api-reference/all_images.jpg)
--------------------------------------------------------------------------------------

###### • All Images by the user

Image References

![Request&Response](public/api-reference/get_all_images_by_user.jpg)
--------------------------------------------------------------------------------------

###### • Change Privacy of the image

True => Private => 1 <br> 
False => Public => 0 <br> 
NULL => Hidden

Image References

![Request&Response](public/api-reference/image_privacy.jpg)
---------------------------------------------------------------------------------------

###### • Find image by id

Image References

![Request&Response](public/api-reference/find_image_by_id.jpg)
--------------------------------------------------------------------------------------

###### • Add access

Image References

![Request&Response](public/api-reference/add_access.jpg)
---------------------------------------------------------------------------------------

###### • Remove access

Image References

![Request&Response](public/api-reference/remove_access.jpg)