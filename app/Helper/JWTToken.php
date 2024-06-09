<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class JWTToken
{
    public static function CreateToken($email, $userID): string
    {
        $key = env("JWT_KEY");
        $payload = [
            "iss" => "promit",
            "iat" => time(),
            "exp" => time() + 3600,
            "email" => $email,
            "id"=>$userID
        ];
        return JWT::encode($payload, $key, 'HS256');


    }
    public static function VerifyToken($token): string|object
    {
        try {
            if ($token === null) {
                return "Unauthozized";
            } else {
                $key = env("JWT_KEY");
                $decode = JWT::decode($token, new Key($key, 'HS256'));
                return $decode;
            }

        } catch (Exception $e) {
            return "Unauthozized";
        }
    }
    public static function CreateTokenForSetPassword($email, $userID): string
    {
        $key = env("JWT_KEY");
        $payload = [
            "iss" => "promit",
            "iat" => time(),
            "exp" => time() + 60 * 60,
            "email" => $email,
            "id" => $userID
        ];
        return JWT::encode($payload, $key, "HS256");
    }
}
