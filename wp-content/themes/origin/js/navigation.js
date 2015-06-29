/**
 * Handles toggling the navigation menu for small screens.
 */

(function ($) {

    // Site Menu 
    var site_nav, site_button, site_menu;
    
    // Article Menu 
    var article_nav, article_button, article_menu;
    
    site_nav = $(".site-navigation");
    article_nav = $(".article-navigation");

    if (!site_nav || !article_nav) 
        return;

    site_button = $(".menu-toggle:first", site_nav); 
    article_button = $(".menu-article-toggle:first", article_nav);  
    
    site_menu = $("ul:first", site_nav);
    article_menu = $("ul:first", article_nav);
  
    if (!site_button || !article_button) 
        return;
        
      if (!site_menu.length || !site_menu.children().length) {
            site_button.hide();
            return;
        }
   
    
    site_button.click(function() {
        site_menu.toggleClass('nav-site-menu');
        
        if(!site_button.hasClass('toggled-on')){
	        site_button.removeClass('toggled-on');
	        site_menu.removeClass('toggled-on');
        } else {
	        site_menu.addClass('toggled-on');
	        site_button.addClass('toggled-on');
        }
    });
    
    article_button.click(function() {
	    article_menu.toggleClass('nav-article-menu');
        
        if(!article_button.hasClass('toggled-on')){
	        article_button.removeClass('toggled-on');
	        article_menu.removeClass('toggled-on');
        } else {
	        article_menu.addClass('toggled-on');
	        article_button.addClass('toggled-on');
        }
    });
    
    
})(jQuery);