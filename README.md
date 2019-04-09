# Image Merge
A simple PHP to "copy" data from one source to another

### Requirement
PHP >= **5.6**

## Getting Started
Install library with composer
```
composer require jackal/copycat
```
## Usage
#### Basic example: from array to sql insert statement
```
require_once __DIR__.'/vendor/autoload.php';
$reader = new \Jackal\Copycat\Reader\ArrayReader([
    ['col1' => 'value1','col2' => 'value2'],
    ['col1' => 'value3','col2' => 'value4'],
    /*...*/
]);

$workflow = new \Jackal\Copycat\Workflow($reader);
$workflow->addWriter(new \Jackal\Copycat\Writer\SQLFileWriter('test_table','test_table.sql'));
$workflow->process();

echo file_get_contents(__DIR__.'/test_table.sql');
```
#### From array to array
```
$reader = new \Jackal\Copycat\Reader\ArrayReader([
    ['value1'],
    ['value2'],
    /*...*/
]);

$workflow = new \Jackal\Copycat\Workflow($reader);
$workflow->addWriter(new \Jackal\Copycat\Writer\ArrayWriter($outputArray));

$workflow->process();

var_dump($outputArray);

```
### Filters
With Filters you can apply logic to exclude certain values from the output.
```
/*[...]*/
/*Define wich column to apply filter*/
$workflow->addFilter(new NotBlankFilter('col1'));
/*[...]*/
```
Filters are callable objects, you can define your own filter
```
/*[...]*/
/*Define custom filter*/
$workflow->addFilter(function($values){
    return $values['col1'] > 0;
});
/*[...]*/
```
### Converter
With Converter you can modify values to the output.
```
/*[...]*/
/*Define custom filter*/
$workflow->addConverter(new DatetimeToStringConverter('col1'));
/*[...]*/
```
You can set your own converter
```
/*[...]*/
//apply custom converter
$workflow->addConverter(function ($values){
    foreach ($values as &$value) {
        if ($value == 'to convert') {
            $value = 'converted';
        }
    }
    return $values;
});
/*[...]*/
```

## Authors
* **Luca Giacalone** (AKA JackalOne)

## License
This project is licensed under the MIT License