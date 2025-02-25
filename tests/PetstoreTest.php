<?php

declare(strict_types=1);

use Petstore\Petstore;
use Petstore\Client;
use Petstore\Exception\ApiException;
use Petstore\Model\Pet;

it('gets client from Petstore class', function (): void {
    $petstore = new Petstore('API_KEY', 'https://petstore.swagger.io');
    $client = $petstore->client;
    expect($client)->toBeInstanceOf(Client::class);
    expect(method_exists($client, 'addPet'))->toBeTrue();
});

it('gets client from Client::create', function (): void {
    $client = Client::create();
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
