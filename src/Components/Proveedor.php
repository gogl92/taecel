<?php namespace Taecel\Taecel\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Exception;

class Proveedor
{
    private int $id;
    private string $nombre;
    private string|null $url_logotipo;
    private int $bolsa_id;
    private string $categoria;
    private int $categoria_id;
    private int $tipo;
    private string|null $promo_url;

    protected array $rules = [
        'ID' => 'required|bail',
        'Nombre' => 'required|bail',
        'BolsaID' => 'required|bail|integer',
        'Categoria' => 'required|bail',
        'CategoriaID' => 'required|bail|integer',
        'Tipo' => 'required|integer'
    ];

    public function __construct(array $data)
    {
        $validator = Validator::make($data, $this->rules);
        throw_if($validator->failed(), new Exception($validator->getMessageBag()->first()));
        $this->id = Arr::get($data, 'ID');
        $this->nombre = Arr::get($data,'Nombre');
        $this->url_logotipo = Arr::get($data,'Logotipo');
        $this->bolsa_id = Arr::get($data,'BolsaID');
        $this->categoria = Arr::get($data,'Categoria');
        $this->categoria_id = Arr::get($data, 'CategoriaID');
        $this->tipo = Arr::get($data,'Tipo');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
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
     * @return string|null
     */
    public function getUrlLogotipo(): ?string
    {
        return $this->url_logotipo;
    }

    /**
     * @param string|null $url_logotipo
     */
    public function setUrlLogotipo(?string $url_logotipo): void
    {
        $this->url_logotipo = $url_logotipo;
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
     * @return int
     */
    public function getTipo(): int
    {
        return $this->tipo;
    }

    /**
     * @param int $tipo
     */
    public function setTipo(int $tipo): void
    {
        $this->tipo = $tipo;
    }

    /**
     * @return string|null
     */
    public function getPromoUrl(): ?string
    {
        return $this->promo_url;
    }

    /**
     * @param string|null $promo_url
     */
    public function setPromoUrl(?string $promo_url): void
    {
        $this->promo_url = $promo_url;
    }

}