<?php

namespace App\GraphQL\Types;

use GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use App\Models\User;
use App\Models\Creditcard;

class CreditcardType extends GraphQLType {

    protected $attributes = [
        'name'          => 'Creditcard', //defining the GraphQL type name
        'description'   => 'Users credit card status', //providing a description for the GraphQL type name
        'model'         => Creditcard::class, //mapping the GraphQL type to the Laravel model
    ];

    public function fields(): array
    {
        return [
            'credit_card' => [
                'type'          => Type::nonNull(Type::string()),
                'description'   => 'Credit card type of the user',
            ]
        ];
    }
}
