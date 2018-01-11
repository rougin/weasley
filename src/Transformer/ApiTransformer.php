<?php

namespace Rougin\Weasley\Transformer;

use Illuminate\Contracts\Support\Arrayable;

/**
 * API Transformer
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ApiTransformer implements TransformerInterface
{
    const PAGINATOR = 'Illuminate\Contracts\Pagination\LengthAwarePaginator';

    /**
     * Transforms the contents of the result.
     *
     * @param  mixed $data
     * @return mixed
     */
    public function transform($data)
    {
        $exists = is_a($data, self::PAGINATOR);

        $result = $data->toArray();

        $exists && $result = $this->paginator($data);

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
        list($response, $result) = array(array(), $data->toArray());

        $rounded = round($result['total'] / $result['per_page']);

        $response['total_items'] = $result['total'];

        $response['total_pages'] = $rounded ?: 1;

        $response['items'] = $result['data'];

        return $response;
    }
}
