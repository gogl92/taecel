<?php

namespace Taecel\Taecel\Components;

use Illuminate\Support\Arr;

class InformacionDeTransaccion
{
    private string $transId;
    private string $fecha;
    private string $carrier;
    private string $folio;
    private string $status;
    private string $monto;
    private string $nota;

    public function __construct(array $data)
    {
        [$this->transId, $this->fecha, $this->carrier, $this->folio, $this->status, $this->monto, $this->nota] = [
            Arr::get($data,'TransID'), Arr::get($data,'Fecha'), Arr::get($data,'Carrier'), Arr::get($data,'Folio'),
            Arr::get($data,'Status'), Arr::get($data, 'Monto'), Arr::get($data, 'Nota')
        ];
    }

    /**
     * @return array|\ArrayAccess|mixed|string
     */
    public function getTransId(): mixed
    {
        return $this->transId;
    }

    /**
     * @param array|\ArrayAccess|mixed|string $transId
     */
    public function setTransId(mixed $transId): void
    {
        $this->transId = $transId;
    }

    /**
     * @return array|\ArrayAccess|mixed|string
     */
    public function getFecha(): mixed
    {
        return $this->fecha;
    }

    /**
     * @param array|\ArrayAccess|mixed|string $fecha
     */
    public function setFecha(mixed $fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * @return array|\ArrayAccess|mixed|string
     */
    public function getCarrier(): mixed
    {
        return $this->carrier;
    }

    /**
     * @param array|\ArrayAccess|mixed|string $carrier
     */
    public function setCarrier(mixed $carrier): void
    {
        $this->carrier = $carrier;
    }

    /**
     * @return array|\ArrayAccess|mixed|string
     */
    public function getFolio(): mixed
    {
        return $this->folio;
    }

    /**
     * @param array|\ArrayAccess|mixed|string $folio
     */
    public function setFolio(mixed $folio): void
    {
        $this->folio = $folio;
    }

    /**
     * @return array|\ArrayAccess|mixed|string
     */
    public function getStatus(): mixed
    {
        return $this->status;
    }

    /**
     * @param array|\ArrayAccess|mixed|string $status
     */
    public function setStatus(mixed $status): void
    {
        $this->status = $status;
    }

    /**
     * @return array|\ArrayAccess|mixed|string
     */
    public function getMonto(): mixed
    {
        return $this->monto;
    }

    /**
     * @param array|\ArrayAccess|mixed|string $monto
     */
    public function setMonto(mixed $monto): void
    {
        $this->monto = $monto;
    }

    /**
     * @return array|\ArrayAccess|mixed|string
     */
    public function getNota(): mixed
    {
        return $this->nota;
    }

    /**
     * @param array|\ArrayAccess|mixed|string $nota
     */
    public function setNota(mixed $nota): void
    {
        $this->nota = $nota;
    }

}