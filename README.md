Speciphy
========

master: [![Build Status](https://secure.travis-ci.org/speciphy/speciphy.png?branch=master)](http://travis-ci.org/speciphy/speciphy)
develop: [![Build Status](https://secure.travis-ci.org/speciphy/speciphy.png?branch=develop)](http://travis-ci.org/speciphy/speciphy)

xSpec BDD Framework for PHP.

Strongly inspired from RSpec.

Features
--------

- Nested context
- Specification with string
- Expectation DSL provided by [Esp&eacute;rance](https://github.com/yuya-takeyama/esperance)

Example
-------

```php
<?php
$spec->describe('Bowling', function () {
    $this->describe('->score', function () {
        $this->context('all gutter game', function () {
            $this->topic(function () {
                $bowling = new Bowling;
                for ($i = 1; $i <= 20; $i++) {
                    $bowling->hit(0);
                }
                return $bowling;
            });

            $this->must('equal 0', function ($bowling) {
                $this->expect($bowling->score)->to->be(0);
            });
        });
    });
});
```

Author
------

Yuya Takeyama
