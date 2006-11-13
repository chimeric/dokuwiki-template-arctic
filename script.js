/**
 * javascript functionality for the arctic template
 * copies the mothod for dokuwikis TOC functionality
 * in order to keep the template XHTML valid
 */

/**
 * Adds the toggle switch to the TOC
 */
function addSbTocToggle() {
    if(!document.getElementById) return;
    var header = $('sb_toc__header');
    if(!header) return;

    var showimg     = document.createElement('img');
    showimg.id      = 'toc__show';
    showimg.src     = DOKU_BASE+'lib/images/arrow_down.gif';
    showimg.alt     = '+';
    showimg.onclick = toggleSbToc;
    showimg.style.display = 'none';

    var hideimg     = document.createElement('img');
    hideimg.id      = 'toc__hide';
    hideimg.src     = DOKU_BASE+'lib/images/arrow_up.gif';
    hideimg.alt     = '-';
    hideimg.onclick = toggleSbToc;

    prependChild(header,showimg);
    prependChild(header,hideimg);
}

/**
 * This toggles the visibility of the Table of Contents
 */
function toggleSbToc() {
  var toc = $('sb_toc__inside');
  var showimg = $('toc__show');
  var hideimg = $('toc__hide');
  if(toc.style.display == 'none') {
    toc.style.display      = '';
    hideimg.style.display = '';
    showimg.style.display = 'none';
  } else {
    toc.style.display      = 'none';
    hideimg.style.display = 'none';
    showimg.style.display = '';
  }
}

// add events on init
addInitEvent(addSbTocToggle);
