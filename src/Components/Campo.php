<?php

namespace Taecel\Taecel\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Exception;

class Campo
{
    private string $nombre;
    private string $campo;
    private int $min;
    private int $max;
    private int $formato;
    private int $confirmar;
    private int $obligatorio;

    protected array $rules = [
        'Nombre' => 'required',
        'Campo'  => 'required',
        'Min'    => 'required|integer',
        'Max'    => 'required|integer',
        'Formato' => 'required|integer',
        'Confirmar' => 'required|integer',
        'Obligatorio' => 'required|integer',
    ];

    public function __construct(array $data)
    {
        $validator = Validator::make($data, $this->rules);
        throw_if($validator->fails(), new Exception($validator->errors()->first()));
        $this->nombre = Arr::get($data,'Nombre');
        $this->campo = Arr::get($data,'Campo');
        $this->min = Arr::get($data,'Min');
        $this->max = Arr::get($data,'Max');
        $this->formato = Arr::get($data, 'Formato');
        $this->confirmar = Arr::get($data,'Confirmar');
        $this->obligatorio = Arr::get($data,'Obligatorio');
    }

    /**
     * @return array|\ArrayAccess|mixed|string
     */
    public function getNombre(): mixed
    {
        return $this->nombre;
    }

    /**
     * @param array|\ArrayAccess|mixed|string $nombre
     */
    public function setNombre(mixed $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return array|\ArrayAccess|mixed|string
     */
    public function getCampo(): mixed
    {
        return $this->campo;
    }

    /**
     * @param array|\ArrayAccess|mixed|string $campo
     */
    public function setCampo(mixed $campo): void
    {
        $this->campo = $campo;
    }

    /**
     * @return array|\ArrayAccess|int|mixed
     */
    public function getMin(): mixed
    {
        return $this->min;
    }

    /**
     * @param array|\ArrayAccess|int|mixed $min
     */
    public function setMin(mixed $min): void
    {
        $this->min = $min;
    }

    /**
     * @return array|\ArrayAccess|int|mixed
     */
    public function getMax(): mixed
    {
        return $this->max;
    }

    /**
     * @param array|\ArrayAccess|int|mixed $max
     */
    public function setMax(mixed $max): void
    {
        $this->max = $max;
    }

    /**
     * @return array|\ArrayAccess|int|mixed
     */
    public function getFormato(): mixed
    {
        return $this->formato;
    }

    /**
     * @param array|\ArrayAccess|int|mixed $formato
     */
    public function setFormato(mixed $formato): void
    {
        $this->formato = $formato;
    }

    /**
     * @return array|\ArrayAccess|int|mixed
     */
    public function getConfirmar(): mixed
    {
        return $this->confirmar;
    }

    /**
     * @param array|\ArrayAccess|int|mixed $confirmar
     */
    public function setConfirmar(mixed $confirmar): void
    {
        $this->confirmar = $confirmar;
    }

    /**
     * @return array|\ArrayAccess|int|mixed
     */
    public function getObligatorio(): mixed
    {
        return $this->obligatorio;
    }

    /**
     * @param array|\ArrayAccess|int|mixed $obligatorio
     */
    public function setObligatorio(mixed $obligatorio): void
    {
        $this->obligatorio = $obligatorio;
    }

}