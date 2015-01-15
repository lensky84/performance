<?php
namespace Lensky\PerformanceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Lensky\PerformanceBundle\Entity\Author;

/**
 * Class LoadAuthorData
 */
class LoadAuthorData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $johnDoe = new Author();
        $johnDoe->setFirstName('John')
            ->setLastName('Doe');
        $manager->persist($johnDoe);
        $this->addReference('author-john-doe', $johnDoe);

        $billGates = new Author();
        $billGates->setFirstName('Bill')
            ->setLastName('Gates');
        $manager->persist($billGates);
        $this->addReference('author-bill-gates', $billGates);

        $willSmith = new Author();
        $willSmith->setFirstName('Will')
            ->setLastName('Smith');
        $manager->persist($willSmith);
        $this->addReference('author-will-smith', $willSmith);

        $jamesBond = new Author();
        $jamesBond->setFirstName('James')
            ->setLastName('Bond');
        $manager->persist($jamesBond);
        $this->addReference('author-james-bond', $jamesBond);

        $mickeyMouse = new Author();
        $mickeyMouse->setFirstName('Mickey')
            ->setLastName('Mouse');
        $manager->persist($mickeyMouse);
        $this->addReference('author-mickey-mouse', $mickeyMouse);

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}