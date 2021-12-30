<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthResource;
use App\Http\Resources\MyProfileResource;
use App\Models\Token;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class UserController extends Controller
{
    /*
        Returns user profile
        parameter: user_id
    */
    public function myProfile(Request $request)
    {
        try {
            //Get Id
            $userId = getUserId($request);


            $getUser = User::find($userId);

            if (isset($getUser)) {
                return response()->success(new MyProfileResource($getUser));
            } else {
                return response()->error('No user found', 404);
            }
        } catch (Throwable $e) {
            return response()->error($e->getMessage());
        }
    }


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

        return 'jpeg';
    }


    /*
        update user's data
    */
    public function update(Request $request)
    {
        try {
            //Get Id
            $userId = getUserId($request);

            $user = User::find($userId);

            //Get image path
            $imagePath = $user->profile_picture;

            $user->update($request->all());

            if ($request->profile_picture != null) {

                /* 
                    Change this to http://127.0.0.1:8000 when testing on local server 
                */
                
                $fileDirectory = str_replace('https://image-hosting-sharing-service.herokuapp.com', public_path(), $imagePath);

                //Delete previous image
                if (file_exists($fileDirectory)) {
                    unlink($fileDirectory);
                }

                //Upload new image
                $image = $request->profile_picture;  // your base64 encoded

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



                $user->profile_picture = asset($imagePath, true);
                $user->save();
            }

            $response = [
                'message' => 'User updated successfully',
                'user' => new AuthResource($user),
            ];

            return response()->success($response);
        } catch (Throwable $e) {
            return response()->error($e->getMessage());
        }
    }

    /*
        Optional functions
    */

    /*
        delete user's data
    */

    public function deleteUser($id)
    {
        try {
            $getUser = User::destroy($id);

            if ($getUser == 1) {
                return response()->success('User deleted succesfully');
            } elseif ($getUser == 0) {
                return response()->error('Already deleted', 404);
            } else {
                return response()->error('No user found', 404);
            }
        } catch (Throwable $e) {
            return response()->error($e->getMessage());
        }
    }

    public function deleteTokenById($id)
    {
        try {
            $getUser = Token::where('user_id', $id)->first();

            if ($getUser == null) {
                return response()->error('No user found', 404);
            }

            $deleteResult = $getUser->delete();

            if ($deleteResult) {
                return response()->success('Token deleted succesfully');
            } else {
                return response()->error('Something went wrong', 404);
            }
        } catch (Throwable $e) {
            return response()->error($e->getMessage());
        }
    }


    public function delete(Request $request)
    {
        try {
            //Get Id
            $userId = getUserId($request);

            //if ($userId == $id) {
                $getUser = User::destroy($userId);

                if ($getUser == 1) {
                    return response()->success('User Deleted Succesfully');
                } elseif ($getUser == 0) {
                    return response()->error('Already deleted', 404);
                } else {
                    return response()->error('No user found', 404);
                }
            // } else {
            //     return response()->error('You are not authorized to perform this action', 401);
            // }
        } catch (Throwable $e) {
            return response()->error($e->getMessage());
        }
    }


    /*
        search user's by name
    */
    public function searchByName($name)
    {
        try {
            return response()->success(AuthResource::collection(User::where('name', 'like', '%' . $name . '%')->get()));
        } catch (Throwable $e) {
            return response()->error($e->getMessage());
        }
    }
}
