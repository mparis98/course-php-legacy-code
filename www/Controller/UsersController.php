<?php
declare(strict_types=1);

namespace Controller;

use Core\Validator;
use Core\View;
use Entity\Users;
use Form\UserForm;
use Model\UsersRepository;
use ValueObject\Identity;

class UsersController
{

    private $user;
    private $userRepository;

    public function __construct(Users $user, UsersRepository $usersRepository)
    {
        $this->user = $user;
        $this->userRepository= $usersRepository;
    }

    public function defaultAction()
    {
        echo 'users default';
    }

    public function addAction(): void
    {
        $user = new UserForm();
        $form = $user->getRegisterForm();

        $v = new View('addUser', 'front');
        $v->assign('form', $form);
    }

    public function saveAction(): void
    {
        $userRep = new UserForm();
        $form = $userRep->getRegisterForm();
        $identity = new Identity();
        $user = new Users($this->userRepository,$identity);
        $method = strtoupper($form['config']['method']);
        $data = $GLOBALS['_' . $method];

        if ($_SERVER['REQUEST_METHOD'] == $method && !empty($data)) {
            $validator = new Validator($form, $data);
            $form['errors'] = $validator->errors;

            if (empty($errors)) {
                $identity->setFirstname($data['firstname']);
                $identity->setLastname($data['lastname']);
                $user->setEmail($data['email']);
                $user->setPwd($data['pwd']);
                $this->userRepository->save($user);
            }
        }

        $v = new View('addUser', 'front');
        $v->assign('form', $form);
    }

    public function loginAction(): void
    {
        $userRep = new UserForm();
        $form = $userRep->getLoginForm();

        $method = strtoupper($form['config']['method']);
        $data = $GLOBALS['_' . $method];
        if ($_SERVER['REQUEST_METHOD'] == $method && !empty($data)) {
            $validator = new Validator($form, $data);
            $form['errors'] = $validator->errors;

            if (empty($errors)) {
                $token = md5(substr(uniqid() . time(), 4, 10) . 'mxu(4il');
                // TODO: connexion
            }
        }

        $v = new View('loginUser', 'front');
        $v->assign('form', $form);
    }

    public function forgetPasswordAction(): void
    {
        $v = new View('forgetPasswordUser', 'front');
    }
}
