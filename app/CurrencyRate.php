<?php

namespace App;

class CurrencyRate
{
    /**
     * @var float
     */
    protected $rate;

    /**
     * @var int
     */
    protected $from;

    /**
     * @var int
     */
    protected $to;

    /**
     * Currency constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->rate = $data['rate'] ?? 0;
        $this->from = $data['from'] ?? 0;
        $this->to = $data['to'] ?? 0;
    }

    /**
     * @return int
     */
    public function rate(): int
    {
        return $this->rate;
    }

    /**
     * @return int
     */
    public function from(): int
    {
        return $this->from;
    }

    /**
     * @return int
     */
    public function to(): int
    {
        return $this->to;
    }
}