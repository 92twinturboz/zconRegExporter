<?php
    require_once __DIR__ . '/vendor/autoload.php';
    // Retrieve JSON from POST
    $json = file_get_contents("php://input");
    // $json = file_get_contents("./sample_user.json");
    if(empty($json)) {
        echo "No data payload";
        die;
    }
    // Parse JSON
    $registration = json_decode($json);
    if ($registration == null && json_last_error() !== JSON_ERROR_NONE) {
        echo "Error reading JSON: " . json_last_error();
    }

    // Remove BSON non-compliant key names
    $registration->{'version'} = $registration->{'$version'};
    unset($registration->{'$version'});
    $registration->{'etag'} = $registration->{'$etag'};
    unset($registration->{'$etag'});

    $registration->{'Entry'}->{'Order'}->{'version'} = $registration->{'Entry'}->{'Order'}->{'$version'};
    unset($registration->{'Entry'}->{'Order'}->{'$version'});
    $registration->{'Entry'}->{'Order'}->{'etag'} = $registration->{'Entry'}->{'Order'}->{'$etag'};
    unset($registration->{'Entry'}->{'Order'}->{'$etag'});

    $registration->{'Order'}->{'version'} = $registration->{'Order'}->{'$version'};
    unset($registration->{'Order'}->{'$version'});
    $registration->{'Order'}->{'etag'} = $registration->{'Order'}->{'$etag'};
    unset($registration->{'Order'}->{'$etag'});
    
    // Update record by matching Id
    $client = new MongoDB\Client('mongodb+srv://<username>:<password>@<hostname>/<dbname>?retryWrites=true&w=majority');
    $collection = $client->zcon2021reg->registrations;
    $updateResult = $collection->replaceOne(['Id' => $registration->{'Id'}], $registration);
    printf("Matched %d document(s)\n", $updateResult->getMatchedCount());
    printf("Modified %d document(s)\n", $updateResult->getModifiedCount());
?>