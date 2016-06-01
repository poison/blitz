--TEST--
set in loop
--FILE--
<?php
include('common.inc');
ini_set('blitz.remove_spaces_around_context_tags', 1);
ini_set('blitz.warn_context_duplicates', 0);

$body = <<<BODY
In a list:
{{ BEGIN list }}
{{set('name', 'Ralph')}}
Item {{ _num }}: {{ name }} - {{ id }}
{{ END list }}

It stays in memory:
{{ BEGIN list }}
Item {{ _num }}: {{ name }} - {{ id }}
{{ END list }}

My hero is {{hero.nickname}}
{{set(hero.nickname, 'Blacky')}}
Now he's called {{hero.nickname}}

{{set(hero.nickname, idiot.candidate)}}
There's an idiot president candidate: {{hero.nickname}}

{{set(hero, "simple string")}}
{{hero}}

{{set(none.name, "Ha")}}
{{none.name}}

{{set(my.foo.bar, "JT")}}
{{my.foo.bar}}

{{set(hero.foo.bar, "JT")}}
{{hero.foo.bar}}

{{set(a.b.c.d.e.f.g, "H")}}
{{a.b.c.d.e.f.g}}

BODY;

$data = array(
    'list' => array(
        array('id' => 3),
        array('id' => 8)
    ),
    'hero' => array(
        'nickname' => 'Julian',
        'foo' => 'bar'
    ),
    'my' => 'Var',
    'idiot' => array(
        'candidate' => 'Donald Trump'
    )
);

$t = new Blitz();
$t->load($body);
$t->display($data);

var_export($data);

?>
--EXPECT--
In a list:
Item 1: Ralph - 3
Item 2: Ralph - 8

It stays in memory:
Item 1: Ralph - 3
Item 2: Ralph - 8

My hero is Julian
Now he's called Blacky

There's an idiot president candidate: Donald Trump

simple string

Ha

JT

JT

H
array (
  'list' => 
  array (
    0 => 
    array (
      'id' => 3,
      'name' => 'Ralph',
    ),
    1 => 
    array (
      'id' => 8,
      'name' => 'Ralph',
    ),
  ),
  'hero' => 
  array (
    'foo' => 'bar',
  ),
  'my' => 
  array (
    'foo' => 
    array (
      'bar' => 'JT',
    ),
  ),
  'idiot' => 
  array (
    'candidate' => 'Donald Trump',
  ),
  'a' => 
  array (
    'b' => 
    array (
      'c' => 
      array (
        'd' => 
        array (
          'e' => 
          array (
            'f' => 
            array (
              'g' => 'H'
            )
          ),
        ),
      ),
    ),
  );
)