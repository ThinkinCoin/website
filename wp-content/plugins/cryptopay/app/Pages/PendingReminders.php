<?php

declare(strict_types=1);

namespace BeycanPress\CryptoPay\Pages;

// Classes
use BeycanPress\CryptoPay\Helpers;
use BeycanPress\CryptoPay\PluginHero\Page;
use BeycanPress\CryptoPay\PluginHero\Table;
use BeycanPress\CryptoPay\Models\AbstractTransaction;
// Types
use BeycanPress\CryptoPay\Types\Transaction\TransactionType;
use BeycanPress\CryptoPay\Types\Transaction\TransactionsType;

class PendingReminders extends Page
{
    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct([
            'priority' => 10,
            'slug' => 'cryptopay_pending_reminders',
            'parent' => Helpers::getPage('HomePage')->getSlug(),
            'pageName' => esc_html__('Pending reminders', 'cryptopay'),
        ]);
    }

    /**
     * @return void
     */
    public function page(): void
    {
        $params = [];

        $code = isset($_GET['code']) ? $_GET['code'] : 'all';

        if ($code == 'all') {
            $params[] = ['code', 'IN', Helpers::getNetworkCodes()];
        } else {
            $params['code'] = $code;
        }

        $models = Helpers::getModels();

        $data = new TransactionsType();
        foreach ($models as $model) {
            /**
             * @var TransactionsType $txs
             * @var AbstractTransaction $model
             */
            $txs = $model->getRemindedPendingTransactions($params);
            $data->merge($txs->map(function ($tx) use ($model) {
                /** @var TransactionType $tx */
                $tx->getParams()->set('addon', $model->getAddon());
                return $tx;
            }));
        }

        $table = (new Table($data->toArray(false)))
        ->setColumns([
            'addon'         => esc_html__('Addon', 'cryptopay'),
            'hash'          => esc_html__('Hash', 'cryptopay'),
            'orderId'       => esc_html__('Order ID', 'cryptopay'),
            'userId'        => esc_html__('User ID', 'cryptopay'),
            'reminderEmail' => esc_html__('Email', 'cryptopay'),
            'network'       => esc_html__('Network', 'cryptopay'),
            'amount'        => esc_html__('Amount', 'cryptopay'),
            'status'        => esc_html__('Status', 'cryptopay'),
            'updatedAt'     => esc_html__('Updated at', 'cryptopay'),
            'createdAt'     => esc_html__('Created at', 'cryptopay'),
        ])
        ->setOptions([
            'search' => [
                'id' => 'search-box',
                'title' => esc_html__('Search...', 'cryptopay')
            ]
        ])
        ->setOrderQuery(['createdAt', 'desc'])
        ->setSortableColumns(['createdAt'])
        ->addHooks([
            'addon' => function ($tx) {
                return $tx->params->addon;
            },
            'hash' => function ($tx) {
                if (Helpers::providerExists($tx->code)) {
                    $transaction = Helpers::getProvider(TransactionType::fromObject($tx));
                    $transactionUrl = $transaction->Transaction($tx->hash)->getUrl();
                    return Helpers::view('components/link', [
                        'text' => $tx->hash,
                        'url' => $transactionUrl
                    ]);
                }

                return $tx->hash;
            },
            'network' => function ($tx) {
                return $tx->network->name;
            },
            'amount' => function ($tx) {
                $currency = $tx->order->paymentCurrency;
                $amount = Helpers::toString($tx->order->paymentAmount, $currency->decimals);
                return esc_html($amount . " " . $currency->symbol);
            },
            'status' => function ($tx) {
                return Helpers::view('components/status', [
                    'status' => $tx->status
                ]);
            },
            'createdAt' => function ($tx) {
                return (new \DateTime($tx->createdAt->date))->setTimezone(
                    new \DateTimeZone(wp_timezone_string())
                )->format('d M Y H:i');
            },
            'updatedAt' => function ($tx) {
                return (new \DateTime($tx->updatedAt->date))->setTimezone(
                    new \DateTimeZone(wp_timezone_string())
                )->format('d M Y H:i');
            },
        ])
        ->addHeaderElements(function (): void {
            Helpers::viewEcho('pages/pending-reminders/form', [
                'pageUrl' => $this->getUrl(),
                'codes' => Helpers::getNetworkCodes()
            ]);
        })
        ->createDataList(function ($data) use ($params) {
            if (isset($_GET['s']) && !empty($_GET['s'])) {
                $s = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : null;
                $data = array_filter($data, function ($tx) use ($params) {
                    foreach ($params as $key => $value) {
                        if (is_array($value)) {
                            if (in_array($tx->{$value[0]}, $value[2])) {
                                return true;
                            }
                        } else {
                            if ($tx->{$key} == $value) {
                                return true;
                            }
                        }
                    }
                    return false;
                });
                $data = array_filter($data, function ($tx) use ($s) {
                    foreach ($tx as $value) {
                        if (is_string($value) && strpos($value, $s) !== false) {
                            return true;
                        }
                    }
                    return false;
                });
                return [$data, count($data)];
            }
        });

        Helpers::addStyle('admin.min.css');
        Helpers::viewEcho('pages/pending-reminders/index', [
            'table' => $table
        ]);
    }
}
