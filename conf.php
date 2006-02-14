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
$conf['tpl_arctic']['pagename']             = 'sidebar';                // the pagename for sidebars inside namespaces
$conf['tpl_arctic']['user_sidebar']         = true;                     // let users have their own sidebar
$conf['tpl_arctic']['user_sidebarns']       = 'users';                  // namespace to look for namespace of logged in users
$conf['tpl_arctic']['group_sidebar']        = true;                     // let groups have shared sidebars
$conf['tpl_arctic']['group_sidebarns']      = 'groups';                 // namespace to look for groups-namespaces
$conf['tpl_arctic']['namespace_sidebar']    = true;                     // enable/disable namespace-sidebars

$conf['tpl_arctic']['breadcrumbs']          = true;                     // show the trace
$conf['tpl_arctic']['breadcrumbs_top']      = true;                     // show trace on top
$conf['tpl_arctic']['breadcrumbs_sb']	    = false;                    // show trace inside sidebar
$conf['tpl_arctic']['youarehere']           = false;                    // use you-are-here-styled trace
$conf['tpl_arctic']['position']             = 0;                        // 0=sidebar left 1=sidebar right
$conf['tpl_arctic']['tb_link_separator']    = '&nbsp;&middot;&nbsp;';   // string to seperate the topbar-links

// define the order of the sidebars
$conf['tpl_arctic']['sidebar_order']        = array( 
                                                'mSb',  // MainSidebar 
                                                'nSb',  // NamespaceSidebars
                                                'gSb',  // GroupSidebars
                                                'uSb',  // UserSidebars
                                                'bcr'   // Breadcrumbs
                                                );  

//define the order of the action-links                                                           
$conf['tpl_arctic']['action_order']         = array( 
                                                'profile',              // update profile (devel only!)
                                                'recent',
                                                'revisions',
                                                'edit_create_source',
                                                'admin',
                                                'index',
                                                'login_logout'
                                                );

//Setup: vim enc=utf-8 tb=4
?>
