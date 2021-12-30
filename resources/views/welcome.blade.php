<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image sharing and hosting service</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <div class="d-flex justify-content-center">
        <h1>Laravel APIs Documentation</h1>
    </div>

    <div class="class m-3">

        <h2>
            EMAIL ACCOUNT<br>
        </h2>

        <p>
            <strong>Instructions:</strong>
            <a href="https://mailtrap.io/signin" target="_blank">Mailtrap</a> is being used for emailing service <br>

            login to receive the password sent by password reset api <br>

            Email : ******** <br>
            Password : ********* <br>
        </p>

        <hr>

        <h2>
            HEADERS REQUIRED<br>
        </h2>

        <p>
            Make sure your request has following headers: <br><br>

            'Accept' : 'application/json' <br>
            'Authorization' : 'Bearer Token' <small class="text-muted">where required</small> <br>
        </p>

        <hr>

        <h2>
            API URLs: <br>
        </h2>


        <p><strong class="text-warning">POST </strong><strong>| REGISTER USER |</strong><small class="text-muted"> Does not require 'Bearer Token'</small>&nbsp; https://image-hosting-sharing-service.herokuapp.com/api/register</p><br>
        <p><strong class="text-warning">POST </strong><strong>| LOGIN USER |</strong><small class="text-muted"> Does not require 'Bearer Token'</small>&nbsp; https://image-hosting-sharing-service.herokuapp.com/api/login</p><br>
        <p><strong class="text-warning">POST </strong><strong>| LOGOUT USER |</strong>&nbsp; https://image-hosting-sharing-service.herokuapp.com/api/logout</p><br>
        <p><strong class="text-warning">POST </strong><strong>| FORGOT PASSWORD |</strong><small class="text-muted"> Does not require 'Bearer Token'</small>&nbsp; https://image-hosting-sharing-service.herokuapp.com/api/forgot-password</p><br>
        <p><strong class="text-success">GET </strong><strong>| USER PROFILE |</strong>&nbsp; https://image-hosting-sharing-service.herokuapp.com/api/users/myprofile</p><br>
        <p><strong class="text-warning">POST </strong><strong>| UPDATE USER PROFILE |</strong>&nbsp; https://image-hosting-sharing-service.herokuapp.com/api/users/update</p><br>
        <p><strong class="text-warning">POST </strong><strong>| UPLOAD IMAGE |</strong>&nbsp; https://image-hosting-sharing-service.herokuapp.com/api/image/upload</p><br>
        <p><strong class="text-danger">DELETE </strong><strong>| DELETE IMAGE |</strong>&nbsp; https://image-hosting-sharing-service.herokuapp.com/api/image/delete/6 <small class="text-muted"> where 6 is id of the image</small></p><br>
        <p><strong class="text-success">GET </strong><strong>| FIND ALL IMAGES |</strong>&nbsp; https://image-hosting-sharing-service.herokuapp.com/api/images/all</p><br>
        <p><strong class="text-success">GET </strong><strong>| FIND ALL IMAGES OF THE USER |</strong>&nbsp; https://image-hosting-sharing-service.herokuapp.com/api/images</p><br>
        <p><strong class="text-warning">POST </strong><strong>| CHANGE PRIVACY OF THE IMAGE |</strong>&nbsp; https://image-hosting-sharing-service.herokuapp.com/api/images/change-privacy/4 <small class="text-muted"> where 4 is id of the image</small></p><br>
        <p><strong class="text-success">GET </strong><strong>| FIND IMAGE BY ID|</strong>&nbsp; https://image-hosting-sharing-service.herokuapp.com/api/images/4 <small class="text-muted"> where 4 is id of the image</small></p><br>
        <p><strong class="text-warning">POST </strong><strong>| ADD USER ACCESS |</strong>&nbsp; https://image-hosting-sharing-service.herokuapp.com/api/images/addaccess</p><br>
        <p><strong class="text-warning">POST </strong><strong>| REMOVE USER ACCESS |</strong>&nbsp; https://image-hosting-sharing-service.herokuapp.com/api/images/removeaccess</p><br>

        <hr>
        
        <h2>
            Authentication
        </h2>
        <h3>
            • Register
        </h3>
        <p>
            URL : https://image-hosting-sharing-service.herokuapp.com/api/register<br>

            <span class="font-weight-bold">Parameters</span><br>

            { <br>
            'name' : 'Test User' <br>
            'email' : 'testuser@gmail.com' <br>
            'password' : 123456 <br>
            'password_confirmation' : 123456 <br>
            'age' : '22' <br>
            'profile_picture' : base64 string <br>
            <span class="text-danger">'security_answer' : alpha </span> <span class="text-success">// Has been temporarily removed </span><br>
            } <br>


            <span class="font-weight-bold">Response: </span><br>
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

        </p>

        <h3>Image References</h3>
        <span class="font-weight-bold">Request: </span><br>

        <img class="m-5" src="{{ asset('api-reference/register_request.jpg' ,true) }}" alt="">

        <br><span class="font-weight-bold">Response: </span><br>

        <img class="m-5" src="{{ asset('api-reference/register-response.jpg' ,true) }}" alt="">

        <hr>

        <h3>
            • Login
        </h3>
        <p>
            URL : https://image-hosting-sharing-service.herokuapp.com/api/login<br>

            <span class="font-weight-bold">Parameters: </span><br><br>

            { <br>
            'email' : 'testuser@gmail.com' <br>
            'password' : 123456 <br>
            } <br>

            <span class="font-weight-bold">Response: </span><br>
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
            "token": "bnasbmasdnmasbm.MDAwMCwiZGF0YSI6MX0.rOwCjuny9TLSsf9Lc <br>
            MzeSuGzGU8Yez1kzWW3jzsViA4" <br>
            } <br>
            } <br>
        </p>

        <h3>Image References</h3>
        <span class="font-weight-bold">Request: </span><br>

        <img class="m-5" src="{{ asset('api-reference/login_request.jpg' ,true) }}" alt="">

        <br><span class="font-weight-bold">Response: </span><br>

        <img class="m-5" src="{{ asset('api-reference/login_response.jpg' ,true) }}" alt="">

        <hr>

        <h3>
            • Logout
        </h3>

        <h3>Image References</h3>

        <img class="m-5" src="{{ asset('api-reference/logout_request_response.jpg' ,true) }}" alt="">

        <hr>


        <h3>
            • Forgot Password
        </h3>

        <h3>Image References</h3>
        <span class="font-weight-bold">Request: </span><br>

        <img class="m-5" src="{{ asset('api-reference/forgot_password_request.jpg' ,true) }}" alt="">

        <br><span class="font-weight-bold">Response: </span><br>

        <img class="m-5" src="{{ asset('api-reference/forgot_password_response.jpg' ,true) }}" alt="">

        <hr>

        <h3>
            • My Profile
        </h3>

        <h3>Image References</h3>
        <img class="m-5" src="{{ asset('api-reference/myprofile.jpg' ,true) }}" alt="">
        <br>

        <hr>

        <h3>
            • Update Profile
        </h3>

        <h3>Image References</h3>
        <span class="font-weight-bold">Request: </span><br>

        <img class="m-5" src="{{ asset('api-reference/user_update_request.jpg' ,true) }}" alt="">

        <br><span class="font-weight-bold">Response: </span><br>

        <img class="m-5" src="{{ asset('api-reference/user_update_response.jpg' ,true) }}" alt=""> <br>

        <hr>

        <h3>
            • Upload Images
        </h3>

        <h3>Image References</h3>
        <span class="font-weight-bold">Request: </span><br>

        <img class="m-5" src="{{ asset('api-reference/image_upload_request.jpg' ,true) }}" alt="">

        <br><span class="font-weight-bold">Response: </span><br>

        <img class="m-5" src="{{ asset('api-reference/image_upload_response.jpg' ,true) }}" alt=""> <br>

        <hr>

        <h3>
            • Image Delete
        </h3>

        <h3>Image References</h3>

        <img class="m-5" src="{{ asset('api-reference/image_delete.jpg' ,true) }}" alt=""> <br>

        <hr>

        <h3>
            • All Images
        </h3>

        <h3>Image References</h3>

        <img class="m-5" src="{{ asset('api-reference/all_images.jpg' ,true) }}" alt=""> <br>

        <hr>

        <h3>
            • All Images by the user
        </h3>

        <h3>Image References</h3>
        <img class="m-5" src="{{ asset('api-reference/get_all_images_by_user.jpg' ,true) }}" alt=""> <br>
        <hr>

        <h3>
            • Change Privacy of the image
        </h3>
        <p>True => Private => 1 <br> False => Public => 0 <br> NULL => Hidden</p>
        <h3>Image References</h3>
        <img class="m-5" src="{{ asset('api-reference/image_privacy.jpg' ,true) }}" alt=""> <br>
        <hr>

        <h3>
            • Find image by id
        </h3>
        <h3>Image References</h3>
        <img class="m-5" src="{{ asset('api-reference/find_image_by_id.jpg' ,true) }}" alt=""> <br>
        <hr>

        <h3>
            • Add access
        </h3>
        <h3>Image References</h3>
        <img class="m-5" src="{{ asset('api-reference/add_access.jpg' ,true) }}" alt=""> <br>
        <hr>

        <h3>
            • Remove access
        </h3>
        <h3>Image References</h3>
        <img class="m-5" src="{{ asset('api-reference/remove_access.jpg' ,true) }}" alt=""> <br>
        <hr>
    </div>
</body>

</html>