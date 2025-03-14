<?php

declare(strict_types=1);

/*
 * This file has been auto generated by Jane,
 *
 * Do no edit it directly.
 */

namespace Petstore\Endpoint;

class UpdatePet extends \Petstore\Runtime\Client\BaseEndpoint implements \Petstore\Runtime\Client\Endpoint
{
    use \Petstore\Runtime\Client\EndpointTrait;
    protected $accept;

    /**
     * Update an existing pet by Id.
     *
     * @param array $accept Accept content header application/xml|application/json
     */
    public function __construct(\Petstore\Model\Pet $requestBody, array $accept = [])
    {
        $this->body = $requestBody;
        $this->accept = $accept;
    }

    public function getMethod(): string
    {
        return 'PUT';
    }

    public function getUri(): string
    {
        return '/pet';
    }

    public function getBody(\Symfony\Component\Serializer\SerializerInterface $serializer, $streamFactory = null): array
    {
        if ($this->body instanceof \Petstore\Model\Pet) {
            return [['Content-Type' => ['application/json']], $serializer->serialize($this->body, 'json')];
        }
        if ($this->body instanceof \Petstore\Model\Pet) {
            return [['Content-Type' => ['application/xml']], $this->body];
        }
        if ($this->body instanceof \Petstore\Model\Pet) {
            return [['Content-Type' => ['application/x-www-form-urlencoded']], http_build_query($serializer->normalize($this->body, 'json'))];
        }

        return [[], null];
    }

    public function getExtraHeaders(): array
    {
        if (empty($this->accept)) {
            return ['Accept' => ['application/xml', 'application/json']];
        }

        return $this->accept;
    }

    /**
     * @return \Petstore\Model\Pet|null
     *
     * @throws \Petstore\Exception\UpdatePetBadRequestException
     * @throws \Petstore\Exception\UpdatePetNotFoundException
     * @throws \Petstore\Exception\UpdatePetMethodNotAllowedException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (is_null($contentType) === false && (200 === $status && mb_strpos($contentType, 'application/json') !== false)) {
            return $serializer->deserialize($body, 'Petstore\Model\Pet', 'json');
        }
        if (400 === $status) {
            throw new \Petstore\Exception\UpdatePetBadRequestException($response);
        }
        if (404 === $status) {
            throw new \Petstore\Exception\UpdatePetNotFoundException($response);
        }
        if (405 === $status) {
            throw new \Petstore\Exception\UpdatePetMethodNotAllowedException($response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return ['petstore_auth'];
    }
}
