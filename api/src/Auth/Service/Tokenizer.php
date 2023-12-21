<?php


namespace Auth\Service;


use DateTimeImmutable;

interface Tokenizer
{
    public function generate(DateTimeImmutable $date): string;
}