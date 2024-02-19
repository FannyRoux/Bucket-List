<?php

namespace App\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;



class Censurator
{
    private const FORBIDENWORDS =['fuck', 'shit', 'alpaca', 'robert'];
    public function __construct(protected EntityManagerInterface $em)
    {

    }
    public function purify(string $text ):string
    {
        foreach (self::FORBIDENWORDS as $word){
          $purifiedText = str_repeat('*',mb_strlen($word));
          $text=str_ireplace($word,$purifiedText,$text);
        }
        return $text;
    }
}