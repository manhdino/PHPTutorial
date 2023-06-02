<?php
// $variable_name = 'Dinomanh';
// $res = 'result: '.$variable_name;
// echo $res.'<br/>';
// $res = "result $variable_name";
// echo $res.'<br/>';
// $res = "result {$variable_name}";
// echo $res.'<br/>';
// $res = "result  of \"variable\" is: $variable_name";
// echo $res.'<br/>';
// $res = 'result  of \'variable\' is:'.$variable_name;
// echo $res.'<br/>';

// $str = '<h1>Unicode</h1>';
// echo htmlspecialchars($str);
// echo htmlspecialchars_decode($str);

// echo $_SERVER['PHP_SELF'];
// echo "<br>";
// echo $_SERVER['SERVER_NAME'];
// echo "<br>";
// echo $_SERVER['SERVER_ADDR'];
// echo '<br>';
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $name = htmlspecialchars($_REQUEST['fname']);
    echo $name;
    if (empty($name)) {
        echo "Name is empty";
    } else {
        echo $name;
    }
}
?>
<!DOCTYPE html>
<html>

<body>

    <form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
        Name: <input type="text" name="fname">
        <input type="submit">
    </form>

</body>

</html>