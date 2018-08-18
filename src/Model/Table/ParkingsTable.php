<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use Cake\Log\Log;
use Search\Manager;
/**
 * Parkings Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 *
 * @method \App\Model\Entity\Parking get($primaryKey, $options = [])
 * @method \App\Model\Entity\Parking newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Parking[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Parking|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Parking patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Parking[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Parking findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 *
 * @mixin \Search\Model\Behavior\SearchBehavior
 */
class ParkingsTable extends Table
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

        $this->setTable('parkings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Search.Search');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'owner_id',
            'joinType' => 'INNER'
        ]);
        
		$this->searchManager()
            ->value('owner_id')
            ->add('Pesquisar', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'field' => ['address', 'neighbourhoods']
            ]);
    }
    /*
	public function find($type = 'all', $options = []){
		$log = $this->query();
		Log::write('debug', "query:".$log);
	}
*/
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
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('address')
            ->maxLength('address', 150)
            ->allowEmpty('address');

        $validator
            ->integer('number')
            ->allowEmpty('number');

        $validator
            ->scalar('zipcode')
            ->maxLength('zipcode', 50)
            ->allowEmpty('zipcode');

        $validator
            ->float('lat')
            ->allowEmpty('lat');

        $validator
            ->float('lng')
            ->allowEmpty('lng');

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
        $rules->add($rules->existsIn(['owner_id'], 'Users'));

        return $rules;
    }
}
