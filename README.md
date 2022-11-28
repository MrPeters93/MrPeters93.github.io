
Not the prettiest site, but on a timespan of a few hours, I am adequately pleased with the outcome.

I did contemplate creating a windows application which would've been more of a challenge, but one I'd welcome - always fun with challenges.


curl is required to be enabled for the website to work.


Pretty much only press-release.php and stylesheet.css are required for the website to work. They need to be in the same directory, but it's a very lightweight website and don't really have any pre-requisites in addition to basic PHP hosting.

### Installation-instructions:

Alternative 1 - XAMPP (Apache):

XAMPP is an easy to use application that allows personal computers to host websites with ease. When utilizing XAMPP you are given the opportunity to install Apache as a small local-hosted website.
https://www.apachefriends.org/

After installing XAMPP you're given the option to launch Apache, this will in turn enable a URL in your web-browser that allows you to navigate to localhost which in turn automatically navigates to any index.html (among other pre-determined files) available in a specific directory.

The files are to be placed in the following directory:
C:\xampp\htdocs\
![image](https://user-images.githubusercontent.com/29412928/204185868-54c06e94-f7f0-42bf-a9a6-78db2510e314.png)

If the directory isn't working properly, go into XAMPP and click Config on the row of Apache. Select to edit the file http.conf and search for "DocumentRoot", this will show you the location where your PHP files goes.

Assuming that Apache is enabled, you should now be able to navigate to localhost in your browser of choice and it will in turn open index.php which will send you to press-release.php
