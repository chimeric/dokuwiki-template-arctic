<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
/**
 * DokuWiki Arctic Template
 *
 * This is the template you need to change for the overall look
 * of DokuWiki.
 *
 * You should leave the doctype at the very top - It should
 * always be the very first line of a document.
 *
 * @link   http://wiki.splitbrain.org/wiki:tpl:templates
 * @author Andreas Gohr <andi@splitbrain.org>
 * additional editing by
 * @author Michael Klier <chi@chimeric.de>
 * @link   http://chimeric.de/wiki/dokuwiki/templates/arctic/
 *
 * Setup vim: ts=2 sw=2:
 */

 require_once(dirname(__FILE__).'/tpl_functions.php');
 $sep = $conf['tpl_arctic']['actionlink_separator'];
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang']?>"
 lang="<?php echo $conf['lang']?>" dir="<?php echo $lang['direction']?>">
<head>
  <title><?php tpl_pagetitle()?> [<?php echo hsc($conf['title'])?>]</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <?php tpl_metaheaders()?>

  <link rel="shortcut icon" href="<?php echo DOKU_TPL?>images/favicon.ico" />

  <?php /*old includehook*/ @include(dirname(__FILE__).'/meta.html')?>
</head>

<body>
<?php /*old includehook*/ @include(dirname(__FILE__).'/topheader.html')?>
<div class="dokuwiki">

  <?php html_msgarea()?>

  <div class="stylehead">
    <div class="header">
      <div class="pagename">
        [[<?php tpl_link(wl($ID,'do=backlink'),$ID)?>]]
      </div>
      <div class="logo">
        <?php tpl_link(wl(),$conf['title'],'name="top" accesskey="h" title="[ALT+H]"')?>
      </div>
    </div>
  
    <?php if($conf['tpl_arctic']['breadcrumbs'] && $conf['tpl_arctic']['breadcrumbs_top']) {?> 
    <div style="margin-left:10px;margin-bottom:3px;margin-top:3px;"><?php tpl_breadcrumbs()?> </div>
    <?php } ?>

    <?php /*old includehook*/ @include(dirname(__FILE__).'/header.html')?>
    </div>

    <div id="bar_top">
        <div class="bar">
          <div class="bar-left">
            <?php 
              if($conf['tpl_arctic']['use_buttons']) { 
                tpl_button('edit');
                tpl_button('history');     
              } else {
                tpl_actionlink('edit');
                print ($sep);
                tpl_actionlink('history');
              } 
            ?>
          </div>
          <div class="bar-right">
            <?php
              if($conf['tpl_arctic']['use_buttons']) {
                if(!$conf['tpl_arctic']['enable_sidebar']) tpl_searchform();
                tpl_button('admin');
                tpl_button('profile');
                tpl_button('recent');
                tpl_button('index');
                tpl_button('login');
              } else {
                if(!$conf['tpl_arctic']['enable_sidebar']) tpl_searchform();
                tpl_actionlink('admin');
                if(auth_quickaclcheck($ID) == 255) print ($sep);
                tpl_actionlink('profile');
                if(isset($INFO['userinfo']['name'])) print ($sep);
                tpl_actionlink('recent');
                print ($sep);
                tpl_actionlink('index');
                print ($sep);
                tpl_actionlink('login');
              }
            ?>
          </div>
      </div>
  </div>

  <?php flush()?>

  <?php /*old includehook*/ @include(dirname(__FILE__).'/pageheader.html')?>

  <?php if($conf['tpl_arctic']['enable_sidebar']) { ?>
    <?php if($conf['tpl_arctic']['position'] == 0) { ?>

      <?php if($ACT != 'diff' && $ACT != 'edit' && $ACT != 'preview') { ?>
        <div class="left_sidebar">
          <?php tpl_searchform() ?>
          <?php tpl_sidebar() ?>
        </div>
        <div class="right_page">
          <?php tpl_content()?>
        </div>
      <? } else { ?>
        <div class="page">
          <?php tpl_content()?> 
        </div> 
      <? } ?>

    <?php } else { ?>

      <?php if($ACT != 'diff' && $ACT != 'edit' && $ACT != 'preview') { ?>
        <div class="left_page">
          <?php tpl_content()?>
        </div>
        <div class="right_sidebar">
          <?php tpl_searchform() ?>
          <?php tpl_sidebar() ?>
        </div>
      <? } else { ?>
        <div class="page">
          <?php tpl_content()?> 
        </div> 
      <? } ?>

    <?php } ?>

  <?php } else { ?>

    <div class="page">
    <!-- wikipage start -->
      <?php tpl_content() ?>
    <!-- wikipage stop -->
    </div>

  <?php } ?>

  <div class="clearer">&nbsp;</div>

  <?php flush()?>

  <div class="stylefoot">
    <div class="meta">
      <div class="user">
        <?php tpl_userinfo()?>
      </div>
      <div class="doc">
        <?php tpl_pageinfo()?>
      </div>
    </div>
  </div>

  <div id="bar_bottom">
    <div class="bar">
      <div class="bar-left">
        <?php 
          if($conf['tpl_arctic']['use_buttons']) {
              tpl_button('edit');
              tpl_button('history');
          } else {
              tpl_actionlink('edit');
              print ($sep);
              tpl_actionlink('history');
          }
        ?>
      </div>
      <div class="bar-right">
        <?php 
          if($conf['tpl_arctic']['use_buttons']) {
              tpl_button('subscription');
              tpl_button('top');
          } else {
              tpl_actionlink('subscription');
              if(isset($INFO['userinfo']['name']) && $ACT == 'show') print ($sep);
              tpl_actionlink('top');
          }
        ?>
      </div>
    </div>
  </div>


<?php /*old includehook*/ @include(dirname(__FILE__).'/footer.html')?>
</div>

<div class="no"><?php tpl_indexerWebBug()?></div>

</body>
</html>
