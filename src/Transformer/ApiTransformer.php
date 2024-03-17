<?php

namespace Rougin\Weasley\Transformer;

use Illuminate\Contracts\Support\Arrayable;

/**
 * API Transformer
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ApiTransformer implements TransformerInterface
{
    const PAGINATOR = 'Illuminate\Pagination\LengthAwarePaginator';

    /**
     * Transforms the contents of the result.
     *
     * @param  mixed $data
     * @return mixed
     */
    public function transform($data)
    {
        $result = $data->toArray();

        if (is_a($data, self::PAGINATOR))
        {
            /** @var \Illuminate\Pagination\LengthAwarePaginator $data */
            $result = $this->paginator($data);
        }

        return $result;
    }

    /**
     * Converts the paginator into Paypal API standards.
     *
     * @param  \Illuminate\Contracts\Support\Arrayable $data
     * @return array<string, mixed>
     */
    protected function paginator(Arrayable $data)
    {
        $object = $data->toArray();

        $perPage = (int) $object['per_page'];

        $total = (int) $object['total'];

        $rounded = round($total / $perPage);

        $result = array();

        $result['total_items'] = $total;

        $result['total_pages'] = $rounded ?: 1;

        $result['items'] = $object['data'];

        return $result;
    }
}
