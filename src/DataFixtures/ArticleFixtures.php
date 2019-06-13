<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Tag;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixture implements DependentFixtureInterface
{
    private static $articleTitles = [
        'Projekt na konkurs malarski',
        'Na wenę trzeba poczekać',
        'Nie ma to jak weekend z kredkami',
        'Czy to faktycznie moja dzialka?',
        'Recenzja tabletu Huion',
        'Bambino też może być przydatne',
        'Malarstwo cyfrowe vs tradycyjne',
        'Czym jest hiperrealizm?',
        'Nawet ja mogę się pobawic farbkami',
    ];

    private static $articleImages = [
        'cyf1.png',
        'cyf2.png',
        'cyf3.png',
        'cyf4.png',
        'cyf5.png',
        'cyf6.png',
        'mal1.png',
        'mal2.png',
        'mal3.png',
        'mal4.png',
        'mal5.png',
        'rys1.png',
        'rys2.png',
        'rys3.png',
        'rys4.png',
        'rys5.png',
        'rys6.png',

    ];



    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(40, 'main_articles', function($count) use ($manager) {
            $article = new Article();
            $article->setTitle($this->faker->randomElement(self::$articleTitles))
                ->setContent(<<<EOF
Lorem ipsum dolor sit amet, **consectetur adipiscing elit**. Morbi posuere lorem a dolor iaculis varius. Curabitur eget auctor velit. Morbi posuere magna ut dictum congue. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum eget vulputate augue. Vivamus ut ligula viverra, sagittis risus in, facilisis mi. Mauris sed nulla id odio finibus tristique. Maecenas dolor orci, accumsan et mollis ac, facilisis quis nunc. Nunc venenatis risus at turpis elementum, ullamcorper molestie massa tempus. Morbi auctor risus ac iaculis hendrerit. Aliquam erat volutpat. Nullam ac elementum turpis, nec molestie risus. Sed sed est vel tortor mattis rutrum a nec sem.

Curabitur auctor dui sit amet ex iaculis, eget volutpat leo auctor. Nulla cursus tincidunt neque, at consectetur elit placerat quis. Vivamus efficitur odio condimentum nibh malesuada pharetra. Mauris ligula libero, rutrum vel elit at, molestie cursus ex. Quisque vel luctus ante, efficitur fringilla elit. Sed gravida varius erat vel scelerisque. Fusce nec neque et turpis commodo luctus. Mauris feugiat ligula ut lacus facilisis facilisis. Nam condimentum ligula in odio cursus, at maximus sapien tincidunt. Praesent ullamcorper, nunc vel vestibulum faucibus, magna velit viverra libero, ut sagittis lorem diam convallis neque. Quisque ultricies suscipit orci vitae accumsan. Sed iaculis a purus at volutpat. Aliquam dictum molestie tempus. Vestibulum quis ultricies libero. Ut id neque laoreet ipsum finibus molestie in ac odio. Maecenas odio tortor, sollicitudin eget vulputate ac, pretium non dui.

Duis neque metus, posuere nec nisi a, auctor tempus nulla. Sed malesuada egestas mauris, id faucibus felis maximus nec. Nullam rhoncus nisl et elit vehicula pulvinar. Aliquam erat volutpat. Ut vel nunc eros. Sed tempor leo id augue aliquam, at sodales erat pulvinar. Nullam eu leo erat. Donec dapibus mauris at nunc sagittis, et pulvinar erat fringilla. Aenean volutpat sollicitudin finibus. Quisque sit amet ligula mauris. Suspendisse potenti. Nam sit amet augue molestie, condimentum ante sit amet, accumsan nunc. Phasellus sagittis viverra leo. Vestibulum finibus, felis at finibus venenatis, tellus nulla porttitor augue, id accumsan nunc ex non sem. Nunc efficitur cursus lorem, et aliquam eros ultrices at. Integer elementum est ut nulla molestie, in faucibus est molestie.

Vestibulum tincidunt mi ut finibus volutpat. Sed tempus felis a ligula euismod, non lobortis velit molestie. Curabitur ultrices ullamcorper eleifend. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nullam cursus et diam scelerisque ultrices. Nulla pulvinar metus purus, nec congue velit ultricies a. Aenean venenatis ante a nisl rutrum mollis. Suspendisse accumsan ex sit amet lacus iaculis congue. Aliquam erat volutpat. Vestibulum laoreet maximus dapibus. Maecenas egestas lacus vitae faucibus tempor. Fusce non imperdiet quam. Nam tristique, dolor et pretium viverra, nisl magna pulvinar tellus, sit amet auctor sem erat ac eros. Donec non pretium dui. Ut sit amet euismod enim, eu tempus orci. Nam fermentum, enim hendrerit consequat pellentesque, dui turpis dictum justo, ut luctus est risus eu ipsum.

Integer eget velit mi. Vestibulum tempor ut massa in pretium. Cras lacinia mattis tempor. Aenean id mi leo. Fusce fermentum et mauris in dignissim. Duis cursus lectus et eros accumsan consectetur. Morbi eu turpis velit. Fusce bibendum rutrum diam ac scelerisque. Morbi malesuada ex a mi ullamcorper, eu placerat mi pulvinar. Etiam aliquam velit tristique semper blandit. Proin luctus eu velit eget maximus. Donec ligula purus, feugiat vitae commodo quis, efficitur sed leo. Nulla nec velit at nunc convallis eleifend.
EOF
            );

            // publish most articles
            if ($this->faker->boolean(70)) {
                $article->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            }

            $article->setAuthor($this->getRandomReference('admin_users'))
                ->setHeartCount($this->faker->numberBetween(5, 100))
                ->setImageFilename($this->faker->randomElement(self::$articleImages))
            ;

            $tags = $this->getRandomReferences('main_tags', $this->faker->numberBetween(0, 5));
            foreach ($tags as $tag) {
                $article->addTag($tag);
            }

            return $article;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
            TagFixture::class,
        ];
    }
}
