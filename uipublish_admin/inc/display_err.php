<?
// $Id: display_err.php,v 1.3 2002/03/12 02:58:15 chavan Exp $


/* Description:   Display Error Message 
 * List of functions:
 *   display_err()
 */

/* FUNCTION: display_err
 * Print out an error message if something goes wrong
 * In most cases follow this function with an exit statement
 * Usage: display_err("your message here")
 */

function display_err ($mesg) {
    global $contact_mesg;
    $string = "<h2>Sorry</h2><p>" . $mesg . "</p><p>" 
      . $contact_mesg . "</p>";
    return $string;
}

?>

