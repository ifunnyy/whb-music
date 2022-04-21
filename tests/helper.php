<?php

/**
 * 工厂创建对象，并存进数据库
 */
function create($class, $attributes = [], $count = 1)
{
    if ($count == 1) {
        return $class::factory()->create($attributes);
    }
    return $class::factory($count)->create($attributes);
}

/**
 * 工厂创建对象
 */
function make($class, $attributes = [], $count = 1)
{
    if ($count == 1) {
        return $class::factory()->make($attributes);
    }
    return $class::factory($count)->make($attributes);
}
