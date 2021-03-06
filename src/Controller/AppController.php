<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Aws\DynamoDb\Marshaler;
use Cake\Controller\Controller;
use PDA\PDA;
use Aws\Sdk;
use Aws\DynamoDb\DynamoDbClient;
use Cake\Http\Exception\NotFoundException;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public PDA $pda;
    public DynamoDbClient $dynamoDb;
    public Marshaler $marshaler;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        $this->dynamoDb = (new Sdk([
                                       'region' => env('DDB_REGION', 'ap-south-1'),
                                       'version' => env('DDB_VERSION', 'latest')
                                   ]))->createDynamoDb();
        $this->pda = new PDA($this->dynamoDb);
        $this->marshaler = new Marshaler();


        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }

    public function error($message = '', $code = 404)
    {
        throw new NotFoundException($message, $code);
    }

    public function resp($data = [], $code = 200)
    {
        $this->response = $this->response->withType('application/json');
        $this->response = $this->response->withStatus($code);
        $this->response = $this->response->withStringBody(json_encode($data));
        return $this->response;
    }
}
