<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Parking Entity
 *
 * @property int $id
 * @property int $owner_id
 * @property int $client_id
 * @property string $description
 * @property string $address
 * @property int $number
 * @property string $zipcode
 * @property string $city
 * @property string $stateOrProvince
 * @property string $complement
 * @property string $neighbourhoods
 * @property float $lat
 * @property float $lng
 * @property int $available
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 */
class Parking extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'owner_id' => true,
        'client_id' => true,
        'description' => true,
        'address' => true,
        'number' => true,
        'zipcode' => true,
		'city' => true,
        'stateOrProvince' => true,
        'complement' => true,
        'neighbourhoods' => true,
        'lat' => true,
        'lng' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'available' => true
    ];
}
