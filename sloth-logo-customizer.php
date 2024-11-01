<?php
/*
 * Plugin Name: Sloth Logo Customizer
 * Plugin URI: http://logo-customizer.sloth.ir
 * Description: Sloth Logo customizer changes the wordpress logo on the login page and enable you to change the support strign and url on the blog info widget.
 * Version: 2.0.2
 * Author: ammar.shahraki
 * Author URI: http://ammarshahraki.sloth.ir
 * Text Domain: sloth-logo-customizer
 * Domain Path: /languages
 */

//error_reporting(E_ALL | E_STRICT);
//ini_set("display_errors", 1);

include_once('sloth-options.php');

class SlothLogoCustomizer{
    private $options;

//         public $allowOverride;
// 	public $siteSignatureUrl;
// 	public $siteSignatureTitle;
// 	public $signatureUrl;
// 	public $signatureTitle;

	public function __construct(){
            $this->options = new SlothOptions();
            
            add_action('admin_menu',          array(&$this, 'blogAdminPage'));
            add_action('network_admin_menu',  array($this, 'networkAdminPage'));
            add_action('login_head',          array(&$this, 'changeLogo'));
            add_action('plugins_loaded',      array(&$this,'loadTextDomain')); 
            
            if($this->options->isSignatureChanged())
                add_filter('widget_meta_poweredby',array(&$this, 'changeSignature'));
	}
	
	public function blogAdminPage(){
            if(is_multisite() && !$this->options->getAllowOverride())
                return;
                
            add_theme_page(
                __('Login Logo', 'sloth-logo-customizer'), 
                __('Login Logo', 'sloth-logo-customizer'), 
                'edit_theme_options',  
                'slothLogo', 
                array(&$this, 'setting') 
                );
	}
	
	public function networkAdminPage(){
            add_submenu_page( 
                'settings.php', 
                __('Login Logo', 'sloth-logo-customizer'), 
                __('Login Logo', 'sloth-logo-customizer'), 
                'edit_theme_options', 
                'sloth_logo_setting', 
                array(&$this, 'networkSetting') 
                );
	}
	
	public function networkSetting(){
            if(isset($_POST['imageAttachmentId']) && $_POST['imageAttachmentId']!=''){
                $this->options->setSiteLogoUrl($_POST['imageAttachmentId']);
// 			update_site_option('SlothLogoCustomizer_SiteImageAttachmentId', $_POST['imageAttachmentId']);
// 			$url = wp_get_attachment_url($_POST['imageAttachmentId']);
// 			update_site_option('SlothLogoCustomizer_SiteImageAttachmentURL', $url);
            }
		
            if(isset($_POST['poweredBy']) && $_POST['poweredBy']=='yes'){
                $override = (isset($_POST['allowOverride']) && $_POST['allowOverride']=='true')? true: false;
                $this->options->setAllowOverride($override);
                $this->options->setSiteSignatureTitle($_POST['title']);
                $this->options->setSiteSignatureUrl($_POST['url']);
//                     update_site_option('SlothLogoCustomizer_AllowOverride',       $override);
//                     update_site_option('SlothLogoCustomizer_SitePoweredByURL',    $_POST['url']);
//                     update_site_option('SlothLogoCustomizer_SitePoweredByTitle',  $_POST['title']);
//                     $this->allowOverride        = get_site_option('SlothLogoCustomizer_AllowOverride');
//                     $this->siteSignatureUrl     = get_site_option('SlothLogoCustomizer_SitePoweredByURL');
//                     $this->siteSignatureTitle   = get_site_option('SlothLogoCustomizer_SitePoweredByTitle');
                    //print_r($_POST);
                    //die($this->allowOverride);
            }
		
// 		$defaultIconURL = plugin_dir_url( __FILE__ ) . 'wordpress-logo.png';
// 		$savedAttachmentPostId = get_site_option( 'SlothLogoCustomizer_SiteImageAttachmentId', 0 );
// 		if($savedAttachmentPostId!=0)
// 			$savedAttachmentURL = wp_get_attachment_url( $savedAttachmentPostId );
// 		else 
// 			$savedAttachmentURL = $defaultIconURL;
			
		wp_enqueue_media();
		
		require('network-setting.php');
	}
	
	public function setting(){
		
		if(isset($_POST['imageAttachmentId']) && $_POST['imageAttachmentId']!=''){
                    $this->options->setBlogLogo($_POST['imageAttachmentId']);
                    //echo $_POST['imageAttachmentId'];
// 			update_option('SlothLogoCustomizer_imageAttachmentId', $_POST['imageAttachmentId']);
		}
		
		if(isset($_POST['poweredBy']) && $_POST['poweredBy']=='yes'){
                    $this->options->setBlogSignatureTitle($_POST['title']);
                    $this->options->setBlogSignatureUrl($_POST['url']);
// 			update_option('SlothLogoCustomizer_PoweredByURL', $_POST['url']);
// 			update_option('SlothLogoCustomizer_PoweredByTitle', $_POST['title']);
//                         $this->signatureUrl	= get_option('SlothLogoCustomizer_PoweredByURL');
//                         $this->signatureTitle	= get_option('SlothLogoCustomizer_PoweredByTitle');
		}
		
// 		$defaultIconURL = plugin_dir_url( __FILE__ ) . 'wordpress-logo.png';
// 		$savedAttachmentPostId = get_option( 'SlothLogoCustomizer_imageAttachmentId', 0 );
// 		$networkIconPostId = get_site_option('SlothLogoCustomizer_SiteImageAttachmentId', 0);
// 		if($savedAttachmentPostId!=0)
// 			$savedAttachmentURL = wp_get_attachment_url( $savedAttachmentPostId );
//                 else if($networkIconPostId != 0)
//                     $savedAttachmentURL = get_site_option('SlothLogoCustomizer_SiteImageAttachmentURL', 0);
// 		else 
// 			$savedAttachmentURL = $defaultIconURL;
			
		wp_enqueue_media();
		
		require('setting.php');
	}
	
	public function changeLogo(){
            if($this->options->isLogoChanged()){
			echo '<style type="text/css">';
			echo "h1 a {background-image: url({$this->options->getLogoUrl()}) !important;}";
			echo '</style>';
            }
	
// 		$savedAttachmentPostId = get_option( 'SlothLogoCustomizer_imageAttachmentId', 0 );
// 		$savedAttachmentURL = wp_get_attachment_url( $savedAttachmentPostId );
// 		if($savedAttachmentPostId != 0){
// 			echo '<style type="text/css">';
// 			echo "h1 a {background-image: url({$savedAttachmentURL}) !important;}";
// 			echo '</style>';
// 		}
	}
	
	public function changeSignature(){
//             $url   = ($this->options->allowOverride)? $this->signatureUrl:   $this->siteSignatureUrl;
//             $title = ($this->allowOverride)? $this->signatureTitle: $this->siteSignatureTitle;
		//$url = get_option('SlothLogoCustomizer_PoweredByURL');
		//$title = get_option('SlothLogoCustomizer_PoweredByTitle');
            echo "<li><a href='{$this->options->getSignatureUrl()}'>{$this->options->getSignatureTitle()}</a></li>";
	}
	
	function loadTextDomain() {
		load_plugin_textdomain( 'sloth-logo-customizer', false, dirname(plugin_basename(__FILE__)).'/languages' );
	}
}

$slothLogo = new SlothLogoCustomizer();
