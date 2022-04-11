<?php

namespace App\DataFixtures;
use app\Entity\Article;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i=1;$i<=10;$i++) { $article=new Article(); $article->setTitre("Titre de l'article n° $i") ->setContenu("<p>Le contenu de l'article n° $i</p>") ->setImage("http://assets.stickpng.com/thumbs/584df6256a5ae41a83ddee0f.png") ->setCreatedAt(new \datetimeImmutable()); $manager->persist($article); } $manager->flush();
    }
}
