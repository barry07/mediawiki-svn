-- MySQL version of the database schema for the Storyboard extension.

CREATE TABLE `/*$wgDBprefix*/storyboard` (
  story_id           INT(8) unsigned   NOT NULL auto_increment,
  story_author_id    INT unsigned          NULL,
  story_author_name  VARCHAR(255)          NULL, 
  story_hit_count    INT(8) unsigned   NOT NULL,
  story_title        VARCHAR(255)      NOT NULL,
  story_text         MEDIUMBLOB            NULL,
  story_modified     CHAR(14) binary   NOT NULL default '',
  story_created      CHAR(14) binary   NOT NULL default '',
  PRIMARY KEY  (`story_id`)
); 