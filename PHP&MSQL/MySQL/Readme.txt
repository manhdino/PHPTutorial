+ What is SQL?
SQL is the standard language for dealing with Relational Databases.
SQL is used to insert, search, update, and delete database records.

+ SELECT Syntax: 
   --> SELECT column1, column2, ...FROM table_name;
   -->  SELECT * FROM table_name;
--> Note: Inside a table, a column often contains many duplicate values;
 and sometimes you only want to list the different (distinct) values.
  --> SELECT DISTINCT column1, column2, ...FROM table_name;

+ SELECT with WHERE: 
  + the WHERE clause is used to filter records.
  + It is used to extract only those records that fulfill a specified condition.
    --> SELECT column1, column2, ...FROM table_name WHERE condition;
  + The WHERE clause can be combined with AND, OR, and NOT operators.
  + The AND and OR operators are used to filter records based on more than one condition:
     --> The AND operator displays a record if all the conditions separated by AND are TRUE.
     --> The OR operator displays a record if any of the conditions separated by OR is TRUE.
     --> The NOT operator displays a record if the condition(s) is NOT TRUE
 --> SELECT column1, column2, ...FROM table_name WHERE condition1 AND condition2 AND condition3 ...;

+ ORDER BY:
   + The ORDER BY keyword is used to sort the result-set in ascending or descending order.
   + The ORDER BY keyword sorts the records in ascending order by default. 
   + To sort the records in descending order, use the DESC keyword.
   + To sort the records in ascending order, use the ASC keyword.
     --> SELECT column1, column2, ...FROM table_name ORDER BY column1, column2, ... ASC|DESC;

+ INSERT INTO:
   + The INSERT INTO statement is used to insert new records in a table.
     --> INSERT INTO table_name (column1, column2, column3, ...) VALUES (value1, value2, value3, ...);

+ UPDATE: 
   + The UPDATE statement is used to modify the existing records in a table.
     -->  UPDATE table_name SET column1 = value1, column2 = value2, ...WHERE condition;
+ DELETE:
   + The DELETE statement is used to delete existing records in a table.
     --> DELETE FROM table_name WHERE condition;
+ LIMIT: 
   + The LIMIT clause is used to specify the number of records to return.
   + The LIMIT clause is useful on large tables with thousands of records. 
   + Returning a large number of records can impact performance.
     --> SELECT column_name(s) FROM table_name WHERE condition LIMIT number;
+ LIKE: 
   + The LIKE operator is used in a WHERE clause to search for a specified pattern in a column.
     --> SELECT column1, column2, ...FROM table_name WHERE columnN LIKE pattern;
   + WHERE CustomerName LIKE 'a%'	Finds any values that start with "a"
   + WHERE CustomerName LIKE '%a'	Finds any values that end with "a"
   + WHERE CustomerName LIKE '%or%'	Finds any values that have "or" in any position
   + WHERE CustomerName LIKE '_r%'	Finds any values that have "r" in the second position
   + WHERE CustomerName LIKE 'a_%'	Finds any values that start with "a" and are at least 2 characters in length
   + WHERE CustomerName LIKE 'a__%'	Finds any values that start with "a" and are at least 3 characters in length
   + WHERE ContactName LIKE 'a%o'	Finds any values that start with "a" and ends with "o"

+ IN: 
   + The IN operator allows you to specify multiple values in a WHERE clause.
   + The IN operator is a shorthand for multiple OR conditions.
    --> SELECT column_name(s) FROM table_name WHERE column_name IN (value1, value2, ...);

+ BETWEEN:
   + The BETWEEN operator selects values within a given range.
   +  The values can be numbers, text, or dates.
     --> SELECT column_name(s) FROM table_name WHERE column_name BETWEEN value1 AND value2;

+ JOIN:
   + A JOIN clause is used to combine rows from two or more tables, based on a related column between them.
   + INNER JOIN: Returns records that have matching values in both tables
      --> SELECT column_name(s) FROM table1 INNER JOIN table2 ON table1.column_name = table2.column_name;
   + LEFT JOIN: Returns all records from the left table, and the matched records from the right table
      --> SELECT column_name(s) FROM table1 LEFT JOIN table2 ON table1.column_name = table2.column_name;
   + RIGHT JOIN: Returns all records from the right table, and the matched records from the left table
      --> SELECT column_name(s) FROM table1 RIGHT JOIN table2 ON table1.column_name = table2.column_name;