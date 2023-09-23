<?php

namespace BeycanPress\CryptoPay;

use \BeycanPress\CryptoPay\PluginHero\Hook;
use \BeycanPress\CryptoPay\PluginHero\Helpers;

class Verifier
{
    use Helpers;

    protected $model;

    /**
     * @param object $model
     */
    public function __construct(object $model)
    {
        $this->model = $model;
    }

    /**
     * @param object $transaction
     * @return bool|null
     */
    public function verifyTransaction(object $transaction) : ?bool
    {
        $order = json_decode($transaction->order);
        $amount = $order->paymentAmount;
        $currency = $order->paymentCurrency;

        $network = json_decode($transaction->network);
        $receiver = Services::getWalletAddress($network->code);
        $provider = Services::getProviderByTx($transaction);
        $transaction = $provider->Transaction($transaction->hash);

        if (is_null($transaction->validate())) {
            return null;
        }

        $confirmationCount = Services::getBlockConfirmationCount($network->code);
        if (method_exists($transaction, 'getConfirmations') && $confirmationCount > 0) {
            if ($transaction->getConfirmations() < $confirmationCount) {
                return null;
            }
        }
        
        $tokenAddress = isset($currency->address) ? $currency->address : null;
        return $transaction->verifyTransferWithData((object) [
            'amount' => $amount,
            'receiver' => $receiver,
            'tokenAddress' => $tokenAddress
        ]);
    }
    
    /**
     * @param int $userId
     * @param string $code
     * @return void
     */
    public function verifyPendingTransactions($userId = 0, string $code = 'all') : void
    {
        if ($userId == 0) {
            $params = [
                'status' => 'pending'
            ];
        } else {
            $params = [
                'status' => 'pending',
                'userId' => $userId
            ];
        }

        if ($code != 'all') {
            $params['code'] = $code;
        }

        $transactions = $this->model->findBy($params);
        if (empty($transactions)) return;

        $uniqueTransactions = [];
        foreach($transactions as $transaction) {
            $order = json_decode($transaction->order);
            if (isset($order->id)) {
                $uniqueTransactions[$order->id] = $transaction;
            }
        }

        $transactions = array_values($uniqueTransactions);

        $this->debug('Verifying pending transactions');
        foreach ($transactions as $transaction) {
            
            $order = json_decode($transaction->order);
            $network = json_decode($transaction->network);

            try {

                if ((time() - strtotime($transaction->createdAt)) < 30) {
                    continue;
                }

                $this->debug('Verifying transaction', 'INFO', [
                    'hash' > $this->hash,
                ]);

                $result = $this->verifyTransaction($transaction);

                if (is_null($result)) continue;

                if ($result) {
                    $this->model->updateStatusToVerifiedByHash($transaction->hash);
                } else {
                    $this->model->updateStatusToFailedByHash($transaction->hash);
                }

                $this->debug('Payment finished (VERIFIER)', 'INFO', [
                    'hash' => $transaction->hash,
                    'network' => $network,
                    'status' => $result
                ]);
                
                Hook::callAction(
                    'payment_finished_' . $this->model->addon, (object) [
                        'userId' => $this->userId,
                        'order' => $order,
                        'network' => $network,
                        'hash' => $transaction->hash,
                        'model' => $this->model,
                        'status' => $result,
                        'params' => json_decode($transaction->params)
                    ]
                );

            } catch (\Exception $e) {
                $this->model->updateStatusToFailedByHash($transaction->hash);
                $this->debug('Error while verifying transaction', 'ERROR', [
                    'hash' => $transaction->hash,
                    'network' => $network,
                    'error' => $e->getMessage()
                ]);
                continue;
            }
        }
    }
}
