MyTurtleAdmin
=============

Admin for the infoscreens (my.flatturtle.com).

MyTurtleAdmin makes use of the [Codeigniter framework](http://codeigniter.com/), [Twitter Bootstrap](http://twitter.github.com/bootstrap),
[Font Awesome](http://fortawesome.github.com/Font-Awesome/),
[SASS](http://sass-lang.com) and the [ControlBay API](https://github.com/FlatTurtle/)

* [Michiel Vancoillie](http://twitter.com/ntynmichiel) (project leader)

Install
=======

*SASS*

`sudo gem install sass`


Deploy
======

Generate CSS with SASS

`sass --watch src/css:assets/css --style compressed`

Build the javascript with ant.

`ant build`

Don't upload the 'src' folder.


Dependencies
============

PHP version 5.3 or newer with cURL.

Current supported databases are MySQL (4.1+), MySQLi, MS SQL, Postgres, Oracle, SQLite, and ODBC.


Copyright and license
=====================

© 2012 - FlatTurtle
Code is licensed under AGPLv3

Some icons come from [iconic](http://somerandomdude.com/work/iconic/) by P.J. Onori &mdash; CC BY-SA 3.0