                           
			     UIPublish

			    INTRODUCTION


* COPYRIGHT NOTICE

  UIPublish
  Copyright (c) 2000-2003 Urban Insight, Inc. 
  Revised 2008, JesusAware

  UIPublish is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  UIPublish is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with UIPublish; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA  
  
  (See LICENSE.txt)


* CREDITS

  Developed by Abhijeet Chavan <chavan at users.sourceforge.net>

  UIPublish development is supported by Urban Insight, Inc. 
  http://www.urbaninsight.com

  Also thanks to:

  - Mats Lidstrom <mlidstrom at users.sourceforge.net> (Bugfix)
  - Toni Cornelissen <toni at dse.nl> (HTML filter)
  - Eduardo Lucero <balzac at users.sourceforge.net> (Bugfixes)
  - Quentin O'Sullivan <quentin at qto.com> (QTOFileManager)
  - Christian Peralta <peralta at urbaninsight.com> 
    (QTOFileManager customization)
  

* OVERVIEW

UIPublish CMS 

An entry-level product for existing websites
One of the most important factors in the success of your website is 
keeping it current. With this goal in mind, Urban Insight has developed 
an open source entry-level content management system that helps you to 
manage frequently-changing sections of your website, such as news, 
publications, events, workshops and jobs.

UIPublish is unique in that it can be easily and affordably "plugged 
into" almost any existing static website to provide you with a content 
management system without needing to overhaul your entire website. 
There is no need to be familiar with web publishing tools or HTML. 
You simply enter the information into a browser as you would like it 
to appear on your website, and you control where and when the 
information appears. 

UIPublish is open-source (and therefore requires no license fee), 
and is most-often used by organizations that have websites with 
between 5 and 100 static pages. UIPublish is designed to be 
integrated with Macromedia Dreamweaver and Contribute. UIPublish 
is cross-platform and runs on Linux, Windows and MacOS.


* DESCRIPTION

  A minimalist PHP-based system for managing dynamic content on a
  website. Suitable for publishing articles, announcements, events,
  etc. Provides an administration interface for content managers.
  Look-and-feel of front-end pages can be customized.

  Content is stored as two types of "items" -- "article" items and
  "event" items. Article items are for content such as news or press
  releases. In other words, items with a publication date. Article
  items with a publication date that matches today's date or earlier
  are displayed on the website. Event items are for content such as
  appointments, meetings, or workshops. In other words, items with
  an event date. If the event date of an event  matches today's date
  or is in the future, it is displayed as an upcoming event. Past
  events can also be displayed.

  Both types of items can be classified in to separate sections. For
  example, with UIPublish you can manage content in a "News" section
  as well as "Reports" section. Items can be listed on the main page
  of a website as well as a separate list for each section.Items can
  also be assigned a "Visibility" setting so that only items with a
  "High" visibility setting appear on the main page of the
  website. Each item has a title, summary, content, and event/post
  date. Each item can also display a "related link" or include a
  file kept in a directory on the filesystem.
  

* FEATURES

- Add dynamic content to a static website
- Copy and paste content from any word processing software (like Microsoft Word)
- Easy-to-use Web based control panel for content managers
- Administrative interface is password-protected 
- Content can be scheduled for publication in the future 
- Content can be scheduled to expire on a given date, or can be archived 
- You control the placement of current news items on the home page 
- Add your own hypertext links 
- Ability to use use a WYSIWYG (What you see is what you get) editor to format text and images (or you can opt to use HTML tags within the content) 
- Ability to upload and link images, PDF documents, HTML files
- Ability to "include" formatted HTML pages
- Easy integration with a web publishing tool like Macromedia Dreamweaver, Adobe GoLive, or Microsoft FrontPage.
- Categorize content in 'sections' and by 'topics
- Content is stored in a database for easy and fast access
- Online print and user manual with easy-to-follow screen images
- Automatically provides RSS/XML feeds 

- PHP beginners should find the code simple enough to customize
- Released under the GNU General Public License (GPL)


* REQUIREMENTS, INSTALLATION, AND NOTES

  - PHP (http://www.php.net)
  - MySQL (http://www.mysql.com)

  For more details about requirements and installation information
  see INSTALL.txt. For version notes and other information see
  NOTES.txt.
