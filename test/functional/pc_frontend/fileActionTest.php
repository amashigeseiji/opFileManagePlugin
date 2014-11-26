<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$browser = new opTestFunctional(new sfBrowser(), new lime_test(null, new lime_output_color()));

include dirname(__FILE__).'/../../bootstrap/database.php';

$browser->get('/file')->with('user')->isAuthenticated(false);
$browser->get('/directory')->with('user')->isAuthenticated(false);

$browser->login('sns@example.com', 'password');
$browser->setCulture('en');

$browser->get('/file')
  ->with('user')->isAuthenticated()

  ->with('request')->begin()
    ->isParameter('module', 'file')
    ->isParameter('action', 'index')
  ->end()

  ->with('response')->begin()
    ->isStatusCode(200)
    ->checkElement('div.partsHeading', '/Public file list/')
    ->checkElement('div.search-box', true)
    ->checkElement('div.search-box input[name="file[name]"]', true)
    ->checkElement('div.search-box input[name="file[note]"]', true)
    ->checkElement('div.search-box select[name="file[member_id]"]', true)
  ->end()
;

//$browser->get('/directory')->with('user')->isAuthenticated();
