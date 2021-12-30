<?php

namespace App\Http\Middleware;

use App\Models\Token;
use App\Models\User;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class CAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //Get Bearer Token
        $getToken = $request->bearerToken();

        if(!$getToken)
        {
            return response([
                'message' => 'Bearer token not found'
            ]);
        }
        
        $ifJSON = $request->header('Accept');
        
        if($ifJSON != 'application/json')
        {
            return response([
                'message' => 'API expects JSON data, set "Accept" Header as application/json'
            ]);
        }

        //Decode
        $decoded = JWT::decode($getToken, new Key('ProgrammersForce', 'HS256'));

        //Get Id
        $userId = $decoded->data;

        $user = User::where('id' , $userId)->first();

        //Send user object along with $request variable
        $request = $request->merge(array('user' => $user));

        $userExists = Token::where('user_id', $userId)->first();

        if (isset($userExists)) {
            return $next($request);
        } else {
            return response([
                'message' => 'Unauthorized'
            ],401);
        }
    }
}
