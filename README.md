# Camagru
This is an MVC framework.

## Setup
There is a file `config/setup.php`. This file can call migration or destroying database; reinitialize or restore `app/*` directories.
Examples:

    //call database migration
    php setup.php migrate
    
    //call database destroying
    php setup.php destroy
    
    //clean and create app directories
    php setup.php clean
    
    //create missing directories
    php setup.php restore
    
    //combination
    php setup.php migrate clean