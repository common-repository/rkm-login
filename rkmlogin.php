<?php
/*
Plugin Name:  RKM Login
Plugin URI:   https://profiles.wordpress.org/
Description:  This is custom login, you have to create new login page and add shortcode to that page. 
Version:      1.0.4
Author:       RKM  
Author URI:   https://profiles.wordpress.org/krajesh0018/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  rkm login
Domain Path:  /languages
*/

/**
 * Register a custom menu page.
 */


function rkm_register_login_menu_page(){
	add_menu_page( 
		__( 'RKM Custom Login', 'textdomain' ),
		'RKM Login',
		'manage_options',
		'rkmcustomlogin',
		'rkm_custom_login_page',
		plugins_url( 'rkm-login/assets/img/rkmlogin02.png' ),
		6
	); 
}
add_action( 'admin_menu', 'rkm_register_login_menu_page' );

/**
 * Display a custom menu page
 */
function rkm_custom_login_page(){
	//esc_html_e( 'Admin Page Test', 'textdomain' );
    $post_page_name = get_option('rkm_post_slug');
    if(!empty($post_page_name) ){
        //echo get_option('rkm_post_slug').' Your short code applied on page <br>';
        $rkm_page = get_page_by_path( get_option('rkm_post_slug') );
        $rkmpage_title =  get_the_title( $rkm_page );

        if( has_shortcode( $rkm_page->post_content, 'rkm_login') ) {
            echo '<script type="text/javascript">jQuery(document).ready(function(){ jQuery("p.notifi").show();})</script>';
        }else{
            echo '<script type="text/javascript">jQuery(document).ready(function(){ jQuery("p.notifi2").show();})</script>';
            update_option('rkm_post_slug',null);
        }
    }
    
    else{
        echo 'Short code not applied';
    }
    ?>
    <div class="wrap">
 
 <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

 <div class="card">

     <div id="universal-message-container">
         <h2>Welcome RKM Login Page</h2>

         <div class="options">
             <p>
                 Please Add this shortcode to your page [rkm_login]
                 <br />
                 
             </p>
             <p class='notifi' style="display:none;"><?php echo "YEAH, shortcode is applied on ".$rkmpage_title." page";?></p>
             <p class='notifi2' style="display:none;">Shortcode Removed from Page</p>
     </div><!-- #universal-message-container -->
</div>

</div><!-- .wrap -->
    <?php
        
}

/* Login shortcode */
function rkm_login (){
    global $post;
    $post_slug = $post->post_name;
    if(isset($post_slug))
    update_option('rkm_post_slug',$post_slug);
    //$slug = get_queried_object()->post_name;
    //basename(get_permalink());
    // Register style sheet.
    wp_enqueue_style( 'rkm-bootstrap-min-css', 'https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css' );
    wp_enqueue_style( 'rkm-bootstrap-theme-min-css', 'https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css' );
    wp_enqueue_script('rkm-bootstrap-min-js', 'https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js', array(), null, true);
    ?>
    <style>
        body{
            background:gray;
            overflow: hidden;
        }
        header, .header, #header, footer, .footer, #footer{
            display:none!important;
        }
        .rkm-login-area{
            width:100%;
            float:left;
            padding:0px;
            margin:0px;
            display:flex;
            align-items:center;
            margin-top:30vh;
        }
        .rkm-login-branding{
            
        }
        .rkm-login-form{
            
        }
        .rkm-login-comdiv {
            background-color: #ebebeb82;
            padding: 20px;
            text-align: center;
            border: 24px solid #5c5c5c1c;
            border-radius: 7px;
            margin-right: 2px;
        }
        .rkm-inner {
            width: 90%;
            margin: auto;
        }
        .container-fluid{
            height:100vh;
        }
        .col-md-3 {
            align-self: stretch;
        }
        #loginform > p > input[type=text], 
        #loginform > p > input[type=password], 
        #loginform > p > input[type=submit], 
        form#loginform p label{
            width:100%;
            text-align: left;
            font-weight:100;
        }
        #loginform > p > input[type=submit]{
            width:50%;
            text-align:center;
            float:left;
        }
        p.login-msg {
            background-color: white;
            padding: 10px;
            border-left: 4px solid #72aee6;
        }
        @media only screen and (max-width: 768px) {
            body{
                overflow:visible;
            }
            .container-fluid {
                height: 100%;
            }
            .rkm-login-area {
                margin: 50px auto!important;
            }
            .rkm-login-comdiv {
                margin-right: 0px;
            }
            .rkm-login-area > div{
                margin-bottom: 10px;
            }
        }
    </style>
    <script type="text/javascript">
        jQuery(document).ready(function(){
             //jQuery("#loginform").addClass("form");
             //jQuery("#loginform > p").addClass("form-group");
             //jQuery("#loginform > p > label").addClass("text-info");
             //jQuery("#loginform > p > input[type=text], #loginform > p > input[type=password]").addClass("form-control");
             //jQuery("#user_login").addClass("my-login-username");
        })
    </script>
    <div class="container-fluid" style="background-image:url(<?php echo plugin_dir_url( __FILE__ ).'assets/img/rkmbcakground.png';?>);background-size: cover;">
        <div class="row rkm-login-area">
            <div class="col-md-3">
                <?php
                    $login  = (isset($_GET['login']) ) ? $_GET['login'] : 0;
                    if ( $login === "failed" ) {
                        echo '<p class="login-msg"><strong>ERROR:</strong> Invalid username and/or password.</p>';
                      } elseif ( $login === "empty" ) {
                        echo '<p class="login-msg"><strong>ERROR:</strong> Username and/or Password is empty.</p>';
                      } elseif ( $login === "false" ) {
                        echo '<p class="login-msg"><strong>ERROR:</strong> You are logged out.</p>';
                      }
                ?>
            </div>
            <div class="col-md-3 rkm-login-branding d-flex align-items-center rkm-login-comdiv">
                <div class="rkm-inner">
                    <img src="<?php echo plugin_dir_url( __FILE__ ).'assets/img/rkmlogin2.png';?>" alt="" width="100px"/>
                    <h3 class="login-logo"><?php echo 'Welcome RKM Login'; ?></h3>
                    <p class="login-desc">This is custom content that you can set from Dashboard. </p>
                </div>
            </div>
            <div class="col-md-3 rkm-login-form d-flex align-items-center rkm-login-comdiv">
                <div class="rkm-inner">
                <?php
                    $args = array(
                        'redirect' => home_url(), 
                        //'id_username' => 'user',
                        //'id_password' => 'pass',
                        //'form_id'        => 'loginform',
                        'label_username' => __( 'Username' ),
                        'label_password' => __( 'Password' ),
                        'label_log_in'   => __( 'Login' ),
                        //'id_remember'    => 'rememberme',
                        //'id_submit'      => 'wp-submit',
                    ) 
                ;?>
                <?php wp_login_form( $args ); ?>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    
    <?php
}
add_shortcode('rkm_login','rkm_login');



$rkm_page = get_page_by_path( get_option('rkm_post_slug') );
if( has_shortcode( $rkm_page->post_content, 'rkm_login') ) {

/*
#redirect the wp-login.php to our new rkm login page.
*/
function redirect_login_page() {
    $login_page  = home_url( get_option('rkm_post_slug') );
    $page_viewed = basename($_SERVER['REQUEST_URI']);
   
    if( $page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
            wp_redirect($login_page);
            exit;
    }
  }
add_action('init','redirect_login_page');

/*
# Note if login fail, or empty or wrong input field.
*/

function login_failed() {
    $login_page  = home_url( get_option('rkm_post_slug') );
    wp_redirect( $login_page . '?login=failed' );
    exit;
  }
  add_action( 'wp_login_failed', 'login_failed' );
   
  function verify_username_password( $user, $username, $password ) {
    $login_page  = home_url( get_option('rkm_post_slug') );
      if( $username == "" || $password == "" ) {
          wp_redirect( $login_page . "?login=empty" );
          exit;
      }
  }
  add_filter( 'authenticate', 'verify_username_password', 1, 3);

  function logout_page() {
    $login_page  = home_url( get_option('rkm_post_slug') );
    wp_redirect( $login_page . "?login=false" );
    exit;
  }
  add_action('wp_logout','logout_page');

  /* If user Logged In */
function add_login_check()
{
    $rkm_page = get_page_by_path( get_option('rkm_post_slug') );
    $rkmpage_title =  get_the_title( $rkm_page );
    $rkm_page_id = $rkm_page->ID;
    if ( is_user_logged_in() && is_page(get_option('rkm_post_slug'))) {
        wp_redirect(home_url());
        exit;
    }
}
add_action('wp', 'add_login_check');

}
else{
    update_option('rkm_post_slug',null);

}
