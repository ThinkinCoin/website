<?php 

namespace BeycanPress\CryptoPay\Pages;

use \BeycanPress\WPTable\Table;
use \BeycanPress\CryptoPay\Verifier;
use \BeycanPress\CryptoPay\Services;
use \BeycanPress\CryptoPay\PluginHero\Page;

/**
 * Order transactions page
 */
class TransactionPage extends Page
{   
    /**
     * @var object
     */
    private $model;

    /**
     * @var array
     */
    private $hooks;

    /**
     * @var array
     */
    private static $slugs = [];

    /**
     * @var string
     */
    public $pageUrl;

    /**
     * @var array
     */
    private $excludeColumns = [];

    /**
     * @param string $name
     * @param string $slug
     * @param string $addon
     * @param int $priority
     * @param string $hooks
     * @param bool $confirmation
     * @param string $excludeColumns
     */
    public function __construct(
        string $name, 
        string $slug, 
        string $addon, 
        int $priority = 10,
        array $hooks = [], 
        bool $confirmation = true, 
        array $excludeColumns = []
    )
    {
        $slug = $this->pluginKey . '_' . sanitize_title($slug);
        
        if (in_array($slug, self::$slugs)) {
            throw new \Exception('This slug is already registered, please choose another slug!');
        }

        self::$slugs[] = $slug;

        $this->hooks = $hooks;
        $this->confirmation = $confirmation;
        $this->excludeColumns = $excludeColumns;
        $this->model = Services::getModelByAddon($addon);
        $this->pageUrl = admin_url('admin.php?page=' . $slug);

        parent::__construct([
            'slug' => $slug,
            'pageName' => $name,
            'parent' => $this->pages->HomePage->slug,
            'priority' => $priority
        ]);
    }

    /**
     * @return void
     */
    public function page() : void
    {
        $code = isset($_GET['code']) ? $_GET['code'] : 'all';
        $status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : null;

        if ($this->setting('backendConfirmation') && $this->confirmation) {
            (new Verifier($this->model))->verifyPendingTransactions(0, $code);
        }

        if (isset($_GET['id']) && $this->model->delete(['id' => absint($_GET['id'])])) {
            $this->notice(esc_html__('Successfully deleted!', 'cryptopay'), 'success', true);
        }

        $params = [];

        if ($code == 'all') {
            $params[] = ['code', 'IN', Services::getNetworkCodes()];
        } else {
            $params['code'] = $code;
        }

        if ($status) {
            $params['status'] = $status;
        }

        $table = (new Table($this->model, $params))
        ->setColumns(array_filter([
            'hash'      => esc_html__('Hash', 'cryptopay'),
            'orderId'   => esc_html__('Order ID', 'cryptopay'),
            'userId'    => esc_html__('User ID', 'cryptopay'),
            'network'   => esc_html__('Network', 'cryptopay'),
            'amount'    => esc_html__('Amount', 'cryptopay'),
            'status'    => esc_html__('Status', 'cryptopay'),
            'updatedAt' => esc_html__('Updated at', 'cryptopay'),
            'createdAt' => esc_html__('Created at', 'cryptopay'),
            'delete'    => esc_html__('Delete', 'cryptopay')
        ], function($key) {
            return !in_array($key, $this->excludeColumns);
        }, ARRAY_FILTER_USE_KEY))
        ->setOptions([
            'search' => [
                'id' => 'search-box',
                'title' => esc_html__('Search...', 'cryptopay')
            ]
        ])
        ->setOrderQuery(['createdAt', 'desc'])
        ->setSortableColumns(['createdAt'])
        ->addHooks(array_merge([
            'hash' => function($tx) {
                return '<a href="'.Services::getProviderByTx($tx)->Transaction($tx->hash)->getUrl().'" target="_blank">'.$tx->hash.'</a>';
            },
            'network' => function($tx) {
                return json_decode($tx->network)->name;
            },
            'amount' => function($tx) {
                $order = json_decode($tx->order);
                $currency = $order->paymentCurrency;
                $amount = Services::toString($order->paymentPrice ?? $order->paymentAmount, $currency->decimals);
                return esc_html($amount . " " . $currency->symbol);
            },
            'status' => function($tx) {
                return '<span class="cp-status '.esc_attr($tx->status).'">'.esc_html__(ucfirst($tx->status), 'cryptopay').'</span>';
            },
            'createdAt' => function($tx) {
                return (new \DateTime($tx->createdAt))->setTimezone(new \DateTimeZone(wp_timezone_string()))->format('Y-m-d H:i:s');
            },
            'updatedAt' => function($tx) {
                return (new \DateTime($tx->updatedAt))->setTimezone(new \DateTimeZone(wp_timezone_string()))->format('Y-m-d H:i:s');
            },
            'delete' => function($tx) {
                if (strtolower($tx->status) == 'pending') return;
                return '<a class="button" href="'.$this->getCurrentUrl() . '&id=' . $tx->id.'">'.esc_html__('Delete', 'cryptopay').'</a>';
            }
        ], $this->hooks))->addHeaderElements(function() {
            return $this->view('pages/transaction-page/form', [
                'codes' => Services::getNetworkCodes()
            ]);
        })
        ->createDataList(function(object $model) use ($params) {
            if (isset($_GET['s']) && !empty($_GET['s'])) {
                $s = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : null;
                return array_values($model->search($s, $params));
            }
        });

        $this->addStyle('admin.min.css');
        $this->viewEcho('pages/transaction-page/index', [
            'table' => $table
        ]);
    }
}