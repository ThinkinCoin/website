<?php 

namespace BeycanPress\CryptoPay\Pages;

use \BeycanPress\CryptoPay\PluginHero\Page;

/**
 * Home page
 */
class HomePage extends Page
{   
    /**
     * @var int
     */
    private $notificationCount;

    /**
     * @var string
     */
    private $apiUrl = 'https://beycanpress.com/wp-json/bp-api/';
    
    /**
     * Class construct
     * @return void
     */
    public function __construct()
    {
        $notification = '';
        $this->controlNotification();
        if ($count = get_option('cryptopay_new_product_notification')) {
            $notification =  sprintf(' <span class="awaiting-mod">%d</span>', $count);
            add_action('admin_bar_menu', function() use ($count) {
                if (current_user_can('manage_options')) {
                    global $wp_admin_bar;
                    $wp_admin_bar->add_menu( array(
                        'id'    => 'cryptopay-new-product-notification', 
                        'title' => '<img src="'.$this->getImageUrl('menu.png').'" alt="'.esc_html__('CryptoPay', 'cryptopay').'" width="18"> '.esc_html__('CryptoPay new products', 'cryptopay').': <span class="cp-bubble-notifi">'.$count.'</span>',
                        'href'  => $this->getUrl(),
                    ));
                }
            }, 500);
        }

        parent::__construct([
            'pageName' => esc_html__('CryptoPay', 'cryptopay') . $notification,
            'subMenuPageName' => esc_html__('Home', 'cryptopay') . $notification,
            'slug' => 'cryptopay_home',
            'icon' => $this->getImageUrl('menu.png'),
            'subMenu' => true,
            'priority' => 1,
        ]);

        add_action('admin_head', function() {
            echo '<style>
                #wp-admin-bar-cryptopay-new-product-notification .ab-item {
                    display: flex!important;
                    align-items: center;
                }
                #wp-admin-bar-cryptopay-new-product-notification .ab-item img {
                    margin-right: 5px;
                }
                .toplevel_page_cryptopay_home .wp-menu-image img, #wp-admin-bar-cryptopay-new-product-notification img {
                    width: 18px;
                }
                .cp-bubble-notifi {
                    display: inline-block;
                    vertical-align: top;
                    box-sizing: border-box;
                    margin: 1px 0 -1px 2px;
                    padding: 0 5px;
                    min-width: 18px;
                    height: 18px;
                    border-radius: 9px;
                    background-color: #d63638;
                    color: #fff;
                    font-size: 11px;
                    line-height: 1.6;
                    text-align: center;
                }                
                </style>';
        });
    }

    /**
     * @return void
     */
    public function controlNotification() : void
    {
        $this->notificationCount = get_option('cryptopay_new_product_notification');
        if (date('Y-m-d') != get_option('cryptopay_new_product_notification_date')) {
            update_option('cryptopay_new_product_notification_date', date('Y-m-d'));
            $res = json_decode(file_get_contents($this->apiUrl . 'notification'));
            update_option('cryptopay_new_product_notification', (isset($res->success) && $res->success ? $res->data->count : 0));
        } else if ($this->notificationCount && isset($_GET['page']) && $_GET['page'] == 'cryptopay_home') {
            update_option('cryptopay_new_product_notification', 0);
        }
    }

    /**
     * @return void
     */
    public function page() : void
    {
        $oldProducts = json_decode(get_option('cryptopay_products_json'));
        if ($this->notificationCount || !$oldProducts) {
            $res = json_decode(str_replace(['<p>', '</p>'], '', file_get_contents($this->apiUrl . 'products')));
            $products = isset($res->success) && $res->success ? $res->data->products : [];
            update_option('cryptopay_products_json', json_encode($products));
            if ($oldProducts) {
                foreach ($products as $category => &$productList) {
                    $productList = array_map(function($product) use ($oldProducts, $category) {
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

        $this->addStyle('admin.min.css');
        $this->viewEcho('pages/home-page/index', compact('products'));
    }
}