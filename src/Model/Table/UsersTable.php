<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Log\Log;
/**
 * Users Model
 *
 * @property \App\Model\Table\BookmarksTable|\Cake\ORM\Association\HasMany $Bookmarks
 * @property \App\Model\Table\ParkingsTable|\Cake\ORM\Association\HasMany $Parkings
 * @property \App\Model\Table\ParkingsTable|\Cake\ORM\Association\HasMany $Lots
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Bookmarks', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Parkings', [
            'foreignKey' => 'owner_id'
        ]);
        //$this->hasMany('Lots', [
        //    'foreignKey' => 'client_id'
       // ]);
        $this->hasMany('Lots', [
            'className' => 'Parkings',
            'foreignKey' => 'client_id'
        ])
        ->setProperty('alugueis');
        
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create')
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmpty('password');
            
        $validator
            ->requirePresence('username', 'create')
            ->maxLength('username', 15)
            ->notEmpty('username');

        return $validator;
    }
	
	public function validationPassword(Validator $validator)
    {
        $validator
                ->add('old_password','custom',[
                    'rule' => function($value, $context){
                        $user = $this->get($context['data']['id']);
                        if($user)
                        {
                            if((new DefaultPasswordHasher)->check($value, $user->password))
                            {
                                return true;
                            }
                        }
                        return false;
                    },
                    'message' => 'Your old password does not match the entered password!',
                ])
                ->notEmpty('old_password');
        
        $validator
                ->add('new_password',[
                    'length' => [
                        'rule' => ['minLength',4],
                        'message' => 'Please enter at least 4 characters in password your password.'
                    ]
                ])
                ->add('new_password',[
                    'match' => [
                        'rule' => ['compareWith','confirm_password'],
                        'message' => 'Sorry! Password dose not match. Please try again!'
                    ]
                ])
                ->notEmpty('new_password');
        
        $validator
                ->add('confirm_password',[
                    'length' => [
                        'rule' => ['minLength',4],
                        'message' => 'Please enter at least 4 characters in password your password.'
                    ]
                ])
                ->add('confirm_password',[
                    'match' => [
                        'rule' => ['compareWith','new_password'],
                        'message' => 'Sorry! Password dose not match. Please try again!'
                    ]
                ])
                ->notEmpty('confirm_password');
        
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->isUnique(['id']));

        return $rules;
    }
}
