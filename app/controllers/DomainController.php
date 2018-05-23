<?php
namespace ITPocProxy\Controller;

use Phalcon\Db\Column;
use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;
use ITPocProxy\Model\Domain;

class DomainController extends Controller
{
    /** @var Response */
    private $response;

    public function initialize() {
        $this->response = new Response();
        $this->response->setHeader('Content-Type', 'application/json');
    }

    public function getAction($id)
    {
        $domain = Domain::findFirst([
            'conditions' => 'id = :id:',
            'bind'       => [
                'id' => $id,
            ],
            'bindTypes' => [
                Column::BIND_PARAM_STR
            ]
        ]);
        if (!$domain) {
            $this->response->setStatusCode(404);
            $this->response->setContent(json_encode([
                'status' => 'error',
                'code' => 404,
                'message' => sprintf('Domain \'%s\' not found', $id)
            ]));
            return $this->response;
        }

        $this->response->setStatusCode(200);
        $this->response->setContent(json_encode($domain));
        return $this->response;
    }

    public function postAction()
    {
        $name = $this->request->getPost("name", null, null);

        $domain = (new Domain())
            ->setName($name);
        if ($domain->create() === false) {
            // error, cannot create
            $this->response->setStatusCode(500);
            $data = [
                'status' => 'error',
                'code' => 500,
                'message' => sprintf('Cannot create domain \'%s\'', $name),
                'details' => []
            ];
            $messages = $domain->getMessages();
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
            'message' => $domain
        ]));
        return $this->response;
    }

    public function putAction($id)
    {
        $domain = Domain::findFirst([
            'conditions' => 'id = :id:',
            'bind'       => [
                'id' => $id,
            ],
            'bindTypes' => [
                Column::BIND_PARAM_STR
            ]
        ]);
        return $domain;
    }

    public function deleteAction($id)
    {
        $domain = Domain::findFirst([
            'conditions' => 'id = :id:',
            'bind'       => [
                'id' => $id,
            ],
            'bindTypes' => [
                Column::BIND_PARAM_STR
            ]
        ]);
        if (!$domain) {
            // error, no domain
            $this->response->setStatusCode(404);
            $this->response->setContent(json_encode([
                'status' => 'error',
                'code' => 404,
                'message' => sprintf('Domain \'%s\' not found', $id)
            ]));
            return $this->response;
        }
        if ($domain->delete() === false) {
            // error, cannot delete
            $this->response->setStatusCode(400);
            $data = [
                'status' => 'error',
                'code' => 400,
                'message' => sprintf('Cannot delete domain \'%s\'', $id),
                'details' => []
            ];
            $messages = $domain->getMessages();
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
            'message' => sprintf('Domain \'%s\' deleted', $id)
        ]));
        return $this->response;
    }
}
