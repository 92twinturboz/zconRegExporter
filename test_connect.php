<?php
    require_once __DIR__ . '/vendor/autoload.php';
    $client = new MongoDB\Client('mongodb+srv://<username>:<password>@<hostname>/<dbname>?retryWrites=true&w=majority');
    $collection = $client->zcon2021reg->registrations;
    $document = $collection->findOne(['Id' => '1-3']);
    var_dump($document);
?>