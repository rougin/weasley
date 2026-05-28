<?php

namespace Rougin\Weasley\Mutators;

use Illuminate\Contracts\Support\Arrayable;
use Rougin\Weasley\Contract\Mutator;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class RestMutator implements Mutator
{
    const PAGINATOR = 'Illuminate\Pagination\LengthAwarePaginator';

    /**
     * @deprecated since ~0.7, use "mutate" instead.
     * @codeCoverageIgnore
     *
     * Transforms the contents of the result.
     *
     * @param \Illuminate\Contracts\Support\Arrayable<integer|string, mixed> $data
     *
     * @return mixed
     */
    public function transform($data)
    {
        return $this->mutate($data);
    }

    /**
     * Mutates the contents of the result.
     *
     * @param \Illuminate\Contracts\Support\Arrayable<integer|string, mixed> $data
     *
     * @return mixed
     */
    public function mutate($data)
    {
        $result = $data->toArray();

        if (is_a($data, self::PAGINATOR))
        {
            /** @var \Illuminate\Pagination\LengthAwarePaginator<integer|string, mixed> $data */
            $result = $this->paginator($data);
        }

        return $result;
    }

    /**
     * Converts the paginator into Paypal API standards.
     *
     * @param \Illuminate\Contracts\Support\Arrayable<integer|string, mixed> $data
     *
     * @return array<string, mixed>
     */
    protected function paginator(Arrayable $data)
    {
        $object = $data->toArray();

        /** @var integer */
        $perPage = $object['per_page'];

        /** @var integer */
        $total = $object['total'];

        $rounded = round($total / $perPage);

        $result = array();

        $result['total_items'] = $total;

        $result['total_pages'] = $rounded ?: 1;

        $result['items'] = $object['data'];

        return $result;
    }
}
