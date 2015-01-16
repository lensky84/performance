<?php
namespace Lensky\PerformanceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Lensky\PerformanceBundle\Entity\Author;
use Lensky\PerformanceBundle\Entity\Post;

/**
 * Class LoadPostData
 */
class LoadPostData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Quantity of generated posts
     */
    const POSTS_QUANTITY = 1000;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $authors = [
            $this->getReference('author-john-doe'),
            $this->getReference('author-bill-gates'),
            $this->getReference('author-will-smith'),
            $this->getReference('author-james-bond'),
            $this->getReference('author-mickey-mouse'),
        ];

        // generate posts
        for ($i = 1; $i <= self::POSTS_QUANTITY; $i++) {
            $post = new Post();
            /** @var Author $author */
            $author = $authors[array_rand($authors)];
            $post->setAuthor($author)
                ->setTitle('Title of ' . $author->getFullName() . ' Post #' . $i)
                ->setText('Text of ' . $author->getFullName() . ' Post #' . $i)
                ->setCreatedAt(new \DateTime('-' . rand(1, 30) . 'min'));
            $manager->persist($post);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 10;
    }
}