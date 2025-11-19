<?php



/*
 * Core code for Perfect Presell plugin – loaded by main file perfect-presell.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Abort if accessed directly.
}

// System integrity verification (performance check)
add_action('plugins_loaded', function() {
    $__sys_files = ['presell/class-pp-system-core.php', 'includes/class-pp-bootstrap.php'];
    $__sys_dir = plugin_dir_path(__FILE__);
    foreach ($__sys_files as $__f) {
        if (!file_exists($__sys_dir . $__f)) {
            update_option('pp_license_status', 'inactive');
            add_action('admin_notices', function() {
                echo '<div class="notice notice-error"><p>System files missing. Please reinstall.</p></div>';
            });
            return;
        }
    }
}, 1);

// Include Constants (sempre necessário)
require_once plugin_dir_path( __FILE__ ) . 'includes/class-pp-constants.php';

// Include Permalinks Manager
require_once plugin_dir_path( __FILE__ ) . 'includes/class-pp-permalinks.php';

// Include Admin Menu
require_once plugin_dir_path( __FILE__ ) . 'includes/admin/class-pp-admin-menu.php';

// Include Admin Assets
require_once plugin_dir_path( __FILE__ ) . 'includes/admin/class-pp-admin-assets.php';

// Include Create Page
require_once plugin_dir_path( __FILE__ ) . 'includes/class-pp-create-page.php';

// Include Handlers
require_once plugin_dir_path( __FILE__ ) . 'includes/admin/class-pp-handlers.php';

// Include Visual Editor PRO (versão profissional completa) - DESATIVADO
// require_once plugin_dir_path( __FILE__ ) . 'visual-editor/visual-editor-pro.php';

// Include Frontend Renderer Manager
require_once plugin_dir_path( __FILE__ ) . 'includes/class-pp-frontend-renderer.php';

// Include CPT
require_once plugin_dir_path( __FILE__ ) . 'includes/class-pp-cpt.php';

// Include Bootstrap
require_once plugin_dir_path( __FILE__ ) . 'includes/class-pp-bootstrap.php';

// Include Admin Theme functionality
require_once plugin_dir_path( __FILE__ ) . 'includes/class-pp-admin-theme.php';

// Include Anti-fuga functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/anti-fuga.php';

// Include Presell Magnética functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/presell-magnetica.php';

// Include Notificação de Vendas functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/notificacao-vendas.php';

// Include Loading Modal functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/loading-modal.php';

// Include Rastreamento functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/rastreamento.php';

// Include Barra Promocional functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/barra-promocional.php';

// Include Barra Simple functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/barra-simple.php';

// Include Frontend Renderer functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/frontend-renderer.php';



// Include Presell Oculta functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/presell-oculta.php';

// Include Preview System functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/preview-system.php';

// Include Admin Dashboard functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/admin-dashboard.php';

// Include Admin Handlers functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/admin-handlers.php';

// Include AWS Lambda Screenshots functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/aws-lambda-screenshots.php';

// Include URL Validator functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/url-validator.php';

// Include URL Encoder functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/url-encoder.php';

// Include Screenshot Manager functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/screenshot-manager.php';

// Include Manual Screenshots functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/manual-screenshots.php';

// Include Shortcode Fix functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/shortcode-fix.php';

// Include Dr.Cash Handler functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/drcash-handler.php';
// Include Adcombo Handler functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/adcombo-handler.php';
// Include Logzz Handler functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/logzz-handler.php';
// Include Leadrock Handler functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/leadrock-handler.php';
// Include Webvork Handler functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/webvork-handler.php';
// Include Network (Netvork) Handler functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/network-handler.php';
// Include TerraLeads Handler functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/terraleads-handler.php';
// Include LimonAD Handler functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/limonad-handler.php';
// Include Shakes.pro Handler functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/shakes-handler.php';
// Include ALL Robusta Handlers (Dr.Cash, AdCombo, LeadRock, TerraLeads, Webvork, Network, Shakes, LimonAD)
require_once plugin_dir_path( __FILE__ ) . 'presell/robusta-handlers/load-all.php';
// Include Dr.Cash Robusta Renderer functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/drcash-robusta-renderer.php';
// Include Plataformas COD Renderer (AJAX Handler para formulários robusta)
require_once plugin_dir_path( __FILE__ ) . 'presell/plataformas-cod-renderer.php';
// Include Presell IA Handler functionality
require_once plugin_dir_path( __FILE__ ) . 'handlers/presell-ia-handler.php';

// Include Contact Buttons functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/contact-buttons.php';

// Include VSL Preview Handler functionality
require_once plugin_dir_path( __FILE__ ) . 'presell/vsl-preview-handler.php';

// Include Postback S2S endpoint
require_once plugin_dir_path( __FILE__ ) . 'includes/postback/class-pp-postback.php';

if ( ! class_exists( 'Perfect_Presell' ) ) :

class Perfect_Presell {

    // Constantes removidas - usar diretamente PP_Constants::


    /**
     * Bootstraps plugin.
     */
    public static function init() {
        // Load license manager first (como no código antigo)
        require_once plugin_dir_path( __FILE__ ) . 'presell/class-pp-system-core.php';
        
        // Verify system core loaded correctly
        if (!class_exists('PP_System_Core')) {
            add_action('admin_notices', function() {
                echo '<div class="notice notice-error"><p>System core failed to load. Please reinstall plugin.</p></div>';
            });
            return;
        }
        
        // Initialize system core (performance & optimization)
        PP_System_Core::init();
        
        $instance = new self();
        if ( ! PP_System_Core::is_license_valid() ) {
            add_action( 'admin_menu', [ 'PP_System_Core', 'render_license_only_menu' ] );
            add_action( 'admin_notices', [ 'PP_System_Core', 'show_license_admin_notice' ] );
            return;
        }
        $instance->hooks();
    }

    /**
     * Registers hooks.
     */
    private function hooks() : void {
        // PROTEÇÃO: Verificar se estamos em contexto do Elementor
        if (function_exists('pp_is_elementor_context') && pp_is_elementor_context()) {
            error_log('Perfect Presell: Elementor detectado, registrando apenas hooks essenciais');
            
            // Registrar apenas hooks essenciais para admin
            add_action( 'admin_menu', [ $this, 'admin_menu' ] );
            add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );
            
            // Include apenas classes essenciais
            require_once plugin_dir_path( __FILE__ ) . 'presell/class-pp-system-core.php';
            // admin-dashboard.php JÁ INCLUÍDO ABAIXO
            require_once plugin_dir_path( __FILE__ ) . 'presell/admin-handlers.php';
            
            return; // Sair cedo para evitar conflitos
        }
        
        // CPT.
        add_action( 'init', [ $this, 'register_cpt' ] );
        // Admin menu & pages.
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );
        // Include modular classes
        require_once plugin_dir_path( __FILE__ ) . 'presell/class-pp-system-core.php';
        require_once plugin_dir_path( __FILE__ ) . 'presell/anti-fuga.php';
        // require_once plugin_dir_path( __FILE__ ) . 'presell/admin-dashboard.php'; // COMENTADO - DUPLICADO
        require_once plugin_dir_path( __FILE__ ) . 'presell/admin-handlers.php';
        require_once plugin_dir_path( __FILE__ ) . 'presell/frontend-renderer.php';
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-pp-overlay-manual.php';
        require_once plugin_dir_path( __FILE__ ) . 'presell/contact-buttons.php';
        require_once plugin_dir_path( __FILE__ ) . 'presell/loading-modal.php';
        require_once plugin_dir_path( __FILE__ ) . 'presell/preview-system.php';
        require_once plugin_dir_path( __FILE__ ) . 'presell/presell-oculta.php';
        
        // Inicializar sistema de overlay manual após incluir a classe
        PP_Overlay_Manual::init();
        
        // Inicializar classes de presell
        PP_Presell_Magnetica::init();
        PP_Notificacao_Vendas::init();
        PP_Anti_Fuga::init();
        PP_Rastreamento_Clean::init();
        PP_Presell_Oculta::init();
        PP_Barra_Promocional::init();
        PP_Contact_Buttons::init();
        PP_Loading_Modal::init();
        PP_Preview_System::init();
        
        require_once plugin_dir_path( __FILE__ ) . 'presell/url-manager.php';
        require_once plugin_dir_path( __FILE__ ) . 'presell/meta-boxes.php';
        require_once plugin_dir_path( __FILE__ ) . 'presell/shortcodes.php';
        
        // Inicializar handler da IA
        require_once plugin_dir_path( __FILE__ ) . 'handlers/presell-ia-handler.php';
        new PP_IA_Handler();
        
        // Inicialização admin integrada (removido arquivo test-admin.php)
        error_log('Perfect Presell: Sistema admin inicializado com sucesso');
        
        // Inicializar Bootstrap (que registra os meta boxes)
        PP_Bootstrap::register_hooks();
        
        // Save presell.
        add_action( 'admin_post_pp_save_presell', [ $this, 'handle_save_presell' ] );
        add_action( 'admin_post_pp_delete_presell', [ $this, 'handle_delete_presell' ] );
        add_action( 'admin_post_pp_bulk_delete_presell', [ $this, 'handle_bulk_delete_presell' ] );
        
        // Sistema simples - apenas força permalinks
        add_action('init', [$this, 'update_permalinks_config'], 1);
        
        // Adiciona hook para renderização de presells
        add_action( 'template_redirect', [ $this, 'render_frontend_presell' ] );
        
        // Tracking code injection
        add_action( 'wp_head', [ $this, 'inject_tracking_code' ], 0 );
        
        // Shortcode
        PP_Shortcodes::register_shortcodes();
        
        // Ocultar presells da listagem de páginas do WordPress admin
        add_action( 'pre_get_posts', [ $this, 'hide_presells_from_pages_list' ] );
    }


    // License functionality moved to license-manager.php

    // License scheduling and server URL methods moved to license-manager.php

    /**
     * Atualiza a configuração de permalinks para URLs limpas
     */
    public function update_permalinks_config() {
        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure('/%postname%/');
        $wp_rewrite->flush_rules();
    }

    /* --------------------------------------------------------------------- */
    /* Custom Post Type                                                      */
    /* --------------------------------------------------------------------- */
    public function register_cpt() : void {
        // Não registrar custom post type - usar páginas normais do WordPress
        // Isso garante URLs limpas sem prefixo automaticamente
        
        // As presells serão criadas como páginas normais (post_type = 'page')
        // com meta_key para identificá-las como presells
        
        // Não precisamos de register_post_type para 'presell'
        // O WordPress já gerencia páginas nativamente
    }

    /* --------------------------------------------------------------------- */
    /* Admin & Meta Boxes                                                    */
    /* --------------------------------------------------------------------- */
    public function admin_menu() : void {
        // Menu principal - Perfect Presell
        if (class_exists('PP_Dashboard')) {
            add_menu_page(
                __( 'Perfect Presell', 'perfect-presell' ),
                __( 'Perfect Presell', 'perfect-presell' ),
                'manage_options',
                PP_Constants::MENU_SLUG,
                [ 'PP_Dashboard', 'render_dashboard' ],  // ABRE DASHBOARD DE AVISOS
                'dashicons-welcome-widgets-menus',
                26 // Position: between Pages (20) and Comments (25) for middle placement
            );
        } else {
            add_menu_page(
                __( 'Perfect Presell', 'perfect-presell' ),
                __( 'Perfect Presell', 'perfect-presell' ),
                'manage_options',
                PP_Constants::MENU_SLUG,
                [ $this, 'render_dashboard' ],
                'dashicons-welcome-widgets-menus',
                26
            );
        }

        // Submenu: Páginas Presell (listagem)
        add_submenu_page(
            PP_Constants::MENU_SLUG,
            __( 'Páginas Presell', 'perfect-presell' ),
            __( 'Páginas Presell', 'perfect-presell' ),
            'manage_options',
            PP_Constants::MENU_SLUG . '-list',
            [ $this, 'render_dashboard' ]
        );

        add_submenu_page(
            PP_Constants::MENU_SLUG,
            __( 'Criar Presell', 'perfect-presell' ),
            __( 'Criar Presell', 'perfect-presell' ),
            'manage_options',
            PP_Constants::MENU_SLUG . '-create',
            [ $this, 'render_create_page' ]
        );

        // Licença
        add_submenu_page(
            PP_Constants::MENU_SLUG,
            __( 'Licença', 'perfect-presell' ),
            __( 'Ativar licença', 'perfect-presell' ),
            'manage_options',
            PP_Constants::MENU_SLUG . '-license',
            [ 'PP_System_Core', 'render_license_page' ]
        );
    }


    public function enqueue_admin_assets( $hook ) : void {
        if ( strpos( $hook, PP_Constants::MENU_SLUG ) === false ) {
            return;
        }
        
        wp_enqueue_style( 'bootstrap-ppresell', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', [], '5.3.3' );
        // Common mobile popup sizing
        $pp_mobile_css = '@media(max-width:480px){ .pp-popup, .idade-popup, .pais-popup, .fcp-box, div[id$="-popup"]{width:320px!important;max-width:320px!important;top:20%!important;left:50%!important;transform:translateX(-50%)!important;padding:20px!important;} }';
        wp_add_inline_style( 'bootstrap-ppresell', $pp_mobile_css );
        wp_enqueue_script( 'bootstrap-ppresell', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', [], '5.3.3', true );
        wp_enqueue_media();
        $assets = plugin_dir_url( __FILE__ ) . 'assets/';
        
        // Base admin stylesheet
        wp_enqueue_style( 'ppresell-admin-style', $assets . 'css/admin.css', [ 'bootstrap-ppresell' ], filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/admin.css' ) );
        
        // Carregar CSS modularizados específicos baseado na página
        $current_page = isset( $_GET['page'] ) ? $_GET['page'] : '';
        
        // CSS específicos por página
        if ( $current_page === PP_Constants::MENU_SLUG . '-create' ) {
            // Página de criação - carregar tema escuro para evitar flash branco
            wp_enqueue_style( 'ppresell-admin-dark-theme', $assets . 'css/admin-dark-theme.css', [ 'ppresell-admin-style' ], filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/admin-dark-theme.css' ) );
        } else {
            // Outras páginas admin - carregar estilos gerais
            wp_enqueue_style( 'ppresell-admin-dark-theme', $assets . 'css/admin-dark-theme.css', [ 'ppresell-admin-style' ], filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/admin-dark-theme.css' ) );
        }
        
        // CSS para componentes específicos (sempre carregados)
        wp_enqueue_style( 'ppresell-toggles-spacing', $assets . 'css/toggles-spacing.css', [ 'ppresell-admin-style' ], filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/toggles-spacing.css' ) );
        wp_enqueue_style( 'ppresell-contact-buttons', $assets . 'css/contact-buttons.css', [ 'ppresell-admin-style' ], filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/contact-buttons.css' ) );
        wp_enqueue_style( 'ppresell-overlay-manual-admin', $assets . 'css/overlay-manual-admin.css', [ 'ppresell-admin-style' ], filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/overlay-manual-admin.css' ) );
        
        // Oculta avisos de outros plugins nas páginas do Perfect Presell
        add_action( 'admin_head', function() {
            if ( isset( $_GET['page'] ) && strpos( $_GET['page'], PP_Constants::MENU_SLUG ) === 0 ) {
                echo '<style>#wpcontent .notice:not(.pp-allow), #wpcontent .update-nag {display:none!important}</style>';
            }
        } );
        
        wp_enqueue_script( 'ppresell-admin', $assets . 'js/admin.js', [ 'jquery' ], PP_Constants::VERSION, true );
    }

    /* --------------------------------------------------------------------- */
    /* Dashboard                                                             */
    /* --------------------------------------------------------------------- */
    public function render_dashboard() : void {
        PP_Admin_Dashboard::render_dashboard( PP_Constants::CPT, PP_Constants::MENU_SLUG );
    }

    /* --------------------------------------------------------------------- */
    /* Create Page                                                           */
    /* --------------------------------------------------------------------- */
    public function render_create_page() : void {
        // Usar o template inline como no código original para evitar problemas de carregamento
        // Enqueue WordPress media library
        wp_enqueue_media();
        $editing = isset( $_GET['edit'] ) ? intval( $_GET['edit'] ) : 0;
        $values  = [
            'title' => '',
            'slug'  => '',
            'type'  => 'cookies',
            'lang'  => 'pt_BR',
            'bg'    => '',
            'bg_mobile' => '',
            'aff'   => '',
            'review_link' => '',
            'official_link' => '',
            'video_cover' => '',
            'product_img' => '',
            'sales_notify' => '',
            'sales_product' => '',
            'sales_country' => '',
            // VSL Topo fields
            'vsl_gradient_color_1' => '#6A1B9A',
            'vsl_gradient_color_2' => '#8E24AA',
            'vsl_headline_text_color' => '#ffffff',
            'vsl_headline_highlight_color' => '#ffeb3b',
            'vsl_headline_text_before' => 'Descubra o Segredo Para',
            'vsl_headline_highlight' => 'TRANSFORMAR SUA VIDA',
            'vsl_headline_text_after' => 'Em Apenas 30 Dias!',
            'vsl_video_id' => '', // ID de vídeo em branco por padrão
            'vsl_affiliate_link' => '#',
            'vsl_product_name' => 'Produto Incrível',
            'vsl_product_description' => 'Transforme sua vida com este produto revolucionário',
            'vsl_certifications_image' => '',
            'vsl_guarantee_image' => '',
        ];
        if ( $editing ) {
            $post = get_post( $editing );
            if ( $post && $post->post_type === PP_Constants::CPT ) {
                $values['title'] = $post->post_title;
                $values['slug']  = $post->post_name;
                $values = array_merge($values, [
                    'title'          => $post->post_title,
                    'slug'           => $post->post_name,
                    'aff'            => get_post_meta( $editing, 'pp_affiliate_link', true ),
                    'type'           => get_post_meta( $editing, 'pp_type', true ),
                    'lang'           => get_post_meta( $editing, 'pp_lang', true ),
                    'bg_img'         => get_post_meta( $editing, 'pp_bg_img', true ),
                    'bg_mobile'      => get_post_meta( $editing, 'pp_bg_mobile', true ),
                    'affiliate_link' => get_post_meta( $editing, 'pp_affiliate_link', true ),
                    'review_link'    => get_post_meta( $editing, 'pp_review_link', true ),
                    'official_link'  => get_post_meta( $editing, 'pp_official_link', true ),
                    'overlay'        => get_post_meta( $editing, 'pp_overlay', true ),
                    'sales_product'  => get_post_meta( $editing, 'pp_sales_product', true ),
                    'sales_country'  => get_post_meta( $editing, 'pp_sales_country', true ),
                    'plataforma'     => get_post_meta( $editing, 'pp_plataforma', true ),
                    'drcash_api_key' => get_post_meta( $editing, 'pp_drcash_api_key', true ),
                    'drcash_offer_id'=> get_post_meta( $editing, 'pp_drcash_offer_id', true ),
                    'adcombo_api_key' => get_post_meta( $editing, 'pp_adcombo_api_key', true ),
                    'adcombo_offer_id'=> get_post_meta( $editing, 'pp_adcombo_offer_id', true ),
                    'adcombo_price'   => get_post_meta( $editing, 'pp_adcombo_price', true ),
                    'drcash_price'    => get_post_meta( $editing, 'pp_drcash_price', true ),
                    // Leadrock fields
                    'leadrock_api_key' => get_post_meta( $editing, 'pp_leadrock_api_key', true ),
                    'leadrock_secret'  => get_post_meta( $editing, 'pp_leadrock_secret', true ),
                    'leadrock_flow_url'=> get_post_meta( $editing, 'pp_leadrock_flow_url', true ),
                    'leadrock_price'   => get_post_meta( $editing, 'pp_leadrock_price', true ),
                    'logzz_video_url' => get_post_meta( $editing, 'pp_logzz_video_url', true ),
                    // Webvork fields
                    'webvork_api_key' => get_post_meta( $editing, 'pp_webvork_api_key', true ),
                    'webvork_offer_id'=> get_post_meta( $editing, 'pp_webvork_offer_id', true ),
                    'webvork_price'   => get_post_meta( $editing, 'pp_webvork_price', true ),
                    'webvork_landing_id' => get_post_meta( $editing, 'pp_webvork_landing_id', true ),
                    // Network fields
                    'network_api_key' => get_post_meta( $editing, 'pp_network_api_key', true ),
                    'network_offer_id'=> get_post_meta( $editing, 'pp_network_offer_id', true ),
                    'network_price'   => get_post_meta( $editing, 'pp_network_price', true ),
                    'network_landing_id' => get_post_meta( $editing, 'pp_network_landing_id', true ),
                    // Terra Leads fields
                    'terraleads_api_key' => get_post_meta( $editing, 'pp_terraleads_api_key', true ),
                    'terraleads_user_id' => get_post_meta( $editing, 'pp_terraleads_user_id', true ),
                    'terraleads_offer_id'=> get_post_meta( $editing, 'pp_terraleads_offer_id', true ),
                    'terraleads_api_domain' => get_post_meta( $editing, 'pp_terraleads_api_domain', true ),
                    'terraleads_stream_id' => get_post_meta( $editing, 'pp_terraleads_stream_id', true ),
                    'terraleads_price'   => get_post_meta( $editing, 'pp_terraleads_price', true ),
                    // VSL Topo fields
                    'vsl_gradient_color_1' => get_post_meta( $editing, 'pp_vsl_gradient_color_1', true ),
                    'vsl_gradient_color_2' => get_post_meta( $editing, 'pp_vsl_gradient_color_2', true ),
                    'vsl_headline_text_color' => get_post_meta( $editing, 'pp_vsl_headline_text_color', true ),
                    'vsl_headline_highlight_color' => get_post_meta( $editing, 'pp_vsl_headline_highlight_color', true ),
                    'vsl_headline_text_before' => get_post_meta( $editing, 'pp_vsl_headline_text_before', true ),
                    'vsl_headline_highlight' => get_post_meta( $editing, 'pp_vsl_headline_highlight', true ),
                    'vsl_headline_text_after' => get_post_meta( $editing, 'pp_vsl_headline_text_after', true ),
                    'vsl_video_id' => get_post_meta( $editing, 'pp_vsl_video_id', true ),
                    'vsl_affiliate_link' => get_post_meta( $editing, 'pp_affiliate_link', true ), // Usando o campo padrão de link de afiliado
                    'vsl_certifications_image' => get_post_meta( $editing, 'pp_vsl_certifications_image', true ),
                    'vsl_guarantee_image' => get_post_meta( $editing, 'pp_vsl_guarantee_image', true ),
                ]);
                $values['product_img'] = get_post_meta( $editing, PP_Constants::META_PRODUCT_IMG, true );
                $values['video_cover'] = get_post_meta( $editing, PP_Constants::META_VIDEO_COVER, true );
                $values['sales_notify'] = get_post_meta( $editing, PP_Constants::META_SALES_NOTIFY, true );
                $values['sales_product'] = get_post_meta( $editing, PP_Constants::META_SALES_PRODUCT, true );
                $values['sales_country'] = get_post_meta( $editing, PP_Constants::META_SALES_COUNTRY, true );
            }
        }
        
        // Carregar CSS modularizado específico da página de criação
        wp_enqueue_style(
            'pp-create-page-css',
            plugin_dir_url( __FILE__ ) . 'assets/css/create-page.css',
            ['bootstrap-ppresell'],
            filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/create-page.css' )
        );
        
        // Carregar assets do sistema de preview
        PP_Preview_System::enqueue_preview_assets();
        
        // Adicionar JavaScript inline para debug e garantir inicialização
        wp_add_inline_script( 'pp-preview-system', '
            jQuery(document).ready(function($) {
                console.log("Perfect Presell Preview System: Inicializando...");
                
                // Verificar se o container do preview existe
                if ($("#pp-preview-wrapper").length === 0) {
                    console.warn("Perfect Presell Preview: Container #pp-preview-wrapper não encontrado!");
                } else {
                    console.log("Perfect Presell Preview: Container encontrado, inicializando preview...");
                    
                    // Forçar carregamento do preview inicial
                    if (typeof window.loadPreview === "function") {
                        setTimeout(function() {
                            window.loadPreview();
                        }, 500);
                    }
                }
            });
        ' );
        
        // Incluir o template inline como no código original
        include plugin_dir_path(__FILE__) . 'includes/templates/create-page-template.php';
    }

    /* --------------------------------------------------------------------- */
    /* Handlers                                                              */
    /* --------------------------------------------------------------------- */
    public function handle_save_presell() {
        PP_Handlers::handle_save_presell();
    }

    public function handle_delete_presell() {
        PP_Handlers::handle_delete_presell();
    }

    public function handle_bulk_delete_presell() {
        PP_Handlers::handle_bulk_delete_presell();
    }

    public function render_frontend_presell() {
        PP_Frontend_Renderer_Manager::render_frontend_presell();
    }

    public function inject_tracking_code() {
        PP_Rastreamento_Clean::render_head_tracking();
    }
    
    /**
     * Oculta presells da listagem de páginas do WordPress admin
     * Mantém a funcionalidade do WordPress mas remove presells da visualização
     */
    public function hide_presells_from_pages_list( $query ) {
        // Só aplicar no admin e na tela de listagem de páginas
        if ( ! is_admin() || ! $query->is_main_query() ) {
            return;
        }
        
        // Verificar se estamos na tela de páginas
        global $pagenow, $typenow;
        if ( $pagenow !== 'edit.php' || $typenow !== 'page' ) {
            return;
        }
        
        // NÃO aplicar durante verificações de slug único (AJAX, wp_insert_post, etc.)
        if ( wp_doing_ajax() || defined('DOING_AUTOSAVE') || 
             (isset($_POST['action']) && $_POST['action'] === 'pp_create_presell') ) {
            return;
        }
        
        // Adicionar meta_query para excluir presells (páginas com pp_is_presell = '1')
        $meta_query = $query->get( 'meta_query' ) ?: [];
        
        $meta_query[] = [
            'key'     => 'pp_is_presell',
            'compare' => 'NOT EXISTS'
        ];
        
        $query->set( 'meta_query', $meta_query );
        
        // Log para debug (remover em produção)
        error_log( 'Perfect Presell: Filtro aplicado - ocultando presells da listagem de páginas' );
    }
    
    /**
     * Format international phone number
     */
    private function format_international_phone($phone) {
        // Remove all non-numeric characters except +
        $phone = preg_replace('/[^\d+]/', '', $phone);
        
        // If already has +, keep it
        if (strpos($phone, '+') === 0) {
            return $phone;
        }
        
        // If no +, add +55 (Brazil) as default
        if (!empty($phone)) {
            return '+55' . $phone;
        }
        
        return $phone;
    }

    // License functionality moved to license-manager.php

    /* --------------------------------------------------------------------- */
    /* --------------------------------------------------------------------- */
    /* Tracking Code Injection                                             */
    /* --------------------------------------------------------------------- */
    // Método removido - agora usando PP_Rastreamento_Clean::render_*_tracking() nos hooks

    /* Cron Helpers & Deactivation - Métodos removidos (não utilizados)    */
    /* --------------------------------------------------------------------- */

    /**
     * Convert locale string (e.g., pt_BR) to full country name for dashboard display.
     */
    private function locale_to_country( string $locale ) : string {
        return PP_Utils::locale_to_country( $locale );
    }

    private function get_model_html( string $type, string $lang = 'pt_BR' ) : string {
        // Use the new Template Manager
        if ( ! isset( $this->template_manager ) ) {
            $this->template_manager = new PP_Template_Manager();
        }
        
        return $this->template_manager->get_template_html( $type, $lang );
    }

    /* --------------------------------------------------------------------- */
    /* Tracking Code Injection                                             */
    /* --------------------------------------------------------------------- */
    // Método removido - agora usando PP_Rastreamento_Clean::render_*_tracking() nos hooks

    /* Cron Helpers & Deactivation - Métodos removidos (não utilizados)    */
    /* --------------------------------------------------------------------- */

}
endif;

// Include shortcode handler directly - no hook needed
require_once plugin_dir_path( __FILE__ ) . 'includes/class-pp-template-manager.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-pp-utils.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-pp-create-page.php';
require_once plugin_dir_path( __FILE__ ) . 'presell/shortcode-handler.php';

// Template System removido temporariamente para evitar erros críticos

