<?php

use App\Models\User;

beforeEach(function () {
    require_once __DIR__ . '/../../../app/helpers.php';
});

it('formatea entero sin decimales', function () {
    expect(format_amount(1500))->toBe('1.500');
});

it('formatea decimal con dos decimales', function () {
    expect(format_amount(1234.56))->toBe('1.234,56');
});

it('formatea valor negativo', function () {
    expect(format_amount(-500.5))->toBe('-500,50');
});

it('devuelve string si no es numérico', function () {
    expect(format_amount('abc'))->toBe('abc');
});

it('formatea string numérico', function () {
    expect(format_amount('2500.00'))->toBe('2.500');
});

it('format_amount_short usa cero decimales', function () {
    expect(format_amount_short(1234.78))->toBe('1.235');
});
