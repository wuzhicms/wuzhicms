$(function(){
	$( '.indexNav' ).each(function(){
		$( this ).click(function(){
			var divCss =  $(this).find( '.index-nav-open' ).css( 'display' );
			var textCss = $(this).find( '.subtitle' ).css( 'display' );
			if( 'none' == divCss && 'inline' == textCss )
			{
				$(this).find( '.index-nav-open' ).show();
				$(this).find( '.subtitle' ).hide();
				$( this ).find( 'div:first' ).removeClass( 'index-nav-close' );
				$( this ).find( 'div:first' ).addClass( 'index-switch-on' );
			}
			else
			{
				$(this).find( '.index-nav-open' ).hide();
				$(this).find( '.subtitle' ).show()
				$( this ).find( 'div:first' ).removeClass( 'index-switch-on' );
				$( this ).find( 'div:first' ).addClass( 'index-nav-close' );
			}
		});
		
	});
});