<?php namespace Taecel\Taecel;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Taecel\Taecel\Components\Bolsa;
use Taecel\Taecel\Components\Producto;
use Taecel\Taecel\Components\Proveedor;
use Taecel\Taecel\Throwables\ServerIsOffline;
use Throwable;
use Exception;

class Taecel
{

    private string $url;
    private string|null $key;
    private string|null $nip;
    private bool $validate_online;

    private const CACHE_KEY = 'productos_availables';

    const TIEMPO_AIRE = 1;
    const PAQUETES = 2;
    const SERVICIOS = 3;
    const GIF_CARDS = 4;

    /** @var Collection<Proveedor> */
    private Collection $proveedores_tae;
    /** @var Collection<Proveedor> */
    private Collection $proveedores_paquetes;
    /** @var Collection<Proveedor> */
    private Collection $proveedores_servicios;
    /** @var Collection<Proveedor> */
    private Collection $proveedores_gifcards;
    /** @var Collection<Producto> */
    private Collection $productos;

    public function __construct(string|null $key, string|null $nip)
    {
        $this->key = $key;
        $this->nip = $nip;
        $this->url = config('taecel.url');
        $this->validate_online = config('taecel.validate_online', false);
        $this->proveedores_tae = new Collection();
        $this->proveedores_paquetes = new Collection();
        $this->proveedores_servicios = new Collection();
        $this->proveedores_gifcards = new Collection();
        $this->productos = new Collection();
    }

    private function url($url) : string
    {
        return "{$this->url}/{$url}";
    }

    public static function create()
    {
        return new Taecel(config('taecel.key'), config('taecel.nip'));
    }

    /**
     * @return array
     * @throws Throwable
     */
    public function getBalance() : array
    {
        if ($this->validate_online) throw_unless($this->isOnline(), ServerIsOffline::class);
        $httpResponse = Http::asForm()->post($this->url('getBalance'), [
            'key' => $this->key,
            'nip' => $this->nip
        ]);
        throw_if($httpResponse->status() !== 200, new Exception(sprintf('%d error', $httpResponse->status())));
        $data = $httpResponse->json();
        throw_unless($data['success'], new Exception(sprintf(__('message %s, error: %d'), $data['message'], $data['error'])));
        $bolsas = [];
        foreach ($data['data'] as $bolsa_data)
        {
            $bolsas[] = new Bolsa($bolsa_data['ID'], $bolsa_data['Bolsa'], floatval($bolsa_data['Saldo']) );
        }
        return $bolsas;
    }

    public function getProducts() : void
    {
        if ($this->validate_online) throw_unless($this->isOnline(), ServerIsOffline::class);
        if(!Cache::has(Taecel::CACHE_KEY))
        {
            $httpResponse = Http::asForm()->post($this->url('getProducts'), [
                'key' => $this->key,
                'nip' => $this->nip
            ]);
            throw_if($httpResponse->status() !== 200, new Exception(sprintf('%d error', $httpResponse->status())));
            $data = $httpResponse->json();
            throw_unless($data['success'], new Exception(sprintf(__('message %s, error: %d'), $data['message'], $data['error'])));
            $_data = $data['data'];
            Cache::add(Taecel::CACHE_KEY, $_data);
        }
        else
        {
            $_data = Cache::get(Taecel::CACHE_KEY);
        }
        foreach ($_data['carriers'] as $carrier)
        {
            $proveedor =  new Proveedor($carrier);
            switch ($proveedor->getCategoriaId())
            {
                case self::TIEMPO_AIRE:
                    $this->proveedores_tae->add($proveedor);
                    break;
                case self::SERVICIOS:
                    $this->proveedores_servicios->add($proveedor);
                    break;
                case self::PAQUETES:
                    $this->proveedores_paquetes->add($proveedor);
                    break;
                case self::GIF_CARDS:
                    $this->proveedores_gifcards->add($proveedor);
                    break;
                default:
                    break;
            }
        }
        foreach ($_data['productos'] as $producto)
        {
            $this->productos->add(new Producto($producto));
        }
    }


    private function isOnline() : bool
    {
        return boolval(@fsockopen("www.google.com", 80));
    }

    public function getProductsByCarrier(int $carrier_id) : Collection
    {
        $this->getProducts();
        return $this->productos->where(function(Producto $producto) use ($carrier_id){
            return $producto->getCarrierId() === $carrier_id;
        });
    }

}