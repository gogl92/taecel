<?php

declare(strict_types=1);

namespace Taecel\Taecel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Taecel\Taecel\Taecel;
use Throwable;

class GenerarMatrizDePruebas extends Command
{
    protected $signature = 'taecel:matrizdepruebas';
    protected $description = 'Genera la matriz de pruebas requerida por taecel';

    public function handle()
    {
        $data = [
            'referencia' => '5555555520',
            'carrier'    => 'Telcel',
            'codigo'     => 'TEL150',
            'monto'      => 150,
        ];

        $repository = Taecel::create();
        $transaction_id = $repository->requestTxn([
            'producto' => $data['codigo'],
            'referencia' => $data['referencia'],
            'monto'     => $data['monto']
        ]);
        try
        {
            $response = $repository->statusTxn(['transaction_id' => $transaction_id]);
            $data['fecha'] = now()->format('Y-m-d H:i:s');
            $data['transaction_id'] = $transaction_id;
            $data['folio'] = $response->getFolio();
            $data['estatus'] = $response->getStatus();
        }
        catch (Throwable $e)
        {
            $data['fecha'] = now()->format('Y-m-d H:i:s');
            $data['transaction_id'] = $transaction_id;
            $data['folio'] = null;
            $data['estatus'] = $e->getMessage();
            logger($e->getMessage());
            logger($e->getFile());
            logger($e->getLine());
        }
        logger($data);
    }
}