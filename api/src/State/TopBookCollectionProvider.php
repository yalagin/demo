<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Exception\RuntimeException;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\TopBook;
use App\Repository\TopBook\TopBookDataInterface;
use App\State\Extension\TopBookCollectionExtensionInterface;

final class TopBookCollectionProvider implements ProviderInterface
{
    public function __construct(
        private TopBookDataInterface $repository,
        private TopBookCollectionExtensionInterface $paginationExtension
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = [])
    {
        $resourceClass = $operation->getClass();
        $operationName = $operation->getName();

        if (TopBook::class !== $resourceClass) {
            // todo Throw exception
        }

        try {
            $collection = $this->repository->getTopBooks();
        } catch (\Exception $e) {
            throw new RuntimeException(sprintf('Unable to retrieve top books from external source: %s', $e->getMessage()));
        }

        if (!$this->paginationExtension->isEnabled($resourceClass, $operationName, $context)) {
            return $collection;
        }

        return $this->paginationExtension->getResult($collection, $resourceClass, $operationName, $context);
    }
}
