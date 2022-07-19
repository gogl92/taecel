<?php

namespace Taecel\Taecel\Tests\Unit;

use Illuminate\Support\Collection;
use Taecel\Taecel\Components\InformacionDeTransaccion;
use Taecel\Taecel\Components\Producto;
use Taecel\Taecel\Components\Proveedor;
use Taecel\Taecel\Taecel;
use Taecel\Taecel\Tests\TestCase;
use Throwable;

class TaecelTest extends TestCase
{

    public function testGetBalance()
    {
        $repository = Taecel::create();
        $this->assertNotNull($repository);
        $response = $repository->getBalance();
        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
    }

    public function testGetProductos()
    {
        $repository = Taecel::create();
        $this->assertNotNull($repository);
        $productos = $repository->getProducts();
        $this->assertNotNull($productos);
        $this->assertInstanceOf(Collection::class, $productos);
        $this->assertTrue($productos->count() > 0);
        foreach ($productos as $producto)
        {
            $this->assertNotNull($producto);
            $this->assertInstanceOf(Producto::class, $producto);
            $this->assertNotNull($producto->getBolsa());
            $this->assertTrue($producto->getBolsaId() > 0);
            $this->assertNotNull($producto->getCategoria());
            $this->assertTrue($producto->getCategoriaId() > 0);
            $this->assertNotNull($producto->getCarrier());
            $this->assertTrue($producto->getCarrierId() > 0);
            $this->assertNotNull($producto->getCodigo());
            $this->assertIsNumeric($producto->getMonto());
            $this->assertNotNull($producto->getVigencia());
            $this->assertNotNull($producto->getDescripcion());
        }
    }

    public function testGetProveedoresTae()
    {
        $repository = Taecel::create();
        $this->assertNotNull($repository);
        $proveedores_tae = $repository->getProveedoresTae();
        $this->assertNotNull($proveedores_tae);
        $this->assertInstanceOf(Collection::class, $proveedores_tae);
        foreach ($proveedores_tae as $proveedor)
        {
            $this->assertNotNull($proveedor);
            $this->assertInstanceOf(Proveedor::class, $proveedor);
            $this->assertIsNumeric($proveedor->getId());
            $this->assertNotNull($proveedor->getNombre());
            $this->assertIsNumeric($proveedor->getBolsaId());
            $this->assertNotNull($proveedor->getCategoria());
            $this->assertIsNumeric($proveedor->getCategoriaId());
            $this->assertIsNumeric($proveedor->getTipo());
            $this->assertIsArray($proveedor->getCampos());
        }
    }

    public function testGetProveedoresDePaquetes()
    {
        $repository = Taecel::create();
        $this->assertNotNull($repository);
        $proveedores_paquetes = $repository->getProveedoresPaquetes();
        $this->assertNotNull($proveedores_paquetes);
        $this->assertInstanceOf(Collection::class, $proveedores_paquetes);
        foreach ($proveedores_paquetes as $proveedor)
        {
            $this->assertNotNull($proveedor);
            $this->assertInstanceOf(Proveedor::class, $proveedor);
            $this->assertIsNumeric($proveedor->getId());
            $this->assertNotNull($proveedor->getNombre());
            $this->assertIsNumeric($proveedor->getBolsaId());
            $this->assertNotNull($proveedor->getCategoria());
            $this->assertIsNumeric($proveedor->getCategoriaId());
            $this->assertIsNumeric($proveedor->getTipo());
            $this->assertIsArray($proveedor->getCampos());
        }
    }

    public function testGetProveedoresServicios()
    {
        $repository = Taecel::create();
        $this->assertNotNull($repository);
        $proveedores_servicios = $repository->getProveedoresServicios();
        $this->assertNotNull($proveedores_servicios);
        $this->assertInstanceOf(Collection::class, $proveedores_servicios);
        foreach ($proveedores_servicios as $proveedor)
        {
            $this->assertNotNull($proveedor);
            $this->assertInstanceOf(Proveedor::class, $proveedor);
            $this->assertIsNumeric($proveedor->getId());
            $this->assertNotNull($proveedor->getNombre());
            $this->assertIsNumeric($proveedor->getBolsaId());
            $this->assertNotNull($proveedor->getCategoria());
            $this->assertIsNumeric($proveedor->getCategoriaId());
            $this->assertIsNumeric($proveedor->getTipo());
            $this->assertIsArray($proveedor->getCampos());
        }
    }

    public function testGetProveedoresGifCards()
    {
        $repository = Taecel::create();
        $this->assertNotNull($repository);
        $proveedores_gifcards = $repository->getProveedoresGifCards();
        $this->assertNotNull($proveedores_gifcards);
        $this->assertInstanceOf(Collection::class, $proveedores_gifcards);
        foreach ($proveedores_gifcards as $proveedor)
        {
            $this->assertNotNull($proveedor);
            $this->assertInstanceOf(Proveedor::class, $proveedor);
            $this->assertIsNumeric($proveedor->getId());
            $this->assertNotNull($proveedor->getNombre());
            $this->assertIsNumeric($proveedor->getBolsaId());
            $this->assertNotNull($proveedor->getCategoria());
            $this->assertIsNumeric($proveedor->getCategoriaId());
            $this->assertIsNumeric($proveedor->getTipo());
            $this->assertIsArray($proveedor->getCampos());
        }
    }

    public function testGetProductsByCarrier()
    {
        $repository = Taecel::create();
        $this->assertNotNull($repository);
        /** @var Collection $proveedores_tae */
        $proveedores_tae = $repository->getProveedoresTae();
        /** @var Proveedor $proveedor */
        $proveedor = $proveedores_tae->first();

        $productos = $repository->getProductsByCarrier($proveedor->getId());
        /** @var Producto $producto */
        foreach ($productos as $producto)
        {
            $this->assertEquals($proveedor->getId(), $producto->getCarrierId());
        }
    }

    public function testRequestTxnWithWrongDataReturnNull()
    {
        $repository = Taecel::create();
        $this->assertNotNull($repository);
        $throw_error = false;
        try {
            $data = [
                'producto' => 'nonexisten',
                'referencia' => 4421234567,
                'monto' => 200
            ];
            $transaction_id = $repository->requestTxn($data);
        }
        catch (Throwable $e)
        {
            $throw_error = true;
        }
        $this->assertTrue($throw_error);
    }

    public function testRequestTaeWithRealDataReturnTransactionId()
    {
        $repository = Taecel::create();
        $this->assertNotNull($repository);
        $proveedores_tae = $repository->getProveedoresTae();
        /** @var Proveedor $proveedor */
        $proveedor = $proveedores_tae->where(function(Proveedor $proveedor){
            return  str_contains($proveedor->getNombre(), 'elcel');
        })->first();
        /** @var Collection $productos */
        $productos = $repository->getProductsByCarrier($proveedor->getId());
        $this->assertTrue($productos->count() > 0);
        /************************************************************
         * Preparando datos para consumir el API
        /************************************************************/
        /** @var Producto $producto */
        $producto = $productos->first();
        $data = [
            'producto' => $producto->getCodigo(),
            'referencia' => sprintf('%d%d', random_int(10000,99999), random_int(10000,99999)),
            'monto' => $producto->getMonto()
        ];
        $transaction_id = $repository->requestTxn($data);
        $this->assertNotNull($transaction_id);
    }

    public function testStatusTxnWithWrongTransactionIdThrowError()
    {
        $repository = Taecel::create();
        $this->assertNotNull($repository);
        $data = ['transID' => '123456789076'];
        $throw_exception = false;
        try
        {
            $response = $repository->statusTxn($data);
        }
        catch (Throwable $e){
            $throw_exception = true;
        }
        $this->assertTrue($throw_exception, 'Debió lanzar una excepción');
    }

    public function testStatusTxnWithRealDataReturnCompleteInformation()
    {
        $repository = Taecel::create();
        $this->assertNotNull($repository);
        $proveedores_tae = $repository->getProveedoresTae();
        /** @var Proveedor $proveedor */
        $proveedor = $proveedores_tae->where(function(Proveedor $proveedor){
            return  str_contains($proveedor->getNombre(), 'elcel');
        })->first();
        /** @var Collection $productos */
        $productos = $repository->getProductsByCarrier($proveedor->getId());
        $this->assertTrue($productos->count() > 0);
        /************************************************************
         * Preparando datos para consumir el API
        /************************************************************/
        /** @var Producto $producto */
        $producto = $productos->first();
        $data = [
            'producto' => $producto->getCodigo(),
            'referencia' => sprintf('%d%d', random_int(10000,99999), random_int(10000,99999)),
            'monto' => $producto->getMonto()
        ];
        $transaction_id = $repository->requestTxn($data);

        $data = $repository->statusTxn(['transaction_id' => $transaction_id]);
        $this->assertNotNull($data);
        $this->assertInstanceOf(InformacionDeTransaccion::class, $data);
    }

    public function testPagarServicioWithRealDataReturnTransactionCompleted()
    {
        $repository = Taecel::create();
        $this->assertNotNull($repository);
        $proveedores_tae = $repository->getProveedoresTae();
        /** @var Proveedor $proveedor */
        $proveedor = $proveedores_tae->where(function(Proveedor $proveedor){
            return  str_contains($proveedor->getNombre(), 'elcel');
        })->first();
        /** @var Collection $productos */
        $productos = $repository->getProductsByCarrier($proveedor->getId());
        $this->assertTrue($productos->count() > 0);
        /************************************************************
         * Preparando datos para consumir el API
        /************************************************************/
        /** @var Producto $producto */
        $producto = $productos->first();
        $data = [
            'producto' => $producto->getCodigo(),
            'referencia' => sprintf('%d%d', random_int(10000,99999), random_int(10000,99999)),
            'monto' => $producto->getMonto()
        ];
        /** @var InformacionDeTransaccion $information */
        $information = $repository->pagarServicio($data);
        $this->assertNotNull($information);
        $this->assertInstanceOf(InformacionDeTransaccion::class, $information);
    }

}