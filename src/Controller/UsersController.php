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

    public function me()
    {
        $token = $this->request->getHeader('Bearer')[0];

        $user = [];

        $eav = $this->marshaler->marshalJson('
            {
                ":token": "' . $token . '"
            }
        ');

        $params = [
            'TableName' => 'tokens',
            'KeyConditionExpression' => '#token = :token',
            'ExpressionAttributeNames' => [ '#token' => 'token' ],
            'ExpressionAttributeValues' => $eav
        ];

        try {
            $_token = $this->dynamoDb->query($params);
            if (!$_token['Count'] || !$_token['Items'][0]['active']['BOOL']) {
                $this->error('Unauthorized', 401);
            }

            $id_entity = $_token['Items'][0]['id_entity']['S'];
            $eav = $this->marshaler->marshalJson('
                    {
                        ":id_entity": "' . $id_entity . '"
                    }
                ');

            $params = [
                'TableName' => 'users',
                'IndexName' => 'sort_id_entity',
                'KeyConditionExpression' => '#id_entity = :id_entity',
                'ExpressionAttributeNames' => [ '#id_entity' => 'id_entity' ],
                'ExpressionAttributeValues' => $eav
            ];
            $me = $this->dynamoDb->query($params);
            if (!$me['Count'] || !$me['Items'][0]['active']['BOOL']) {
                $this->error('Unauthorized', 401);
            }
            $user = [
                'name' => $me['Items'][0]['github']['M']['name']['S'],
                'photo' => $me['Items'][0]['github']['M']['photo']['S']
            ];
        } catch (DynamoDbException $DynamoDbException) {
            $this->error($DynamoDbException->getMessage());
        }
        return $this->resp($user);
    }
}
