This Bundle can be used for the management of assets in symfony.

# How to works ?
A service theme is registered in the DIC. He allows the others services with the tag "lia.subscriber.theme" to subscribe himself.

# Implementation

## base.html.twig 
Modify the file :
```twig
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>{% block title %}Welcome!{% endblock %}</title>
        {{ lia_get('lia.service.theme').renderTop() }}
        {% block stylesheets %}{% endblock %}
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    </head>
    <body>
        {% block body %}{% endblock %}
        {{ lia_get('lia.service.theme')->renderBottom() }}
        {% block javascripts %}{% endblock %}
    </body>
</html>
```
## ThemeSubscriberAutoService.php
Creates a file : **[BUNDLE]/DependencyInjection/ThemeSubscriberAutoService.php** 
```php
    
    namespace [BUNDLE]\DependencyInjection;
    
    use Lia\ThemeBundle\Core\AssetBag;
    use Lia\ThemeBundle\Core\SubscriberBase;
    
    class ThemeSubscriberAutoService
        extends SubscriberBase
    
    {
        /**
         * Allows to set the assets for the bundle
         * They will be on the top of the page
         * @param AssetBag $bag
         */
        public function setTop(AssetBag $bag)
        {
    
        }
    
        /**
         * Allows to set the assets for the bundle
         * They will be on the bottom of the page
         * @param AssetBag $bag
         */
        public function setBottom(AssetBag $bag)
        {
            
        }
    }
    
```

Automatically this class will subscribe to main service (described on top). 

Now you can add asset files (css, javascript) in the $bag object.

All asset files will be loaded in the skeleton of the page.
