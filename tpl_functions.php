<?php
/**
 * functions for arctic template
 *
 * License: GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @author:         Michael Klier <chi@chimeric.de>
 * @homepage:       http://www.chimeric.de
 */

include(DOKU_TPLINC.'default.php');

/**
 * fetches the sidebar-pages and displays the sidebar
 * 
 * @author Michael Klier <chi@chimeric.de>
 */
function tpl_sidebar() {
    global $conf, $ID, $REV, $INFO, $lang;
   
    $OP    = array(); 
    $SbPn  = $conf['tpl_arctic']['pagename'];
    $uSbNs = $conf['tpl_arctic']['user_sidebarns'];
    $gSbNs = $conf['tpl_arctic']['group_sidebarns'];
    $mSb   = $SbPn;
    
    $svID  = $ID;
    $svREV = $REV;

    if(file_exists(wikiFN($mSb))) { 
        $OP['mSb'] = '<div class="m_sidebar">'.p_sidebar_xhtml($mSb).'</div>';
    } else {
        echo '<div class="i_sidebar">';
        html_index($svID);
        echo '</div>';
    }

    if(isset($INFO['userinfo']['name'])) {
        if($conf['tpl_arctic']['user_sidebar']) {
            $uSb = $uSbNs.':'.$_SERVER['REMOTE_USER'].':'.$SbPn; 
            if(file_exists(wikiFN($uSb))) $OP['uSb'] = '<div class="u_sidebar">'.p_sidebar_xhtml($uSb).'</div>';
        }
        if($conf['tpl_arctic']['group_sidebar']) {
            foreach($INFO['userinfo']['grps'] as $grp) {
                $gSb = $gSbNs.':'.$grp.':'.$SbPn;
                if(file_exists(wikiFN($gSb))) $OP['gSb'] .= '<div class="g_sidebar">'.p_sidebar_xhtml($gSb).'</div>';
            }
        
        }
    }
    
    if(isset($conf['tpl_arctic']['namespace_sidebar'])) {
        if(!preg_match("/".$uSbNs."|".$gSbNs."/", $svID)) {
            $path = explode(':', $svID);
            $nSb = '';
            $found = false;
            while(!$found && count($path) > 0) {
                $nSb = implode(':', $path).':'.$SbPn;
                $found = file_exists(wikiFN($nSb));
                array_pop($path);
            }
            if($found) $OP['nSb'] = '<div class="ns_sidebar">'.p_sidebar_xhtml($nSb).'</div>';
        }
    }

    $ID = $svID;
    $REV = $svREV;
    
    foreach($conf['tpl_arctic']['sidebar_order'] as $Sb) {
        if($Sb == 'bcr') {
            if($conf['tpl_arctic']['breadcrumbs'] && $conf['tpl_arctic']['breadcrumbs_sb']) {
                echo '<div class="bc_sidebar"><h1>'.$lang['breadcrumb'].'</h1><div class="breadcrumbs">';
                if($conf['youarehere']) {
                    tpl_youarehere();
                } else {
                    tpl_breadcrumbs();
                }
                echo '</div></div>';
            }
        } else {
            print $OP[$Sb];
        }
    }
}

/**
 * removes the TOC of the sidebar-pages and shows a edit-button if user has enough rights
 * 
 * @author Michael Klier <chi@chimeric.de>
 */
function p_sidebar_xhtml($Sb) {
    $data = p_wiki_xhtml($Sb,'',false);
    if(auth_quickaclcheck($Sb) >= AUTH_EDIT) {
        $data .= '<div class="secedit">'.html_btn('secedit',$Sb,'',array('do'=>'edit','rev'=>'','post')).'</div>';
    }
    return preg_replace('/<div class="toc">.*?(<\/div>\n<\/div>)/s', '', $data);
}

//Setup vim: ts=4 sw=4:
?>
