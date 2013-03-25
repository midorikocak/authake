v2.3.1 (Mar 25, 2012) Mutlu Tevfik Kocak
    * Settings are working
    * Schema is deleted due to faults

v2.2.3 (Nov 6, 2012) Mutlu Tevfik Kocak
	* Gravatar support
	* All new look & feel
    * Continuous login failure issue solved
    * New markdowns added
    * Enum type of rule permissions are removed
    * Schema file generated
    * New markdown files added

v2.1 (Jan, 31 2012)
    * fixed: this->rquest->data issues
    * login using email
    * views thanks to Lonardo Pedretti
    * fixed: getcontrollers

v2.0 (Oct 27, 2011) Mutlu Tevfik Kocak

THIS VERSION RUNS ONLY WITH CAKEPHP 2.0

	* All changes made to run with CakePHP 2.0
	* __() translations without true thing
	* $components are now $this->Component
	* All folder and file names are compatible with CakePHP 2.0
	* And many other great things to run with CakePHP 2.0

v1.3 (Apr 25, 2010) Nik Chankov

    * Repacked the plugin into a single directory. Working with CakePHP 1.3. Adding many settings which could be overwriten within a project.
    
v1.13 (feb 26, 2008)

    * The default database ids were buggy, as I forgot to include the auto_increment values when exporting to sql (thanks to Eric)

v1.12 (feb 25, 2008)

    * Bug (partialy solved) when password changing in user_controller.php (thanks to Kiang, http://twpug.net/)

v1.11 (feb 19, 2008)

    * Accounts have an expiry date

v1.10 (feb 14, 2008)

THE DATABASE CHANGED SO YOU SHOULD REINSTALL ALL THE TABLES

    * Only administrators can modify or make an administrator. Avoid to gain administrator level.
    * Accounts can be disabled (Marco Sbragi's suggestion)
    * Cometic changes in app_controller.php (everything moved to authake component).
    * Possible to set a specific flash message for the rule that denies the access.
    * New session timeout feature. Allow to have an illimited cake session, and then choose the application session timeout.

First release (feb 12, 2008)
