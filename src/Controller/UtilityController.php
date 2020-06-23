<?php
declare(strict_types=1);

namespace App\Controller;

use Aws\Sdk;
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;
use Ramsey\Uuid\Uuid;
use PDA\PDA;

/**
 * Utility Controller
 *
 */
class UtilityController extends AppController
{
    private DynamoDbClient $dynamoDb;

    public function migrations()
    {
        $this->dynamoDb = (new Sdk([
           'endpoint' => 'http://localhost:8000',
           'region' => 'ap-south-1',
           'version' => 'latest'
       ]))->createDynamoDb();
        $this->createTables();
    }

    private function createTables()
    {
        $prefix = 'dapier.local.';
        $tables = [
            'sources' => [
                'name' => 'sources',
                'schema' => [
                    'HASH' => 'id',
                    'RANGE' => 'name'
                ],
                'attr_def' => [
                    'id' => 'S',
                    'name' => 'S'
                ]
            ],
            'tokens' => [
                'name' => 'tokens',
                'schema' => [
                    'HASH' => 'id',
                    'RANGE' => 'access_token'
                ],
                'attr_def' => [
                    'id' => 'S',
                    'access_token' => 'S'
                ]
            ],
            'github_users',
            'users'
        ];
        foreach ($tables as $table) {
            $schema = [];
            foreach ($table['schema'] as $type => $name) {
                $schema[] = [
                    'AttributeName' => "$name",
                    'KeyType' => "$type"
                ];
            }
            $attr_def = [];
            foreach ($table['attr_def'] as $name => $type) {
                $attr_def[] = [
                    'AttributeName' => "$name",
                    'AttributeType' => "$type"
                ];
            }
            $table_ddl = [
                'TableName' => "$prefix$table",
                'KeySchema' => $schema,
                'AttributeDefinitions' => $attr_def,
                'ProvisionedThroughput' => [
                    'ReadCapacityUnits' => 1,
                    'WriteCapacityUnits' => 1
                ]
            ];
            $this->dynamoDb->createTable($table_ddl);
        }
    }
}
