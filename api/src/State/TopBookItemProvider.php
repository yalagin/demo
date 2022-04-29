<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Exception\InvalidIdentifierException;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\TopBook;
use App\Repository\TopBook\TopBookDataInterface;

final class TopBookItemProvider implements ProviderInterface
{
    public function __construct(private TopBookDataInterface $repository)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = [])
    {
        $resourceClass = $operation->getClass();
        $id = $uriVariables['id'] ?? null;

        if (TopBook::class !== $resourceClass) {
            // todo Throw exception
        }

        if (!is_int($id)) {
            throw new InvalidIdentifierException('Invalid id key type.');
        }

        try {
            $topBooks = $this->repository->getTopBooks();
        } catch (\Exception $e) {
            throw new \RuntimeException(sprintf('Unable to retrieve top books from external source: %s', $e->getMessage()));
        }

        return $topBooks[$id] ?? null;
    }
}
