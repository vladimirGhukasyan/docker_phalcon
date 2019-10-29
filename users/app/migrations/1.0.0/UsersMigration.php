<?php
use Phalcon\Db\Column as Column;
use Phalcon\Db\Index as Index;
use Phalcon\Db\Reference as Reference;
use Phalcon\Mvc\Model\Migration;

class UsersMigration extends \Phalcon\Mvc\Model\Migration
{
    public function up()
    {

        $this->morphTable(
            'users',
            [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type'          => Column::TYPE_INTEGER,
                            'size'          => 10,
                            'unsigned'      => true,
                            'notNull'       => true,
                            'autoIncrement' => true,
                            'first'         => true,
                        ]
                    ),


                    new Column(
                        'login',
                        [
                            'type'    => Column::TYPE_VARCHAR,
                            'size'    => 70,
                            'notNull' => true,
                            'after'   => 'id'
                        ]
                    ),
                    new Column(
                        'password',
                        [
                            'type'    => Column::TYPE_DECIMAL,
                            'size'    => 70,
                            'notNull' => true,
                            'after'   => 'login',
                        ]
                    ),
                ],
                'indexes' => [
                    new Index(
                        'PRIMARY',
                        [
                            'id',
                        ]
                    ),

                ],
                'options' => [
                    'TABLE_TYPE'      => 'BASE TABLE',
                    'ENGINE'          => 'InnoDB',
                    'TABLE_COLLATION' => 'utf8_general_ci',
                ],
            ]
        );
        self::$_connection->query(
            'users',
            [
                'test',
                'test',
            ],
            [
                'login',
                'password',
            ]
        );
    }
}