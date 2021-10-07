# MVCFrameworkPHP
This project is an application built in a custom built PHP MVC framework.

## Starting the application 

### Prerequisites

You must have PHP7.4 or higher installed.

You must have a database setup and running on your system before starting the app. The databse must be MySQL.
To create the database structure for the app, run the ```migrations_and_seeding.sql``` file in the root directory.
The file will create a database called ```testdb``` and create the following table structure:

1. ```users(id, name, email, password, type_id, technology_id, framework_id)```
2. ```types(id, name)```
3. ```technologies(id, name, type_id)```
4. ```frameworks(id, name, technology_id)```

And it will seed the database with data for the ```types```, ```frameworks``` and ```technologies``` tables.
You need to have a database user with access to this new database, enter this user's details in the ```/config/database_config.php``` config file.
If your database is not running on port ```3306``` that needs to be changed in the config as well.

### Starting the app

Run ```php -S localhost:port``` from the project root directory, replace ```port``` with the port you want the application to be available on.
You can now open and use the application in your browser.


### Code test task

The code for the code test task is located in:

#### Code test controllers

```/controllers/UserController.php``` Contains the functionality for user register/login and searching for users 

```/controllers/HomeController.php``` Contains functionality to display the home page. 


#### Code test models

```/models/User.php``` Contains functionality to create, read and update users 

```/models/Technology.php``` Contains functionality to read technologies 

```/models/Framework.php``` Contains functionality to read frameworks 

#### Code test views

```/resources/templates/home.tpl``` The home page with the search form 

```/resources/templates/login.tpl``` The login page 

```/resources/templates/loginform.tpl``` A login form component to allow having a login form in the results page 

```/resources/templates/register.tpl``` The register page 

```/resources/templates/results.tpl``` The results page

## Using the framework as a framework

The framework this application is built in can be used like any other PHP framework.


### Configuration

All configuration files for the application are in the config folder, there are 4 configuration files:

1. ```app_config.php``` Contains the main configuration options for the app such as the app name, the setting for maintenance mode, enabling or disabling authentication..etc
2. ```database_config.php``` Contains configuration options for the database connection/s such as database names, usernames and passwords, the framework currently supports working only with one database connection and toggling between connections has to be done by editing the config.
3. ```route_config.php``` Contains the routes for the application, here you can add/remove routes to the application.
4. ```validator_config.php``` Here you can define rules for validating requests to the application.

The config files contain additional instructions and explanations for the options inside.

### Views

Front end templates (views) are stored in the ```/resources/templates``` folder

The framework uses the Smarty PHP templating engine although it can be easily replaced with another if needed.
The templates are Smarty PHP templates.

#### Short expressions

You can return a view from anywhere in the app by calling ```view('template_name', parameters)```, the parameters are optional and represent an array of parameters to pass to the view template.
If you need to inject a view somewhere (for example a login form component), you can call ```viewString('template_name', parameters)```, this function will return the rendered view as a string which you can later echo back to your frontend.

#### CSRF protection

If your view is going to contain a form, the form must have a csrf token field. The framework allows for inserting a csrf form field in any form just by calling the ```csrf()``` helper function from inside the template, example: 
```
<form>
{csrf()}
.
.
.
</form>
```

### Javascript and CSS

All scripts and stylesheets are stored in the ```/resources/css``` and ```/resources/js``` folders respectively.
The framework will load all scripts and stylesheets it finds in these folders.


### The Request object

On startup the incoming request is captured and stored as a Request class object.
The Request class provides methods for working with the captured request.
The methods provided are:

1. ```hasCookie($cookie)``` Checks if the request has the provided cookie
2. ```getCookie($cookie)``` Returns a cookie if present in the request
3. ```getAllCookies()``` Returns all cookies from the request
4. ```isFormData()``` Checks if the request contains form data
5. ```hasKey($key)``` Checks if the request has the provided parameter key 
6. ```getKey($key)``` Returns the parameter that has the provided parameter key, if it exists
7. ```method()``` Returns the request method (POST, GET, PUT, PATCH, DELETE)      
8. ```all()``` Returns all request parameters
9. ```only($parameters)``` Returns those request parameters whose keys you pass as a parameter to the function
10. ```getContentType()``` Returns the content type header of the request
11. ```accepts()``` Returns the content of the accept header
12. ```getFullRequestUrl()``` Returns the full url of the request
13. ```getRequestPath()``` Returns only the path of the request
14. ```getHost()``` Returns only the host of the request
15. ```hasId()``` Checks if the request target is a resource id, example ```/resource/1```
16. ```getPathElements()``` If the request path has a resource id get the elements of the path

### Controllers

Controllers are stored in the controllers folder.
All controllers must extend the base Controller class.

All controller methods that will be used as POST/GET route targets need to accept an instance of the Request class as their first parameter and have all other parameters be optional.


### Models

Models are stored in the models folder.
All models must extend the base Model class.
All models have access to a property  ```database``` from the base class.
The database property gives simple access to the currently connected database using a class named PDODatabaseAccess which provides a simple interface to PDO. This class is loosely coupled via a DatabaseAccess interface and can be swapped out if needed.

The methods available are:
1. ```query(string $query)``` Set the query string, the queries use prepared parameters but can be used without (not recommended)
2. ```with(array $parameters)``` Set the query parameters, if query doesn't need parameters or you want to make a query without prepared parameters, this call can be ommited.
3. ```run()``` Run the query, this function returns only a boolean status and is to be used if no results are expected.
4. ```fetch()``` Run the query and fetch all rows that the query returns, the results are returned in an associative array containing ```status``` - the success of the query and ```results``` an array of the returned rows.
5. ```first()``` Run the query and fetch only the first row, the results are returned in an associative array containing ```status``` - the success of the query and ```results``` the returned row.

An example call to database would be \
```
$this->database->query("select * from users where id = :id")->with([':id'=>the_id])->fetch()
```

### Authentication 

Authentication is done via the Authentication class. For now the application supports only session based authentication provided by the SessionAuthenticator class, but other types can be added they just need to implement the Authenticator interface.
To authenticate a user call the ```authenticateUser($password, $hash, $id)``` method from the Authenticator class instance, or you can call the method in a single line by chaining the class instantiation with it ```Auhtenticator::getInstance()->authenticateUser($password, $hash, $id)``` 
This method takes the password provided by the login request, the user's hashed password from the database and the user's id as arguments and on success sets the currently authenticated user to be the provided user id. If an authentication is successful the function will return ```true``` otherwise it will return ```false```

To log out a user (clear authentication status) use the ```revokeAuthentication()``` method.

To get the currently authenticated user's id use the ```getAuthenticatedId()``` method.

The framework doesn't come with login/logout functionality out of the box, it is the user's job to implement a functionality that will recieve a login request, validate the data , attempt an authentication and handle the results of it.
The framework does contain helper methods and classes to make this process easier.

#### Short expressions

You can check if a user is currently authenticated by using the ```auth()``` method, it will return  ```true``` if there is an authenticated user or ```false``` if not. This can be used inside templates to show/hide segments depending on if the user is authenticated.


### Validating request data

The framework provides a Validator class that can be used to validate incoming request against a defined set of rules. The available rules are in the ```/config/validator_config.php``` file.
The user can define new rules as long as they follow the naming pattern given in the config file, there are rules already provided as examples that can also be used to validate data.

To validate a request call the ```validateRequest($request)``` method from the Authenticator class, this can also be called as ```Validator::getInstance()->validateRequest($request)``` 

If validation fails the user will be redirected back to the previous page with the validation errors in session.

#### Short expressions

The request validation can be done with a shorter expression ```validate($request, $rules)```

The error messages from a failed validation can be retrieved using the ```errors()``` function. This function will retrieve the errors from session in a string, separated by linebreaks. This function can be used inside a template to show the errors when the user gets redirected back.
An example of how this function can be used:
```
<form>
.
.
.
</form>
<div id="errors" class="text-danger">
{errors()}
</div>
```

### Cookies

The framework provides a Cookies class that contains methods for setting and reading encrypted cookies.
The encryption algorithm can be found in ```/config/app_config.php```

#### Reading cookies

For reading encrypted cookies (encrypted by the application itself since only the algorithm used by the app can be decrypted)
the method ```Cookies::readCookieFromRequest($request, $name)``` can be used. The method takes in the request and the name of the cookie you're looking for and returns the cookie as a string.

#### Setting cookies 

For setting encrypted cookies the method ```Cookies::setCookie(string $name, string $data)``` is provided. The method takes in the cookie name and value and returns the success of the operation.

#### Clearing a cookie

For clearing a cookie the method ```Cookie::clearCookie(string $name)``` is provided. The method takes the cookie name as a string and sets it's expire date to be in the past. 

### Encryption

The Encryption class is used to hash passwords and encrypt data for cookies, but is also available for the user to utilise wherever they see fit.

#### Encrypting data

For encrypting data, the method ```encryptString($string)``` is provided. The data needs to be in a string format. The method returns the encrypted data as a string.
This method can also be called in a one line statement like ```Encryption::getInstance()->encryptString($string)```

#### Decrypting data

For decrypting data, the method ```decryptString($string)``` is provided. The data needs to be in a string format. The method returns the decrypted data as a string.
This method can also be called in a one line statement like ```Encryption::getInstance()->decryptString($string)```

### Redirecting users

The framework provides a Redirect class for handling redirects. All user accessable functionality of this class can be accessed through the ```redirect($route, $code, $messages)``` function.

The function has no required parameters , the route parameter should contain a route for the user to be redirected to but if it's empty the user will be redirected to their previous location. 

For redirecting to the home route, the full route is not needed, instead the route parameter could be set to ```'home'```.

The code parameter is the response code for the redirect, if left null the redirect will return a 200 OK code.  

The messages parameter is an array of messages to be saved in session and be available after the redirect. If left out, there won't be any messages saved.

### Messages

#### Viewing

For viewing messages set in the current session the function ```messages()``` is provided, it returns the messages formatted for displaying in a template.

Example usage:

```
<div id="messages" class="text-info">
{messages()}
</div>
```
#### Setting

There is no method to set messages as of now, but they can be set manually since they are stored in the current session.
To set a message use ```Session::append('messages', "Your message")```