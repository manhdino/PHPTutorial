<?php
if (!defined('_INCODE')) die('Access denied...');
//Function query to database

function query($sql, $data = [], $statementStatus = false)
{
    global $conn;
    $query = false;
    try {
        $statement = $conn->prepare($sql);
        if (empty($data)) {
            $query =  $statement->execute();
        } else {
            $query = $statement->execute($data);
        }
        echo '<br>';
    } catch (Exception $e) {
        require_once('modules/errors/404_DB.php');
        die();
    }
    if ($statementStatus && $query) {
        return $statement;
    }
    return $query;
}

function insert($table, $dataInsert)
{
    $sql = '';
    // echo '<pre>';
    // print_r($dataInsert);
    // echo '<pre>';

    $keyArr = array_keys($dataInsert);
    // echo '<pre>';
    // print_r($keyArr);
    // echo '<pre>';

    $fieldStr = implode(',', $keyArr);
    // echo '<pre>';
    // print_r($fieldStr);
    // echo '<pre>';

    $valueStr = ':' . implode(', :', $keyArr);
    // echo $valueStr;

    $sql = 'INSERT INTO ' . $table . '(' . $fieldStr . ')' . ' VALUES' . '(' . $valueStr . ')';
    // echo $sql;
    return query($sql, $dataInsert);
}

function update($table, $dataUpdate, $condition = '')
{
    //$sql = "UPDATE users SET email=:email,fullname=:fullname WHERE id=:id";
    $sql = '';
    // $keyArr = array_keys($dataUpdate);
    // $fieldStr = implode('=: ,', $keyArr);
    // echo '<pre>';
    // print_r($fieldStr);
    // echo '<pre>';
    $updateStr = '';
    foreach ($dataUpdate as $key => $value) {
        $updateStr .= $key . '=:' . $key . ', ';
    }
    $updateStr = rtrim($updateStr, ', ');
    //  echo $updateStr;
    // echo '<br>';
    if (!empty($condition)) {
        $sql = 'UPDATE ' . $table . ' SET ' . $updateStr . ' WHERE ' . $condition;
    } else {
        $sql = 'UPDATE ' . $table . ' SET ' . $updateStr;
    }
    return query($sql, $dataUpdate);
}

function delete($table, $condition = '')
{
    //$sql = 'DELETE from users WHERE id =?';

    if (!empty($condition)) {
        $sql = 'DELETE FROM ' . $table . ' WHERE ' . $condition;
    } else {
        $sql = 'DELETE FROM ' . $table;
    }
    echo $sql;
    return query($sql);
}
// Lấy dữ liệu từ câu lệnh sql - lấy tất cả
function getRaw($sql)
{
    $statement = query($sql, [], true);
    if (is_object($statement)) {
        $datafetch = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $datafetch;
    }
    return false;
}

// Get the first record matching from the query
function firstRaw($sql)
{
    $statement = query($sql, [], true);
    // echo '<pre>';
    // print_r($statement);
    // echo '<pre>';
    if (is_object($statement)) {
        $datafetch = $statement->fetch(PDO::FETCH_ASSOC);
        return $datafetch;
    }
    return false;
}

function get($table, $field = '*', $condition = '')
{
    $sql = 'SELECT ' . $field . ' FROM ' . $table;
    echo $sql;
    if (!empty($condition)) {
        $sql .= ' WHERE ' . $condition;
    }
    return getRaw($sql);
}

function first($table, $field = '*', $condition = '')
{
    $sql = 'SELECT ' . $field . ' FROM ' . $table;
    echo $sql;
    if (!empty($condition)) {
        $sql .= ' WHERE ' . $condition;
    }
    return firstRaw($sql);
}

//Lay so dong cau truy van
function getRows($sql)
{
    $statement = query($sql, [], true);
    // echo '<pre>';
    // print_r($statement);
    // echo '</pre>';
    if (!empty($statement)) {
        //rowCount returns the number of rows  were affected by the query
        //   echo $statement->rowCount();
        return $statement->rowCount();
    }
}

//Lay id vua insert
function insertId()
{
}
