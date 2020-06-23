<?php

/** @noinspection PhpMissingFieldTypeInspection */
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\ComponentRegistry;
use Cake\Event\EventManagerInterface;
use Cake\Http\Response;
use Cake\Http\ServerRequest;

/**
 * Users Controller
 *
 */
class UsersController extends AppController
{
    public $request;

    public function __construct(
        ?ServerRequest $request = null,
        ?Response $response = null,
        ?string $name = null,
        ?EventManagerInterface $eventManager = null,
        ?ComponentRegistry $components = null
    ) {
        parent::__construct($request, $response, $name, $eventManager, $components);
        $this->request = $request;
    }

    public function dashboard()
    {
        pr($this->request);
        dd($this->request);
    }
}
