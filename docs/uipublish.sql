# $Id: uipublish.sql,v 1.5 2003/03/31 06:44:03 chavan Exp $

#  ---------------------------------------------------------------
#  DESCRIPTION	: Creates tables for UIPublish
#
#  This sql file will create a table called "UIPublish" required 
#  for UIPublish module and one called UIPublish_cal.
#  ---------------------------------------------------------------

#  ------------------------------------------------------------------
#  VERSION HISTORY:
# 
#  2001_07_11
#  - New table for calendar
#  
#  - Decided naming conventions:
#  	* TableNames
#  	* field_names
#  	* field_primary_ID
#  	* field_foreign_key_id
#
#  - Status can be:
#    1 = ACTIVE ( Appears on website )
#    2 = INACTIVE (Default)
#
#  - Weight can be:
#    1 = HIGH (Appears on front page)
#    2 = STANDARD (Default)
#    3 = LOW 
#  ------------------------------------------------------------------

# Uncomment following line if you like to automatically delete 
# an existing UIPublish table. WARNING: If a UIPublish table exists
# this will drop the table and all data will be lost.
#
# DROP TABLE UIPublish;

#  ---- NEWS

CREATE TABLE `UIPublish` (
  `ID` int(11) NOT NULL auto_increment,
  `modify_date` timestamp(14) NOT NULL,
  `post_date` date NOT NULL default '0000-00-00',
  `expire_date` date default NULL,
  `status` tinyint(4) default '2',
  `weight` tinyint(4) default '2',
  `section_id` tinyint(4) default NULL,
  `title` varchar(200) NOT NULL default '',
  `summary` varchar(255) default NULL,
  `content` text,
  `link_title` varchar(200) default NULL,
  `link_url` varchar(200) default NULL,
  `filepath` varchar(200) default NULL,
  PRIMARY KEY  (`ID`)
);

INSERT INTO UIPublish (
       ID,
       modify_date,
       post_date,
       expire_date,
       status,
       weight,
       section_id,
       title,
       summary,
       content,
       link_title,
       link_url,
       filepath)
VALUES (
       NULL, 
       NULL,
       '2000-07-23',
       '2001-08-23',
       '1',
       '1',
       '0',
       'Company Launches New Website',
       'Company, Inc. has launched a new website.',
       'Company, Inc has launched a new website.',
       'Urban Insight',
       'http://www.urbaninsight.com',
       ''
       );
       
# Uncomment following line if you like to automatically delete 
# an existing UIPublish_cal table. If a UIPublish_cal table exists
# this will drop the table and all data will be lost.
#
# DROP TABLE UIPublish_cal;

#  ---- CALENDAR

CREATE TABLE `UIPublish_cal` (
  `ID` int(11) NOT NULL auto_increment,
  `modify_date` timestamp(14) NOT NULL,
  `post_date` date NOT NULL default '0000-00-00',
  `expire_date` date default NULL,
  `status` tinyint(4) default '2',
  `weight` tinyint(4) default '2',
  `section_id` tinyint(4) default NULL,
  `title` varchar(200) NOT NULL default '',
  `summary` varchar(255) default NULL,
  `content` text,
  `link_title` varchar(200) default NULL,
  `link_url` varchar(200) default NULL,
  `filepath` varchar(200) default NULL,
  PRIMARY KEY  (`ID`)
);

INSERT INTO UIPublish_cal (
       ID,
       modify_date,
       post_date,
       expire_date,
       status,
       weight,
       section_id,
       title,
       summary,
       content,
       link_title,
       link_url,
       filepath)
VALUES (
       NULL, 
       NULL,
       '2000-07-23',
       '2001-08-23',
       '1',
       '1',
       '0',
       'Company Launches New Calendar',
       'Company, Inc. has launched a new website.',
       'Company, Inc has launched a new website.',
       'Urban Insight',
       'http://www.urbaninsight.com',
       ''
       );       
       