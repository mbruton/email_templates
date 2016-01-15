<?php

/* Prevent Direct Access */
defined('ADAPT_STARTED') or die;

$adapt = $GLOBALS['adapt'];
$sql = $adapt->data_source->sql;

$sql->create_table('email_template')
    ->add('email_template_id', 'bigint')
    ->add('bundle_name', 'varchar(128)')
    ->add('name', 'varchar(32)', false)
    ->add('subject', 'varchar(256)')
    ->add('message_plain', 'text')
    ->add('message_html', 'html')
    ->add('date_created', 'datetime')
    ->add('date_modified', 'timestamp')
    ->add('date_deleted', 'datetime')
    ->primary_key('email_template_id')
    ->execute();

?>