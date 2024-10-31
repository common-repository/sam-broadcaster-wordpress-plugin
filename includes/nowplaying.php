<?php
function sradiobfmnowplaying() {
    global $sradiobfm_db;
    sradiobfm_connecttodb();
    $sradiobfm_query = "SELECT songlist.*, historylist.listeners as listeners, historylist.requestID as requestID, historylist.date_played as starttime FROM historylist,songlist WHERE (historylist.songID = songlist.ID) AND (songlist.songtype='S') ORDER BY historylist.date_played DESC LIMIT 6";
    $sradiobfm_nplaying = $sradiobfm_db->get_results($sradiobfm_query, ARRAY_A);
    $sradiobfm_nplaying_sll = up_next();
   //@@@@WARNING SPEED ISSUE

    $trim_title = trim($sradiobfm_nplaying[0]['title']);
    $amazon_pur_url= "http://www.amazon.com/gp/search?ie=UTF8&keywords=" . urlencode($trim_title) . "&tag=" . get_option('sradiobfm_amazon_aff') . "&index=music&linkCode=ur2&camp=1789&creative=9325";
?>
<div class="sradiobfm_row">
    <span class="label">Coming Up:</span>
    <span class="sepa">&nbsp;</span><span class="formw"><?php if (!empty($sradiobfm_nplaying_sll[0]['title'])){
        echo $sradiobfm_nplaying_sll[0]['title'];}; ?></span>
</div>
<div id="sradiobfm_plugin_col_one">
    <div style="text-align: center;"><?php disp_cover_image($sradiobfm_nplaying[0]['ID']);?></div>
    <div style="text-align: center;"><br /><a href="<?php echo $amazon_pur_url;?>"><img src="/images/buyfromamazon.gif"/></a></div>
    <hr/>
    <b>Genre:</b> <?php echo $sradiobfm_nplaying[0]['genre']; ?>
    <?php //$genre2="more crap"; ( ( $genre2 ) > 0 ) ? disp_genres( $genre2 ) : _e( "n/a" ); ?>
    <hr/><br />
</div>
<div id="sradiobfm_plugin_col_two">
  <div class="sradiobfm_plugin_row"><span class="label">Artist:</span><span class="sepa">&nbsp;</span><span class="formw">
  <?php echo $sradiobfm_nplaying[0]['artist']; ?></a>
  </span></div>
  <div class="sradiobfm_plugin_row"><span class="label">Album:</span><span class="sepa">&nbsp;</span><span class="formw">
  <?php echo $sradiobfm_nplaying[0]['album']; ?></a>
  </span></div>
  <div class="sradiobfm_plugin_row"><span class="label">Title:</span><span class="sepa">&nbsp;</span><span class="formw">
  <?php echo $sradiobfm_nplaying[0]['title']; ?></a>
  </span></div>
  <br/>
  <?php if(strlen($sradiobfm_nplaying[0]['composer']) > 0) { ?>
    <div class="sradiobfm_plugin_row"><span class="label">Composer:</span><span class="sepa">&nbsp;</span><span class="formw"><?php _e( $sradiobfm_nplaying[0]['composer'] ); ?></span></div>
  <?php } ?>
  <div class="sradiobfm_plugin_row"><span class="label">Rating:</span><span class="sepa">&nbsp;</span><span class="formw"><?php echo $sradiobfm_nplaying[0]['rating'];//( $now_playing["rating"] <= 0 ) ? _e( $amazon_rating ) : _e( $now_playing["rating"] ); ?></span></div>
  <div class="sradiobfm_plugin_row"><span class="label">Duration:</span><span class="sepa">&nbsp;</span><span class="formw"><?php _e( convert_duration( $sradiobfm_nplaying[0]['duration'] ) ); ?> (Remain: <b id="countDownText"></b>)</span></div>
  <div class="sradiobfm_plugin_row"><span class="label">Year:</span><span class="sepa">&nbsp;</span><span class="formw"><?php _e( $sradiobfm_nplaying[0]['albumyear'] ); ?></span></div>
  <br/>
  <div class="sradiobfm_plugin_row"><span class="label">Added:</span><span class="sepa">&nbsp;</span><span class="formw"><?php echo $sradiobfm_nplaying[0]['date_added'];//_e( date( get_option('date_format'), strtotime($now_playing["date_added"])) ); ?></span></div>
  <div class="sradiobfm_plugin_row"><span class="label"># Plays:</span><span class="sepa">&nbsp;</span><span class="formw"><?php echo $sradiobfm_nplaying[0]['count_played']; ?></span></div>
  <div class="sradiobfm_plugin_row"><span class="label">Last Played:</span><span class="sepa">&nbsp;</span><span class="formw"><?php echo $sradiobfm_nplaying[0]['last_played'];//_e( date( get_option('date_format') . " " . get_option('time_format'), strtotime($now_playing["date_played"])) ); ?></span></div>
  <div class="sradiobfm_plugin_row"><span class="label"># Requests:</span><span class="sepa">&nbsp;</span><span class="formw"><?php echo $sradiobfm_nplaying[0]['count_requested']; ?></span></div>
  <?php //if($now_playing["count_requested"] > 0) { ?>
  <div class="sradiobfm_plugin_row"><span class="label">Last Request:</span><span class="sepa">&nbsp;</span><span class="formw"><?php echo $sradiobfm_nplaying[0]['last_requested'];//_e( date( get_option('date_format') . " " . get_option('time_format'), strtotime($now_playing["last_requested"])) ); ?></span></div>
  <?php //} ?>
  <br/>
  <b>Lyrics:</b>
  <?php echo $sradiobfm_nplaying_sl[0]['lyrics'];//disp_song_lyrics( $now_playing["lyrics"] ); ?>
  <?php //disp_lyrics_disc( ); ?>
</div>
<br style="clear: both;" />
<br style="clear: both;" />

<table border="0" width="98%" cellspacing="0" cellpadding="4">
  <tr bgcolor="#002E5B"> 
    <td colspan="2" nowrap align="left"> 
      <p><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#FFFFFF"><b>Recently 
        played songs</b></font>
    </td>
	<td colspan="3" nowrap align="center"> 
      <p><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#FFFFFF"><b>Links</b></font>
    </td>
    <td nowrap align="left"> 
      <p><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#FFFFFF"><b>Album</b></font>
    </td>
	<td nowrap align="Right"> 
      <p><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#FFFFFF"><b>Time</b></font>
    </td>
  </tr>

 
  <tr bgcolor="#dadada"> 
  
	
 
 
    <td colspan=2>
    <font size="2" color="#003366"><small><?php echo $sradiobfm_nplaying[1]['title']; ?></small></font>
    </td>
    <td nowrap width="1%"> 
      <!-- ADAM <p align="center"><font size="2" color="#003366"><img
    src="images/buy.gif" alt="Buy this CD now!" border="0"></a></font> --> 
    </td>
    <td nowrap width="1%"> 
    <p align="center">
    <font size="2" color="#003366"><img src="../images/home.gif" alt="Artist homepage" border="0"></a></font> 
    </td>
	<td nowrap align="center" nowrap width="1%"> 
    <font size="2" color="#003366"><img
    src="../images/info.gif" alt="Song information" border="0"></a></font> 
    </td>
    <td nowrap>
    <font color="#003366" size="2"><small><?php echo $sradiobfm_nplaying[1]['album']; ?></small></font>
    </td>
    <td nowrap> 
    <p align="right"><font color="#003366" size="2"><small><strong><?php _e( convert_duration( $sradiobfm_nplaying[1]['duration'] ) ); ?></strong></small></font>
    </td>
  </tr>
 
  <tr bgcolor="#F6F6F6"> 
  
	
 
 
    <td colspan=2><font size="2" color="#003366"><small><?php echo $sradiobfm_nplaying[2]['title']; ?></small></font></td>
    <td nowrap width="1%"> 
      <!-- ADAM <p align="center"><font size="2" color="#003366"><img
    src="images/buy.gif" alt="Buy this CD now!" border="0"></a></font> --> 
    </td>
    <td nowrap width="1%"> 
      <p align="center"><font size="2" color="#003366"><img
    src="../images/home.gif" alt="Artist homepage" border="0"></a></font> 
    </td>
	
	<td nowrap align="center" nowrap width="1%"> 
      <font size="2" color="#003366"><img
    src="../images/info.gif" alt="Song information" border="0"></a></font> 
    </td>
	
    <td nowrap><font color="#003366" size="2"><small><?php echo $sradiobfm_nplaying[2]['album']; ?></small></font></td>
    <td nowrap> 
      <p align="right"><font color="#003366" size="2"><small><strong><?php _e( convert_duration( $sradiobfm_nplaying[2]['duration'] ) ); ?></strong></small></font>
    </td>
  </tr>
  
    <tr bgcolor="#dadada"> 
  
	
 
 
    <td colspan=2><font size="2" color="#003366"><small><?php echo $sradiobfm_nplaying[3]['title']; ?></small></font></td>
    <td nowrap width="1%"> 
      <!-- ADAM <p align="center"><font size="2" color="#003366"><img
    src="images/buy.gif" alt="Buy this CD now!" border="0"></a></font> --> 
    </td>
    <td nowrap width="1%"> 
      <p align="center"><font size="2" color="#003366"><img
    src="../images/home.gif" alt="Artist homepage" border="0"></a></font> 
    </td>
	
	<td nowrap align="center" nowrap width="1%"> 
      <font size="2" color="#003366"><img
    src="../images/info.gif" alt="Song information" border="0"></a></font> 
    </td>
	
    <td nowrap><font color="#003366" size="2"><small><?php echo $sradiobfm_nplaying[3]['album']; ?></small></font></td>
    <td nowrap> 
      <p align="right"><font color="#003366" size="2"><small><strong><?php _e( convert_duration( $sradiobfm_nplaying[3]['duration'] ) ); ?></strong></small></font>
    </td>
  </tr>
 
  <tr bgcolor="#F6F6F6"> 
  
	
 
 
    <td colspan=2><font size="2" color="#003366"><small><?php echo $sradiobfm_nplaying[4]['title']; ?></small></font></td>
    <td nowrap width="1%"> 
      <!-- ADAM <p align="center"><font size="2" color="#003366"><img
    src="images/buy.gif" alt="Buy this CD now!" border="0"></a></font> --> 
    </td>
    <td nowrap width="1%"> 
      <p align="center"><font size="2" color="#003366"><img
    src="../images/home.gif" alt="Artist homepage" border="0"></a></font> 
    </td>
	
	<td nowrap align="center" nowrap width="1%"> 
      <font size="2" color="#003366"><img
    src="../images/info.gif" alt="Song information" border="0"></a></font> 
    </td>
	
    <td nowrap><font color="#003366" size="2"><small><?php echo $sradiobfm_nplaying[4]['album']; ?></small></font></td>
    <td nowrap> 
      <p align="right"><font color="#003366" size="2"><small><strong><?php _e( convert_duration( $sradiobfm_nplaying[4]['duration'] ) ); ?></strong></small></font>
    </td>
  </tr>
  
    <tr bgcolor="#dadada"> 
  
	
 
 
    <td colspan=2><font size="2" color="#003366"><small><?php echo $sradiobfm_nplaying[5]['title']; ?></small></font></td>
    <td nowrap width="1%"> 
      <!-- ADAM <p align="center"><font size="2" color="#003366"><img
    src="images/buy.gif" alt="Buy this CD now!" border="0"></a></font> --> 
    </td>
    <td nowrap width="1%"> 
      <p align="center"><font size="2" color="#003366"><img
    src="../images/home.gif" alt="Artist homepage" border="0"></a></font> 
    </td>
	
	<td nowrap align="center" nowrap width="1%"> 
      <font size="2" color="#003366"><img
    src="../images/info.gif" alt="Song information" border="0"></a></font> 
    </td>
	
    <td nowrap><font color="#003366" size="2"><small><?php echo $sradiobfm_nplaying[5]['album']; ?></small></font></td>
    <td nowrap> 
      <p align="right"><font color="#003366" size="2"><small><strong><?php _e( convert_duration( $sradiobfm_nplaying[5]['duration'] ) ); ?></strong></small></font>
    </td>
  </tr>
  </table>
 
  
<?php 
}
    add_shortcode('sradiobfmnowplaying','sradiobfmnowplaying');
?>