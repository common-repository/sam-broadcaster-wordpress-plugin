<?php
function sradiobfm_connecttodb() {
    global $sradiobfm_db;
    global $idebug;
    
    if (!isset($sradiobfm_db)) {
        $wpdb->persistent = true;
        $sradiobfm_db = new wpdb(get_option('sradiobfm_dbuser'), get_option('sradiobfm_dbpwd'), get_option('sradiobfm_dbname'), get_option('sradiobfm_dbhost'));
    //$sradiobfm_db->persistent = true;
    }
}

function convert_duration($duration) {
    $return_value = "";
    $ss = round( $duration / 1000 );
    $mm = ( int )( $ss / 60 );
    $ss = ( $ss % 60 );
    if( $ss < 10 ) {
        $ss = "0" . $ss;
    }
    $return_value = $mm . ":" . $ss;
    return $return_value;
    }
function disp_cover_image($sradiobfm_tmp_songID){
    global $sradiobfm_db;
    //echo "SONGID $sradiobfm_tmp_songID";
    $query = "select * from songlist where ID=$sradiobfm_tmp_songID";
    $query_result = $sradiobfm_db->get_results($sradiobfm_db->prepare($query), ARRAY_A);
    $title = $query_result[0]['artist']; 
    //echo "$title @@@@@";
    //print_r($query_result);
    if (empty($query_result[0]['picture']) || $query_result == 0) {
        //return "na.GIF";

        $artistname = $query_result[0]['artist'];
        unset($query, $query_result);
        //echo $query_result[0]['picture'];
        $query = "select picture from externalartistdata where name=\"$artistname\"";
        $query_result = $sradiobfm_db->get_var($sradiobfm_db->prepare($query));
        //print_r($query_result);
        //echo "RESULT $query_result";
        if (empty($query_result)) {
            
                _e( '<img src="' . get_option('sradiobfm_img_folder') . "/" . "na.GIF" . '" title="' . $title . '" alt="' . '" border="0" />' );           
        } else {
            //echo "IN ELSE";
                $query_result = trim($query_result);
                _e( '<img src="' . get_option('sradiobfm_img_folder') . "/" . $query_result . '" title="' . $title . '" alt="' . '" border="0" />' );
        }
        

//esc_html( $the_array["album"] ) .
//esc_html( $the_array["album"] ) 
    } else {
        echo "IN MAIN ELSE";
        //print_r($query_result);
        _e( '<img src="' . get_option('sradiobfm_img_folder') . "/" . $query_result[0]['picture'] . '" title="' . '" alt="' . '" border="0" />' );
    }
}

function up_next() {
    global $sradiobfm_db;
    sradiobfm_connecttodb();
    $query="SELECT songlist.*, queuelist.requestID as requestID FROM queuelist, songlist WHERE (queuelist.songID = songlist.ID)  AND (songlist.songtype='S') AND (songlist.artist <> '') ORDER BY queuelist.sortID ASC"; 
    //print_r($result);
    return $sradiobfm_nplaying_sll = $sradiobfm_db->get_results(($sradiobfm_db->prepare($query)), ARRAY_A);
}
function getimagefilename($inputfile) {
    $file_parts = pathinfo($inputfile);
    $newfilename = $file_parts['filename'] . "." . $file_parts['extension'];
    return $newfilename;
}
function gen_thumbnail( $input_image ) {
  $tmpcwd = getcwd();
  
  $input_image = $tmpcwd . $input_image;
  echo "INPUT FILE $input_image";
  $input_file =  $input_image;
  $input_file = trim($input_file);
  
  $file_parts = pathinfo($input_image);
  $newfilename = $file_parts['filename'] . "." . $file_parts['extension'];
  $output_file = get_option('sradiobfm_img_folder') . "/" . $newfilename;
  
  $output_file = $tmpcwd . $output_file;
    echo "OUTPUT FILE $output_file";    
  $output_file = trim($output_file);
  $cover_art_thumbnail_height = get_option('sradiobfm_pic_width');
  $cover_art_thumbnail_width = get_option('sradiobfm_pic_height');
  echo "$cover_art_thumbnail_height, $cover_art_thumbnail_width";

  if ( file_exists( $input_file ) && !file_exists( $output_file ) ) {
    // Get the image file extension
    $file_extension = substr( strrchr( $input_file, '.' ), 1 );
    if ( preg_match( '/jpg|jpeg/', $file_extension ) ) {
      $src_img = imagecreatefromjpeg($input_file);
    } else if ( preg_match( '/png/', $file_extension ) ) {
      $src_img = imagecreatefrompng( $input_file );
    } else if ( preg_match( '/gif/', $file_extension )) {
      $src_img = imagecreatefromgif( $input_file );
    } else {
      return;
    }

    // Sanity check to make sure we have an image
    if (!$src_img) {
        echo "@@@ $src_img@@@";
        return;
    }

    // Get the dimensions of the original image by using imageSX() and imageSY()
    //   and calculate the dimensions of the thumbnail accordingly keeping the correct aspect ratio.
    $old_x = imageSX( $src_img );
    $old_y = imageSY( $src_img );

    if ($old_x > $old_y) {
      $thumb_w = $cover_art_thumbnail_width;
      $thumb_h = $old_y * ( $cover_art_thumbnail_height / $old_x );
    } else if ( $old_x < $old_y ){
      $thumb_w = $old_x * ( $cover_art_thumbnail_width / $old_y );
      $thumb_h = $cover_art_thumbnail_height;
    } else {
      $thumb_w = $cover_art_thumbnail_width;
      $thumb_h = $cover_art_thumbnail_height;
    }

    // Create the image as a true color version using imagecreatetruecolor()
    //   and resize and copy the original image into the new thumbnail image on the top left position.
    $dst_img = imagecreatetruecolor( $thumb_w, $thumb_h );
    imagecopyresampled( $dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y );

    // Write the correct thumbnail image type
    if ( preg_match( '/jpg|jpeg/', $file_extension ) ) {
      imagejpeg($dst_img, $output_file);
    } else if ( preg_match( '/png/', $file_extension ) ) {
      imagepng( $dst_img, $output_file );
    } else if ( preg_match( '/gif/', $file_extension ) ) {
      imagegif( $dst_img, $output_file );
    }
    // Destroy the two image objects to free memory
    imagedestroy( $dst_img );
    imagedestroy( $src_img );
  } else {
    echo "SOMETHING WENT WRONG $input_file" . file_exists( $input_file ) . "@" . !file_exists( $output_file ) . "@";
  }
}

function amazon_purchase($songtitle) {
    $trim_title = trim($songtitle);
    $amazon_pur_url= "http://www.amazon.com/gp/search?ie=UTF8&keywords=" . urlencode($trim_title) . "&tag=" . get_option('sradiobfm_amazon_aff') . "&index=music&linkCode=ur2&camp=1789&creative=9325";
    //echo $amazon_pur_url;
    echo urlencode2($amazon_pur_url);
}
//bhafm-20 

function destruct_filename($title) {
        $filename = explode(".", $title,-1);
        $filename = implode(",", $filename);
        $sterile_filename = preg_replace( "/[^\w\.-]+/", " ", $filename );
        return $sterile_filename;
}

function urlencode2($url) 
{ 
        // safely cast back already encoded "&" within the query 
        $url = str_replace( "&amp;","&",$url ); 
        $phpsep = (strlen(ini_get('arg_separator.input')>0))?ini_get('arg_separator.output'):"&"; 
        // cut optionally anchor 
        $ancpos = strrpos($url,"#"); 
        $lasteq = strrpos($url,"="); 
        $lastsep = strrpos($url,"&"); 
        $lastqsep = strrpos($url,"?"); 
        $firstsep = strpos($url, "?"); 
        // recognize wrong positioned anchor example.php#anchor?asdasd 
        if ($ancpos !== false 
        || ($ancpos > 0 
            && ($lasteq > 0 && $lasteq < $ancpos ) 
            && ($lastsep > 0 && $lastsep < $ancpos ) 
            && ($lastqsep > 0 && $lastqsep < $ancpos ) 
            ) 
        ) 
        { 
               $anc = "#" . urlencode( substr( $url,$ancpos+1 ) ); 
               $url = substr( $url,0,$ancpos ); 
        } 
        else 
        { 
            $anc = ""; 
        } 
        // separate uri and query string 
        if ($firstsep == false) 
        { 
            $qry = "";    // no query 
            $urlenc = $url.$anc;  // anchor 
        } 
        else 
        { 
            $qry = substr( $url, $firstsep + 1 ) ; 
            $vals = explode( "&", $qry ); 
            $valsenc = array(); 
            foreach( $vals as $v ) 
            { 
                $buf = explode( "=", $v ); 
                $buf[0]=urlencode($buf[0]); 
                $buf[1]=urlencode($buf[1]); 
                $valsenc[] = implode("=",$buf); 
            } 
            $urlenc = substr( $url, 0 , $firstsep  );    // encoded origin uri 
            $urlenc.= "?" . implode($phpsep, $valsenc )    // encoded query string 
            . $anc; // anchor 
        } 
        $urlenc = htmlentities( $urlenc, ENT_QUOTES ); 
        return $urlenc; 
}

?>