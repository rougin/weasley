<?php

namespace Rougin\Weasley\Fixture;

use Rougin\Ezekiel\Dialect\SqliteDialect;
use Rougin\Ezekiel\Query;
use Rougin\Ezekiel\Result;
use Rougin\Ezekiel\Schema\Design;
use Rougin\Ezekiel\Schema\Table;
use Rougin\Slytherin\Integration\Configuration;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Database
{
    /**
     * @return \Rougin\Slytherin\Integration\Configuration
     */
    public static function config()
    {
        $config = new Configuration;

        $config->set('database.default', 'sqlite');

        $config->set('database.sqlite.database', ':memory:');

        $config->set('database.sqlite.driver', 'sqlite');

        $config->set('database.sqlite.prefix', '');

        return $config;
    }

    /**
     * @param \PDO $pdo
     *
     * @return void
     */
    public static function migrate(\PDO $pdo)
    {
        $table = new Table(new SqliteDialect);

        $fn = function (Design $d)
        {
            $d->increments('id');

            $d->text('name');

            $d->text('username');

            $d->text('password');
        };

        $table->create('users', $fn);

        $pdo->exec($table->toSql());
    }

    /**
     * @param \PDO $pdo
     *
     * @return void
     */
    public static function seed(\PDO $pdo)
    {
        $row = array('id' => 1);
        $row['name'] = 'Rougin';
        $row['username'] = 'rougin';
        $row['password'] = 'rougin';

        $users = array($row);

        $row = array('id' => 2);
        $row['name'] = 'Royce';
        $row['username'] = 'royce';
        $row['password'] = 'royce';
        $users[] = $row;

        $row = array('id' => 3);
        $row['name'] = 'Gutib';
        $row['username'] = 'gutib';
        $row['password'] = 'gutib';
        $users[] = $row;

        $test = password_hash('test', PASSWORD_BCRYPT);

        $row = array('id' => 4);
        $row['name'] = 'Test';
        $row['username'] = 'test';
        $row['password'] = $test;
        $users[] = $row;

        $query = new Query;

        $query->insertInto('users')
            ->values($users);

        $result = new Result($pdo);

        $result->items($query);
    }
}
