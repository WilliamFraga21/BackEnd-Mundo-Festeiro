<?php

function dd(mixed $value, mixed ...$values): void
{
    var_dump($value, ...$values);
    die();
}


function url(): string
{
    return $_SERVER['HTTP_HOST'] . '/';
}

function asset(string $file): string
{
    return 'http://'. $_SERVER['HTTP_HOST'] . '/storage/' . $file;
}