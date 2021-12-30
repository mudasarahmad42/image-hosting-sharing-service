<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

if(!function_exists('getUserId'))
{
    function getUserId(Request $request)
    {
        //Get Bearer Token
        $getToken = $request->bearerToken();

        if (!$getToken) {
            return null;
        }
        
        //Decode
        $decoded = JWT::decode($getToken, new Key('ProgrammersForce', 'HS256'));
    
        //Get Id
        return $decoded->data;
    }
}

?>