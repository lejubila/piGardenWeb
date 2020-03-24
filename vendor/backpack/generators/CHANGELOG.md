# Changelog

All Notable changes to `Backpack Generators` will be documented in this file

## NEXT - YYYY-MM-DD

### Added
- Nothing

### Deprecated
- Nothing

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing

## 1.2.7 - 2019-02-27

## Added
- Backpack\Base 1.1 compatibility;

## 1.2.6 - 2019-01-16

## Added
- CrudPanel reference to CrudController stb, for IDE code completion;

## 1.2.5 - 2018-11-22

## Added
- support for Backpack/Base 1.0.0

## 1.2.4 - 2018-08-27

### Removed
- commented API from controller stub;

## 1.2.3 - 2018-07-07

### Added
- ```setRequiredFields()``` to controller stub;

### Fixed
- fields before columns in the controller stub;


## 1.2.2 - 2018-06-22

### Fixed
- composer requirements;


## 1.2.1 - 2018-06-22

### Fixed
- Travis CI;

## 1.2.0 - 2018-06-22

### Fixed
- cleaner service provider;
- annotation to allow IDEs to autocomplete the code when referencing ```$crud```;
- #39 - use backpack_auth() function from 0.9.x updates;

### Removed
- support for Backpack\Base below 0.9;


## 1.1.13 - 2018-02-14

### Fixed
- table now is now pluralized correctly (for English names);
- crud model is now generated with $table and $fillable uncommented;


## 1.1.12 - 2018-02-14

### Deprecated
- CrudRequest is no longer needed, so generated form requests now extend ```Illuminate\Foundation\Http\FormRequest```;


## 1.1.11 - 2017-08-30

### Added
- Laravel 5.5 support (handle() alias for fire());
- Package auto-discovery;


## 1.1.10 - 2017-08-11

### Fixed
- calls to CrudController::storeCrud() and CrudController::updateCrud() now pass the $request as parameter - just in case you modified it in the setup() in any way;


## 1.1.9 - 2017-04-26

### Added
- more removeButton methods to CrudController stub;

### Fixed
- CrudController setup method name (no uppercase letters);


## 1.1.8 - 2017-04-03

### Fixed
- using single quotes instead of double quotes for class names;
- using the configured admin prefix;
- better entity name pluralization;


## 1.1.7 - 2016-12-21

### Removed
- laracasts/generators dependency; it's NOT a Backpack\Generators dependency, it's a Backpack\Base dependency;


## 1.1.6 - 2016-12-21

### Added
- laracasts/generators dependency;


## 1.1.4 - 2016-10-25

### Fixed
- Updated controller stub with new features;
- Replaced constructor in controller with setup();


## 1.1.3 - 2016-07-31

### Fixed
- Working bogus unit tests.


## 1.1.2 - 2016-07-30

### Added
- Bogus unit tests. At least we'be able to use travis-ci for requirements errors, until full unit tests are done.

## 1.1.1 - 2016-07-31

### Added
- ajax table view command for CrudControllers


## 1.1.0 - 2016-05-22

### Added
- Generators for CRUD files: backpack:crud, backpack:crud-request, backpack:crud-model and backpack:crud-controller
