<?php
$SETTINGS['conn'] = my_connect($SETTINGS);

function my_connect($SETTINGS)
{
    $conn = new mysqli($SETTINGS['servername'], $SETTINGS['username'], $SETTINGS['password'], $SETTINGS['dbname']); // Create connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset('utf8mb4');
    return $conn;
}

function my_query($sql, $debug = 0)
{
    global $SETTINGS;
    if ($debug) echo "<pre>$sql</pre>";
    $result = $SETTINGS['conn']->query($sql);

    if ($result === false) {
        return 0;
    }

    if (isset($result->num_rows)) {
        $arrRes = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $arrRes[] = $row;
            }
        }
        return $arrRes;
    }
    if ($result === TRUE) {
        if ($SETTINGS['conn']->insert_id) {
            return $SETTINGS['conn']->insert_id;
        }
        return 1;
    }
    return 0;
}
