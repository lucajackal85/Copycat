<?php

namespace Jackal\Copycat\Reader;

use PDO;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PDOMySQLReader
 * @package Jackal\Copycat\Reader
 */
class PDOMySQLReader extends BaseReader
{
    /**
     * @var array
     */
    protected $options;

    /**
     * PDOMySQLReader constructor.
     * @param $query
     * @param array $options
     */
    public function __construct($query, array $options)
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'host' => 'localhost',
            'port' => 3306,
            'username' => null,
            'password' => null,
            'database_name' => null,
            'query' => $query,
            'driver_options' => [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ],
        ]);

        $this->options = $resolver->resolve($options);

        /** @noinspection SpellCheckingInspection */
        $dbh = $pdo = new PDO(
            sprintf('mysql:host=%s;dbname=%s', $this->options['host'], $this->options['database_name']),
            $this->options['username'],
            $this->options['password'],
            $this->options['driver_options']
        );
        foreach ($dbh->query($query) as $row) {
            $this->addItem($row);
        }
        $dbh = null;
    }
}
