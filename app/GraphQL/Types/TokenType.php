<?php

namespace App\GraphQL\Types;

use GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class TokenType extends GraphQLType {

    protected $attributes = [
        'name' => 'Token', //defining the GraphQL type name
    ];

    public function fields(): array
    {
        return [
            'token' => [
                //defining the id field as a non-null integer
                'type'          => Type::nonNull(Type::string()),
            ],
        ];
    }
}
