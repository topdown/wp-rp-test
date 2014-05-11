RP-TEST theme for Wordpress
==============

the RP theme is a trial task made by me , in order to show my knowledge and skills in Wordpress and PHP. 

Here will be a short documentation on how to use the theme as well as some tutorials.

Installation
------------
There are 2 ways to install the theme.

**Uploading in WordPress Dashboard**

1. Navigate to the 'Add New' in the themes dashboard
2. Navigate to the 'Upload Theme' area
3. Select `rp_test.zip` from your computer
4. Click 'Install Now'
5. Activate the theme

**Using FTP**

1. Download `rp_test.zip`
2. Extract the `rp_test` directory to your computer
3. Upload the `rp_test` directory to the `/wp-content/themes/` directory
4. Activate the Theme in the Theme dashboard


Theme Setup
------------

After the theme is activated you have to setup the "Home page" and "Menu"
Otherwise you will have a chunky frontPage and one menu item "Home"

The theme will create a page called "Home page" with slug "rp_home".
This page will have all the fields needed to customize the Frontpage.

In order to setupe the Frontpage go to pages->Home Page and fill out the forms.

For more details about he Homepage setup visit our [wiki->Home Page setup](https://github.com/rubenCodeforges/wp-rp-test/wiki/Home-page-setup)

You also should add some menu items , by default the theme displays only a "Home" menu item.

Theme Customization
------------

The RP theme is well customized , there a lot of sections you can customize,
The theme has also some theme settings

Here is a small list :
* Site title
* Footer socials.
* Navigation - supports 2 menus
* Footer copyrights

There are more things you can customize , please visit the [wiki](https://github.com/rubenCodeforges/wp-rp-test/wiki) for more details

Theme specific widget
------------

The theme provides its custom widget.
The widget is based on the standard Category widget, with some additions.

RP Sidebar widget - Located in `Appearance -> widgets`

Theme Vendors
------------
The theme has a heavy use of the `ACF - plugin` (Advanced Custom Field).
If you dont have this plugin , the theme will promt you to install it.

Fore more information about this plugin got to [ACF Website](http://www.advancedcustomfields.com/)

The Theme uses the `TGM-Plugin-Activation` Class , author Thomas Griffin [Git Hub Link](https://github.com/thomasgriffin/TGM-Plugin-Activation)
