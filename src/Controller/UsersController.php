<?php

/** @noinspection PhpMissingFieldTypeInspection */
declare(strict_types=1);

namespace App\Controller;

use Aws\DynamoDb\Exception\DynamoDbException;
use Cake\Controller\ComponentRegistry;
use Cake\Event\EventManagerInterface;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

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

    public function logout()
    {
        $tokensTable = TableRegistry::getTableLocator()->get('Tokens');
        $token = $tokensTable
            ->find()
            ->contain(['GithubUsers'])
            ->where([
                        'hash' => $this->request->getHeader('Bearer')[0],
                        'status' => true
                    ])
            ->first();
        $token->status = false;
        $token->last_active = date('Y-m-d H:i:s');
        $logout = false;
        if ($tokensTable->save($token)) {
            $logout = true;
        }
        if (!$this->request->is('ajax')) {
            return $this->redirect('/login');
        }
        echo json_encode(['logout' => $logout]);
        die;
    }
}
