<?php
namespace MutluSms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MutluMessages Model
 *
 * @method \MutluSms\Model\Entity\MutluMessage get($primaryKey, $options = [])
 * @method \MutluSms\Model\Entity\MutluMessage newEntity($data = null, array $options = [])
 * @method \MutluSms\Model\Entity\MutluMessage[] newEntities(array $data, array $options = [])
 * @method \MutluSms\Model\Entity\MutluMessage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \MutluSms\Model\Entity\MutluMessage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \MutluSms\Model\Entity\MutluMessage[] patchEntities($entities, array $data, array $options = [])
 * @method \MutluSms\Model\Entity\MutluMessage findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MutluMessagesTable extends Table
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

        $this->table('mutlu_messages');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
    }


    function setSentAll()
    {
        $this->query()
            ->update()
            ->set(['sent' => true])
            ->where(['sent' => false])
            ->execute();
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
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('number', 'create')
            ->notEmpty('number');

        $validator
            ->requirePresence('message', 'create')
            ->notEmpty('message');

        return $validator;
    }
}
