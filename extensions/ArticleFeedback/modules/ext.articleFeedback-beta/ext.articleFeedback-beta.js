/*
 * Script for Article Feedback (beta)
 */

( function( $, mw ) {

$.articleFeedback = {
	'fn': {
		'updateRating': function() {
			$(this).find( 'label' ).removeClass( 'articleFeedback-rating-label-full' );
			var $label = $(this).find( 'label[for=' + $(this).find( 'input:radio:checked' ).attr( 'id' ) + ']' )
			if ( $label.length ) {
				$label
					.prevAll( 'label' )
						.add( $label )
							.addClass( 'articleFeedback-rating-label-full' )
							.end()
						.end()
					.nextAll( 'label' )
						.removeClass( 'articleFeedback-rating-label-full' );
				$(this).find( '.articleFeedback-rating-clear' ).show();
			} else {
				$(this).find( '.articleFeedback-rating-clear' ).hide();
			}
		},
		'build': function( context ) {
			context.$ui
				.addClass( 'articleFeedback articleFeedback-visibleWith-form' )
				// Append HTML
				.append( '\
<div class="articleFeedback-panel">\
	<div class="articleFeedback-buffer">\
		<div class="articleFeedback-switch articleFeedback-switch-report articleFeedback-visibleWith-form" rel="report"><msg key="report-switch-label" /></div>\
		<div class="articleFeedback-switch articleFeedback-switch-form articleFeedback-visibleWith-report" rel="form"><msg key="form-switch-label" /></div>\
		<div class="articleFeedback-title articleFeedback-visibleWith-form"><msg key="form-panel-title" /></div>\
		<div class="articleFeedback-title articleFeedback-visibleWith-report"><msg key="report-panel-title" /></div>\
		<div class="articleFeedback-instructions articleFeedback-visibleWith-form"><msg key="form-panel-instructions" /></div>\
		<div class="articleFeedback-description articleFeedback-visibleWith-report"><msg key="report-panel-description" /></div>\
		<div style="clear:both;"></div>\
		<div class="articleFeedback-ratings">\
			<div class="articleFeedback-rating articleFeedback-rating-new" rel="wellsourced">\
				<span class="articleFeedback-label" title-msg="field-wellsourced-tip"><msg key="field-wellsourced-label" /></span>\
				<div class="articleFeedback-rating-fields articleFeedback-visibleWith-form"><input type="radio" /><input type="radio" /><input type="radio" /><input type="radio" /><input type="radio" /></div>\
				<div class="articleFeedback-rating-labels articleFeedback-visibleWith-form"><label></label><label></label><label></label><label></label><label></label><div class="articleFeedback-rating-clear"></div></div>\
				<div class="articleFeedback-rating-meter articleFeedback-visibleWith-report"><div></div></div>\
			</div>\
			<div class="articleFeedback-rating articleFeedback-rating-new" rel="neutral">\
				<span class="articleFeedback-label" title-msg="field-neutral-tip"><msg key="field-neutral-label" /></span>\
				<div class="articleFeedback-rating-fields articleFeedback-visibleWith-form"><input type="radio" /><input type="radio" /><input type="radio" /><input type="radio" /><input type="radio" /></div>\
				<div class="articleFeedback-rating-labels articleFeedback-visibleWith-form"><label></label><label></label><label></label><label></label><label></label><div class="articleFeedback-rating-clear"></div></div>\
				<div class="articleFeedback-rating-meter articleFeedback-visibleWith-report"><div></div></div>\
			</div>\
			<div class="articleFeedback-rating articleFeedback-rating-new" rel="complete">\
				<span class="articleFeedback-label" title-msg="field-complete-tip"><msg key="field-complete-label" /></span>\
				<div class="articleFeedback-rating-fields articleFeedback-visibleWith-form"><input type="radio" /><input type="radio" /><input type="radio" /><input type="radio" /><input type="radio" /></div>\
				<div class="articleFeedback-rating-labels articleFeedback-visibleWith-form"><label></label><label></label><label></label><label></label><label></label><div class="articleFeedback-rating-clear"></div></div>\
				<div class="articleFeedback-rating-meter articleFeedback-visibleWith-report"><div></div></div>\
			</div>\
			<div class="articleFeedback-rating articleFeedback-rating-new" rel="readable">\
				<span class="articleFeedback-label" title-msg="field-readable-tip"><msg key="field-readable-label" /></span>\
				<div class="articleFeedback-rating-fields articleFeedback-visibleWith-form"><input type="radio" /><input type="radio" /><input type="radio" /><input type="radio" /><input type="radio" /></div>\
				<div class="articleFeedback-rating-labels articleFeedback-visibleWith-form"><label></label><label></label><label></label><label></label><label></label><div class="articleFeedback-rating-clear"></div></div>\
				<div class="articleFeedback-rating-meter articleFeedback-visibleWith-report"><div></div></div>\
			</div>\
			<div style="clear:both;"></div>\
		</div>\
		<button class="articleFeedback-submit articleFeedback-visibleWith-form" type="submit" disabled>Submit feedback</button>\
		<div style="clear:both;"></div>\
	</div>\
</div>\
<div class="articleFeedback-dialog" rel="survey">\
	<div class="articleFeedback-buffer">\
		<div class="articleFeedback-title">Take a survey?</div>\
	</div>\
</div>\
<div class="articleFeedback-dialog" rel="register">\
	<div class="articleFeedback-buffer">\
		<div class="articleFeedback-title">Create an account?</div>\
	</div>\
</div>\
<div class="articleFeedback-dialog" rel="edit">\
	<div class="articleFeedback-buffer">\
		<div class="articleFeedback-title">Edit a page?</div>\
	</div>\
</div>\
				' )
				.localize( { 'prefix': 'articlefeedback-beta-' } )
				.find( '[title]' )
					.tipsy( {
						'gravity': 'nw',
						'center': false,
						'fade': true,
						'delayIn': 300,
						'delayOut': 100
					} )
					.end()
				// Buttonify the button
				.find( '.articleFeedback-submit' )
					.button()
					.end()
				// Hide report elements initially
				.find( '.articleFeedback-visibleWith-report' )
					.hide()
					.end()
				// Connect labels and fields
				.find( '.articleFeedback-rating' )
					.each( function() {
						var rel = $(this).attr( 'rel' );
						$(this)
							.find( '.articleFeedback-rating-fields input' )
								.attr( 'name', rel )
								.each( function( i ) {
									$(this)
										.val( i + 1 )
										.attr(
											'id',
											'articleFeedback-rating-field-' + rel + '-' + ( i + 1 )
										);
								} )
								.end()
							.find( '.articleFeedback-rating-labels label' )
								.each( function( i ) {
									$(this)
										.attr(
											'for',
											'articleFeedback-rating-field-' + rel + '-' + ( i + 1 )
										);
								} );
					} )
					.end()
				// Setup switch behavior
				.find( '.articleFeedback-switch' )
					.click( function( e ) {
						context.$ui
							.find( '.articleFeedback-visibleWith-' + $(this).attr( 'rel' ) )
								.show()
								.end()
							.find( '.articleFeedback-switch' )
								.not( $(this) )
								.each( function() {
									context.$ui
										.find( '.articleFeedback-visibleWith-' + $(this).attr( 'rel' ) )
										.hide();
								} );
						e.preventDefault();
						return false;
					} )
					.end()
				// Setup rating behavior
				.find( '.articleFeedback-rating-labels label' )
					.hover(
						function() {
							$(this)
								.addClass( 'articleFeedback-rating-label-hover' )
								.prevAll( 'label' )
									.andSelf()
										.addClass( 'articleFeedback-rating-label-full' );
						},
						function() {
							$(this).removeClass( 'articleFeedback-rating-label-hover' );
							$.articleFeedback.fn.updateRating.call(
								$(this).closest( '.articleFeedback-rating' )
							);
						}
					)
					.mousedown( function() {
						$( '.articleFeedback-submit' ).button( { 'disabled': false } );
						$(this)
							.addClass( 'articleFeedback-rating-label-down' )
							.nextAll()
								.removeClass( 'articleFeedback-rating-label-full' )
								.end()
							.parent()
								.find( '.articleFeedback-rating-clear' )
									.show();
					} )
					.mouseup( function() {
						$(this).removeClass( 'articleFeedback-rating-label-down' );
					} )
					.end()
				.find( '.articleFeedback-rating-clear' )
					.click( function() {
						$(this).hide();
						var $rating = $(this).closest( '.articleFeedback-rating' );
						$rating.find( 'input:radio' ).attr( 'checked', false );
						$.articleFeedback.fn.updateRating.call( $rating );
					} );
		}
	}
};

$.fn.articleFeedback = function( method, data ) {
	$(this).each( function() {
		var context = $(this).data( 'articleFeedback-context' );
		if ( !context ) {
			// Create context
			context = { '$ui': $(this) };
			// Build user interface
			$.articleFeedback.fn.build( context );
			// Save context
			$(this).data( 'articleFeedback-context', context );
		}
		// Proceed with handling input
	} );
	return $(this);
};

} )( jQuery, mediaWiki );

$( '#catlinks' ).before( $( '<div></div>' ).articleFeedback() );
