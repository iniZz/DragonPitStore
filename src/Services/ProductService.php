<?php

namespace App\Services;

use App\Entity\Product;

use Doctrine\ORM\EntityManagerInterface;

class ProductService
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }
    
    public function Update($product){

        $slug = str_replace(" ", "-", strtolower($product->getName()));
        $queryBuilder = $this->entityManager->getRepository("App\Entity\Product");
        $slug2;
        $post = $queryBuilder->findOneBySlugField($slug);
        if ($post != null) {
            $loop = true;
            do {
                
                $randomS = $this->generateRandomString(6);
                $slug2 = $slug.'-'.$randomS;
                sleep(1);
                if (!$queryBuilder->findOneBySlugField($slug2)) {
                    $loop = false;
                }
            } while ($loop);

            $slug = $slug2;
        }
        
        $product->setSlug($slug);
            
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    public function Insert($product){
        $slug = str_replace(" ", "-", strtolower($product->getName()));
        $queryBuilder = $this->entityManager->getRepository("App\Entity\Product");
        $slug2;
        $post = $queryBuilder->findOneBySlugField($slug);
        if ($post != null) {
            $loop = true;
            do {
                
                $randomS = $this->generateRandomString(6);
                $slug2 = $slug.'-'.$randomS;
                sleep(1);
                if (!$queryBuilder->findOneBySlugField($slug2)) {
                    $loop = false;
                }
            } while ($loop);

            $slug = $slug2;
        }
        
        $product->setSlug($slug);
            
        $this->entityManager->persist($product);
        $this->entityManager->flush();
        
    }

    private function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $characters = '01eXzE';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
        
    }
}