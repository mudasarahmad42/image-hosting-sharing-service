<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmEmail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Token;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Throwable;

use App\Helpers;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\NewPasswordRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AuthResource;
use App\Mail\PasswordResetMail;
use App\Models\PasswordReset;
use Illuminate\Support\Str;
use App\Services\service;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /*

    /*
     Functions to get extensions from base64 code
     */
    function getBytesFromHexString($hexdata)
    {
        for ($count = 0; $count < strlen($hexdata); $count += 2)
            $bytes[] = chr(hexdec(substr($hexdata, $count, 2)));

        return implode($bytes);
    }

    function getImageMimeType($imagedata)
    {
        $imagemimetypes = array(
            "jpeg" => "FFD8",
            "png" => "89504E470D0A1A0A",
            "gif" => "474946",
            "bmp" => "424D",
            "tiff" => "4949",
            "tiff" => "4D4D"
        );

        foreach ($imagemimetypes as $mime => $hexbytes) {
            $bytes = $this->getBytesFromHexString($hexbytes);
            if (substr($imagedata, 0, strlen($bytes)) == $bytes)
                return $mime;
        }

        return 'jpg';
    }


    /*
        Function to create a new user
    */
    public function register(RegisterRequest $request)
    {
        try {
            $fields = $request->validated();

            $image = $request->profile_picture;  // your base64 encoded
            // $image = str_replace('data:image/jpg;base64,', '', $image);

            $trimImage = explode(",", $image);
                foreach ($trimImage as $value) {
                    $trimmedBase64 = trim($value);
                }


            //Get Extension
            $imgdata = base64_decode($trimmedBase64);
            $extension = $this->getImageMimeType($imgdata);

            $trimmedBase64 = str_replace(' ', '+', $trimmedBase64);
            $imageName = Str::random(10) . '.' . $extension;
            $imagePath = 'storage/profile-pictures/' . $imageName;

            Storage::disk('profile-pictures')->put($imageName, base64_decode($trimmedBase64));

            $user = User::create([
                'name' => $fields['name'],
                'email' => $fields['email'],
                'password' => bcrypt($fields['password']),
                //'security_answer' => $fields['security_answer'],
                'age' => $fields['age'],
                'profile_picture' => asset($imagePath, true),
            ]);

            $response = [
                'message' => 'User has been created successfully',
                'user' => new AuthResource($user),
            ];

            return response()->success($response, 201);
        } catch (Throwable $e) {
            return response()->error($e->getMessage());
        }
    }


    /*
        Function to login the user by assigning a token to it
    */
    public function login(LoginRequest $request)
    {
        try {

            $fields = $request->validated();

            // Check email
            $user = User::where('email', $fields['email'])->first();

            if ($user == null) {
                return response()->error('User does not exist');
            }

            $token = (new service)->createToken($user->id);

            // Check password
            if (!$user || !Hash::check($fields['password'], $user->password)) {

                return response()->error('Invalid credentials');
            }

            //Check if user is already logged in
            $isLoggedIn = Token::where('user_id', $user->id)->first();

            if ($isLoggedIn) {

                $loggedInResponse = [
                    'message' => 'User is already logged in',
                    'user' => new AuthResource($user),
                    'token' => $token
                ];

                //By using ResponseServiceProvider
                return response()->success($loggedInResponse, 201);
            }

            //Store token in database
            $saveToken = Token::create([
                'user_id' => $user->id,
                'token' => $token
            ]);

            $response = [
                'message' => 'Logged in successfully',
                'user' => new AuthResource($user),
                'token' => $token
            ];

            return response()->success($response, 201);
        } catch (Throwable $e) {
            return response()->error($e->getMessage(), 404);
        }
    }


    /*
        Function to logout the user by deleting its JWT token
    */
    public function logout(Request $request)
    {
        try {
            //Get user id
            $getUserId = getUserId($request);

            $userExists = Token::where('user_id', $getUserId)->first();

            if ($userExists) {
                $userExists->delete();
            } else {
                // If middleware is bypassed we can still return this respone
                // currently middleware is returning 'Unauthorized' response if it does
                // not find token against this user in the Token table
                return response()->error('This user is already logged out', 404);
            }

            return response()->success('Logout Succesfully');
        } catch (Throwable $e) {
            return response()->error($e->getMessage());
        }
    }



    /*
        Function to confirm the user registration by email
        this function can be hit through the link sent to the user
        to their email address
    */
    public function EmailConfirmation($email, $token)
    {
        try {
            $userExists = User::where('email', $email)->first();

            if (!$userExists) {
                return response()->error('Something went wrong!');
            }

            $userToken = $userExists->verification_token;

            if ($userToken != $token) {
                return response()->error('Invalid link', 401);
            }

            if ($userExists->email_verified_at != null) {
                return response()->error('Your link has expired', 410);
            }

            $userExists->email_verified_at = time();
            $userExists->save();
            return response()->success('Email Confirmed', 201);
        } catch (Throwable $e) {
            return response()->error($e->getMessage());
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {

        $fields = $request->validated();

        $userExists = User::where('email', $fields['email'])->first();

        if (!$userExists) {
            return response()->error('Sorry! Account recovery failed');
        }

        //if ($fields['security_answer'] == $userExists->security_answer) {

            $generatePassword = (string) Str::uuid();

            $newPassword = Str::limit($generatePassword, 8, '');

            $url = $newPassword;

            $userExists->password = bcrypt($newPassword);
            $userExists->save();

            Mail::to($fields['email'])->send(new PasswordResetMail($url, config("batalew787@ecofreon.com")));

            return response()->success('Use the new password sent to your email address to login to your account');
        // } else {
        //     return response()->success('Unsuccessful attempt to reset the password');
        // }
    }


    public function passwordReset(NewPasswordRequest $request, $email, $token)
    {
        try {
            $getUser = User::where('email', $email)->first();

            if (!$getUser) {
                return response()->error('No such user exists');
            }

            $passwordReset = PasswordReset::where('email', $email)->where('token', $token)->first();

            $passwordResetToken = $passwordReset->token;

            if ($passwordResetToken != $token) {
                return response()->error('You are not authorized to use this link', 401);
            }

            if ($passwordReset->expired == 1) {
                return response()->error('Your link has expired', 410);
            }

            $getUser->password = bcrypt($request['new_password']);
            $passwordReset->expired = 1;

            //Save Changes
            $passwordReset->save();
            $getUser->save();

            return response()->success('Password changed');
        } catch (Throwable $e) {
            return response()->error($e->getMessage());
        }
    }
}
