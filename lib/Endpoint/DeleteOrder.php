<?php

declare(strict_types=1);

/*
 * This file has been auto generated by Jane,
 *
 * Do no edit it directly.
 */

namespace Petstore\Endpoint;

class DeleteOrder extends \Petstore\Runtime\Client\BaseEndpoint implements \Petstore\Runtime\Client\Endpoint
{
    use \Petstore\Runtime\Client\EndpointTrait;
    protected $orderId;

    /**
     * For valid response try integer IDs with value < 1000. Anything above 1000 or non-integers will generate API errors.
     *
     * @param int $orderId ID of the order that needs to be deleted
     */
    public function __construct(int $orderId)
    {
        $this->orderId = $orderId;
    }

    public function getMethod(): string
    {
        return 'DELETE';
    }

    public function getUri(): string
    {
        return str_replace(['{orderId}'], [$this->orderId], '/store/order/{orderId}');
    }

    public function getBody(\Symfony\Component\Serializer\SerializerInterface $serializer, $streamFactory = null): array
    {
        return [[], null];
    }

    /**
     * @return null
     *
     * @throws \Petstore\Exception\DeleteOrderBadRequestException
     * @throws \Petstore\Exception\DeleteOrderNotFoundException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (200 === $status) {
            return null;
        }
        if (400 === $status) {
            throw new \Petstore\Exception\DeleteOrderBadRequestException($response);
        }
        if (404 === $status) {
            throw new \Petstore\Exception\DeleteOrderNotFoundException($response);
        }

        return null;
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
