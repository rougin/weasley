<?php

namespace Rougin\Weasley\Mutators;

use Illuminate\Contracts\Support\Arrayable;
use Rougin\Weasley\Contract\Mutator;

/**
 * API Transformer
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class RestMutator implements Mutator
{
    const PAGINATOR = 'Illuminate\Pagination\LengthAwarePaginator';

    /**
     * @deprecated since ~0.7, use "mutate" instead.
     *
     * Transforms the contents of the result.
     *
     * @param  \Illuminate\Contracts\Support\Arrayable $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function transform($data)
    {
        return $this->mutate($data);
    }

    /**
     * Mutates the contents of the result.
     *
     * @param  \Illuminate\Contracts\Support\Arrayable $data
     * @return mixed
     */
    public function mutate($data)
    {
        $result = $data->toArray();

        if (is_object($data) && is_a($data, self::PAGINATOR))
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
