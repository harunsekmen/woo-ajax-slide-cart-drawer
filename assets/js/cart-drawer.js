(function($) {
  'use strict';
  window.WASCD = {
    open: function() { $('#wascd-cart-overlay').addClass('active').show(); $('#wascd-cart-drawer').addClass('active').attr('aria-hidden', 'false'); },
    close: function() { $('#wascd-cart-overlay').removeClass('active').hide(); $('#wascd-cart-drawer').removeClass('active').attr('aria-hidden', 'true'); }
  };
  $(document).ready(function() {
    $('.wascd-close, #wascd-cart-overlay').on('click', WASCD.close);
    $(document.body).on('added_to_cart', WASCD.open);
  });
})(jQuery);
