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

        $view = new View('addUser', 'front');
        $view->assign('form', $form);
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

        $view = new View('addUser', 'front');
        $view->assign('form', $form);
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
                $login = $_POST['email'];
                $password = $_POST['pwd'];
                if ($login != null && $password != null) {
                    $user = $this->userRepository->getUserLogin($login);
                    if ($user) {
                        if (password_verify($password, $user['pwd'])) {
                            session_start();
                            $_SESSION['email'] = $user['email'];
                            $_SESSION['id'] = $user['id'];
                            $view = new View('homepage', 'back');
                            $view->assign('pseudo', 'prof');
                        } else {
                            echo "<div class=\"msg msg-error z-depth-3 scale-transition\">Incorrect password</div>";
                        }
                    } else {
                        echo "<div class=\"msg msg-error z-depth-3 scale-transition\">The user does not exist</div>";
                    }
                }
            }
        }

        $view = new View('loginUser', 'front');
        $view->assign('form', $form);
    }

    public function forgetPasswordAction(): void
    {
        $v = new View('forgetPasswordUser', 'front');
    }
}
