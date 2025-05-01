<?php

declare(strict_types=1);

namespace Taecel\Taecel\Tests\Unit;

use Illuminate\Support\Collection;
use Random\RandomException;
use Taecel\Taecel\Models\InformacionDeTransaccion;
use Taecel\Taecel\Models\Producto;
use Taecel\Taecel\Models\Proveedor;
use Taecel\Taecel\Taecel;
use Taecel\Taecel\Tests\TestCase;
use Throwable;

class TaecelTest extends TestCase
{

    /**
     * @dataProvider matrizDePruebasProvider
     * @ dataProvider matrizDePruebasServiciosProvider
     */
    public function testMatrizDePruebas($referencia, $carrier, $codigo, $monto): void
    {
        try {
            $data = [
                'referencia' => $referencia,
                'carrier'    => $carrier,
                'codigo'     => $codigo,
                'monto'      => $monto,
            ];

            $repository = Taecel::create();
            $transaction_id = $repository->requestTxn([
                'producto' => $data['codigo'],
                'referencia' => $data['referencia'],
                'monto'     => $data['monto']
            ]);

            $transaction = $repository->statusTxn(['transaction_id' => $transaction_id]);
            $csvRow = [
                $referencia,
                $carrier,
                $codigo,
                $monto,
                $transaction->getFecha(),
                $transaction->getTransId(),
                $transaction->getFolio(),
                $transaction->getStatus(),
                $transaction->getNota(),
            ];
            $file = fopen('result.csv', 'a');
            fputcsv($file, $csvRow);
            fclose($file);
        } catch (\Throwable $e) {
            $csvRow = [
                $referencia,
                $carrier,
                $codigo,
                $monto,
                '', // Fecha
                '', // TransId
                '', // Folio
                'fracasada', // Estatus
                $e->getMessage(), // Nota/Error
            ];
            $file = fopen('result.csv', 'a');
            fputcsv($file, $csvRow);
            fclose($file);
            file_put_contents('result_errors.log', sprintf("Error for referencia %s, carrier %s, codigo %s, monto %s: %s\n%s\n", $referencia, $carrier, $codigo, $monto, $e->getMessage(), $e->getTraceAsString()), FILE_APPEND);
        } finally {
            $this->assertTrue(true);
        }
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function testGetBalance(): void
    {
        $repository = Taecel::create();
        $this->assertNotNull($repository);
        $response = $repository->getBalance();
        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
    }

    /**
     * @return void
     */
    public function testGetProductos(): void
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

    /**
     * @return void
     */
    public function testGetProveedoresTae(): void
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

    /**
     * @return void
     */
    public function testGetProveedoresDePaquetes(): void
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

    /**
     * @return void
     */
    public function testGetProveedoresServicios(): void
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

    /**
     * @return void
     */
    public function testGetProveedoresGifCards(): void
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

    /**
     * @return void
     */
    public function testGetProductsByCarrier(): void
    {
        $repository = Taecel::create();
        $this->assertNotNull($repository);
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

    /**
     * @return void
     */
    public function testRequestTxnWithWrongDataReturnNull(): void
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
            $repository->requestTxn($data);
        }
        catch (Throwable $e)
        {
            $throw_error = true;
        }
        $this->assertTrue($throw_error);
    }

    /**
     * @return void
     * @throws RandomException
     * @throws Throwable
     */
    public function testRequestTaeWithRealDataReturnTransactionId(): void
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

    /**
     * @return void
     */
    public function testStatusTxnWithWrongTransactionIdThrowError(): void
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

    /**
     * @return void
     * @throws RandomException
     * @throws Throwable
     */
    public function testStatusTxnWithRealDataReturnCompleteInformation(): void
    {
        $repository = Taecel::create();
        $this->assertNotNull($repository);
        $proveedores_tae = $repository->getProveedoresTae();
        /** @var Proveedor $proveedor */
        $proveedor = $proveedores_tae->where(function(Proveedor $proveedor){
            return  str_contains($proveedor->getNombre(), 'elcel');
        })->first();
        $productos = $repository->getProductsByCarrier($proveedor->getId());
        $this->assertTrue($productos->count() > 0);

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

    /**
     * @return void
     * @throws Throwable
     * @throws RandomException
     */
    public function testPagarServicioWithRealDataReturnTransactionCompleted(): void
    {
        $repository = Taecel::create();
        $this->assertNotNull($repository);
        $proveedores_tae = $repository->getProveedoresTae();
        /** @var Proveedor $proveedor */
        $proveedor = $proveedores_tae->where(function(Proveedor $proveedor){
            return  str_contains($proveedor->getNombre(), 'elcel');
        })->first();

        $productos = $repository->getProductsByCarrier($proveedor->getId());
        $this->assertTrue($productos->count() > 0);

        /** @var Producto $producto */
        $producto = $productos->first();
        $data = [
            'producto' => $producto->getCodigo(),
            'referencia' => sprintf('%d%d', random_int(10000,99999), random_int(10000,99999)),
            'monto' => $producto->getMonto(),
        ];
        $information = $repository->pagarServicio($data);
        $this->assertNotNull($information);
        $this->assertInstanceOf(InformacionDeTransaccion::class, $information);
    }

    public static function matrizDePruebasProvider(): array
    {
        return [
            ['5555555505', 'Telcel',    'TEL010', 10],
            ['5555555510', 'Telcel',    'TEL050', 50],
            ['5555555515', 'Telcel',    'TEL100', 100],
            ['5555555520', 'Telcel',    'TEL150', 150],
            ['5555555525', 'Telcel',    'TEL200', 200],
            ['5555555530', 'Movistar',  'MOV010', 10],
            ['5555555540', 'Movistar',  'MOV050', 50],
            ['5555555560', 'Movistar',  'MOV100', 100],
            ['5555555565', 'Movistar',  'MOV120', 120],
            ['5555555200', 'Movistar',  'MOV150', 150],
        ];
    }

    public static function matrizDePruebasServiciosProvider(): array
    {
        return [
            ['871235412635', 'Sky', 'SKY000', 95],
            ['6589745213', 'Telmex', 'TMX001', 100],
            ['125478965412365478965230126654', 'Cfe', 'CFE000', 260],
            ['9854123547', 'Megacable', 'MEG000', 131],
            ['27458965324125', 'Dish', 'DSH000', 103],
            ['3456987', 'Maxcom', 'MAX000', 177],
        ];
    }
}