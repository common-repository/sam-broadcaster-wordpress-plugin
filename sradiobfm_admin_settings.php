<?php
global $current_user;
get_currentuserinfo();
if (is_super_admin($current_user->user_login)) { 
    if($_POST['sradiobfm_hidden'] == 'Y'){
        //form data sent
        $dbhost = $_POST['sradiobfm_dbhost'];
        update_option('sradiobfm_dbhost', $dbhost);
        $dbname = $_POST['sradiobfm_dbname'];
        update_option('sradiobfm_dbname',$dbname);
        $dbuser = $_POST['sradiobfm_dbuser'];
        update_option('sradiobfm_dbuser',$dbuser);
        $dbpwd = $_POST['sradiobfm_dbpwd'];
        update_option('sradiobfm_dbpwd',$dbpwd);
        $img_folder = $_POST['sradiobfm_img_folder'];
        update_option('sradiobfm_img_folder', $img_folder);
        $website_address = $_POST['sradiobfm_website_address'];
        update_option('sradiobfm_website_address', $website_address);
        $pic_width  = $_POST['sradiobfm_pic_width'];
        update_option('sradiobfm_pic_width', $pic_width);
        $pic_height = $_POST['sradiobfm_pic_height'];
        update_option('sradiobfm_pic_height', $pic_height);
        $amazon_aff = $_POST['sradiobfm_amazon_aff'];
        update_option('sradiobfm_amazon_aff', $amazon_aff);        
         ?>
        <div class="updated"><p><strong><?php _e('Options saved.');?></strong></p></div>
        <?php
    } else {
        //normal page display
        $dbhost = get_option('sradiobfm_dbhost');
        $dbname = get_option('sradiobfm_dbname');
        $dbuser = get_option('sradiobfm_dbuser');
        $dbpwd = get_option('sradiobfm_dbpwd');
        $img_folder = get_option('sradiobfm_img_folder');
        $website_address = get_option('sradiobfm_website_address');
        $pic_width = get_option('sradiobfm_pic_width');
        $pic_height = get_option('sradiobfm_pic_height');
        $amazon_aff = get_option('sradiobfm_amazon_aff');         
    }
?>
<div class="wrap">  
    <?php    echo "<h2>" . __( 'Radio Database Settings', 'sradiobfm_trdom' ) . "</h2>"; ?>  
  
    <form name="sradiobfm_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
        <input type="hidden" name="sradiobfm_hidden" value="Y">  
        <?php    echo "<h4>" . __( 'Radio Database Options', 'sradiobfm_trdom' ) . "</h4>"; ?>  
        <p><?php _e("Database host: " ); ?><input type="text" name="sradiobfm_dbhost" value="<?php echo $dbhost; ?>" size="20"><?php _e(" ex: localhost" ); ?></p>  
        <p><?php _e("Database name: " ); ?><input type="text" name="sradiobfm_dbname" value="<?php echo $dbname; ?>" size="20"><?php _e(" ex: data_base" ); ?></p>  
        <p><?php _e("Database user: " ); ?><input type="text" name="sradiobfm_dbuser" value="<?php echo $dbuser; ?>" size="20"><?php _e(" ex: root" ); ?></p>  
        <p><?php _e("Database password: " ); ?><input type="text" name="sradiobfm_dbpwd" value="<?php echo $dbpwd; ?>" size="20"><?php _e(" ex: secretpassword" ); ?></p>
        <p><?php _e("Website Address: " ); ?><input type="text" name="sradiobfm_website_address" value="<?php echo $website_address; ?>" size="50"><?php _e(" ex: http://something.com" ); ?></p>
        <p><?php _e("Image Folder: " ); ?><input type="text" name="sradiobfm_img_folder" value="<?php echo $img_folder; ?>" size="20"><?php _e(" ex: /album/images relative to the URL (i.e. where SAM has uploaded your album art)" ); ?></p>
        <p><?php _e("Picture Width: " ); ?><input type="text" name="sradiobfm_pic_width" value="<?php echo $pic_width; ?>" size="20"><?php _e(" Pixel ex: 198" ); ?></p>
        <p><?php _e("Picture Height: " ); ?><input type="text" name="sradiobfm_pic_height" value="<?php echo $pic_height; ?>" size="20"><?php _e("Pixel ex: 200" ); ?></p>
        <p><?php _e("Amazon Affiliate ID: " ); ?><input type="text" name="sradiobfm_amazon_aff" value="<?php echo $amazon_aff; ?>" size="100"><?php _e(" Amazon Affiliate #" ); ?></p>
       
        
        
        
        <p class="submit">  
        <input type="submit" name="Submit" value="<?php _e('Update Options', 'sradiobfm_trdom' ) ?>" />  
        </p>  
    </form>  
</div>  
<?php
/**
 * require_once('/home/bollywood/public_html/wp-config.php');

 * function sradiobfm_makepost() {
 *     class wm_mypost{
 *         var $post_title;
 *         var $post_content;
 *         var $post_status;
 *         var $post_author;
 *         var $post_name;
 *         var $post_type;
 *         var $comment_status;
 *         
 *     }
 *     $wm_mypost= new wm_mypost();
 *     //fill object
 *     $wm_mypost->post_title=rand(1,100);
 *     $wm_mypost->post_content = 'test';
 *     $wm_mypost->post_status = 'publish';
 *     $wm_mypost->post_author = 1;
 *     $wm_mypost->post_category = array(get_option('sradiobfm_artist_wpcategory'));

 *     $wp_rewrite->feeds = 'yes';
 *     
 *     $temp_output = wp_insert_post($wm_mypost);
 *     echo "<br />$temp_output";
 * }
 * sradiobfm_makepost();
 */

$args=array(
    'orderby' => 'name',
    'order' => 'ASC'
);
$categories=get_categories($args);
    foreach($categories as $category) { 
    echo '<p>Category: <a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> </p> ';
    echo '<p> Description:'. $category->description . '</p>';
    echo '<p> ID:'. $category->term_id . '</p>';
    echo '<p> Post Count: '. $category->count . '</p>';
    } 
}
?>
