Church Theme Content (WordPress Plugin)
=============================

A WordPress plugin from [churchthemes.com](https://churchthemes.com) providing compatible themes with church-related post types, taxonomies and fields.

Why the Fork?
-------------

A client was needing help to exclude dates from recurring events. After searching for a solution and even looking into the premium plugin for [Custom Recurring Events](https://churchthemes.com/plugins/custom-recurring-events/) and still not finding a solution, it was decided that a solution needed to be created and support added. It was also required that a Fork of ct-meta-box was also needed for adding a customized field type for the MultiDatesPicker. The Fork can be found at [https://github.com/amaster507/ct-meta-box](https://github.com/amaster507/ct-meta-box).

Further Requirements:
---------------------

* Theme Support: (usually /includes/support-ctc.php:67) CTC requires theme's support before showing fields in meta-boxes. You will need to add `_ctc_event_recurrence_exclude_dates` to your theme support-ctc.php file. Add the element as a string to the `add_theme_support( 'ctc-events' , ... ` function. See the following example:

```php

add_theme_support( 'ctc-events', array(
	//...
	'fields' => array(
		//...
		'_ctc_event_recurrence_exclude_dates', //ADD THIS ELEMENT
		//...
	),
	//...
	)
) );

```

* Theme FunctionS: (usually /framework/includes/events.php:138,711) find where and if your theme calls `ctfw_get_meta_data` usually inside of a function `ctfw_event_data` there is an array of elements passed to the ctfw_get_meta_data function and `recurrence_exclude_dates` needds to be added. Usually in the same file there is a call to the function `get_dates`    . See the following example:

```php

function ctfw_event_data( $args = array() ) {
	//...
	$meta = ctfw_get_meta_data( array(
		//...
		'recurrence_exclude_dates',	//ADD THIS ELEMENT
    //...
	), $post_id );
  //...
}

//...

function ctfw_event_calendar_data( $args ) {
  //...
  if ( $args['get_events'] ) {
    //...
    foreach ( $events as $event ) {
      //...
      if ( $event_data['recurrence'] && $event_data['recurrence'] != 'none' ) {
        //...
        $recurrence_args = array(
          //...
          'exclude_dates'	=> $event_data['recurrence_exclude_dates'],	//ADD THIS ELEMENT
          //...
        );
        //...
      }
      //...
    }
    //...
  }
  //...
}

```

Purpose
-------

Church Theme Content provides functionality enabling the user to manage *sermons*, *events*, *people* and *locations* to be displayed by a compatible theme.

Experienced WordPress developers agree that functionality like this does not belong in themes since themes are intended only to control the appearance of a WordPress site. Content that users might expect to take with them if they switch themes should "live" in a plugin. Similarly, our approach is not to display content using the plugin since themes offer more control for that purpose.

For more information:

* [View on churchthemes.com](https://churchthemes.com/plugins/church-theme-content/)
* [View on WordPress.org](http://wordpress.org/plugins/church-theme-content)

For a list of official and third-party compatible themes, see [Best Church WordPress Themes](https://churchthemes.com/best-church-wordpress-themes/).

Developers
----------

The Church Theme Content plugin was made in a way that other church theme developers can take advantage of it. A couple benefits are that you will save time and be helping to accomplish better data portability among church websites powered by WordPress.

Visit the [Developer Guide](https://churchthemes.com/guides/developer/church-theme-content/) on churchthemes.com for instructions and example code.
