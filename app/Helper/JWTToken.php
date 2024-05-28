<?php 

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class JWTToken
{
    public static function CreateToken($email):string
    {
        $key=env("JWT_KEY");
        $payload=[
            "iss"=>"promit",
            "iat"=>time(),
            "exp"=>time()+3600,
            "email"=>$email
            ];
       return JWT::encode($payload,$key,'HS256');


    }
    public static function VerifyToken($token):string
    {
        try{
            $key=env("JWT_KEY");
            $decode=JWT::decode($token,new Key($key,'HS256'));
            return $decode->email;

        }
        catch(Exception $e)
        {
            return "Unauthozized";
        }
    }
    public static function CreateTokenForSetPassword($email):string
    {
        $key=env("JWT_KEY");
        $payload=[
            "iss"=>"promit",
            "iat"=>time(),
            "exp"=>time()+60*60,
            "email"=>$email
        ];
       return JWT::encode($payload,$key,"HS256");
    }
}