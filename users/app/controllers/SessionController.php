<?php

use Phalcon\Mvc\Controller;

class SessionController extends Controller
{

    public function loginAction()
    {

        $sessions = $this->getDI()->getShared("session");

        if ($sessions->has("token")) {

            $this->response->setStatusCode(413, 'Method not allowed');
            $this->response->setContent('zxczxc');
            $this->response->send();

        }

        if (!$this->request->isPost()) {

            $this->response->setStatusCode(405, 'Method not allowed');
            $this->response->setContent(json_encode(['result' => 'Method not allowed','jsonrpc'=>$this->request->getPost('jsonrpc'),'id'=>$this->request->getPost('id')]));
            $this->response->send();

        }

        $data = $this->request->getPost('params');
        $data = explode(',', $data);
        $login = $data[0];
        $password = $data[1];
        $user = Users::findFirstByLogin($login);

        if ($user) {
            if ($this->security->checkHash($password, $user->password)) {
                $token = $this->security->hash($user->login);
                $this->session->set("token", $user->login);
                $this->response->setStatusCode(200, 'Found');
                $this->response->setContent(json_encode(['result' => $token,'jsonrpc'=>$this->request->getPost('jsonrpc'),'id'=>$this->request->getPost('id')]));
                $this->response->send();

            } else {
                $this->response->setStatusCode(403, 'Not Found');
                $this->response->setContent(json_encode(['result' => 'неверный логин или пароль','jsonrpc'=>$this->request->getPost('jsonrpc'),'id'=>$this->request->getPost('id')]));
                $this->response->send();
            }
        } else {
            $this->response->setStatusCode(403, 'Not Found');
            $this->response->setContent(json_encode(['result' => 'неверный логин или пароль','jsonrpc'=>$this->request->getPost('jsonrpc'),'id'=>$this->request->getPost('id')]));
            $this->response->send();
        }

    }

    public function logoutAction()
    {
        $this->session->destroy();
        $this->response->setStatusCode(200, '');
        $this->response->setContent(json_encode(['result' => '','jsonrpc'=>$this->request->getPost('jsonrpc'),'id'=>$this->request->getPost('id')]));
        $this->response->send();
    }
}