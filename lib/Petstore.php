<?php

declare(strict_types=1);

namespace Petstore;

use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\PluginClient;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Http\Message\Authentication\Bearer;

class Petstore
{
    /** @var Client */
    public $client;

    /**
     * Instantiates client.
     *
     * @param string $apiKey API key.
     * @param string $apiUrl REST endpoint.
     */
    public function __construct(string $apiKey, string $apiUrl = 'https://petstore.swagger.io')
    {
        $httpClient = Psr18ClientDiscovery::find();
        $uri = Psr17FactoryDiscovery::findUriFactory()->createUri($apiUrl);
        $bearer = new Bearer($apiKey);
        $plugins = [
            new AddHostPlugin($uri),
            new AuthenticationPlugin($bearer),
        ];
        $httpClient = new PluginClient($httpClient, $plugins);
        $this->client = Client::create($httpClient);
    }
}
