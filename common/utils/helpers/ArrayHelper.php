<?php

namespace common\utils\helpers;

use Traversable;
use yii\helpers\BaseArrayHelper;

class ArrayHelper extends BaseArrayHelper
{
    /**
     * Creates  an  array  with  all  falsey  values removed. The values
     * false, null, 0, "", undefined, and NaN are all falsey.
     *
     ** ArrayHelper::compact([0, 1, false, 2, '', 3]);
     ** // → [1, 2, 3]
     *
     * @param array $array array to compact
     *
     * @return array
     *
     */
    public static function compact(array $array)
    {
        return array_values(array_filter($array));
    }

    /**
     * Creates an array of elements split into groups the length of size. If array can't be split evenly, the final chunk will be the remaining elements.
     *
     * ArrayHelper::chunk([1, 2, 3, 4, 5], 3);
     * // → [[1, 2, 3], [4, 5]]
     *
     * @param array $array original array
     * @param int $size the chunk size
     * @param boolean $preserveKeys When set to TRUE keys will be preserved. Default is FALSE which will reindex the chunk numerically
     *
     * @return array
     *
     */
    public static function chunk(array $array, $size = 1, $preserveKeys = false)
    {
        return array_chunk($array, $size, $preserveKeys);
    }

    /**
     * Creates an array of array values not included in the other given arrays using SameValueZero for equality comparisons. The order and references of result values are determined by the first array
     *
     * @param array $array1
     * @param array $array2
     *
     * @return array
     */
    public static function difference(array $array1, array $array2)
    {
        return array_diff($array1, $array2);
    }

    /**
     * This method is like difference except that it accepts iteratee which is invoked for each element of array and values to generate the criterion by which they're compared. The order and references of result values are determined by the first
     * array. The iteratee is invoked with one argument
     *
     * @param array $array1
     * @param array $array2
     * @param $func
     *
     * @return array
     */
    public static function differenceBy(array $array1, array $array2, $func)
    {
        return array_udiff($array1, $array2, $func);
    }

    /**
     * Takes a nested combination of collections and returns their contents as a single, flat array.
     * Does not preserve indexes.
     *
     * ArrayHelper::flatten([1, [2, [3, [4]], 5]])
     * => [1, 2, 3, 1, 2, 3, 4, 5]
     *
     * @param Traversable|array $collection
     *
     * @return array
     */
    public static function flatten($collection)
    {
        $stack  = [$collection];
        $result = [];
        while ( ! empty($stack)) {
            $items = array_shift($stack);
            if (is_array($items) || $items instanceof Traversable) {
                /** @var array | Traversable $items */
                foreach ($items as $element) {
                    array_unshift($stack, $element);
                }
            } else {
                array_unshift($result, $items);
            }
        }

        return $result;
    }

    /**
     * Returns true if every value in the collection passes the callback truthy test
     * Callback arguments will be element, index, collection
     *
     * If all users are active, do something
     * if(ArrayHelper::every($users, function($user, $collectionKey, $collection) {return $user->isActive();}) {}
     *
     * @param Traversable|array $collection
     * @param callable $callback
     *
     * @return bool
     */
    public static function every($collection, callable $callback)
    {
        foreach ($collection as $index => $element) {
            if ( ! $callback($element, $index, $collection)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Fills elements of array with value
     *
     ** ArrayHelper::fill([1, 2, 3], 4);
     ** // → [
     *      0 => 4,
     *      1 => 4,
     *      2 => 4
     * ]
     *
     ** ArrayHelper::fill([1, 2, 3], 4, true);
     ** // → [
     *      1 => 4,
     *      2 => 4,
     *      3 => 4
     * ]
     *
     * @param array $array
     * @param $value
     * @param bool $preserveKey
     *
     * @return array
     */
    public static function fill(array $array, $value, $preserveKey = false)
    {
        if ($preserveKey) {
            return array_fill_keys(array_values($array), $value);
        }

        array_walk($array, function (&$val) use ($value) {
            $val = $value;
        });

        return $array;
    }

    /**
     * Gets the first element of array
     *
     * @param array $array
     *
     * @return null
     */
    public static function first(array $array)
    {
        return is_array($array) && count($array) > 0 ? array_values($array)[0] : null;
    }

    /**
     * Looks through each element in the list, returning an array of all the elements that pass a truthy test (callback). Callback arguments will be element, index, collection
     *
     * $notEvenNumbers = ArrayHelper::_filter($arr, function($number) {
     * return $number % 2 !== 0;
     * });
     *
     * @param Traversable|array $collection
     * @param callable $callback
     *
     * @return array
     */
    public static function _filter($collection, callable $callback)
    {
        $aggregation = [];
        foreach ($collection as $index => $element) {
            if ($callback($element, $index, $collection)) {
                $aggregation[$index] = $element;
            }
        }

        return $aggregation;
    }

    /**
     * Gets all but the last element of array
     *
     * @param array $array
     *
     * @return mixed
     */
    public static function initial(array $array)
    {
        return is_array($array) && count($array) > 0 ? array_pop($array) : [];
    }

    /**
     * Creates an array of unique values that are included in all given arrays using SameValueZero for equality comparisons. The order and references of result values are determined by the first array
     *
     * ArrayHelper::intersection([1, 2, 3], [3, 4, 5])
     *
     * // → [
     *      2 => 3,
     * ]
     *
     * ArrayHelper::intersection([1, 2, 3], [3, 4, 5], true)
     *
     * // → [
     *      0 => 3,
     * ]
     *
     * @param array $array1
     * @param array $array2
     * @param bool $preserveKey
     *
     * @return array
     */
    public static function intersection(array $array1, array $array2, $preserveKey = false)
    {
        if ($preserveKey) {
            return array_intersect($array1, $array2);
        }

        return array_values(array_intersect($array1, $array2));
    }

    /**
     * This method is like intersection except that it accepts iteratee which is invoked for each element of each arrays to generate the criterion by which they're compared. The order and references of result values are determined by the first
     * array. The iteratee is invoked with one argument
     *
     * ArrayHelper::intersectionBy([1, 2, 3], [3, 4, 5], "strcasecmp")
     *
     * // → [
     *      2 => 3,
     * ]
     *
     * ArrayHelper::intersectionBy([1, 2, 3], [3, 4, 5], "strcasecmp", true)
     *
     * // → [
     *      0 => 3,
     * ]
     *
     * @param array $array1
     * @param array $array2
     * @param $func
     * @param bool $preserveKey
     *
     * @return array
     */
    public static function intersectionBy(array $array1, array $array2, $func, $preserveKey = false)
    {
        if ($preserveKey) {
            return array_uintersect($array1, $array2, $func);
        }

        return array_values(array_uintersect($array1, $array2, $func));
    }

    /**
     * Gets the last element of array
     *
     * @param array $array
     *
     * @return null
     */
    public static function last(array $array)
    {
        return is_array($array) && count($array) > 0 ? array_values($array)[-1] : null;
    }

    /**
     * Returns true if all of the elements in the collection pass the callback falsy test
     * Callback arguments will be element, index, collection.
     *
     * if (ArrayHelper::none($users, function($user, $collectionKey, $collection) {return $user->isActive();})) {// Do something with a whole list of inactive users}
     *
     * @param Traversable|array $collection
     * @param callable $callback
     *
     * @return bool
     */
    public static function none($collection, callable $callback)
    {
        foreach ($collection as $index => $element) {
            if ($callback($element, $index, $collection)) {
                return false;
            }
        }

        return true;
    }

    /**
     * prepend item or value to an array
     *
     ** ArrayHelper::prepend([1, 2, 3], 4);
     ** // → [4, 1, 2, 3]
     *
     * @param array $array
     * @param null $value
     *
     * @return array
     *
     */
    public static function prepend(array $array, $value = null)
    {
        array_unshift($array, $value);

        return $array;
    }

    /**
     * Removes all given values from array using an array of values
     *
     ** ArrayHelper::pullAll([1, 2, 3], [1, 2]);
     ** // → [
     *      0 => 3,
     * ]
     *
     ** ArrayHelper::pullAll([1, 2, 3], [1, 2], true);
     ** // → [
     *      2 => 3,
     * ]
     *
     * @param array $array
     * @param array $values
     * @param bool $preserveKey
     *
     * @return array
     * @throws \yii\base\InvalidParamException
     */
    public static function pullAll(array $array, array $values, $preserveKey = false)
    {
        $tempArray = array_filter($array, function ($value) use ($values) {
            if ( ! ArrayHelper::isIn($value, $values)) {
                return $value;
            }
        });

        if ($preserveKey) {
            return $tempArray;
        }

        return array_values($tempArray);
    }

    /**
     * This method is like pullAll except that it accepts iteratee which is invoked for each element of array and values to generate the criterion by which they're compared. The iteratee is invoked with one argument: (value)
     *
     * $values = [1, 2];
     ** ArrayHelper::pullAllBy([1, 2, 3], function ($value) use ($values) {});
     ** // → [
     *      0 => 3,
     * ]
     *
     ** ArrayHelper::pullAllBy([1, 2, 3], function ($value) use ($values) {}, true);
     ** // → [
     *      2 => 3,
     * ]
     *
     * @param array $array
     * @param $func
     * @param bool $preserveKey
     *
     * @return array
     * @internal param array $values
     */
    public static function pullAllBy(array $array, $func, $preserveKey = false)
    {
        $tempArray = array_filter($array, $func);

        if ($preserveKey) {
            return $tempArray;
        }

        return array_values($tempArray);
    }

    /**
     * Shuffle an array ensuring no item remains in the same position.
     *
     ** ArrayHelper::randomize([1, 2, 3]);
     ** // → [2, 3, 1]
     *
     * @param array $array original array
     *
     * @return array
     *
     */
    public static function randomize(array $array)
    {
        for ($i = 0, $c = count($array); $i < $c - 1; $i++) {
            $j = mt_rand($i + 1, $c - 1);
            list($array[$i], $array[$j]) = [$array[$j], $array[$i]];
        }

        return $array;
    }

    /**
     * Returns the elements in list without the elements that the truthy test (callback) passes. The opposite of
     * Callback arguments will be element, index, collection
     *
     * $evenNumbers = ArrayHelper::reject($arr, function($number) {
     * return $number % 2 !== 0;
     * });
     *
     * @param Traversable|array $collection
     * @param callable $callback
     *
     * @return array
     */
    public static function reject($collection, callable $callback)
    {
        $aggregation = [];
        foreach ($collection as $index => $element) {
            if ( ! $callback($element, $index, $collection)) {
                $aggregation[$index] = $element;
            }
        }

        return $aggregation;
    }

    /**
     * generate array of repeated values
     *
     ** ArrayHelper::repeat('foo', 3);
     ** // → ['foo', 'foo', 'foo']
     *
     * @param string $object The object to repeat.
     * @param int $times How many times has to be repeated.
     *
     * @return array Returns a new array of filled values.
     *
     */
    public static function repeat($object, $times)
    {
        return array_fill(0, (int)$times, $object);
    }

    /**
     * Reverses array so that the first element becomes the last, the second element becomes the second to last, and so on
     *
     * @param array $array
     * @param bool $preserveKey
     *
     * @return array
     */
    public static function reverse(array $array, $preserveKey = false)
    {
        return array_reverse($array, $preserveKey);
    }

    /**
     * Returns true if some of the elements in the collection pass the callback truthy test. Short-circuits and stops
     * traversing the collection if a truthy element is found. Callback arguments will be value, index, collection
     *
     * if (ArrayHelper::some($users, function($user, $collectionKey, $collection) use($me) {return $user->isFriendOf($me);})) {// One of those users is a friend of me}
     *
     * @param Traversable|array $collection
     * @param callable $callback
     *
     * @return bool
     */
    public static function some($collection, callable $callback)
    {
        foreach ($collection as $index => $element) {
            if ($callback($element, $index, $collection)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Gets all but the first element of array.
     *
     * @param array $array
     *
     * @return array
     */
    public static function tail(array $array)
    {
        array_shift($array);

        return $array;
    }

    /**
     * Creates an array of unique values, in order, from all given arrays using SameValueZero for equality comparisons
     *
     * @param array $array1
     * @param array $array2
     *
     * @return array
     */
    public static function union(array $array1, array $array2)
    {
        $tempArray = array_unique(ArrayHelper::merge($array1, $array2));
        sort($tempArray);

        return $tempArray;
    }

    /**
     * Creates an array of unique values that is the symmetric difference of the given arrays. The order of result values is determined by the order they occur in the arrays
     *
     * ArrayHelper::_xor([2, 1], [2, 3])
     * => [1, 3]
     *
     * @param array $array1
     * @param array $array2
     *
     * @return array
     */
    public static function _xor(array $array1, array $array2)
    {
        return array_merge(array_diff($array1, $array2), array_diff($array2, $array1));
    }

    /**
     * Recombines arrays by index and applies a callback optionally
     *
     * ArrayHelper::zip(['one', 'two', 'three'], [1, 2, 3])
     * => [['one', 1], ['two', 2], ['three', 3]]
     *
     * @param $args array|Traversable $collection One or more callbacks
     *
     * @return array
     */
//    public static function zip(...$args)
//    {
//        $callback = null;
//        if (is_callable(end($args))) {
//            $callback = array_pop($args);
//        }
//
//        $result = [];
//        foreach ((array)reset($args) as $index => $value) {
//            $zipped = [];
//            foreach ($args as $arg) {
//                $zipped[] = isset($arg[$index]) ? $arg[$index] : null;
//            }
//            if ($callback !== null) {
//                /** @var callable $callback */
//                $zipped = $callback(...$zipped);
//            }
//            $result[$index] = $zipped;
//        }
//
//        return $result;
//    }
}