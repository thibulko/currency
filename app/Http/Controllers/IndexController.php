<?php

namespace App\Http\Controllers;

use App\Currency;
use App\CurrencyRate;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class IndexController extends Controller
{
    /**
     * @var Client
     */
    private $client;

    /**
     * IndexController constructor.
     */
    public function __construct()
    {
        $this->client = new Client;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = [];

        if ($request->has('sid')) {
            $data['sid'] = $request->sid;
            $currencies = $this->getCurrencies($request->sid);
            $rates = $this->getCurrenciesRates($request->sid);

            if (!empty($rates)) {
                foreach($rates as $rate) {
                    if ($currencies->has($rate->from())) {
                        $currencies->get($rate->from())->addRate($rate);
                    }
                }
            }

            $data['currencies'] = $currencies;
        }

        return view('welcome', $data);
    }

    /**
     * @param string $sid
     * @return Collection
     */
    private function getCurrencies(string $sid): Collection
    {
        $response = $this->client->get('https://testing.bb.yttm.work:5000/v1/get_currencies?sid=' . $sid);
        $data = json_decode((string) $response->getBody(), true);

        if (!empty($data) && !empty($data['currencies'])) {
            return collect(($data['currencies']))->mapWithKeys(function($item) {
                 return [$item['curr_id'] => new Currency($item)];
             });
        }
    }

    /**
     * @param string $sid
     * @return Collection
     */
    private function getCurrenciesRates(string $sid): Collection
    {
        $response = $this->client->get('https://testing.bb.yttm.work:5000/v1/get_currency_rates?sid=' . $sid);
        $data = json_decode((string) $response->getBody(), true);

        if (!empty($data) && !empty($data['rates'])) {
            return collect($data['rates'])->mapInto(CurrencyRate::class);
        }
    }
}
