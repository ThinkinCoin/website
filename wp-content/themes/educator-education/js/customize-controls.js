( function( api ) {

	// Extends our custom "educator-education" section.
	api.sectionConstructor['educator-education'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );