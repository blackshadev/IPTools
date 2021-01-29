# IPTools

[![Latest Version on Packagist][ico-version]][link-packagist]
[![CI][ico-actions]][link-actions]
[![Infection MSI](https://badge.stryker-mutator.io/github.com/blackshadev/iptools/master)](https://infection.github.io)

This package is a set of tools for working with IP addresses and networks. 

A lot of the internals are inspired by S1lentium/IPTools, but when using that package I noticed I started by 
wrapping everything I needed in separate classes. Which lead me to create my own package.

The state is pretty alpha at this point but feel free to use it. I do my best to not change the interfaces and facades if possible.

## Installation

`composer require littledevnl/iptools`

## Getting started

```php
use Littledev\IPTools\Address;
use Littledev\IPTools\Network;
use Littledev\IPTools\IPFamily;
use Littledev\IPTools\Iterator\AddressIterator;

$ip = Address::parse($_SERVER['REMOTE_ADDR']);
if ($ip->version() === IPFamily::IPv6) {
    echo 'Good for you!';
}

$network6 = Network::parse('2001:db8::/64');
if ($network6->contains($ip)) {
    echo 'You use an IP which is reserved for documentation.';
}

$localNetwork = Network::parse('127.0.0.1/24');
if ($localNetwork->contains($ip)) {
    echo 'No place like localhost.';
}

$iterator = new AddressIterator($localNetwork);
foreach ($iterator as $address) {
    echo 'In local network: ' . $address;
}
```

## Goals

- No dependencies.
- A set of tools for parsing and working with IP addresses and networks
- Utility classes should be open for extension through a common parent 

## Changelog

- [v0.1] Parsing of IP addresses and networks. 
- [v0.2] `constains` now accepts networks and addresses. Generalized 
- [v0.3] Network Iterators 

## Limitations

Not yet a complete set of tools, it is just the beginning.

Without external dependencies for things like arbitrary precision numbers, it is impossible to do certain things. 
For instance calculating the number of hosts in a IPV6 network. You can do it yourself with bcmath, see the example below

```php
use Littledev\IPTools\Network;
use Littledev\IPTools\IPFamily;

$net = Network::parse('2001:db8::/64');
$numbersOfAddresses =  bcpow('2', (string)(IPFamily::MAX_PREFIX_IPV6 - $net->subnet()->prefix()));
``` 

[ico-version]: https://img.shields.io/packagist/v/littledevnl/iptools.svg?style=flat-square
[ico-actions]: https://img.shields.io/github/workflow/status/blackshadev/iptools/CI?label=CI%2FCD&style=flat-square

[link-actions]: https://github.com/blackshadev/iptools/actions?query=workflow%3ACI%2FCD
[link-packagist]: https://packagist.org/packages/littledevnl/iptools
