<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ContactsTable extends Table
{
    public function initialize(array $config)
    {
        $this->belongsTo('Companies');
    }

    public function validationDefault(Validator $validator)
    {
        $validator->requirePresence('first_name', 'create')
            ->notEmptyString('first_name')
            ->add('first_name', [
                'length' => [
                    'rule' => ['minLength', 2],
                    'message' => 'First name need to be at least 2 characters long',
                ]
            ]);

        $validator->requirePresence('last_name', 'create')
            ->notEmptyString('last_name')
            ->add('last_name', [
                'length' => [
                    'rule' => ['minLength', 2],
                    'message' => 'Last name need to be at least 2 characters long',
                ]
            ]);

        $validator->requirePresence('phone_number', 'create')
            ->notEmptyString('phone_number')
            ->lengthBetween('phone_number', [10, 20], 'Phone Number should be 10-20 characters long');

        $validator->requirePresence('address', 'create')->notEmptyString('address');
        $validator->requirePresence('notes', 'create')->notEmptyString('notes');

        return $validator;
    }
}
