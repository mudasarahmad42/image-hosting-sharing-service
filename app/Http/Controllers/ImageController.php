<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserRequest;
use App\Http\Requests\ImagePrivacyRequest;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Models\SharedImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ImageController extends Controller
{
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

        return 'jpeg';
    }

    public function imageUpload(ImageUploadRequest $request)
    {
        try {
            //Validate the fields
            $fields = $request->validated();

            //Get Id
            $userId = getUserId($request);

            $image = $request->image;  // your base64 encoded

            $trimImage = explode(",", $image);
            foreach ($trimImage as $value) {
                $trimmedBase64 = trim($value);
            }


            //Get Extension
            $imgdata = base64_decode($trimmedBase64);
            $extension = $this->getImageMimeType($imgdata);

            $trimmedBase64 = str_replace(' ', '+', $trimmedBase64);
            $imageName = Str::random(10) . '.' . $extension;
            $imagePath = 'storage/images/' . $imageName;

            Storage::disk('images')->put($imageName, base64_decode($trimmedBase64));


            //Add the image
            $image = Image::create([
                //'name' => $fields['name'] . '_' . (string) Str::uuid(),
                'name' => $fields['name'],
                'user_id' => $userId,
                'extension' => $extension,
                'privacy' => null,
                'path' =>  asset($imagePath, true),
            ]);

            $response = [
                'image' => $image,
                'message' => 'Image Uploaded Successfully'
            ];

            //Return HTTP 201 status, call was successful and something was created
            return response()->success($response, 201);
        } catch (Throwable $e) {
            return response()->error($e->getMessage());
        }
    }


    public function deleteImageById(Request $request, $id)
    {
        try {
            //Get Id
            $userId = getUserId($request);

            //Get Image by Id
            $image = Image::find($id);

            if ($image == null) {
                return response()->error('Image not found', 404);
            }

            if ($userId != $image->user_id) {
                return response()->error('You are not authorized to perform this action', 401);
            }

            /* 
                    Change this to http://127.0.0.1:8000 when testing on local server 
                */

            $fileDirectory = str_replace('https://image-hosting-sharing-service.herokuapp.com', public_path(), $image->path);

            //Delete image
            if (file_exists($fileDirectory)) {
                unlink($fileDirectory);
            }

            //delete record from database
            $image->delete();

            return response()->success('Image deleted successfully');
        } catch (Throwable $e) {
            return response()->error($e->getMessage());
        }
    }


    public function findAll()
    {
        try {

            //Get all images
            $images = Image::all();

            if ($images->isEmpty()) {
                return response()->success('No images found');
            }

            return response()->success(ImageResource::collection($images));
        } catch (Throwable $e) {
            return response()->error($e->getMessage());
        }
    }


    public function findById(Request $request, $id)
    {
        try {

            //Get Id
            $userId = getUserId($request);
            
            //Get image
            $image = Image::find($id);

            if (!$image) {
                return response()->error('No such image found');
            }

            //Get privacy of the image
            $imagePrivacy = $image->privacy;

            //If image is hidden return the appropriate response
            if ($imagePrivacy === null) {
                if ($image->user_id == $userId) {
                    return $image;
                }
                return response()->error('This image is not available');
            }

            //If image is public return the image
            if ($imagePrivacy === 0) {
                return $image;
            }


            //If image is private return the image to users that have access to this image
            if ($imagePrivacy == 1) {
                //Get the list of user_ids that have access to this particular image
                $allowedUsers = SharedImage::where('image_id', $id)->pluck('user_id')->toArray();

                if (in_array($userId, $allowedUsers) || $image->user_id == $userId) {
                    return $image;
                }

                return response()->error('This image is private or perhaps never existed');
            }

            return response()->error('Something went wrong');
        } catch (Throwable $e) {
            return response()->error($e->getMessage());
        }
    }


    // public function findByLink(Request $request, $link)
    // {
    //     try {

    //         //Get Id
    //         $userId = getUserId($request);

    //         //Get image
    //         $image = Image::where('path', $link)->first();

    //         $imageId = $image->id;

    //         if (!$image) {
    //             return response()->error('No such image found');
    //         }

    //         //Get privacy of the image
    //         $imagePrivacy = $image->privacy;

    //         //If image is hidden return the appropriate response
    //         if ($imagePrivacy === null) {
    //             if($image->user_id == $userId)
    //             {
    //                 return $image;
    //             }
    //             return response()->error('This image is not available');
    //         }

    //         //If image is public return the image
    //         if ($imagePrivacy === 0) {
    //             return $image;
    //         }


    //         //If image is private return the image to users that have access to this image
    //         if ($imagePrivacy == 1) {
    //             //Get the list of user_ids that have access to this particular image
    //             $allowedUsers = SharedImage::where('image_id', $imageId)->pluck('user_id')->toArray();

    //             if (in_array($userId, $allowedUsers)) {
    //                 return $image;
    //             }
    //         }

    //         return response()->error('Something went wrong');
    //     } catch (Throwable $e) {
    //         return response()->error($e->getMessage());
    //     }
    // }


    public function findAllByUser(Request $request)
    {
        try {
            //Get Id
            $userId = getUserId($request);

            //Get Image by Id
            $images = Image::where('user_id', $userId)->get();

            if ($images->isEmpty()) {
                return response()->success('No images found');
            }

            return response()->success(ImageResource::collection($images));
        } catch (Throwable $e) {
            return response()->error($e->getMessage());
        }
    }


    public function getUser($id)
    {
        //Get user by Id
        $user = $this->getUser($id);

        if (!$user) {
            return response()->error('Something went wrong');
        } else {
            return $user;
        }
    }

    public function changePrivacy(ImagePrivacyRequest $request, $id)
    {
        try {

            $fields = $request->validated();

            //Get Id
            $userId = getUserId($request);

            //Get Image by Id
            $image = Image::find($id);

            if ($image == null) {
                return response()->error('Image not found', 404);
            }

            if ($userId != $image->user_id) {
                return response()->error('You are not authorized to perform this action', 401);
            }

            $image->privacy = $fields['privacy'];
            $image->save();

            //Return HTTP 201 status, call was successful and something was created
            return response()->success('Image privacy changed successfully');
        } catch (Throwable $e) {
            return response()->error($e->getMessage());
        }
    }


    public function addUserAccess(AddUserRequest $request)
    {
        try {

            $fields = $request->validated();

            //Get Id
            $userId = getUserId($request);

            //Get Image by Id
            $image = Image::find($fields['image_id']);

            if($image == null)
            {
                return response()->error('No such images exists');
            }

            if ($userId != $image->user_id) {
                return response()->error('You are not authorized to perform this action');
            }

            if ($userId == $fields['user_id']) {
                return response()->error('You already have access to your image');
            }

            $alreadyAccessible = SharedImage::where('user_id', $fields['user_id'])->where('image_id', $fields['image_id'])->first();

            if ($alreadyAccessible) {
                return response()->error('You already have access to this image');
            }

            //Add user in the list of people who have access to this image
            SharedImage::create([
                'user_id' => $fields['user_id'],
                'image_id' => $fields['image_id'],
            ]);
            

            return response()->success('User has been granted access to this image');
        } catch (Throwable $e) {
            return response()->error($e->getMessage());
        }
    }


    public function removeUserAccess(AddUserRequest $request)
    {
        try {

            $fields = $request->validated();

            //Get Id
            $userId = getUserId($request);

            //Get Image by Id
            $image = Image::find($fields['image_id']);

            if($image == null)
            {
                return response()->error('No such images exists');
            }

            if ($userId != $image->user_id) {
                return response()->error('You are not authorized to perform this action');
            }

            if ($userId == $fields['user_id']) {
                return response()->error('You already have access to your image');
            }

            $exists = SharedImage::where('user_id', $fields['user_id'])->where('image_id', $fields['image_id'])->first();

            if ($exists != null) {
                $exists->delete();
                $exists->save();

                return response()->success('You have revoked the access of this image for this user');
            }

            return response()->error('Something went wrong');
        } catch (Throwable $e) {
            return response()->error($e->getMessage());
        }
    }
}
