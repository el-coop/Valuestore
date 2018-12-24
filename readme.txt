El-Coop Valuestore - (based on spatie valuestore)

Install - composer require elcoop/valuestore

Docs:

Create Valuestore:

use ElCoop\Valuestore\Valuestore;

$valuestore = new Valuestore($filename);
// $filename has to be json, if the file doesnt exist one will be created.

Get All Values:

$all = $valuestore->all()
// $all is a $key => $value array.

Put New Value:

$valuestre->put($name,$value);
// $name has to be string.

Get New Value:

$value = $valuestore->get($name);
// $name has to be string, if $name does not exists in settings file null will be returned - an additional $default
// parameter can be given, returned in the case of $name not existing.

Get All Values Starting With:
$values = $valuestore->allStartingWith($string);
// returns all values with names starting with $string, returns null if none exist.
