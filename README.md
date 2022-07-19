# iTrends/taecel

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Travis](https://img.shields.io/travis/taecel/taecel.svg?style=flat-square)]()
[![Total Downloads](https://img.shields.io/packagist/dt/taecel/taecel.svg?style=flat-square)](https://packagist.org/packages/taecel/taecel)


## Install

```bash
composer require itrends/taecel
```


## Usage

Just add the next variables to your .env file:

```
TAECEL_KEY=YOUR_KEY
TAECEL_NIP=YOUR_NIP
```

Then, you can use the next functions:

- getBalance (According taecel library)
- getProducts (Return all products availables)
- getProveedoresTae (Return all TAE carriers)
- getProvedoresServicios (Return all carriers's service)
- getProveedoresPaquetes (Return all TAE carriers that use packages or plans)
- getProductsByCarrier (Return all products from a carrier)
- requestTxn (Return a transaction id if data is correct)
- statusTxn (With one transaction_id, check if is completed)
- pagarServicio (Do two last steps one by one, throw an error or return transaction data)


## Testing

Befone run the tests, configure TAECEL_KEY and TAECEL_NIP environment variables, and then:

```bash
composer test
```


## Contributing

All pull request are grateful, with respective unit tests.


## License

The MIT License (MIT). Please see [License File](/LICENSE.md) for more information.