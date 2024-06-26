<?php

use App\Exceptions\CurrencyRateNotFoundException;
use App\Services\CurrencyService;

test('convert usd to eur successfully', function () {
    $convertedCurrency = (new CurrencyService())->convert(100, 'usd', 'eur');
 
    expect($convertedCurrency)
        ->toBeFloat()
        ->toEqual(98.0);
});

test('convert usd to gbp returns zero', function () { 
    $convertedCurrency = (new CurrencyService())->convert(100, 'usd', 'gbp');
 
    expect($convertedCurrency)
        ->toBeFloat()
        ->toEqual(0.0);
});

test('convert gbp to usd throws exception', function () { 
    $this->expectException(CurrencyRateNotFoundException::class);
    $convertedCurrency = (new CurrencyService())->convert(100, 'gbp', 'usd');
 
    expect($convertedCurrency)
        ->toBeFloat()
        ->toEqual(0.0);
});