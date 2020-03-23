
# Backpack\CRUD

[![Latest Version on Packagist](https://img.shields.io/packagist/v/backpack/crud.svg?style=flat-square)](https://packagist.org/packages/backpack/crud)
[![Software License](https://img.shields.io/badge/license-YuMMy-yellow.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/Laravel-Backpack/CRUD/master.svg?style=flat-square)](https://travis-ci.org/Laravel-Backpack/CRUD)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/laravel-backpack/crud.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-backpack/crud/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-backpack/crud.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-backpack/crud)
[![Style CI](https://styleci.io/repos/53581270/shield)](https://styleci.io/repos/53581270)
[![Total Downloads](https://img.shields.io/packagist/dt/backpack/crud.svg?style=flat-square)](https://packagist.org/packages/backpack/crud)

Quickly build an admin interface for your Eloquent models, using Laravel 6 or 5.8. Erect a complete CMS at 10 minutes/model, max.

Features:
- 49+ field types
- 23+ column types
- 1-1, 1-n and n-n relationships
- Table view with search, pagination, click column to sort by it
- Reordering (nested sortable)
- Back-end validation using Requests
- Translatable models (multi-language)
- Easily extend fields (customising a field type or adding a new one is as easy as creating a new view with a particular name)
- Easily overwrite functionality (customising how the create/update/delete/reorder process works is as easy as creating a new function with the proper name in your EntityCrudCrontroller)

> ### Security updates and breaking changes
> Please **[subscribe to the Backpack Newsletter](http://backpackforlaravel.com/newsletter)** so you can find out about any security updates, breaking changes or major features. We send an email every 1-2 months.

![List / table view for Backpack/CRUD](https://backpackforlaravel.com/uploads/home_slider/1.png)


## Getting started

If you have never used Backpack before, the best place to understand it and get started is [backpackforlaravel.com](https://backpackforlaravel.com/). 

## Install

Please note you need to install Backpack\Base before you can use Backpack\CRUD. It will provide you with the AdminLTE design.

Installation guides:
- [Install Backpack on Laravel 5.2](https://laravel-backpack.readme.io/docs/installation) - deprecated, lacks a lot of features;
- [Install Backpack on Laravel 5.3](https://laravel-backpack.readme.io/docs/installation-on-laravel-53) - last feature update was 02 Feb 2017;
- [Install Backpack on Laravel 5.4](https://laravel-backpack.readme.io/docs/install-on-laravel-54) - last feature update was 27 Sep 2017;
- [Install Backpack on Laravel 5.5, 5.6, 5.7](https://backpackforlaravel.com/docs/3.5/installation) - last feature update was 27th Feb 2019;
- [Install Backpack on Laravel 5.8 or 6.x](https://backpackforlaravel.com/docs/3.6/installation) - recommended;

## Features

Check out [the about page in the documentation](https://backpackforlaravel.com/docs/3.5/getting-started-crud-operations) to get familiar with all the Backpack\CRUD features.


## Usage

If you've already checked out the features link above, take a look at how you can create a CRUD for a model in [this example](https://backpackforlaravel.com/docs/3.4/getting-started-crud-operations). At the end of the page you'll also find a way you can do everything in 1-2 minutes, using the command line and [backpack/generators](https://github.com/laravel-backpack/generators).

In short:

1. Make your model use the CrudTrait.

2. Create a controller that extends CrudController.

3. Create a new resource route.

4. **(optional)** Define your validation rules in a Request files.


## Screenshots

- List view pictured above.
- Create/update view:
![Create or update view for Backpack/CRUD](https://backpackforlaravel.com/uploads/home_slider/2.png)
- File manager (elFinder):
![File manager interface for Backpack/CRUD](https://backpackforlaravel.com/uploads/home_slider/4.png)

More screenshots available at [backpackforlaravel.com](https://backpackforlaravel.com).

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email hello@tabacitu.ro instead of using the issue tracker.

Please **[subscribe to the Backpack Newsletter](http://backpackforlaravel.com/newsletter)** so you can find out about any security updates, breaking changes or major features. We send an email every 1-2 months.

## Credits

- [Cristian Tabacitu](http://tabacitu.ro) - architect, designer, manager, main coder, PR guy, customer service guy & chief honcho;
- [Owen Melbourne](https://github.com/OwenMelbz) - new features, bug fixing and support;
- [Oliver Ziegler](https://github.com/OliverZiegler) - new features, bug fixing and support;
- [Thomas Swonke](https://github.com/tswonke) - new features, bug fixing and support;
- [Catalin Tudorache](https://github.com/tumf87) - new features, bug fixing and support;
- [All Contributors][link-contributors]

Special thanks go to:
- [John Skoumbourdis](http://www.grocerycrud.com/) - Grocery CRUD for CodeIgniter was the obvious inspiration for this package.
- [Abdullah Almsaeed](https://adminlte.io/) - creator of AdminLTE


## License

Backpack is free for non-commercial use and 49 EUR/project for commercial use. Please see [License File](LICENSE.md) and [backpackforlaravel.com](https://backpackforlaravel.com/#pricing) for more information.


## Hire us

We've spend more than 50.000 hours creating, polishing and maintaining administration panels on Laravel. We've developed e-Commerce, e-Learning, ERPs, social networks, payment gateways and much more. We've worked on admin panels _so much_, that we've created one of the most popular software in its niche - just from making public what was repetitive in our projects.

If you are looking for a developer/team to help you build an admin panel on Laravel, look no further. You'll have a difficult time finding someone with more experience & enthusiasm for this. This is _what we do_. [Contact us](https://backpackforlaravel.com/need-freelancer-or-development-team).


[ico-version]: https://img.shields.io/packagist/v/dick/crud.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/tabacitu/crud.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/backpack/crud
[link-downloads]: https://packagist.org/packages/backpack/crud
[link-author]: https://tabacitu.ro
[link-contributors]: ../../contributors
