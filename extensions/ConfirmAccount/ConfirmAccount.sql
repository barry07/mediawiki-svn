-- (c) Aaron Schulz, 2007

-- Table structure for table `Confirm account`
-- Replace /*$wgDBprefix*/ with the proper prefix

-- This stores all of our reviews, 
-- the corresponding tags are stored in the tag table
CREATE TABLE /*$wgDBprefix*/account_requests (
  acr_id int unsigned NOT NULL auto_increment,
  -- Usernames must be unique, must not be in the form of
  -- an IP address. _Shouldn't_ allow slashes or case
  -- conflicts. Spaces are allowed, and are _not_ converted
  -- to underscores like titles. See the User::newFromName() for
  -- the specific tests that usernames have to pass.
  acr_name varchar(255) binary NOT NULL default '',
  -- Optional 'real name' to be displayed in credit listings
  acr_real_name varchar(255) binary NOT NULL default '',
  -- Note: email should be restricted, not public info.
  -- Same with passwords.
  acr_email tinytext NOT NULL,
  -- Initially NULL; when a user's e-mail address has been
  -- validated by returning with a mailed token, this is
  -- set to the current timestamp.
  acr_email_authenticated binary(14) default NULL,
  -- Randomly generated token created when the e-mail address
  -- is set and a confirmation test mail sent.
  acr_email_token binary(32),
  -- Expiration date for the user_email_token
  acr_email_token_expires binary(14),
  -- A little about this user
  acr_bio mediumblob NOT NULL,
  -- Private info for reviewers to look at when considering request
  acr_notes mediumblob NOT NULL,
  -- Links to recognize/identify this user, CSV, may not be public
  acr_urls mediumblob NOT NULL,
  -- IP address
  acr_ip VARCHAR(255) NULL default '',
  --Name of attached file (.pdf,.doc,.txt ect...)
  acr_filename VARCHAR(255) NULL,
  acr_storage_key VARCHAR(64) NULL,
  
  -- Timestamp of account registration.
  acr_registration char(14) NOT NULL,
  
  -- Flag for rejected accounts
  acr_deleted bool NOT NULL,
  -- Time of rejection (if rejected)
  acr_rejected binary(14),
  -- Time request was put on hold (if held)
  acr_held binary(14),
  -- The user who rejected/held it
  acr_user int unsigned NOT NULL default 0,
  -- Reason
  acr_comment varchar(255) NOT NULL default '',
  
  PRIMARY KEY (acr_id),
  UNIQUE KEY (acr_name),
  INDEX (acr_email_token),
  INDEX acr_deleted_reg (acr_deleted,acr_registration)
) TYPE=InnoDB;