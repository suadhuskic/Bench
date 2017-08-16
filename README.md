[Bench]
===========

### Benching time zones ! You shouldn't be scared of time zones and you shouldnt present `America/Los_Angeles`  to the user neither. Yikes...that would of scared my co-worker.


Lets display a set of countries for that user to auto-complete on or simply select from.




```php
use Bench\Bench;

$countries = Bench::getCountries();
```
