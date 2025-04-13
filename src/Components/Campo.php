<?php

declare(strict_types=1);

namespace Taecel\Taecel\Components;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Exception;

class Campo implements Arrayable, Jsonable
{
    protected string $nombre;
    protected string $campo;
    protected int $min;
    protected int $max;
    protected int $formato;
    protected int $confirmar;
    protected int $obligatorio;

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

    public function toArray()
    {
        return [
            'nombre' => $this->getNombre(),
            'campo'  => $this->getCampo(),
            'min'    => $this->getMin(),
            'max'    => $this->getMax(),
            'formato'=> $this->getFormato(),
            'confirmar' => $this->getConfirmar(),
            'obligatorio'=> $this->getObligatorio()
        ];
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}