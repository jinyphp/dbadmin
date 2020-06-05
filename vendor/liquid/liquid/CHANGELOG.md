## master

## 1.4.8 (2018-03-22)

 * Now we return null for missing properties, like we do for missing keys for arrays.

## 1.4.7 (2018-02-09)

 * Paginate tag shall now respect request parameters.
 * It is now possible to set a custom query param for the paginate tag.
 * Page number will now never go overboard.

## 1.4.6 (2018-02-07)

 * TagPaginate shall not pollute the global scope, but work in own scope.
 * TagPaginate errors if no collection present instead of vague warning.

## 1.4.5 (2017-12-12)

 * Capture tag shall save a variable in the global context.

## 1.4.4 (2017-11-03)

 * TagUnless is an inverted TagIf: simplified implementation
 * Allow dashes in filenames

## 1.4.3 (2017-10-10)

 * `escape` and `escape_once` filters now escape everything, but arrays
 * New standard filter for explicit string conversion

## 1.4.2 (2017-10-09)

 * Better caching for non-extending templates
 * Simplified 'assign' tag to use rules for variables
 * Now supporting PHP 7.2
 * Different types of exception depending on the case
 * Filterbank will not call instance methods statically
 * Callback-type filters

## 1.4.1 (2017-09-28)

 * Unquoted template names in 'include' tag, as in Jekyll
 * Caching now works correctly with 'extends' tag

## 1.4.0 (2017-09-25)

 * Dropped support for EOL'ed versions of PHP (< 5.6)
 * Arrays won't be silently cast to string as 'Array' anymore
 * Complex objects could now be passed between templates and to filters
 * Additional test coverage

## 1.3.1 (2017-09-23)

 * Support for numeric and variable array indicies
 * Support loop break and continue
 * Allow looping over extended ranges
 * Math filters now work with floats
 * Fixed 'default' filter
 * Local cache with data stored in a private variable
 * Virtual file system to get inversion of control and DI
 * Lots of tests with the coverage upped to 97%
 * Small bug fixes and various enhancements

## 1.3.0 (2017-07-17)

 * Support Traversable loops and filters
 * Fix date filter for format with colon
 * Various minor improvements and bugs fixes

## 1.2.1 (2016-12-12)

 * Remove content injection from $_GET.
 * Add PHP 5.6, 7.0, 7.1 to Travis file.

## 1.2 (2016-06-11)

 * Added "ESCAPE_BY_DEFAULT" setting for context-aware auto-escaping.
 * Made "Context" work with plain objects.
 * "escape" now uses "htmlentities".
 * Fixed "escape_now".

## 1.1 (2015-06-01)

 * New tags: "paginate", "unless", "ifchanged" were added
 * Added support for "for in (range)" syntax
 * Added support for multiple conditions in if statements
 * Added support for hashes/objects in for loops

## 1.0 (2014-09-07)

 * Add namespaces
 * Add composer support
 * Implement new standard filters
 * Add 'raw' tag

## 0.9.2 (2012-08-15)

 * context->set allows now global vars
 * Allow Templatenames with Fileextension
 * Tag 'extends' supports now multiple inheritance
 * Clean up code, change all variables and methods to camelCase

## 0.9.1 (2012-05-12)

 * added the extends and block filter
 * Initial release
