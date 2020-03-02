# HtmlSkel
  
  
## use via composer.json / GIT VCS (recommended way) :
(demo app will be in /vendor/olaulau/htmlskel directory)  

```
{
	"repositories": [
	    {
	        "type": "vcs",
	    	"url": "https://github.com/olaulau/HtmlSkel"
		}
	],
	"require": {
		"olaulau/htmlskel": "dev-master"
	}
}
```
then : ``composer install``  
to copy demo content : ``cp -R vendor/olaulau/htmlskel/{assets,conf,php,.gitignore,.htaccess,index.php} .``


## make your project directly extend this skel (not recommended) :
(demo app will be at your project root)  
``git clone git@github.com:olaulau/HtmlSkel.git .``   
then change your project's GIT url:  
``git remote set-url origin https://github.com/USERNAME/REPOSITORY.git``    
  