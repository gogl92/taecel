<?php

declare(strict_types=1);

namespace Taecel\Taecel\Components;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Exception;
use Throwable;

class Producto implements Arrayable, Jsonable
{
    protected string $bolsa;
    protected int $bolsa_id;
    protected string $categoria;
    protected int $categoria_id;
    protected string $carrier;
    protected int $carrier_id;
    protected string $codigo;
    protected float $monto;
    protected float $unidades;
    protected string $vigencia;
    protected string $descripcion;

    protected array $rules = [
        'Bolsa' => 'required|bail',
        'BolsaID' => 'required|bail|integer',
        'Categoria' => 'required|bail',
        'CategoriaID' => 'required|bail|integer',
        'Carrier' => 'required|bail',
        'CarrierID' => 'required|bail|integer',
        'Codigo' => 'required|bail',
        'Monto' => 'required|integer',
        'Unidades' => 'required',
        'Vigencia' => 'required|string',
        'Descripcion' => 'required'
    ];

    /**
     * @throws Throwable
     */
    public function __construct(array $data)
    {
        $validator = Validator::make($data, $this->rules);
        throw_if($validator->failed(), new Exception($validator->getMessageBag()->first()));
        $this->bolsa = Arr::get($data,'Bolsa');
        $this->bolsa_id = Arr::get($data,'BolsaID');
        $this->categoria = Arr::get($data,'Categoria');
        $this->categoria_id = Arr::get($data,'CategoriaID');
        $this->carrier = Arr::get($data,'Carrier');
        $this->carrier_id = Arr::get($data,'CarrierID');
        $this->codigo = Arr::get($data,'Codigo');
        $this->monto = Arr::get($data,'Monto');
        $this->unidades = Arr::get($data,'Unidades');
        $this->vigencia = Arr::get($data,'Vigencia');
        $this->descripcion = Arr::get($data,'Descripcion');
    }

    /**
     * @return string
     */
    public function getBolsa(): string
    {
        return $this->bolsa;
    }

    /**
     * @param string $bolsa
     */
    public function setBolsa(string $bolsa): void
    {
        $this->bolsa = $bolsa;
    }

    /**
     * @return int
     */
    public function getBolsaId(): int
    {
        return $this->bolsa_id;
    }

    /**
     * @param int $bolsa_id
     */
    public function setBolsaId(int $bolsa_id): void
    {
        $this->bolsa_id = $bolsa_id;
    }

    /**
     * @return string
     */
    public function getCategoria(): string
    {
        return $this->categoria;
    }

    /**
     * @param string $categoria
     */
    public function setCategoria(string $categoria): void
    {
        $this->categoria = $categoria;
    }

    /**
     * @return int
     */
    public function getCategoriaId(): int
    {
        return $this->categoria_id;
    }

    /**
     * @param int $categoria_id
     */
    public function setCategoriaId(int $categoria_id): void
    {
        $this->categoria_id = $categoria_id;
    }

    /**
     * @return string
     */
    public function getCarrier(): string
    {
        return $this->carrier;
    }

    /**
     * @param string $carrier
     */
    public function setCarrier(string $carrier): void
    {
        $this->carrier = $carrier;
    }

    /**
     * @return int
     */
    public function getCarrierId(): int
    {
        return $this->carrier_id;
    }

    /**
     * @param int $carrier_id
     */
    public function setCarrierId(int $carrier_id): void
    {
        $this->carrier_id = $carrier_id;
    }

    /**
     * @return string
     */
    public function getCodigo(): string
    {
        return $this->codigo;
    }

    /**
     * @param string $codigo
     */
    public function setCodigo(string $codigo): void
    {
        $this->codigo = $codigo;
    }

    /**
     * @return float
     */
    public function getMonto(): float
    {
        return $this->monto;
    }

    /**
     * @param float $monto
     */
    public function setMonto(float $monto): void
    {
        $this->monto = $monto;
    }

    /**
     * @return float
     */
    public function getUnidades(): float
    {
        return $this->unidades;
    }

    /**
     * @param float $unidades
     */
    public function setUnidades(float $unidades): void
    {
        $this->unidades = $unidades;
    }

    /**
     * @return string
     */
    public function getVigencia(): string
    {
        return $this->vigencia;
    }

    /**
     * @param string $vigencia
     */
    public function setVigencia(string $vigencia): void
    {
        $this->vigencia = $vigencia;
    }

    /**
     * @return string
     */
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

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

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

}