# iTrends/taecel

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Travis](https://img.shields.io/travis/taecel/taecel.svg?style=flat-square)]()
[![Total Downloads](https://img.shields.io/packagist/dt/taecel/taecel.svg?style=flat-square)](https://packagist.org/packages/taecel/taecel)


## Instalación

```bash
composer require itrends/taecel
```


## Uso

Solo necesita agregar las siguientes variables a su archivo ```.env```, estas son prporcionadas por taecel cuando 
ellos obtienen información de su empresa.

```
TAECEL_KEY=YOUR_KEY
TAECEL_NIP=YOUR_NIP
```

Una vez hecho esto, para comenzar a utilizarlo, hay dos maneras:

### A traves del facade de Laravel

```
$balance = Taecel::getBalance()
```

### A traves de una instancia de la clase Taecel 

```
$taecel = Taecel::create()
```

Ambos utilizarán las variables de entorno para poder obtener el KEY y NIP de taecel, y una vez instanciado, 
pueden hacer uso de cualquiera de las siguientes funciones:

### getBalance

De acuerdo al API de taecel devuelve siempre un JSON con información similar a la siguiente:

```json
{
    "success": true,
    "error": 0,
    "message": "Consulta Exitosa",
    "data": [
        {
            "ID": "1",
            "Bolsa": "Tiempo Aire",
            "Saldo": "899,968,134"
        },
        {
            "ID": "2",
            "Bolsa": "Pago de Servicios",
            "Saldo": "99,913,654"
        },
        {
            "ID": "3",
            "Bolsa": "Timbres CFDI",
            "Saldo": "5,697"
        }
    ]
}
```

### getProducts

Devuelve una colección de todos los productos disponibles, cada producto es una instancia del objeto ```Producto```, el cual es arrable y jsonable, 
actualmente el objeto tiene todos los objetos mostrados en ```$this```:

```php
public function toArray()
{
    return [
        'bolsa' => $this->getBolsa(),
        'bolsa_id' => $this->getBolsaId(),
        'categoria' => $this->getCategoria(),
        'categoria_id' => $this->getCategoriaId(),
        'carrier' => $this->getCarrier(),
        'carrier_id' => $this->getCarrierId(),
        'codigo' => $this->getCodigo(),
        'monto' => $this->getMonto(),
        'unidades' => $this->getUnidades(),
        'vigencia' => $this->getVigencia(),
        'descripcion' => $this->getDescripcion()
    ];
}
```

### getProveedoresTae, get ProveedoresServicios, getProveedoresPaquetes y getProductsByCarrier

Devuelve todos los proveedores disponibles, dependiendo de la necesidad, cada proveedor es una instancia de la clase```Proveedor``` en el sistema, el cual se forma con
la siguiente estructura.

```php
public function toArray()
{
    return [
        'id' => $this->getId(),
        'nombre' => $this->getNombre(),
        'bolsa_id' => $this->getBolsaId(),
        'categoria' => $this->getCategoria(),
        'categoria_id' => $this->getCategoriaId(),
        'tipo' => $this->getTipo()
    ];
}
```

### getProductsByCarrier

Devuelve una colección de objetos ```producto``` filtrado por proveedor

### requestTXN

Solicita una orden de compra, requiere que se le envíen 3 campos:

```
producto
referencia
monto
```

Ésta función devuelve un ```transaction_id``` que es un ```string``` que sirve para realizar consultas al método ```statusTxn```, 
en dado caso de que algo salga mal, lanza una excepción con el error devuelto por taecel.

### statusTXN

Verifica el estatus de una transaccion, requiere que se envien los siguientes datos:

```
transaction_id
```

A traves de éste campo intentará verificar el estatus de la transacción, 
y si todo sale bien devolverá un objeto ```InformacionDeTransaccion``` que 
contiene lo siguiente:


```php
public function toArray()
{
    return [
        'transId' => $this->getTransId(),
        'fecha'   => $this->getFecha(),
        'carrier' => $this->getCarrier(),
        'folio'   => $this->getFolio(),
        'status'  => $this->getStatus(),
        'monto'   => $this->getMonto(),
        'nota'    => $this->getNota()
    ];
}
```

### pagarServicio

Practicamente ésta función hace lo mismo que ```requestTXN```, pero devuelve un objeto 
```InformacionDeTransaccion``` dado que también manda a hablar a ```statusTXN``` 

## Pruebas unitarias

Antes de correr los test configure TAECEL_KEY y TAECEL_NIP como variables de entorno, y entonces ejecute.

```bash
composer test
```


## Contribuciones

Todas las contribuciones sin bien recibidas, siempre y cuando cuenten con las pruebas unitarias correspondientes.
