# HtmlSkel
  
## make your project directly extend this skel :
(demo app will be at your project root)  
``git clone git@github.com:olaulau/HtmlSkel.git .``   
then change your project's GIT url:  
``git remote set-url origin https://github.com/USERNAME/REPOSITORY.git``    
  
  
## use via composer.json (GIT VCS) :
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
