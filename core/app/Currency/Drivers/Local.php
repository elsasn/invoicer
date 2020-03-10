<?php

namespace App\Currency\Drivers;

use DateTime;
use Illuminate\Support\Arr;
use Torann\Currency\Drivers\AbstractDriver;
use Illuminate\Support\Collection;
use Illuminate\Database\DatabaseManager;
use App\Models\Currency as CurrencyModel;

class Local extends AbstractDriver
{
    protected $database;
    public function __construct(array $config)
    {
        parent::__construct($config);

        $this->database = app('db')->connection($this->config('connection'));
    }
    /**
     * {@inheritdoc}
     */
    public function create(array $params)
    {
        $currencies = include(__DIR__ . '/../../../vendor/torann/currency/resources/currencies.php');
        // Ensure the currency doesn't already exist
        foreach ($currencies as $code=>$currency){
            $created = new DateTime('now');
            $currency = array_merge([
                'name' => '',
                'code' => $code,
                'symbol' => '',
                'format' => '',
                'exchange_rate' => 1,
                'active' => 0,
                'created_at' => $created,
                'updated_at' => $created,
            ], $currency);
            CurrencyModel::create($currency);
        }
        /*if ($this->find($params['code'], null) !== null) {
            return 'exists';
        }
        // Created at stamp
        $created = new DateTime('now');
        $params = array_merge([
            'name' => '',
            'code' => '',
            'symbol' => '',
            'format' => '',
            'exchange_rate' => 1,
            'active' => 0,
            'created_at' => $created,
            'updated_at' => $created,
        ], $params);

       return CurrencyModel::create($params);*/
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        $collection = new Collection($this->database->table($this->config('table'))->get());

        return $collection->keyBy('code')
            ->map(function ($item) {
                return [
                    'uuid' => $item->uuid,
                    'name' => $item->name,
                    'code' => strtoupper($item->code),
                    'symbol' => $item->symbol,
                    'format' => $item->format,
                    'exchange_rate' => $item->exchange_rate,
                    'active' => $item->active,
                    'created_at' => $item->updated_at,
                    'updated_at' => $item->updated_at,
                ];
            })
            ->all();
    }

    /**
     * {@inheritdoc}
     */
    public function find($code, $active = 0)
    {
        return Arr::get($this->all(), $code);
    }

    /**
     * {@inheritdoc}
     */
    public function update($code, array $attributes, DateTime $timestamp = null)
    {
        $table = $this->config('table');

        // Create timestamp
        if (empty($attributes['updated_at']) === true) {
            $attributes['updated_at'] = new DateTime('now');
        }

        return $this->database->table($table)
            ->where('code', strtoupper($code))
            ->update($attributes);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($code)
    {
        // Get blacklist path
        /*$path = $this->getConfig('path');

        // Get all as an array
        $currencies = $this->all();

        if (isset($currencies[$code])) {
            unset($currencies[$code]);

            return file_put_contents($path, json_encode($currencies));
        }

        return false;*/
    }
}