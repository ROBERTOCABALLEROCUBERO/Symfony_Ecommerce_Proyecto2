<?php

namespace App\Tests;

use Symfony\Component\Panther\PantherTestCase;

class BuscadorTest extends PantherTestCase
{
    public function testSomething(): void
    {
        $productoBuscado = 'Producto1';
    
        // Creamos un cliente Panther para realizar peticiones HTTP a nuestra aplicación
        $client = static::createPantherClient();
        // Realizamos una petición GET a la ruta /search/product?nombre=Producto1
        $crawler = $client->request('GET', '/search/product?nombre=' . $productoBuscado);
    
        // Comprobamos que la respuesta HTTP tiene un código 200
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    
        // Comprobamos que existe un número de elementos .Productos igual al número de productos devueltos por la búsqueda
        $productos = $crawler->filterXPath('//tr[@class="Productos"]');
        $this->assertCount(count($productos), $productos);
    
        // Comprobamos que el texto del elemento con la clase .nombre dentro de un elemento con la clase 
        //.producto contiene la cadena "Producto1"
        $nombreProductos = $crawler->filterXPath('//tr[@class="Productos"]//td[@class="nombre"]');
        foreach ($nombreProductos as $nombreProducto) {
            $this->assertStringContainsStringIgnoringCase($productoBuscado, $nombreProducto->nodeValue);
        }
        }
        
    }



/*     filter($selector): devuelve un nuevo Crawler que contiene todos los elementos que coinciden con el selector CSS especificado.
filterXPath($xpath): devuelve un nuevo Crawler que contiene todos los elementos que coinciden con la expresión XPath especificada.
count(): devuelve la cantidad de elementos en el Crawler.
each($callback): itera sobre cada elemento del Crawler y llama al callback con el elemento y su índice.
reduce($callback): devuelve un nuevo Crawler que contiene sólo los elementos para los cuales el callback devuelve true.
first(): devuelve el primer elemento del Crawler.
last(): devuelve el último elemento del Crawler.
text(): devuelve el texto dentro del primer elemento del Crawler.
html(): devuelve el HTML dentro del primer elemento del Crawler.
attr($name): devuelve el valor del atributo especificado del primer elemento del Crawler. */

/* En esta línea de código, se está utilizando el método filterXPath del Crawler para buscar en el 
documento HTML todos los elementos <tr> que tengan un atributo class con el valor "Productos". 
La expresión XPath utilizada para lograr esto es //tr[@class="Productos"].

Para entender esta expresión, es importante tener en cuenta que XPath es un lenguaje de consulta para documentos XML y HTML 
que permite seleccionar elementos y atributos en un documento. En XPath, // se utiliza para buscar todos los elementos en un documento, 
mientras que [@attribute_name="attribute_value"] se utiliza para seleccionar elementos que tengan un atributo específico con un valor 
específico.

Por lo tanto, //tr[@class="Productos"] busca todos los elementos <tr> que tengan un atributo class con el valor "Productos". 
El resultado de esta búsqueda es un nuevo Crawler que contiene todos los elementos encontrados.

En cuanto a los paréntesis en la llamada al método filterXPath, estos se utilizan para especificar la expresión XPath que se utilizará para buscar los elementos. 
En este caso, la expresión XPath //tr[@class="Productos"] se pasa como argumento al método filterXPath dentro de los paréntesis. */