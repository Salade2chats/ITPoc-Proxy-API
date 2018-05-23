<?php
namespace ITPocProxy\Controller;

use Phalcon\Db\Column;
use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;
use ITPocProxy\Model\SubDomain;

class SubDomainController extends Controller
{
    /** @var Response */
    private $response;

    public function initialize() {
        $this->response = new Response();
        $this->response->setHeader('Content-Type', 'application/json');
    }

    public function getAction($id)
    {
        $subDomain = SubDomain::findFirst([
            'conditions' => 'id = :id:',
            'bind'       => [
                'id' => $id,
            ],
            'bindTypes' => [
                Column::BIND_PARAM_STR
            ]
        ]);
        if (!$subDomain) {
            $this->response->setStatusCode(404);
            $this->response->setContent(json_encode([
                'status' => 'error',
                'code' => 404,
                'message' => sprintf('Sub-domain \'%s\' not found', $id)
            ]));
            return $this->response;
        }

        $this->response->setStatusCode(200);
        $this->response->setContent(json_encode($subDomain));
        return $this->response;
    }

    public function postAction()
    {
        $sub_domain = $this->request->getPost("sub-domain", null, null);
        $userId = $this->request->getPost("user_id", null, null);
        $domainId = $this->request->getPost("domain_id", null, null);

        $subDomain = (new SubDomain())
            ->setSubdomain($sub_domain)
            ->setUserId($userId)
            ->setDomainId($domainId);
        if ($subDomain->create() === false) {
            // error, cannot create
            $this->response->setStatusCode(500);
            $data = [
                'status' => 'error',
                'code' => 400,
                'message' => sprintf('Cannot create sub-domain \'%s\'', $sub_domain),
                'details' => []
            ];
            $messages = $subDomain->getMessages();
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
            'message' => $subDomain
        ]));
        return $this->response;
    }

    public function putAction($id)
    {
        $subDomain = SubDomain::findFirst([
            'conditions' => 'id = :id:',
            'bind'       => [
                'id' => $id,
            ],
            'bindTypes' => [
                Column::BIND_PARAM_STR
            ]
        ]);
        return $subDomain;
    }

    public function deleteAction($id)
    {
        $subDomain = SubDomain::findFirst([
            'conditions' => 'id = :id:',
            'bind'       => [
                'id' => $id,
            ],
            'bindTypes' => [
                Column::BIND_PARAM_STR
            ]
        ]);
        if (!$subDomain) {
            // error, no sub-domain
            $this->response->setStatusCode(404);
            $this->response->setContent(json_encode([
                'status' => 'error',
                'code' => 404,
                'message' => sprintf('Sub-domain \'%s\' not found', $id)
            ]));
            return $this->response;
        }
        if ($subDomain->delete() === false) {
            // error, cannot delete
            $this->response->setStatusCode(500);
            $data = [
                'status' => 'error',
                'code' => 500,
                'message' => sprintf('Cannot delete sub-domain \'%s\'', $id),
                'details' => []
            ];
            $messages = $subDomain->getMessages();
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
            'message' => sprintf('Sub-domain \'%s\' deleted', $id)
        ]));
        return $this->response;
    }
}
