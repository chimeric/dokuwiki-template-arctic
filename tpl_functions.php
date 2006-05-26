<?php
/**
 * functions for arctic template
 *
 * License: GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @author:         Michael Klier <chi@chimeric.de>
 * @homepage:       http://www.chimeric.de
 */

if(!defined('DW_LF')) define('DW_LF',"\n");

/**
 * fetches the sidebar-pages and displays the sidebar
 * 
 * @author Michael Klier <chi@chimeric.de>
 */
function tpl_sidebar() {
    global $conf, $ID, $REV, $INFO, $lang;
   
    $OP    = array(); 
    $SbPn  = tpl_getConf('pagename');
    $uSbNs = tpl_getConf('user_sidebar_namespace');
    $gSbNs = tpl_getConf('group_sidebar_namespace');
    $mSb   = $SbPn;
    
    $svID  = $ID;
    $svREV = $REV;

    if(file_exists(wikiFN($mSb))) { 
        $OP['M'] .= '<div class="m_sidebar">' . DW_LF;
        $OP['M'] .= '  ' . p_sidebar_xhtml($mSb) . DW_LF;
        $OP['M'] .= '</div>';
    } else {
        print '<div class="i_sidebar">' . DW_LF;
        print '  ' . html_index($svID) . DW_LF;
        print '</div>';
    }

    if(isset($INFO['userinfo']['name'])) {
        if(!tpl_getConf('user_sidebar')) {
            $uSb = $uSbNs . ':' . $_SERVER['REMOTE_USER'] . ':' . $SbPn; 
            if(file_exists(wikiFN($uSb))) {
                $OP['U'] .= '<div class="u_sidebar">' . DW_LF;
                $OP['U'] .= '  ' . p_sidebar_xhtml($uSb) . DW_LF;
                $OP['U'] .= '</div>' . DW_LF;
            }
        }
        if(!tpl_getConf('group_sidebar')) {
            foreach($INFO['userinfo']['grps'] as $grp) {
                $gSb = $gSbNs.':'.$grp.':'.$SbPn;
                if(file_exists(wikiFN($gSb))) {
                    $OP['G'] .= '<div class="g_sidebar">' . DW_LF;
                    $OP['G'] .= '  ' . p_sidebar_xhtml($gSb) . DW_LF;
                    $OP['G'] .= '</div>' . DW_LF;
                }
            }
        
        }
    }
    
    if(!tpl_getConf('namespace_sidebar')) {
        if(!preg_match("/".$uSbNs."|".$gSbNs."/", $svID)) {
            $path  = explode(':', $svID);
            $nSb   = '';
            $found = false;
            while(!$found && count($path) > 0) {
                $nSb   = implode(':', $path).':'.$SbPn;
                $found = file_exists(wikiFN($nSb));
                array_pop($path);
            }
            if($found) {
                $OP['N'] .= '<div class="ns_sidebar">' . DW_LF;
                $OP['N'] .= '  ' . p_sidebar_xhtml($nSb) . DW_LF;
                $OP['N'] .= '</div>' . DW_LF;
            }
        }
    }

    $ID  = $svID;
    $REV = $svREV;

    $ORDER = explode('-',tpl_getConf('sidebar_order'));
    
    foreach($ORDER as $Sb) {
        print $OP[$Sb] . DW_LF;
    }

    // print breadcrumbs
    if(tpl_getConf('breadcrumbs') == 'sidebar' or tpl_getConf('breadcrumbs') == 'both') {
        print '<div class="bc_sidebar">' . DW_LF;
        print '  <h1>'.$lang['breadcrumb'].'</h1>' . DW_LF;
        print '  <div class="breadcrumbs">' . DW_LF;

       ($conf['youarehere'] != 1) ? tpl_breadcrumbs() : tpl_youarehere();

        print '  </div>' . DW_LF;
        print '</div>' . DW_LF;
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
