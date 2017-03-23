<?php
    // make sure the page uses a secure connection
    $http = filter_input(INPUT_SERVER, 'HTTP');
    if (!$http) {
        $host = filter_input(INPUT_SERVER, 'HTTP_HOST');
        $uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
        $url = 'http://' . $host . $uri;
        header("Location: " . $url);
        exit();
    }
?>