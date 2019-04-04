# Image Merge
A simple PHP to "copy" data from one source to another

### Requirement
PHP >= **5.5.9** with GD support 

## Getting Started
Install library with composer
```
composer require jackal/copycat
```
## Usage
#### Minimal example: from array to sql insert statement
```
require_once __DIR__.'/vendor/autoload.php';
$reader = new \Jackal\Copycat\Reader\ArrayReader([
    ['col1' => 'value1','col2' => 'value2'],
    ['col1' => 'value3','col2' => 'value4'],
    /*...*/
]);

$workflow = new \Jackal\Copycat\Workflow($reader);
$workflow->addWriter(new \Jackal\Copycat\Writer\SQLFileWriter('test_table','test_table.sql',true));
$workflow->process();

echo file_get_contents(__DIR__.'/test_table.sql');
```
#### Adding filters: you can skip certain values applying rules
```
/*[...]*/
/*Define wich column to apply filter*/
$workflow->addFilter(new NotBlankFilter('col1'));
/*[...]*/
```
##### Filters are callable objects, so you can also define custom rules, example:
```
/*[...]*/
/*Define custom filter*/
$workflow->addFilter(function($values){
    return $values['col1'] > 0;
});
/*[...]*/
```
#### Adding converter: you can set converter to convert values
```
/*[...]*/
/*Define custom filter*/
$workflow->addConverter('col1',new DatetimeToStringConverter('Y-m-d H:i:s'));
/*[...]*/
```


## Authors
* **Luca Giacalone** (AKA JackalOne)

## License
This project is licensed under the MIT License