<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

;

class ProductsFixtures extends Fixture{

        public function __construct(private UserPasswordHasherInterface $passwordEncoder, private SluggerInterface $slugger)
        {}
        
        public function load(ObjectManager $manager): void
        {

            $product = new Products();
            $faker = Faker\Factory::create('fr_FR');

            for($prod=1; $prod <= 10 ; $prod++){
                $product->setName($faker->text(15));
                $product->setDescription($faker->text(30));
                $product->setSlug($this->slugger->slug($product->getName())->lower());
                $product->setPrice($faker->numberBetween(600,150000));
                $product->setStock($faker->numberBetween(0,10));
                
                //when i search a refrence of category , i use getReference() method
                $category = $this->getReference('cat-'.rand(1,8));
                $product->setCategories($category);
                
                $manager->persist($product);
                $this->setReference('prod-'.$prod,$product);
            
            }
            
            $manager->flush();
        }
}