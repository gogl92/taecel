<?php

namespace Taecel\Taecel\Components;

class Bolsa
{
    private int|string $id;
    private string $nombre;
    private float $saldo;

    public function __construct(int|string $id, string $nombre, float $saldo)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->saldo = $saldo;
    }

    /**
     * @return int|string
     */
    public function getId(): int|string
    {
        return $this->id;
    }

    /**
     * @param int|string $id
     */
    public function setId(int|string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return float
     */
    public function getSaldo(): float
    {
        return $this->saldo;
    }

    /**
     * @param float $saldo
     */
    public function setSaldo(float $saldo): void
    {
        $this->saldo = $saldo;
    }

}