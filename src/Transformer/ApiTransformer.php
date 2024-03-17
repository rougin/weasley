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
     * @return array
     */
    protected function paginator(Arrayable $data)
    {
        $response = array();

        $result = $data->toArray();

        $perPage = (int) $result['per_page'];

        $total = (int) $result['total'];

        $rounded = round($total / $perPage);

        $response['total_items'] = $total;

        $response['total_pages'] = $rounded ?: 1;

        $response['items'] = $result['data'];

        return $response;
    }
}
