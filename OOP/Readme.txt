Things must be learned in OOP programming:
   + Class,Object            OK
   + Access Range            OK
   + Extends                 Ok
   + Property Static, Method Static(self,static) OK
   + Trait
   + Namespace
   + Magic methods:
    + __construct
    + __destruct
    + __get
    + __set
    + __call
    + __callStatic
   + Call multiple methods 
   + Interface  OK
   + Abtract Class OK
   
/**
* A class is a template for objects, and an object is an instance of class.
* Class includes methods,properties and constants(declared by constants "const")
* Structure of classes contains:
class class_name{
visibility $property1;
visibility $property2;

const constant1 = value1;
const constant2 = value2;

visibility function method_name1(){
//body
}
visibility function method_name2(){
//body
}}
+ 1 class - 1 file: when create a new object then create in a different file and 
import the class of that object

+ class_name: naming by PascalCase: first character of every letter is capitalized
+ visibility: public, private, protected
+ properties: naming by CamelCase: first letter is lowercase,from the second letter first character of every letter is
capitalized
+ constants_name: all letters are capital and connected by _ character and defined by "const" keyword
+ method_name: naming by CamelCase
    --> $tenObject = new TenClass();
* Struct of Object:
$obj_name = new class_name();
$obj_name->property1;//call property
$obj_name->method_name;//call method
$obj_name::constant1;//call constant or class_name::constant;

*$this:
The $this keyword refers to the current object, and is only available inside methods.
$this can be understood as a object using inside the class
* Visibility:
+ public:the property or method can be accessed from everywhere. This is default
+ protected:the property or method can be accessed within the class and by classes extends from that class
+ private: the property or method can ONLY be accessed within the class

* Constructor methods: __construct()
+ A constructor allows you to initialize an object's properties before creation of the object.
+ If you create a __construct() function, PHP will automatically call this function when you create an object from a
class.

* Destructor methods: __destruct()
+ A destructor is called when the object is destructed or the program is stopped or exited.
+ If you create a __destruct() function, PHP will automatically call this function when program is stopped

* Extends:
+ When child class will inherit all the public and protected properties and methods
from the parent class.It's like child class can have its own properties and methods
+ An inherited class is defined by using the "extends" keyword.

* Overriding Inherited Methods:
+ Inherited methods can be overridden by use the same name in the child class
+ It's mean parent class and child class has the same name of methods
+ Keyword "final" used to prevent inheritance or prevent method Overriding


* The static properties and methods:
   + A class was called static if all the properties and methods was static
   + Static properties and methods: can be called directly without creating an instance of the class
   + Static properties and methods are declared with the "static" keyword
     --> To access a static property and method: 
        class_name::$static_properties_name;
        class_name::static_method_name;
       
   + Becasue A class can have both static and non-static properties and methods.So,a static property and method
   can be accessed and called from a method in the same class using the "self" keyword and double colon (::)
   --> slef::$properties_name(in the same class)
   --> slef::static_method_name(in the same class)
   + To call a static property and method from a child class using the "parent" keyword inside the child class
   -->  parent::$properties_parent_name(was declared in the parent class)
   -->  parent::static_method_name(was declared in the parent class)

* Abtract class:
  + Abstract classes and methods are when the parent class has a named method, but need its child classes to fill out the tasks.
  + An abstract class is a class that contains at least one abstract method. An abstract method is a method that is declared, but not implemented in the code.
  + An abstract class or method is defined with the "abstract" keyword:
  + So, when a child class is inherited from an abstract class, we must have the following rules:
     + The child class method must be defined with the same name with the parent abstract method
     + The child class method must be less restricted access modifier
     + The number of required arguments must be the same. However, the child class may have optional arguments in addition
  + No abstract properties or abstract constants
  + Cannot instantiate object from abstract class,otherwise can instantiate object from the child class
  + Scopes in an abstract class can only be declared as: public and protected

* Interface:
  + Interface are similar to abstract classes. The difference between interfaces and abstract classes are:
    + Interfaces cannot have properties, while abstract classes can
    + All interface methods must be public, while abstract class methods is public or protected
    + All methods in an interface are abstract, so they cannot be implemented in code and the abstract keyword is not necessary
  + Classes can implement an interface while inheriting from another class at the same time
  + Interfaces are declared with the interface keyword
  + Inside Interface must declared method but nothing code inside the body method(like abstract class)
  + Interface cannot declared properties but can declared constants 
  + To use Interface, class needs to implement the interface_name
  + A class that implements an interface must implement all of the interface's methods.
  + Interface can extends from another Interface by using the "extends" keyword 

* When using the Abstract Class and When using the Interface template??

* Magic methods: Methods default in OOP
   + __construct method: automatically called when the object is created
   + __destruct method: automatically called when the object is destroyed
   + __get method: Use to get the data of the properties which is not accessible
   + __set method: Use to set the data of the properties which is not accessible
   + __call method: Use to call the method that is not exits in the object
   + __callStatic method: Use to call the static method that is not exits 

*Trait:
   + PHP only supports single inheritance: a child class can inherit only from one single parent.
   + Traits are used to declare methods that can be used in multiple classes. Traits can have methods and abstract methods 
   that can be used in multiple classes, and the methods can have any access modifier (public, private, or protected).
   + Traits are declared with the "trait" keyword
      --> To use the Trait: use traits_class_name;
   
*Namespaces:  
   + allow the same name to be used for more than one class
   + Ex: 
     classes/Home/class Post  declare namespace HomePost
     classes/Admin/class Post  declare namespace AdminPost
       --> Initialize Object : $homePost = new HomePost\Post();
    --> Structure: $obj_name = new namespace\class_name();
       --> Initialize Object(C2):
                     use HomePost\Post();
                     $homePost = new Post();
    + if using use and still have same name then use "as"
            use HomePost\Post as HomePost
            use AdminPost\Post as AdminPost
            $homePost = new HomePost();

*Final Class:used to prevent a class from being inherited 

*Call multiple method: call method on 1 line 
  --> add return $this on the method

*/