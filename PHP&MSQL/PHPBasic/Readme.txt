+ A PHP script is executed on the server, and the result is HTML will be sent back to the browser.
+ Variables:
   $variables_name = variables_value;
   --> the variables_name should naming rules camelCase: $userId
   --> PHP has no command for declaring a variable. 
   It is created the moment you first assign a value to it.
   --> PHP automatically associates a data type to the variable, depending on its value
+ PHP Variables Scope:
   --> Gobal: A variable declared outside a function has a GLOBAL SCOPE and 
    can only be accessed outside a function
   --> Local: A variable declared within a function has a LOCAL SCOPE and 
   can only be accessed within that function
   --> Note: You can have local variables with the same name in different functions, 
   because local variables are only recognized by the function in which they are declared.
   --> if within the function, you want to access the variables with GLOBAL SCOPE then
   you must using the keyword "global" declared inside the function
--> Note: PHP also stores all global variables in an array called "$GLOBALS[index]". 
The index holds the name of the variable. This array is also accessible from within 
functions and can be used to update global variables directly.
   --> Static: Normally, when a function is completed/executed, all of its variables are deleted.
    However, sometimes we want a local variable NOT to be deleted. We need it for a further job.
    To do this, use the "static" keyword when you first declare the variable:
      --> Then, each time the function is called, that variable will still have the information 
      it contained from the last time the function was called.The variable is still local to the function.

--> Summary:
     + Local: accessed within function, local variables with the same name in different functions          
     + Global: accessed outside function,if accessed inside function must declare keyword "global"
       or declare $GLOBALS['variables_name']
     + Static: accessed within function,using when want to keep the value of variable every time the 
     function is called 
+ Constants: Constants are automatically global and can be used across the entire script.
    --> define("GREETING", "Welcome to W3Schools.com!");
+ Operator:
   + '5' + '6' = 11
   + '5' + 6 = 11
   + '5'.'6' = 56
   + '5' + '5 days' = 10 because 5 days were converted to Interger
+ Null coalescing: $variable = value1 ?? value2: if value1 is NULL or not exits, $variable = value2
+ echo <function_name/variable_name/String/Number>;
+ Debug:
  + var_dump($variable_name); --> return type and value of variable
  + echo '<pre>';
    print_r($array_name);
     echo '</pre>';  --> print array 
+ PHP Concatenate:
   --> Ex1: $res = 'result '.$variable_name;
   --> Ex2: $res = "result $variable_name";
   --> Ex3: $res = "result {$variable_name}";
   --> Ex4: $res = "result  of \"variable\" is: $variable_name";
   --> Ex5: $res = 'result  of \'variable\' is:'.$variable_name;

+ PHP String Functions:
   + strlen($str) - return the length of a string
   + explode(separator,string,limit) -  function breaks a string into an array.
     + separator: specifies where to break the string
     + string	the string to split limit
     + limit:  specifies the number of array elements to return.
        + limit > 0: returns an array with a maximum of limit element(s)
        + limit < 0: Returns an array with one element except for the last -limit elements()
        + limit = 0: Returns an array with one element(default if not declare)
   + implode(separator,array): Join array elements into a string
        --> separator: specifies what to put between the array elements.Default " "
   + str_word_count($str): return counts the number of words in a string.
   + strrev($str): reverses a string
   + strpos($str,$search): searches for a specific text within a string.
      If a match is found, the function returns the character position of the first match.
      If no match is found, it will return FALSE.
   + str_replace($search, $replace, $string): find $search in string and replace into $replace in $string
   + str_repeat($str, $repeat):  repeats a string a specified number of times.
   + md5($str,raw): calculates the MD5 hash of a string.
      --> raw: TRUE -  16 character binary format
               FALSE - Default. 32 character hex number
   + sha1($str,raw):
      --> raw: TRUE - Raw 20 character binary format
               FALSE - Default. 40 character hex number
   + how to ignore the html string
      + htmlspecialchars($str_html): print tag html in the screen
      + htmlspecialchars_decode($str_html): convert string html to tag HTML and execute
   + strip_tags(string,allow):
     --> Ex: strip_tags("Hello <b><i>world!</i></b>","<b>"); 
        --> Strip the string from HTML tags, but allow <b> tags to be used

....

+ Array:
   --> Ex: 
   $cars = array("Volvo", "BMW", "Toyota");
   echo "I like " . $cars[0] . ", " . $cars[1] . " and " . $cars[2] . "."; 
+ PHP Associative Arrays: use named keys that you assign to them
   --> Ex: $age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");

+ PHP Array Functions:
....

+ Superglobals: built-in variables that are always available in all scopes,which means that they are always accessible, 
regardless of scope - and you can access them from any function, class or file
 without having to do anything special.
  +  $GLOBALS: $GLOBALS is a PHP super global variable which 
  is used to access global variables from anywhere in the PHP script 
  (also from within functions or methods).PHP stores all global variables in an array called $GLOBALS[index].
   The index holds the name of the variable.
  + $_SERVER: $_SERVER is a PHP super global variable which holds information about headers, paths, and script locations.
    + $_SERVER['PHP_SELF']	: returns the filename of the currently executing script
    + $_SERVER['SERVER_NAME']	Returns the name of the host server (such as localhost)

+ strict: 
  + PHP automatically associates a data type to the variable, depending on its value. 
  Since the data types are not set in a strict sense, you can do things like adding a string to an integer without causing an error.
    --> Ex:  + '5' + '5 days' = 10 because 5 days were converted to Interger
   --> Solution: set declare(strict_types=1); This must be on the very first line of the PHP file.
      <?php declare(strict_types=1); // strict requirement
         function addNumbers(int $a, int $b) {
          return $a + $b;}
         echo addNumbers(5, "5 days");
// since strict is enabled and "5 days" is not an integer, an error will be thrown

+ Passing Arguments by Reference: When a function argument is passed by reference, 
changes to the argument also change the variable that was passed in. 
To turn a function argument into a reference use operator "&"
<?php
   function add_five(&$value) {
    $value += 5;
   }
   $num = 2;
   add_five($num);
   echo $num; // 7
?>

+ Date Time in PHP
   + date(format,timestamp): Format a local date and time and return the formatted date strings
        --> format read on W3Schools
   + time():  returns timestamp - the current time in the number of seconds since 00:00:00 1/1/1970(Unix timestamp)
   + strotime(str): str-output-time --> parses an English textual datetime into a Unix timestamp
   + strftime(format,timestamp): str-format-time: format read on W3Schools
   + mktime( $hour, $minute, $second, $month, $day, $year): make-time return Unix timestamp

+ File,Cookies,Sessions,Array Functions,String Functions

+ Cookies: 
  + A cookie is a string of information stored in the user's browser
used to follow, save back user history, boost experience experiment
  + Use Cookies when:
     + Remember Login: When the user has successfully logged in and after exiting the site and re-entering, website will automatically log in again
     + Product search history on the website
     + Suggest products and services (Based on search habits, see products) 
       --> Ex: Purchase Order on Shoppe or Tiki
  + How to work:
     + When user access to the website, Server will create a Cookies and send it back to brower'user
     + Brower'user will save the Cookies from Server
     + The next time, when user access to the website again, Cookies are already save
     in the brower'user will send to the Server
  + Locations on website: Inspect --> Application --> Cookies
  + Functions:
     + setcookie($name, $value, $expire = 0, $path="", $domain = "", $security =
false, $httponly = false);
       + $name: name of the cookie.
       + $value: string value of the cookie. This value is stored on the clients brower --> $_COOKIE['cookiename']
       + $expire:time the cookie expires. This is a Unix timestamp 
       + $path: path on the server in which the cookie will be available on.
         +  If set to '/', the cookie will be available within the entire domain
      + $domain: domain that the cookie is available to
      + $secure: cookie should only be transmitted over a secure HTTPS connection from the client. 
      When set to true, the cookie will only be set if a secure connection exists. 
      On the server-side, it's on the programmer to send this kind of cookie only on secure connection (Ex: $_SERVER["HTTPS"]).
      + localhost --> use HTTP --> $httponly
      + $_COOKIE[$name]: Superglobals variable is array contain all the Cookies
      + Tool: EditThisCookie

+ Session:
   + If Cookies is saved in brower then Session is saved in Server
   + Session will saved in file php.ini 
   + When the brower is close, Session will be destroy
   + Used for Login Page,...
   + When user access to the website, Sever will create a Session and save in Session Store 
   + Server send back to brower Set-Cookies
   + 
