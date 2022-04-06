<?php
namespace App\GraphQL\Queries;

use GraphQL;
use Closure;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class UserQuery extends Query {

    protected $attributes = [
        'name'  => 'user',
    ];

    private $jwt;
    
    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        try {
            $this->auth = $this->jwt->parseToken()->authenticate();
        } catch (\Exception $e) {
            $this->auth = null;
        }
        return (boolean) $this->auth;
    }

    public function type(): Type
    {
        return GraphQL::type('User'); //retrieve a single user
    }

    public function rules(array $args = []): array
    {
        return [
            'id' => [
                'required',
                'numeric',
                'min:1',
                'exists:user,id'
            ],
        ];
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return User::findOrFail($args['id']);
    }

}

/* 
namespace App\GraphQL\Queries;
use Closure;
use App\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;
class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'user query'
    ];
    private $jwt;
    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }
    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
      try {
          $this->auth = $this->jwt->parseToken()->authenticate();
      } catch (\Exception $e) {
          $this->auth = null;
      }
      return (boolean) $this->auth;
    }
    public function type(): Type
    {
        return Type::listOf(GraphQL::type('user'));
    } 
    public function args(): array
    {
        return [
        ];
    }
    public function resolve($root, $args)
        {
            $users = User::all();
            return $users;
        } 
}
*/