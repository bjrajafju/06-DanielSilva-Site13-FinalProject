<?php
// Genericas para qualquer projeto
// todos
function db_get_all($table, $where = "1", $order = "id DESC", $limit = "")
{
    $sql = "SELECT * FROM $table WHERE $where ORDER BY $order $limit";
    return my_query($sql);
}

// um
function db_get_one($table, $where = "1")
{
    $sql = "SELECT * FROM $table WHERE $where LIMIT 1";
    $res = my_query($sql);
    return $res[0] ?? null;
}

// quantos há
function db_count($table, $where = "1")
{
    $sql = "SELECT COUNT(*) as total FROM $table WHERE $where";
    $res = my_query($sql);
    return $res[0]['total'] ?? 0;
}

function db_get_translated(
    $table,
    $translation_table,
    $fk,
    $where = "",
    $order = "",
    $limit = ""
) {
    global $LANG_ID;

    $sql = "
        SELECT *
        FROM $table t
        JOIN $translation_table tt 
            ON tt.$fk = t.id
            AND tt.lang_id = $LANG_ID
    ";

    if ($where) {
        $sql .= " WHERE $where";
    }

    if ($order) {
        $sql .= " ORDER BY $order";
    }

    if ($limit) {
        $sql .= " LIMIT $limit";
    }

    return my_query($sql);
}

