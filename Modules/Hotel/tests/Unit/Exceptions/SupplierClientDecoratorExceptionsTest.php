<?php

declare(strict_types=1);

use Modules\Hotel\Clients\Decorator\SupplierClientDecorator;
use Modules\Hotel\Exceptions\SupplierEmptyResponseException;
use Modules\Hotel\Exceptions\SupplierUnavailableException;
use Modules\Hotel\Fakers\FakeFailConnectionClient;
use Modules\Hotel\Fakers\FakeServerErrorClient;
use Modules\Hotel\Fakers\ThrowingEmptyClient;

it('test client throws SupplierEmptyResponseException', function (): void {
    $client = new ThrowingEmptyClient();

    expect(fn () => $client->handle())->toThrow(SupplierEmptyResponseException::class);
});

it('returns empty array when client throws SupplierEmptyResponseException (handled by decorator)', function (): void {
    $decorated = new SupplierClientDecorator(new ThrowingEmptyClient());

    $result = $decorated->handle();
    expect($result)->toBeArray()->toBeEmpty();
});

it('tests SupplierUnavailableException for connection exception (handled by decorator)', function (): void {
    $decorated = new SupplierClientDecorator(new FakeFailConnectionClient());

    expect(fn () => $decorated->handle())->toThrow(SupplierUnavailableException::class);
});

it('tests SupplierUnavailableException for request exceptions (handled by decorator)', function (): void {
    $decorated = new SupplierClientDecorator(new FakeServerErrorClient());

    expect(fn () => $decorated->handle())->toThrow(SupplierUnavailableException::class);
});
