# IPTools

This package is a set of tools for working with IP addresses and networks. 

A lot of the internals are inspired by S1lentium/IPTools, but when using that package I noticed I started by 
wrapping everything I needed in separate classes. Which lead me to create my own package.

The state is pretty alpha at this point but feel free to use it. I do my best to not change the interfaces and facades if possible.

## Examples

```php
use Littledev\IPTools\Address;
use Littledev\IPTools\Network;
use Littledev\IPTools\IPFamily;

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
```
