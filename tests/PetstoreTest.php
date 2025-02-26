<?php

declare(strict_types=1);

use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Message\Authentication\Bearer;
use Petstore\Petstore;
use Petstore\Client;
use Petstore\Exception\ApiException;
use Petstore\Model\Pet;

it('instantiates Petstore client', function (): void {
    $petstore = new Petstore('API_KEY', 'https://petstore.swagger.io');
    $client = $petstore->client;
    expect($client)->toBeInstanceOf(Client::class);
    expect(method_exists($client, 'addPet'))->toBeTrue();
});

it('instantiates client from Client::create', function (): void {
    $bearer = new Bearer('API_KEY');
    $plugins = [new AuthenticationPlugin($bearer)];
    $client = Client::create(null, $plugins);
    expect($client)->toBeInstanceOf(Client::class);
    expect(method_exists($client, 'addPet'))->toBeTrue();
});

it('adds pet', function (): void {
    $petstore = new Petstore('API_KEY');
    $pet = new Pet();
    $pet->setName('Neo');
    $pet->setPhotoUrls(['https://placecats.com/neo/300/200']);
    $response = $petstore->client->addPet($pet);
    expect($response)->toBe(null);
});

it('gets pet not found', function (): void {
    try {
        $petstore = new Petstore('API_KEY');
        $petstore->client->getPetById(0);
    } catch (Throwable $throwable) {
        expect($throwable)->toBeInstanceOf(ApiException::class);
        expect($throwable->getMessage())->toBe('Pet not found');
        expect($throwable->getCode())->toBe(404);
    }
});
