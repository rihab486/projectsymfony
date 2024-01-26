<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

;

class CategoriesFixtures extends Fixture
{

    private $counter = 1;
    public function __construct(private SluggerInterface $slugger)
    {
        
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $parent = $this->createCategory('Informatique',null,$manager);
        $this->createCategory('fullstack web',$parent,$manager);
        $this->createCategory('fullstack mobile',$parent,$manager);
        $this->createCategory('BA',$parent,$manager);
        $this->createCategory('Designer',$parent,$manager);
        $parent = $this->createCategory('Mode',null,$manager);
        $this->createCategory('homme',$parent,$manager);
        $this->createCategory('femme',$parent,$manager);
        
        $manager->flush();
    }
    public function createCategory(string $name,Categories $parent = null,ObjectManager $manager)
     {


        $category = new Categories();
        $category->setName($name);
        $category->setSlug( $this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $manager->persist($category);
        $this->addReferencE('cat-'.$this->counter , $category);
        $this->counter++ ;
        $manager->flush();
        return $parent;


     }
}
