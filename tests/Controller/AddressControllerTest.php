<?php

namespace App\Test\Controller;

use App\Entity\Address;
use App\Entity\User;
use App\Repository\AddressRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddressControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private AddressRepository $repository;
    private string $path = '/address/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Address::class);
        $this->userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Address index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        // $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'address[city]' => 'Testing',
            'address[postcode]' => '11-111',
            'address[street]' => 'Testing',
            'address[user]' => '1',
        ]);

        self::assertResponseRedirects('/address/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        // $this->markTestIncomplete();
        $user = $this->userRepository->find(1);
        $fixture = new Address();
        $fixture->setCity('My city');
        $fixture->setPostcode('11-111');
        $fixture->setStreet('My streen');
        $fixture->setUser($user);

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Address');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        // $this->markTestIncomplete();
        $user = $this->userRepository->find(1);

        $fixture = new Address();
        $fixture->setCity('My Title');
        $fixture->setPostcode('11-111');
        $fixture->setStreet('My Title');
        $fixture->setUser($user);

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'address[city]' => 'Something New',
            'address[postcode]' => '22-222',
            'address[street]' => 'Something New',
            'address[user]' => '1',
        ]);

        self::assertResponseRedirects('/address/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getCity());
        self::assertSame('22-222', $fixture[0]->getPostcode());
        self::assertSame('Something New', $fixture[0]->getStreet());
        self::assertSame($user->getId(), $fixture[0]->getUser()->getId());
    }

    public function testRemove(): void
    {
        // $this->markTestIncomplete();
        $user = $this->userRepository->find(1);

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Address();
        $fixture->setCity('My Title');
        $fixture->setPostcode('11-111``');
        $fixture->setStreet('My Title');
        $fixture->setUser($user);

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/address/');
    }
}
