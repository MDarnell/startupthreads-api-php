<?php

require_once __DIR__ . '/../src/StartupThreads.php';

/**
* Test for the client library.
*
* Contributors:
 * Matthew Darnell <mdarnell@calculatedchaos.com>
*
* @author Matthew Darnell <mdarnell@calculatedchaos.com>
* @version 0.1
*/

class StartupThreadsTest extends PHPUnit_Framework_TestCase {

  public function testSetEndpoint()
  {
    $new_endpoint = 'http://example.com/2';
    $st = new StartupThreads();
    $st->setEndpoint($new_endpoint);

    $this->assertEquals($new_endpoint, $st->getEndpoint());
  }

  public function testSetHeaders()
  {
    $headers = ['Sample-Header' => 'Test string'];
    $st = new StartupThreads(null, ['headers' => $headers]);

    $this->assertArrayHasKey('Sample-Header', $st->getHeaders());

    $st->setHeaders(['Another-Sample' => 'Test two']);
    $this->assertEquals(2, count($st->getHeaders()));
  }

  public function testSetToken()
  {
    $token = 'i-love-my-boss';
    $st = new StartupThreads($token);

    $this->assertEquals($token, $st->getToken());

    $st->setToken('wrong-value');

    $this->assertNotEquals($token, $st->getToken());
  }

}
