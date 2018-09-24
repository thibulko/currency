<?php

namespace App;

use Illuminate\Support\Collection;

class Currency
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var Collection
     */
    protected $rates;

    /**
     * Currency constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->id = $data['curr_id'] ?? 0;
        $this->code = $data['curr_code'] ?? "";
        $this->name = $data['curr_name'] ?? "";
        $this->status = $data['status'] ?? "";

        $this->rates = collect();
    }

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function code(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function status(): string
    {
        return $this->status;
    }

    /**
     * @return Collection
     */
    public function rates(): Collection
    {
        return $this->rates;
    }

    /**
     * @param CurrencyRate $rate
     * @return Collection
     */
    public function addRate(CurrencyRate $rate): void
    {
        $this->rates->push($rate);
    }
}
