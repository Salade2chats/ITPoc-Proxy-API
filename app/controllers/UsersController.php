<?php
namespace ITPocProxy\Controller;

use Phalcon\Db\Column;
use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;
use ITPocProxy\Model\Users;

class UsersController extends Controller
{
    /** @var Response */
    private $response;

    public function initialize() {
        $this->response = new Response();
        $this->response->setHeader('Content-Type', 'application/json');
    }

    public function getAction($id)
    {
        $user = Users::findFirst([
            'conditions' => 'id = :id:',
            'bind'       => [
                'id' => $id,
            ],
            'bindTypes' => [
                Column::BIND_PARAM_STR
            ]
        ]);
        if (!$user) {
            $this->response->setStatusCode(404);
            $this->response->setContent(json_encode([
                'status' => 'error',
                'code' => 404,
                'message' => sprintf('User \'%s\' not found', $id)
            ]));
            return $this->response;
        }

        $this->response->setStatusCode(200);
        $this->response->setContent(json_encode($user));
        return $this->response;
    }

    public function postAction()
    {
        $email = $this->request->getPost("email", "email", null);
        $password = $this->request->getPost("password", null, null);
        $ip = $this->request->getClientAddress();

        $user = (new Users())
            ->setEmail($email)
            ->setClearPassword($password);
        if ($user->create() === false) {
            // error, cannot create
            $this->response->setStatusCode(500);
            $data = [
                'status' => 'error',
                'code' => 500,
                'message' => sprintf('Cannot create user \'%s\'', $email),
                'details' => []
            ];
            $messages = $user->getMessages();
            foreach ($messages as $message) {
                $data['details'][] = $message->getMessage();
            }
            $this->response->setContent(json_encode($data));
            return $this->response;
        }
        // success
        $this->response->setStatusCode(200);
        $this->response->setContent(json_encode([
            'status' => 'success',
            'code' => 200,
            'message' => $user
        ]));
        return $this->response;
    }

    public function putAction($id)
    {
        $user = Users::findFirst([
            'conditions' => 'id = :id:',
            'bind'       => [
                'id' => $id,
            ],
            'bindTypes' => [
                Column::BIND_PARAM_STR
            ]
        ]);
        return $user;
    }

    public function deleteAction($id)
    {
        $user = Users::findFirst([
            'conditions' => 'id = :id:',
            'bind'       => [
                'id' => $id,
            ],
            'bindTypes' => [
                Column::BIND_PARAM_STR
            ]
        ]);
        if (!$user) {
            // error, no user
            $this->response->setStatusCode(404);
            $this->response->setContent(json_encode([
                'status' => 'error',
                'code' => 404,
                'message' => sprintf('User \'%s\' not found', $id)
            ]));
            return $this->response;
        }
        if ($user->delete() === false) {
            // error, cannot delete
            $this->response->setStatusCode(400);
            $data = [
                'status' => 'error',
                'code' => 400,
                'message' => sprintf('Cannot delete user \'%s\'', $id),
                'details' => []
            ];
            $messages = $user->getMessages();
            foreach ($messages as $message) {
                $data['details'][] = $message->getMessage();
            }
            $this->response->setContent(json_encode($data));
            return $this->response;
        }
        // success
        $this->response->setStatusCode(200);
        $this->response->setContent(json_encode([
            'status' => 'success',
            'code' => 200,
            'message' => sprintf('User \'%s\' deleted', $id)
        ]));
        return $this->response;
    }
}
