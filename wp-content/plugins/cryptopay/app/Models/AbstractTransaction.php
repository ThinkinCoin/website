<?php

namespace BeycanPress\CryptoPay\Models;

use BeycanPress\WPModel\AbstractModel;
use BeycanPress\CryptoPay\PluginHero\Helpers;

/**
 * General transaction table model
 */
abstract class AbstractTransaction extends AbstractModel
{
    use Helpers;

    public $version = '1.0.1';

    /**
     * @param string $tableName
     */
    public function __construct(string $tableName)
    {
        $this->tableName = 'cp_' . $tableName;
        
        parent::__construct([
            'hash' => [
                'type' => 'string',
                'length' => 250,
                'index' => [
                    'type' => 'unique'
                ]
            ],
            'order' => [
                'type' => 'text'
            ],
            'orderId' => [
                'type' => 'integer',
                'nullable' => true,
            ],
            'userId' => [
                'type' => 'integer'
            ],
            'network' => [
                'type' => 'text'
            ],
            'params' => [
                'type' => 'text',
                'nullable' => true,
            ],
            'code' => [
                'type' => 'string',
                'length' => 50,
            ],
            'testnet' => [
                'type' => 'boolean',
                'default' => false,
            ],
            'status' => [
                'type' => 'string',
                'length' => 10
            ],
            'updatedAt' => [
                'type' => 'timestamp'
            ],
            'createdAt' => [
                'type' => 'timestamp',
                'default' => 'current_timestamp',
            ],
        ]);

        $this->createTable();
    }

    /**
     * @param string $hash
     * @param string $status
     * @return bool|null
     */
    public function updateStatusByHash(string $hash, string $status) : ?bool
    {
        return $this->update([
            'status' => $status,
            'updatedAt' => date('Y-m-d H:i:s', $this->getUTCTime()->getTimestamp())
        ], [
            'hash' => $hash
        ]);
    }

    /**
     * @param string $hash
     * @return bool|null
     */
    public function updateStatusToVerifiedByHash(string $hash) : ?bool
    {
        return $this->updateStatusByHash($hash, 'verified');
    }

    /**
     * @param string $hash
     * @return bool|null
     */
    public function updateStatusToFailedByHash(string $hash) : ?bool
    {
        return $this->updateStatusByHash($hash, 'failed');
    }

    /**
     * @param string $hash
     * @return bool|null
     */
    public function updateStatusToRefundedByHash(string $hash) : ?bool
    {
        return $this->updateStatusByHash($hash, 'refunded');
    }

    /**
     * @param string $text
     * @param array $params
     * @return array
     */
    public function search(string $text, array $params = []) : array
    {
        $predicates = '';
        $pleaceholders = ['%s'];
        $parameters = ['%' . $this->db->esc_like($text) . '%'];
        if (!empty($params)) {
            $i = 1;
            foreach ($params as $key => $value) {
                $pleaceholder = '%' . $i . '$s';
                if (is_array($value) && $value[0] == 'code') {
                    $value = array_map(function ($value) {
                        return "'$value'";
                    }, $value[2]);
                    $value = "(" . implode(',', $value) . ")";
                    $predicates .= "AND 'code' IN $pleaceholder";
                } else {
                    $predicates .= "AND {$key} = '$pleaceholder'";
                }
                $pleaceholders[] = $pleaceholder;
                $parameters[] = $value;
                $i++;
            }
        }

        return [
            'data' => $this->getResults(str_ireplace(
                $pleaceholders, 
                $parameters, "
                SELECT * FROM {$this->tableName} 
                WHERE hash LIKE '%s' 
                OR orderId LIKE '%s'
                OR userId LIKE '%s' 
                OR network LIKE '%s'
                OR status LIKE '%s'
                ". $predicates . "
                ORDER BY id DESC
            ")),
            'count' => $this->getVar(str_ireplace(
                $pleaceholders, 
                $parameters, "
                SELECT COUNT(id) FROM {$this->tableName} 
                WHERE hash LIKE '%s' 
                OR orderId LIKE '%s'
                OR userId LIKE '%s' 
                OR network LIKE '%s'
                OR status LIKE '%s'
                ". $predicates . "
                ORDER BY id DESC
            ")) ?? 0
        ];
    }

    /**
     * @return array
     */
    public function getCodes() : array
    {
        return $this->getCol("SELECT DISTINCT(code) FROM {$this->tableName} WHERE code != ''");
    }

}