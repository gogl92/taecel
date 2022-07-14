<?php namespace Taecel\Taecel;

use Illuminate\Support\Facades\Http;
use Taecel\Taecel\Components\Bolsa;
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

    /** @var array<Proveedor> */
    protected array $carriers = [];

    public function __construct(string|null $key, string|null $nip)
    {
        $this->key = $key;
        $this->nip = $nip;
        $this->url = config('taecel.url');
        $this->validate_online = config('taecel.validate_online', false);
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
        $httpResponse = Http::asForm()->post($this->url('getProducts'), [
            'key' => $this->key,
            'nip' => $this->nip
        ]);
        throw_if($httpResponse->status() !== 200, new Exception(sprintf('%d error', $httpResponse->status())));
        $data = $httpResponse->json();
        throw_unless($data['success'], new Exception(sprintf(__('message %s, error: %d'), $data['message'], $data['error'])));
        foreach ($data['carriers'] as $carrier)
        {
            $this->carriers[] = new Proveedor($carrier);
        }
    }


    private function isOnline() : bool
    {
        return boolval(@fsockopen("www.google.com", 80));
    }

}