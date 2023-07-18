<?php

namespace App\DataFixtures;

use App\Entity\Images;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ImagesFixtures extends Fixture implements DependentFixtureInterface
//l'implementation va permettre de dire à cette Fixture que son exécution 
//dépend de celle d'une autre fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for($img=1; $img <=50; $img++){
            $image = new Images();
            $image->setName($faker->image(null,640,480));
            $product = $this->getReference('prod-'.rand(1,10));
            $image->setProducts($product);
            $manager->persist($image);
        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
         //on precise que l’exécution de Productsfixture se fait avant ImagesFixture
        return [
            ProductsFixtures::class
        ];
    }
}
