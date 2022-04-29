<?php

declare(strict_types=1);

namespace App\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\OpenApi;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
final class OpenApiFactory implements OpenApiFactoryInterface
{
    public function __construct(private readonly OpenApiFactoryInterface $decorated)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);
        $paths = $openApi->getPaths();
        $paths->addPath('/stats', new PathItem(null, null, null, new Operation(
                'get',
                ['Stats'],
                [
                    Response::HTTP_OK => [
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'books_count' => [
                                            'type' => 'integer',
                                            'example' => 997,
                                        ],
                                        'topbooks_count' => [
                                            'type' => 'integer',
                                            'example' => 101,
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'Retrieves the number of books and top books (legacy endpoint).'
            )
        ));
        $paths->addPath('/profile', new PathItem(null, null, null, new Operation(
                'get',
                ['Profile'],
                [
                    Response::HTTP_OK => [
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'id' => ['type' => 'string'],
                                        'email' => ['type' => 'string'],
                                        'roles' => ['type' => 'array'],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'Show the current user profile.'
            )
        ));

        return $openApi;
    }
}
