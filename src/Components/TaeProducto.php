<?php

namespace Taecel\Taecel\Components;

class TaeProducto
{

    private string $bolsa;
    private int $bolsa_id;
    private string $categoria;
    private int $categoria_id;
    private string $carrier;
    private int $carrier_id;
    private string $codigo;
    private float $monto;
    private float $unidades;
    private string $vigencia;
    private string $descripcion;

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

}