<?php
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

use Cake\Controller\Controller;
use Cake\Filesystem\File;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    public $helpers = [
        'Form' => ['className' => 'CustomForm']
    ];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authorize' => ['Controller'],
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email'],
                    'userModel' => 'Stores'
                ]
            ],
            'loginAction' => [
                'plugin' => false,
                'controller' => 'Stores',
                'action' => 'login'
            ],
            'loginRedirect' => [
                'controller' => 'Pages',
                'action' => 'dashboard'
            ],
            'logoutRedirect' => [
                'plugin' => false,
                'controller' => 'Stores',
                'action' => 'login'
            ],
            'unauthorizedRedirect' => [
                'controller' => 'Pages',
                'action' => 'dashboard',
                'prefix' => false
            ],
            'authError' => 'Usted no tiene permisos de acceso.',
            'flash' => [
                'element' => 'error'
            ]/*,
            'storage' => 'Session'*/
        ]);

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        parent::beforeFilter($event);
    }

    public function isAuthorized($store)
    {
        if (isset($store['role']) && $store['role'] === 0) {
            return true;
        }
        return false;
    }

    public function moveUploadFile($nameFile, $dest)
    {
        $file = new File($nameFile, true, 0664);
        $file->copy(WWW_ROOT . $dest);
        $file->close();
    }
}
