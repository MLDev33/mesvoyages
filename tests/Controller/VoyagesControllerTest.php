<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of VoyagesControllerTest
 *
 * @author m-lordiportable
 */
class VoyagesControllerTest extends WebTestCase {

    public function testAccesPage() {
        $client = static::createClient();
        $client->request("GET", '/voyages');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testContenuPage() {
        $client = static::createClient();
        $crawler = $client->request("GET", '/voyages');
        $this->assertSelectorTextContains('h1', "Mes voyages");
        $this->assertSelectorTextContains('th', "Ville");
        $this->assertCount(4, $crawler->filter('th'));
        $this->assertSelectorTextContains('h5', "Une ville");
    }

    public function testLinkVille() {
        $client = static::createClient();
        $client->request("GET", '/voyages');
        // clic sur un lien (le nom d'une ville)
        $client->clickLink('Une ville');
        // récupération du résultat du clic
        $response = $client->getResponse();
        // contrôle si le lien existe
        $this->assertResponseStatusCodeSame(Response::HTTP_OK, $response->getStatusCode());
        // récupération de la route et contrôle qu'elle est correcte
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/voyages/voyage/101', $uri);
    }

    public function testFiltreVille() {
        $client = static::createClient();
        $client->request("GET", '/voyages');
        // simulation de la soumission du formulaire
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Une ville'
        ]);
        // vérifie le nombre de lignes obtenues
        $this->assertCount(1, $crawler->filter('h5'));
        // vérifier si la ville correspond à la recherche
        $this->assertSelectorTextContains('h5', 'Une ville');
    }
}
