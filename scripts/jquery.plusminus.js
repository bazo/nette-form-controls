(function( $ ) {
  $.fn.plusMinus = function(options) {

var settings = {
	min: -100000000,
	max:  100000000,
	step: 1,
	onChange: function(ui, value){
	    
	}
    };
    
    return this.each(function() {        
      if ( options ) { 
        $.extend( settings, options );
      }
      
      $this = $(this);
      
      var plusButton = $this.children('.plus');
      var minusButton = $this.children('.minus');
      var input = $this.children('input[type="hidden"]');
      
      var linkedElement = $this.data('linkedelement');
      var linkedProperty = $this.data('linkedproperty');
      
      plusButton.bind('click', function(){
	 var newValue = parseInt(input.val()) + parseInt(settings.step);
	 if(newValue > settings.max) newValue = settings.max;
	 input.val( newValue );
	 settings.onChange($this, newValue, linkedElement, linkedProperty);
      });
      
      minusButton.bind('click', function(){
	 var newValue = parseInt(input.val()) - parseInt(settings.step);
	 if(newValue > settings.max) newValue = settings.max;
	 input.val( newValue ); 
	 settings.onChange($this, newValue, linkedElement, linkedProperty);
      });
      return this;
    });
  };
})( jQuery );