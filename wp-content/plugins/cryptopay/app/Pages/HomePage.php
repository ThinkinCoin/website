<?php

declare(strict_types=1);

namespace BeycanPress\CryptoPay\Pages;

use BeycanPress\CryptoPay\Helpers;
use BeycanPress\CryptoPay\PluginHero\Page;
use BeycanPress\CryptoPay\PluginHero\Http\Client;

/**
 * Home page
 */
class HomePage extends Page
{
    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var int
     */
    private int $count = 0;

    /**
     * @var string
     */
    private string $apiUrl = 'https://beycanpress.com/wp-json/bp-api/';

    /**
     * Class construct
     * @return void
     */
    public function __construct()
    {
        try {
            $notification = '';
            $this->client = new Client();
            $this->client->setBaseUrl($this->apiUrl);
            $this->controlNotification();
            $this->count = absint(get_option('cryptopay_new_product_notification_new_count', 0));
            if ($this->count > 0 && !(isset($_GET['page']) && $_GET['page'] == 'cryptopay_home')) {
                $notification =  sprintf(' <span class="awaiting-mod">%d</span>', $this->count);
                add_action('admin_bar_menu', function (): void {
                    if (current_user_can('manage_options')) {
                        global $wp_admin_bar;
                        $wp_admin_bar->add_menu(array(
                            'id'    => 'cryptopay-new-product-notification',
                            'title' => Helpers::view('components/notification', [
                                'count' => $this->count
                            ]),
                            'href'  => $this->getUrl(),
                        ));
                    }
                }, 500);
            }
        } catch (\Throwable $th) {
            Helpers::debug($th->getMessage(), 'ERROR', $th);
        }

        parent::__construct([
            'priority' => 1,
            'subMenu' => true,
            'slug' => 'cryptopay_home',
            'icon' => Helpers::getImageUrl('menu.png'),
            'pageName' => esc_html__('CryptoPay', 'cryptopay') . $notification,
            'subMenuPageName' => esc_html__('Home', 'cryptopay') . $notification,
        ]);

        add_action('admin_head', function (): void {
            Helpers::viewEcho('css/admin-bar-css');
        });
    }

    /**
     * @return void
     */
    public function controlNotification(): void
    {
        $oldCount = get_option('cryptopay_new_product_notification_count') ?? 0;
        if (date('Y-m-d') != get_option('cryptopay_new_product_notification_date')) {
            $res = $this->client->get('notification');
            $newCount = isset($res->success) && $res->success ? $res->data->count : 0;
            update_option('cryptopay_new_product_notification_date', date('Y-m-d'));
            update_option('cryptopay_new_product_notification_count', $newCount);
            if (($newCount - $oldCount)) {
                update_option('cryptopay_new_product_notification_new_count', ($newCount - $oldCount));
            }
        }
    }

    /**
     * @return void
     */
    public function page(): void
    {
        try {
            update_option('cryptopay_new_product_notification_new_count', 0);
            $oldProducts = json_decode(get_option('cryptopay_products_json', '{}'));
            if ($this->count || !$oldProducts) {
                $res = $this->client->get('products');
                $products = isset($res->success) && $res->success ? $res->data->products : [];
                if (!empty($products)) {
                    update_option('cryptopay_products_json', json_encode($products));
                }
                if ($oldProducts) {
                    foreach ($products as $category => &$productList) {
                        $productList = array_map(function ($product) use ($oldProducts, $category) {
                            if (isset($oldProducts->$category)) {
                                if (array_search($product->id, array_column($oldProducts->$category, 'id')) === false) {
                                    $product->new = true;
                                }
                            } else {
                                $product->new = true;
                            }
                            return $product;
                        }, $productList);
                    }
                }
            } else {
                $products = $oldProducts;
            }
        } catch (\Throwable $th) {
            Helpers::debug($th->getMessage(), 'ERROR', $th);
        }

        Helpers::addStyle('admin.min.css');
        Helpers::viewEcho('pages/home-page/index', compact('products'));
    }
}
