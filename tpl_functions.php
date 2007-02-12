<?php
/**
 * DokuWiki Template Arctic Functions
 *
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author  Michael Klier <chi@chimeric.de>
 */

if(!defined('DOKU_LF')) define('DOKU_LF',"\n");

/**
 * Prints the sidebars
 * 
 * @author Michael Klier <chi@chimeric.de>
 */
function tpl_sidebar($pos) {

    $sb_order   = ($pos == 'left') ? explode(',', tpl_getConf('left_sidebar_order'))   : explode(',', tpl_getConf('right_sidebar_order'));
    $sb_content = ($pos == 'left') ? explode(',', tpl_getConf('left_sidebar_content')) : explode(',', tpl_getConf('right_sidebar_content'));

    // process contents by given order
    foreach($sb_order as $sb) {
        if(in_array($sb,$sb_content)) {
            $key = array_search($sb,$sb_content);
            unset($sb_content[$key]);
            tpl_sidebar_dispatch($sb,$pos);
        }
    }

    // check for left content not specified by order
    if(is_array($sb_content) && !empty($sb_content) > 0) {
        foreach($sb_content as $sb) {
            tpl_sidebar_dispatch($sb,$pos);
        }
    }
}

/**
 * Dispatches the given sidebar type to return the right content
 *
 * @author Michael Klier <chi@chimeric.de>
 */
function tpl_sidebar_dispatch($sb,$pos) {
    global $lang;
    global $conf;
    global $ID;
    global $REV;
    global $INFO;

    $svID  = $ID;   // save current ID
    $svREV = $REV;  // save current REV 

    $pname   = tpl_getConf('pagename');

    switch($sb) {

        case 'main':
            $main_sb = $pname;
            if(@file_exists(wikiFN($main_sb)) && auth_quickaclcheck($main_sb) >= AUTH_READ) {
                print '<div class="main_sidebar sidebar_box">' . DOKU_LF;
                print p_sidebar_xhtml($main_sb) . DOKU_LF;
                print '</div>' . DOKU_LF;
            }
            break;

        case 'namespace':
            $user_ns = tpl_getConf('user_sidebar_namespace');
            $group_ns = tpl_getConf('group_sidebar_namespace');
            if(!preg_match("/".$user_ns."|".$group_ns."/", $svID)) { // skip group/user sidebars and current ID
                $path  = explode(':', $svID);
                $ns_sb = '';
                $found = false;
                while(!$found && count($path) > 0) {
                    $ns_sb = implode(':', $path).':'.$pname;
                    $found = @file_exists(wikiFN($ns_sb));
                    array_pop($path);
                }
                if($found && auth_quickaclcheck($ns_sb) >= AUTH_READ) {
                    print '<div class="namespace_sidebar sidebar_box">' . DOKU_LF;
                    print p_sidebar_xhtml($ns_sb) . DOKU_LF;
                    print '</div>' . DOKU_LF;
                }
            }
            break;

        case 'user':
            $user_ns = tpl_getConf('user_sidebar_namespace');
            if(isset($INFO['userinfo']['name'])) {
                $user_sb = $user_ns . ':' . $_SERVER['REMOTE_USER'] . ':' . $pname;
                if(@file_exists(wikiFN($user_sb))) {
                    print '<div class="user_sidebar sidebar_box">' . DOKU_LF;
                    print p_sidebar_xhtml($user_sb) . DOKU_LF;
                    print '</div>';
                }
            }
            break;

        case 'group':
            $group_ns = tpl_getConf('group_sidebar_namespace');
            if(isset($INFO['userinfo']['name'])) {
                foreach($INFO['userinfo']['grps'] as $grp) {
                    $group_sb = $group_ns.':'.$grp.':'.$pname;
                    if(@file_exists(wikiFN($group_sb)) && auth_quickaclcheck($group_sb) >= AUTH_READ) {
                        print '<div class="group_sidebar sidebar_box">' . DOKU_LF;
                        print p_sidebar_xhtml($group_sb) . DOKU_LF;
                        print '</div>' . DOKU_LF;
                    }
                }
            }
            break;

        case 'index':
            print '<div class="index_sidebar sidebar_box">' . DOKU_LF;
            print '  ' . html_index($svID) . DOKU_LF;
            print '</div>' . DOKU_LF;
            break;

        case 'toc':
            if(auth_quickaclcheck($svID) >= AUTH_READ) {
                $instructions = p_cached_instructions(wikiFN($svID));
                if(!empty($instructions)) {
                    foreach($instructions as $instruction) {
                        // ~~NOTOC~~ is set - do nothing
                        if($instruction[0] == 'notoc') return;
                    }
                }
                $meta = p_get_metadata($svID);
                $toc  = $meta['description']['tableofcontents'];
                if(count($toc) >= 3) {
                    print '<div class="toc_sidebar sidebar_box">' . DOKU_LF;
                    print p_toc_xhtml($toc);
                    print '</div>' . DOKU_LF;
                }
            }
            break;
        
        case 'toolbox':
            $actions = array('admin', 'edit', 'history', 'recent', 'backlink', 'subscription', 'index', 'login');

            print '<div class="toolbox_sidebar sidebar_box">' . DOKU_LF;
            print '  <div class="level1">' . DOKU_LF;
            print '    <ul>' . DOKU_LF;

            foreach($actions as $action) {
                if(!actionOK($action)) continue;
                if($action == 'admin' && auth_quickaclcheck($svID) != 255) continue;
                if($action == 'subscription' && !isset($_SERVER['REMOTE_USER'])) continue;
                print '     <li><div class="li">';
                tpl_actionlink($action);
                print '     </li>' . DOKU_LF;
            }

            print '  </div>' . DOKU_LF;
            print '</div>' . DOKU_LF;
            break;

        case 'trace':
            if(tpl_getConf('trace') == 'sidebar' or tpl_getConf('trace') == 'both') {
                print '<div class="trace_sidebar sidebar_box">' . DOKU_LF;
                print '  <h1>'.$lang['breadcrumb'].'</h1>' . DOKU_LF;
                print '  <div class="breadcrumbs">' . DOKU_LF;
               ($conf['youarehere'] != 1) ? tpl_breadcrumbs() : tpl_youarehere();
                print '  </div>' . DOKU_LF;
                print '</div>' . DOKU_LF;
            }
            break;

        case 'extra':
            print '<div class="extra_sidebar sidebar_box">' . DOKU_LF;
            @include(dirname(__FILE__).'/' . $pos .'_sidebar.html');
            print '</div>' . DOKU_LF;
            break;

        default:
            // check for user defined sidebars
            if(@file_exists(DOKU_TPLINC.'sidebars/'.$sb.'/sidebar.php')) {
                print '<div class="'.$sb.'_sidebar sidebar_box">' . DOKU_LF;
                @require_once(DOKU_TPLINC.'sidebars/'.$sb.'/sidebar.php');
                print '</div>' . DOKU_LF;
            }
            break;
    }

    // restore ID and REV
    $ID  = $svID;
    $REV = $svREV;
}

/**
 * Removes the TOC of the sidebar pages and 
 * shows a edit button if the user has enough rights
 * 
 * @author Michael Klier <chi@chimeric.de>
 */
function p_sidebar_xhtml($sb) {
    $data = p_wiki_xhtml($sb,'',false);
    if(auth_quickaclcheck($sb) >= AUTH_EDIT) {
        $data .= '<div class="secedit">'.html_btn('secedit',$sb,'',array('do'=>'edit','rev'=>'','post')).'</div>';
    }
    return preg_replace('/<div class="toc">.*?(<\/div>\n<\/div>)/s', '', $data);
}


/**
 * Renders the TOC
 *
 * copy of render_TOC() located in /inc/parser/xhtml.php
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
 * Callback function for html_buildlist()
 */
function _tocitem($item) {
    return '<span class="li"><a href="#'.$item['hid'].'" class="toc">'.htmlspecialchars($item['title']).'</a></span>';
}

//Setup vim: ts=4 sw=4:
?>
