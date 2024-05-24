<?php

use App\Enums\OrderStatusEnum;
use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

if (!function_exists('formatDate')) {
    function formatDate($date, string $format = 'd/m/Y')
    {
        // If $date is a string, parse it into a Carbon instance
        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }

        // If $date is a Carbon instance, format it
        if ($date instanceof \Carbon\Carbon) {
            return $date->format($format);
        }

        // Return the original value if it's not a string or Carbon instance
        return $date;
    }
}

if (!function_exists('formatNumber')) {
    function formatNumber($number, $type = '')
    {
        $whole = floor($number);  // returns the whole number part
        $fraction = $number - $whole;  // returns the fractional part

        if ($fraction > 0) {
            // if the number has a fractional part, format with decimal
            return number_format($number, 1, ',', '.') . ' ' . $type;
        }

        // if the number doesn't have a fractional part, format without decimal
        return number_format($number, 0, ',', '.') . ' ' . $type;
    }
}

if (!function_exists('flashMessage')) {
    function flashMessage(string $type, string $message)
    {
        session()->flash($type, $message);
    }
}

if (!function_exists('formatQuery')) {
    function formatQuery(array $arrData)
    {
        $conditions = [];
        $arrData = array_diff_key($arrData, ['page' => 0]);
        foreach ($arrData as $field => $value) {
            if ($value !== null) {
                if (is_array($value)) {
                    $conditions[] = [$field, 'IN', $value];
                } else {
                    if (is_numeric($value)) {
                        $conditions[] = [$field, $value];
                    } else {
                        $conditions[] = [$field, 'LIKE', "%$value%"];
                    }
                }
            }
        }

        return $conditions;
    }
}

if (!function_exists('searchDate')) {
    function searchDate(Builder $query, string $key, ?string $value, ?string $logical = '=')
    {
        if ($value) {
            $query = $query->whereDate($key, $logical, $value);
        }

        return $query;
    }
}

if (!function_exists('searchBetween')) {
    function searchBetween(Builder $query, string $key, ?string $fromInput, ?string $toInput)
    {
        if ($fromInput && $toInput) {
            $query = $query->whereBetween($key, [$fromInput, $toInput]);
        } elseif ($fromInput) {
            $query = $query->where($key, '>', $fromInput);
        } elseif ($toInput) {
            $query = $query->where($key, '<', $toInput);
        }

        return $query;
    }
}

if (!function_exists('formatSelectWeightPrice')) {
    function formatSelectWeightPrice()
    {
        $weightPrice = config('constant.pet_price_weight');
        $formatWeightPrice = [];
        foreach ($weightPrice as $value) {
            $formatWeightPrice[trans('Less') . ' ' . $value . ' KG'] = $value;
        }

        return $formatWeightPrice;
    }
}

if (!function_exists('getUser')) {
    function getUser()
    {
        if (Auth::check()) {
            return Auth::user();
        }

        return null;
    }
}

if (!function_exists('isCustomer')) {
    function isCustomer()
    {
        if (Auth::check()) {
            return Auth::user()->role_id === RoleEnum::CUSTOMER;
        }

        return false;
    }
}

if (!function_exists('flatten')) {
    function flatten(array $array)
    {
        $return = [];
        array_walk_recursive($array, function ($a) use (&$return) {
            $return[] = $a;
        });

        return $return;
    }
}

if (!function_exists('orderStatusColor')) {
    function orderStatusColor($statusID)
    {
        switch ($statusID) {
            case OrderStatusEnum::CREATED:
                return 'text-cyan-500';
            case OrderStatusEnum::CONFIRMED:
                return 'text-indigo-500';
            case OrderStatusEnum::IN_PROGRESS:
                return 'text-violet-500';
            case OrderStatusEnum::WAITING:
                return 'text-sky-500';
            case OrderStatusEnum::COMPLETED:
                return 'text-green-500';
            case OrderStatusEnum::CANCELLED:
                return 'text-red-500';
            default:
                return 'text-gray-900';
        }
    }
}
