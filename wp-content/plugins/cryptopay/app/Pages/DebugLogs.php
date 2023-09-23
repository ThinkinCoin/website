<?php 

namespace BeycanPress\CryptoPay\Pages;

use \BeycanPress\CryptoPay\PluginHero\Page;

class DebugLogs extends Page
{   
    public function __construct()
    {
        parent::__construct([
            'pageName' => esc_html__('Debug logs'),
            'parent' => $this->pages->HomePage->slug,
            'priority' => 11,
        ]);
    }

    /**
     * @return void
     */
    public function page() : void
    {
        if ($_POST['delete'] ?? 0) {
            $this->deleteLogFile();
            wp_redirect(admin_url('admin.php?page=cryptopay_settings'));
        }
        
        $this->viewEcho('pages/debug-logs', [
            'logs' => $this->getLogFile()
        ]);
    }
}