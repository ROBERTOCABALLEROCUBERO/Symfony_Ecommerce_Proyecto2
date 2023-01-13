<?php

namespace App\Test\Controller;

use App\Entity\Productos;
use App\Repository\ProductosRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductosControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ProductosRepository $repository;
    private string $path = '/productos/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Productos::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Producto index');

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
            'producto[nombre_prod]' => 'Testing',
            'producto[cantidad]' => 'Testing',
            'producto[genero]' => 'Testing',
            'producto[precio]' => 'Testing',
            'producto[descuento]' => 'Testing',
            'producto[talla]' => 'Testing',
            'producto[tipo]' => 'Testing',
            'producto[fotoprod]' => 'Testing',
        ]);

        self::assertResponseRedirects('/productos/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Productos();
        $fixture->setNombre_prod('My Title');
        $fixture->setCantidad('My Title');
        $fixture->setGenero('My Title');
        $fixture->setPrecio('My Title');
        $fixture->setDescuento('My Title');
        $fixture->setTalla('My Title');
        $fixture->setTipo('My Title');
        $fixture->setFotoprod('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Producto');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Productos();
        $fixture->setNombre_prod('My Title');
        $fixture->setCantidad('My Title');
        $fixture->setGenero('My Title');
        $fixture->setPrecio('My Title');
        $fixture->setDescuento('My Title');
        $fixture->setTalla('My Title');
        $fixture->setTipo('My Title');
        $fixture->setFotoprod('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'producto[nombre_prod]' => 'Something New',
            'producto[cantidad]' => 'Something New',
            'producto[genero]' => 'Something New',
            'producto[precio]' => 'Something New',
            'producto[descuento]' => 'Something New',
            'producto[talla]' => 'Something New',
            'producto[tipo]' => 'Something New',
            'producto[fotoprod]' => 'Something New',
        ]);

        self::assertResponseRedirects('/productos/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNombre_prod());
        self::assertSame('Something New', $fixture[0]->getCantidad());
        self::assertSame('Something New', $fixture[0]->getGenero());
        self::assertSame('Something New', $fixture[0]->getPrecio());
        self::assertSame('Something New', $fixture[0]->getDescuento());
        self::assertSame('Something New', $fixture[0]->getTalla());
        self::assertSame('Something New', $fixture[0]->getTipo());
        self::assertSame('Something New', $fixture[0]->getFotoprod());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Productos();
        $fixture->setNombre_prod('My Title');
        $fixture->setCantidad('My Title');
        $fixture->setGenero('My Title');
        $fixture->setPrecio('My Title');
        $fixture->setDescuento('My Title');
        $fixture->setTalla('My Title');
        $fixture->setTipo('My Title');
        $fixture->setFotoprod('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/productos/');
    }
}
