<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Exception;

class ContactsController extends AppController
{
    /**
     * Displays a view
     *
     * @param array ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found
     * @throws \Cake\View\Exception\MissingTemplateException In debug mode.
     */
    public function index()
    {
        try {
            $contacts = TableRegistry::getTableLocator()->get('Contacts');
            $query = $contacts->find('all', [
                'fields' => ['id', 'first_name', 'last_name', 'phone_number']
            ]);
            return $this->response->withType('application/json')
                ->withStringBody(json_encode($query->all()));
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function indexExt()
    {
        try {
            $contacts = TableRegistry::getTableLocator()->get('Contacts');
            $query = $contacts->find('all', [
                'contain' => ['Companies' => ['fields' => ['id', 'company_name', 'address']]],
                'fields' => ['id', 'first_name', 'last_name', 'phone_number']
            ]);
            return $this->response->withType('application/json')
                ->withStringBody(json_encode($query->all()));
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function store()
    {
        try {
            $contacts = TableRegistry::getTableLocator()->get('Contacts');
            $contact = $contacts->newEntity($this->request->getData());
            $res = [];
            if ($contact->getErrors()) {
                $res = ['status' => 0, 'errors' => $contact->getErrors()];
            } else {
                $contacts->save($contact);
                $res = ['status' => 1, 'data' => $contact];
            }
            return $this->response->withType('application/json')
                ->withStringBody(json_encode($res));
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
