# This software, copyright (C) 2008-2009 by Wikiation.  "This software is developed by Kim Bruning."
# (C) 2009 Kim Bruning, Charles Melbye 
#
# Distributed under the terms of the MIT license.
#
# =============================================================
# Default settings file. DO NOT EDIT (edit settings.py instead)
# =============================================================

# Provides sane defauls and backwards compatibility for
# settings.py.

import os, getpass

# "You Are Here"
installerdir=os.path.dirname(os.path.abspath(__file__))

# where to find .install directories and the files contained therein
installfiles=os.path.join(installerdir,'installfiles')
testfiles=os.path.join(installerdir,'testfiles')

# where do we store the _tagcache file
tagcache=os.path.join(installerdir,"_tagcache")

# where to find mediawiki tags and trunk on svn
tagsdir="http://svn.wikimedia.org/svnroot/mediawiki/tags"
trunkdir="http://svn.wikimedia.org/svnroot/mediawiki/trunk"
# we could alternately/additionally take a tag version for extensions. (future)
extensionssubdir="extensions"
extensionsdir=trunkdir+"/"+extensionssubdir

#how to call php
phpcommand="php"

# where to install diverse revisions
# (Let's guess we want to use the typical public_html, you'll still need to make 
# the directory "revisions" though!)
# override if you want to use someplase else!
instancesdir=os.path.expanduser('~/public_html/revisions')


# base scriptpath for every installation (ie, where to reach the above over the web)
base_scriptpath="/~"+getpass.getuser()+"/revisions/"

# where to install the toolkit
toolkit_dir=os.path.split(installerdir)[0]

#where check_isolation can be found

isolation_create=toolkit_dir+'/check_isolation/create_and_ul.sh'
isolation_test=toolkit_dir+'/check_isolation/dl_and_check.sh'
# run automated tests during installation
# this is useful if you are in a testing environment.
# If you are running production, you might want to leave
# this set to False.
run_automated_tests=False

debug=False

# initial user
adminuser_name="admin"
adminuser_password="admin1234"

#mysql info
mysql_user="root"
mysql_server="localhost"
mysql_pass=""


#Prefix database names used by the installer with some unique string.
# This is useful if multiple people on one machine are using the same
# mysql instance, to prevent collisions. 
#
# Note that it might be a bad idea to change this is you still have 
# old databases around, because the installer won't be able to see them.

dbname_prefix=""


# default language code for the wiki.

wgLanguageCode="en"

# what mysql commands should be used. (Who us? Use horrible hacks?)


userpart=""
passpart=""
mysql_opts=""
if os.path.exists(os.path.join(installerdir, 'settings.py')):
       from settings import *
	
if mysql_user:
	userpart="-u"+mysql_user

if mysql_pass:
	passpart="-p"+mysql_pass

if mysql_server:
	serverpart="-h"+mysql_server

if not 'mysql_arguments' in globals():
	mysql_arguments=" "+userpart+" "+passpart+" "+serverpart

if not 'mysql_command' in globals():
	mysql_command="mysql "+mysql_opts+" "+mysql_arguments

if not 'mysqldump_command' in globals():
	mysqldump_command="mysqldump "+mysql_arguments


#legacy support (rename old variables, etc)
if 'revisionsdir' in globals():
	instancesdir=revisionsdir
	
