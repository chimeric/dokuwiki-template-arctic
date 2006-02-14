<?php
/**
 * functions for arctic template
 *
 * License: GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @version: 0.6 2005-01-18
 * 
 * @author:         Michael Klier <chi@chimeric.de>
 * @homepage:       http://www.chimeric.de
 */

require_once('conf.php');

/**
 * displays the toplinks
 *
 * @author Michael Klier <chi@chimeric.de>
 */
function tpl_topbar() {
    global $INFO,$ID,$REV,$lang,$conf;
    $perm = $INFO['perm'];
    $sSep = $conf['tpl_arctic']['tb_link_separator'];
    $EDITID = ($REV) ? $ID.'&amp;rev='.$REV : $ID;
  
    $aAction = array(
        "recent"    => '<a href="?do=recent" class="interwiki" title="'.$lang['btn_rec'].'" accesskey="R">'.$lang['btn_recent'].'</a>',
        "profile"   => '<a href="?do=profile" class="interwiki" title="'.$lang['btn_profile'].'">'.$lang['btn_profile'].'</a>',
        "revisions" => '<a href="?id='.$ID.'&amp;do=revisions" class="interwiki" title="'.$lang['btn_revs'].'" accesskey="O">'.$lang['btn_revs'].'</a>',
        "edit"      => '<a href="?id='.$EDITID.'&amp;do=edit" class="interwiki" title="'.$lang['btn_edit'].'" accesskey="E">'.$lang['btn_edit'].'</a>',
        "create"    => '<a href="?id='.$ID.'&amp;do=edit" class="interwiki" title="'.$lang['btn_create'].'" accesskey="E">'.$lang['btn_create'].'</a>',
        "source"    => '<a href="?id='.$ID.'&amp;do=edit" class="interwiki" title="'.$lang['btn_source'].'" accesskey="V">'.$lang['btn_source'].'</a>',
        "admin"     => '<a href="?do=admin" class="interwiki" title="'.$lang['btn_admin'].'">'.$lang['btn_admin'].'</a>',
        "index"     => '<a href="?do=index" class="interwiki" title="'.$lang['btn_index'].'" accesskey="X">'.$lang['btn_index'].'</a>',
        "logout"    => '<a href="?do=logout" class="interwiki" title="'.$lang['btn_logout'].'">'.$lang['btn_logout'].'</a>',
        "login"     => '<a href="?do=login" class="interwiki" title="'.$lang['btn_login'].'">'.$lang['btn_login'].'</a>'
        );
    
    // show the links in the preffered order 
    foreach($conf['tpl_arctic']['action_order'] as $action) {
        switch($action) {
            case('edit_create_source'):
                if($perm > AUTH_READ) {
                    if(file_exists(wikiFN($ID))) {
                        $sTopbar .= $aAction['edit'].$sSep;
                    } else {
                        $sTopbar .= $aAction['create'].$sSep;
                    }
                } else {
                    $sTopbar .= $aAction['source'].$sSep;
                }
                break;

            case('admin'):
                if($perm > AUTH_EDIT) $sTopbar .= $aAction[$action].$sSep;
                break;

            case('index'):
                if($perm > AUTH_EDIT) $sTopbar .= $aAction[$action].$sSep;    
                break;
                
            case('revisions'):
                if($perm > AUTH_READ) $sTopbar .= $aAction[$action].$sSep;
                break;
                
            case('profile'):
                if(isset($INFO['userinfo']['name'])) $sTopbar .= $aAction[$action].$sSep;
                break;

            case('login_logout'):
                if(isset($INFO['userinfo']['name'])) {
                    $sTopbar .= $aAction['logout'].$sSep;
                } else {
                    $sTopbar .= $aAction['login'].$sSep;
                }
                break;
                
            default:
                $sTopbar .= $aAction[$action].$sSep;
                break;     
        }
    }
   
    print (preg_replace("/$sSep$/", "",($sTopbar)));
}

/**
 * fetches the sidebar-pages and displays the sidebar
 * 
 * @author Michael Klier <chi@chimeric.de>
 */
function tpl_sidebar() {
    global $conf, $ID, $REV, $INFO,$lang;
   
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
        html_index('.');
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
    
    foreach($conf['tpl_arctic']['sidebar_order'] as $Sb) {
        if($Sb == 'bcr') {
            if($conf['tpl_arctic']['breadcrumbs'] && $conf['tpl_arctic']['breadcrumbs_sb']) {
                echo '<div class="bc_sidebar"><h1>'.$lang['breadcrumb'].'</h1><div class="breadcrumbs">';
                if($conf['tpl_arctic']['youarehere']) {
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

    $ID = $svID;
    $REV = $svREV;
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
?>
