<?php 
class SlothOptions{
    private $allowOverride;
    
    private $siteSignatureTitle;
    private $siteSignatureUrl;
    private $siteLogoPostId;
    private $siteLogoUrl;
    
    private $blogSignatureTitle;
    private $blogSignatureUrl;
    private $blogLogoPostId;
    private $blogLogoUrl;
    
    private $defaultLogoUrl;
    
    public function __construct(){
        if( is_multisite() ){
            add_site_option("SlothLogoCustomizer_AllowOverride",          true);
            add_site_option("SlothLogoCustomizer_SitePoweredByURL",       "");
            add_site_option("SlothLogoCustomizer_SitePoweredByTitle",     "");
            add_site_option("SlothLogoCustomizer_SiteImageAttachmentId",  "0");
            add_site_option("SlothLogoCustomizer_SiteImageAttachmentURL", "");
        }
        add_option("SlothLogoCustomizer_PoweredByURL",       "",  "", 'no');
        add_option("SlothLogoCustomizer_PoweredByTitle",     "",  "", 'no');
        add_option("SlothLogoCustomizer_imageAttachmentId",  "0", "", 'no');
        add_option("SlothLogoCustomizer_imageAttachmentURL", "",  "", 'no');
        
        $this->allowOverride        = get_site_option('SlothLogoCustomizer_AllowOverride');
        $this->siteSignatureUrl     = get_site_option('SlothLogoCustomizer_SitePoweredByURL');
        $this->siteSignatureTitle   = get_site_option('SlothLogoCustomizer_SitePoweredByTitle');
        $this->siteLogoPostId       = get_site_option('SlothLogoCustomizer_SiteImageAttachmentId');
        $this->siteLogoUrl          = get_site_option('SlothLogoCustomizer_SiteImageAttachmentURL');
        
        $this->blogSignatureUrl     = get_option('SlothLogoCustomizer_PoweredByURL');
        $this->blogSignatureTitle   = get_option('SlothLogoCustomizer_PoweredByTitle');
        $this->blogLogoPostId       = get_option('SlothLogoCustomizer_imageAttachmentId');
        $this->blogLogoUrl          = get_option('SlothLogoCustomizer_imageAttachmentURL');
                
        $this->defaultLogoUrl = plugin_dir_url( __FILE__ ) . 'wordpress-logo.png';
    }
    
    //--------------------------------------------
    public function isSignatureChanged(){
        $title = $this->getSignatureTitle();
        $url = $this->getSignatureUrl();
        return (trim($title)!="" && trim($url)!="");
        
//         if( is_multisite() ){
//             if(trim($this->siteSignatureUrl) != "" && trim($this->siteSignatureTitle) != "")
//                 return true;
//             if($this->allowOverride && trim($this->blogSignatureUrl) != "" && trim($this->blogSignatureTitle) != "")
//                 return true;
//             else
//                 return false;
//         } else {
//             if(trim($this->blogSignatureUrl) != "" && trim($this->blogSignatureTitle) != "")
//                 return true;
//             else
//                 return false;
//         }
    }
    
    public function isLogoChanged(){
        return $this->getLogoUrl() != $this->defaultLogoUrl;
    }
    
    public function getAllowOverride(){
        return $this->allowOverride;
    }
    
    //--------------------------------------------
    public function getSiteSignatureTitle(){
        $title = "";
        if(trim($this->siteSignatureTitle)!="") $title = $this->siteSignatureTitle;
        return $title;
    }
    
    public function getSiteSignatureUrl(){
        $url = "";
        if(trim($this->siteSignatureUrl)!="") $url = $this->siteSignatureUrl;
        return $url;
    }
    
    public function getSiteLogoUrl(){
        $url = $this->defaultLogoUrl;
        if(trim($this->siteLogoUrl)) $url = $this->siteLogoUrl;
        return $url;
    }
    
    public function getSiteLogoPostId(){
        return $this->siteLogoPostId;
    }
    
    //--------------------------------------------
    public function getBlogSignatureTitle(){
        $title = "";
        if(trim($this->blogSignatureTitle)!="") $title = $this->blogSignatureTitle;
        return $title;
    }
    
    public function getBlogSignatureUrl(){
        $url = "";
        if(trim($this->blogSignatureUrl)!="") $url = $this->blogSignatureUrl;
        return $url;
    }
    
    public function getSiteSignatureTitlePlaceholder(){
        $title = __('Wordpress.org', 'sloth-logo-customizer');
        if(is_multisite() && trim($this->siteSignatureTitle)!="") $title = $this->siteSignatureTitle;
        return $title;
    }
    
    public function getSiteSignatureUrlPlaceholder(){
        $url = "http://www.wordpress.org";
        if(is_multisite() && trim($this->siteSignatureUrl)!="") $url = $this->siteSignatureUrl;
        return $url;
    }
    //--------------------------------------------
    public function getSignatureTitle(){
        $title = "";
        if(is_multisite()){
            $title = $this->siteSignatureTitle;
            if($this->allowOverride && trim($this->blogSignatureTitle)!= "") 
                $title = $this->blogSignatureTitle;
        } else {
            if(trim($this->blogSignatureTitle)!= "") 
                $title = $this->blogSignatureTitle;
        }
        return $title;
    }
    
    public function getSignatureUrl(){
        $url = "";
        if(is_multisite()){
            $url = $this->siteSignatureUrl;
            if($this->allowOverride && trim($this->blogSignatureUrl)!= "") 
                $url = $this->blogSignatureUrl;
        } else {
            if(trim($this->blogSignatureUrl)!= "") 
                $url = $this->blogSignatureUrl;
        }
        return $url;
    }
    
    public function getLogoUrl(){
        $url = $this->defaultLogoUrl;
        if(is_multisite()){
            if(trim($this->siteLogoUrl)) $url = $this->siteLogoUrl;
            if($this->allowOverride && trim($this->blogLogoUrl)!= "") 
                $url = $this->blogLogoUrl;
        } else {
            if(trim($this->blogLogoUrl)!= "") 
                $url = $this->blogLogoUrl;
        }
        return $url;
    }

    public function getBlogLogoPostId(){
        $postId = 0;
        if($this->blogLogoPostId != 0) 
            $postId = $this->blogLogoPostId;
            
        return $postId;
    }
    
    public function getDefaultLogoUrl(){
        if(is_multisite() && !is_network_admin())
            return $this->getSiteLogoUrl();
        else
            return $this->defaultLogoUrl;
    }

    //-------------------------------------------
    public function setAllowOverride($override){
        update_site_option('SlothLogoCustomizer_AllowOverride', $override);
        $this->allowOverride  = $override;
    }
    
    public function setSiteSignatureTitle($title){
        update_site_option('SlothLogoCustomizer_SitePoweredByTitle', $title);
        $this->siteSignatureTitle = $title;
    }
    
    public function setSiteSignatureUrl($url){
        update_site_option('SlothLogoCustomizer_SitePoweredByURL', $url);
        $this->siteSignatureUrl = $url;
    }
    
    public function setSiteLogoUrl($postId){
        $url = wp_get_attachment_url($postId);
        
        update_site_option('SlothLogoCustomizer_SiteImageAttachmentId', $postId);
        update_site_option('SlothLogoCustomizer_SiteImageAttachmentURL', $url);
        
        $this->siteLogoPostId = $postId;
        $this->siteLogoUrl = $url;
    }

    //-------------------------------------------
    public function setBlogSignatureTitle($title){
        update_option('SlothLogoCustomizer_PoweredByTitle', $title);
        $this->blogSignatureTitle = get_option('SlothLogoCustomizer_PoweredByTitle');
    }
    
    public function setBlogSignatureUrl($url){
        update_option('SlothLogoCustomizer_PoweredByURL', $url);
        $this->blogSignatureUrl = get_option('SlothLogoCustomizer_PoweredByURL');
    }
    
    public function setBlogLogo($postId){
        $url = wp_get_attachment_url($postId);
        
        update_option('SlothLogoCustomizer_imageAttachmentId', $postId);
        update_option('SlothLogoCustomizer_imageAttachmentURL', $url);
        
        $this->blogLogoPostId = $postId;
        $this->blogLogoUrl = $url;
    }
}