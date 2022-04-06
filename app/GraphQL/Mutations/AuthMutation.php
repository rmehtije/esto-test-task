<?php

namespace App\GraphQL\Mutations;

use GraphQL;
use Closure;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class AuthMutation extends Mutation
{
    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    protected $attributes = [
        'name' => 'login'
    ];

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        return true;
    }

    public function type(): Type
    {
        return GraphQL::type('Token');
    }

    public function args(): array
    {
        return [
            'email' => [
                'name' => 'email',
                'type' =>  Type::nonNull(Type::string()),
            ],
            'password' => [
                'name' => 'password',
                'type' =>  Type::nonNull(Type::string()),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = $this->jwt->attempt($args)) {
                return json_encode(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return json_encode(['error' => 'could_not_create_token'], 500);
        }
        // all good so return the token
        return json_encode(compact('token'));
    }
}
