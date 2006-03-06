<?php
/**
 * License: GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * 
 * configuration file for template "arctic"
 * 
 * @author:         Michael Klier <chi@chimeric.de> 
 * @homepage:       http://www.chimeric.de
 */

$conf['tpl_arctic']['enable_sidebar']       = true;                     // enable/disable sidebar
$conf['tpl_arctic']['position']             = 0;                        // 0=sidebar left 1=sidebar right
$conf['tpl_arctic']['pagename']             = 'sidebar';                // the pagename for sidebars inside namespaces
$conf['tpl_arctic']['user_sidebar']         = true;                     // let users have their own sidebar
$conf['tpl_arctic']['user_sidebarns']       = 'users';                  // namespace to look for namespace of logged in users
$conf['tpl_arctic']['group_sidebar']        = true;                     // let groups have shared sidebars
$conf['tpl_arctic']['group_sidebarns']      = 'groups';                 // namespace to look for groups-namespaces
$conf['tpl_arctic']['namespace_sidebar']    = true;                     // enable/disable namespace-sidebars

$conf['tpl_arctic']['breadcrumbs']          = true;                     // show the trace
$conf['tpl_arctic']['breadcrumbs_top']      = true;                     // show trace on top
$conf['tpl_arctic']['breadcrumbs_sb']	      = false;                    // show trace inside sidebar

$conf['tpl_arctic']['actionlink_separator'] = '&nbsp;&middot;&nbsp;';   // string to seperate the topbar-links
$conf['tpl_arctic']['use_buttons']          = false;                    // use buttons instead of links

// define the order of the sidebars
$conf['tpl_arctic']['sidebar_order']        = array( 
                                                'uSb',  // UserSidebars
                                                'gSb',  // GroupSidebars
                                                'nSb',  // NamespaceSidebars
                                                'mSb',  // MainSidebar 
                                                'bcr'   // Breadcrumbs
                                                );  

//Setup vim: ts=2 sw=2:
?>
