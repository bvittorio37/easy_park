<?php

namespace App\Test\Controller;

use App\Entity\Parking;
use App\Repository\ParkingRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ParkingControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ParkingRepository $repository;
    private string $path = '/parking/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Parking::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Parking index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'parking[matricule]' => 'Testing',
            'parking[debut]' => 'Testing',
            'parking[sortie]' => 'Testing',
            'parking[place]' => 'Testing',
            'parking[tarif]' => 'Testing',
        ]);

        self::assertResponseRedirects('/parking/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Parking();
        $fixture->setMatricule('My Title');
        $fixture->setDebut('My Title');
        $fixture->setSortie('My Title');
        $fixture->setPlace('My Title');
        $fixture->setTarif('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Parking');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Parking();
        $fixture->setMatricule('My Title');
        $fixture->setDebut('My Title');
        $fixture->setSortie('My Title');
        $fixture->setPlace('My Title');
        $fixture->setTarif('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'parking[matricule]' => 'Something New',
            'parking[debut]' => 'Something New',
            'parking[sortie]' => 'Something New',
            'parking[place]' => 'Something New',
            'parking[tarif]' => 'Something New',
        ]);

        self::assertResponseRedirects('/parking/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getMatricule());
        self::assertSame('Something New', $fixture[0]->getDebut());
        self::assertSame('Something New', $fixture[0]->getSortie());
        self::assertSame('Something New', $fixture[0]->getPlace());
        self::assertSame('Something New', $fixture[0]->getTarif());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Parking();
        $fixture->setMatricule('My Title');
        $fixture->setDebut('My Title');
        $fixture->setSortie('My Title');
        $fixture->setPlace('My Title');
        $fixture->setTarif('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/parking/');
    }
}
