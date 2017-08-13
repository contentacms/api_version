# Api Version

This module tracks an api version number for a Drupal site, based upon
configuration changes.

This number is exposed in the ```X-Drupal-ApiVersion``` header as a semantic version number.

For now the implementation just counts up major version number on every config change,
but we can be more intelligent.


