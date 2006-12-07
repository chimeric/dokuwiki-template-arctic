<?php
/**
 * functions for arctic template
 *
 * License: GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @author:         Michael Klier <chi@chimeric.de>
 * @homepage:       http://www.chimeric.de
 */

if(!defined('DOKU_LF')) define('DOKU_LF',"\n");

/**
 * fetches the sidebar-pages and displays the sidebar
 * 
 * @author Michael Klier <chi@chimeric.de>
 */
function tpl_sidebar() {
    global $conf, $ID, $REV, $INFO, $lang;
   
    $out   = array(); 
    $SbPn  = tpl_getConf('pagename');
    $uSbNs = tpl_getConf('user_sidebar_namespace');
    $gSbNs = tpl_getConf('group_sidebar_namespace');
    $mSb   = $SbPn;
    
    $svID  = $ID;
    $svREV = $REV;

    if(tpl_getConf('toc2sidebar')) {
        $meta = p_get_metadata($svID);
        $toc  = $meta['description']['tableofcontents'];
        if(count($toc) >= 3) {
            $out['T'] .= '<div class="t_sidebar">' . DOKU_LF;
            $out['T'] .= p_toc_xhtml($toc);
            $out['T'] .= '</div>' . DOKU_LF;
        }
    }

    if(@file_exists(wikiFN($mSb)) && auth_quickaclcheck($mSb)) { 
        $out['M'] .= '<div class="m_sidebar">' . DOKU_LF;
        $out['M'] .= '  ' . p_sidebar_xhtml($mSb) . DOKU_LF;
        $out['M'] .= '</div>';
    } else {
        print '<div class="i_sidebar">' . DOKU_LF;
        print '  ' . html_index($svID) . DOKU_LF;
        print '</div>';
    }

    if(isset($INFO['userinfo']['name'])) {
        if(tpl_getConf('user_sidebar')) {
            $uSb = $uSbNs . ':' . $_SERVER['REMOTE_USER'] . ':' . $SbPn; 
            if(@file_exists(wikiFN($uSb))) {
                $out['U'] .= '<div class="u_sidebar">' . DOKU_LF;
                $out['U'] .= '  ' . p_sidebar_xhtml($uSb) . DOKU_LF;
                $out['U'] .= '</div>' . DOKU_LF;
            }
        }
        if(tpl_getConf('group_sidebar')) {
            foreach($INFO['userinfo']['grps'] as $grp) {
                $gSb = $gSbNs.':'.$grp.':'.$SbPn;
                if(@file_exists(wikiFN($gSb)) && auth_quickaclcheck($gSb)) {
                    $out['G'] .= '<div class="g_sidebar">' . DOKU_LF;
                    $out['G'] .= '  ' . p_sidebar_xhtml($gSb) . DOKU_LF;
                    $out['G'] .= '</div>' . DOKU_LF;
                }
            }
        
        }
    }
    
    if(tpl_getConf('namespace_sidebar')) {
        if(!preg_match("/".$uSbNs."|".$gSbNs."/", $svID)) {
            $path  = explode(':', $svID);
            $nSb   = '';
            $found = false;
            while(!$found && count($path) > 0) {
                $nSb   = implode(':', $path).':'.$SbPn;
                $found = @file_exists(wikiFN($nSb));
                array_pop($path);
            }
            if($found && auth_quickaclcheck($nSb)) {
                $out['N'] .= '<div class="ns_sidebar">' . DOKU_LF;
                $out['N'] .= '  ' . p_sidebar_xhtml($nSb) . DOKU_LF;
                $out['N'] .= '</div>' . DOKU_LF;
            }
        }
    }

    $ID  = $svID;
    $REV = $svREV;

    $ORDER = explode('-',tpl_getConf('sidebar_order'));
    
    foreach($ORDER as $Sb) {
        print $out[$Sb] . DOKU_LF;
    }

    // print breadcrumbs
    if(tpl_getConf('breadcrumbs') == 'sidebar' or tpl_getConf('breadcrumbs') == 'both') {
        print '<div class="bc_sidebar">' . DOKU_LF;
        print '  <h1>'.$lang['breadcrumb'].'</h1>' . DOKU_LF;
        print '  <div class="breadcrumbs">' . DOKU_LF;

       ($conf['youarehere'] != 1) ? tpl_breadcrumbs() : tpl_youarehere();

        print '  </div>' . DOKU_LF;
        print '</div>' . DOKU_LF;
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

/**
 * renders the TOC, copies render_TOC from 
 * <dokuwiki>/inc/parser/xhtml.php
 *
 * @author Andreas Gohr <andi@splitbrain.org>
 */
function p_toc_xhtml($toc) {
    global $lang;

    $out  = '';
    $out  = '<div class="toc">'.DOKU_LF;
    $out .= '<div class="tocheader toctoggle" id="sb_toc__header">';
    $out .= $lang['toc'];
    $out .= '</div>'.DOKU_LF;
    $out .= '<div id="sb_toc__inside">'.DOKU_LF;
    $out .= html_buildlist($toc,'toc','_tocitem');
    $out .= '</div>'.DOKU_LF.'</div>'.DOKU_LF;

    return ($out);
}

/**
 * callback function for html_buildlist
 */
function _tocitem($item) {
    return '<span class="li"><a href="#'.$item['hid'].'" class="toc">'.htmlspecialchars($item['title']).'</a></span>';
}

//Setup vim: ts=4 sw=4:
?>
