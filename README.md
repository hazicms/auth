Steps to Get Started
--------------------


1. Add this package to your composer.json:
  
        "require": {
            "hazicms/auth": "dev-master"
        }
  
2. Run composer update

        composer update
    
3. Add the ServiceProviders to the providers array in ```config/app.php```.<br>

        'HaziCms\Auth\AuthServiceProvider'


4. Publish config files for generators, modules and images:

        php artisan vendor:publish --provider="HaziCms\Generator\Generator\GeneratorServiceProvider"

        php artisan vendor:publish

        php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravel5"

5. Modify ```modules.php``` file to your needs.On Cms, change 'namespace' => 'HaziCms\Modules', and 'modules' => app_path('Modules').

6. Modify ```generator.php``` file to your needs.

7. Add ADMIN-LTE dashboard template: cd public && bower update && cd ..

8. Add bower dependencies (at least CKEditor):  cd vendor/hazicms/generator/ && bower update && cd ..

9. Fire artisan command to generate module with model.

        php artisan hazicms:generator ModuleName ModelName
        
    e.g.
    
        php artisan hazicms:generator Network Project
        php artisan hazicms:generator Blog Post
 
11. Enter the fields with options<br>

    fieldName:fieldType[,htmlAtribute1 ,htmlAtribute2]:[fieldData]:[defaultOption]
    
    Examples: 
        
        Select: group:select,'id' => 'mySelect', 'class' => 'red':['admin' => 'admin','user' => 'user']:user
        Text: title:text,'size' => 255
        Float: price:float,'min' => 1, 'max' => 10
        Textarea: body:textarea,'placeholder' => 'Body content' (make ```bower install``` inside generator folder)
        Radiobutton: sex:radio,'id' => 'sex', 'class' => 'red':['male' => 'ale','female' => 'fem']:fem
        Checkbutton: data:check,'id' => 'data', 'class' => 'red':['clean_the_room' => 'clean','go_to_your_home' => 'home']:home (*)
        Number: assistance:number,'id' => 'assistance', 'class' => 'red'
        Date: birthday:date,'id' => 'date', 'class' => 'red' (make ```bower install``` inside generator folder)

    There are some basic field examples on field_example_data file.

(*) Need to uncomment 3 lines on the modules controller to run. Laravelcollective/form has a bug with checkboxes. Until this been solved, this trick is needed! :-(
If you see "preg_replace(): Parameter mismatch, pattern is a string while replacement is an array" error, you need to read the last sentece. :-)

12. Go to http://domain.com/admin/[Plural's ModelName] :)


Use ROXY fileman[0] as a filebrowser for CKEditor
-------------------------------------------------

1. Download fileman for PHP, unzip on public folder and give permissions.

2. Add on: /public/theme/ckeditor/config.js

        var roxyFileman = '/fileman/index.html';
        config.filebrowserBrowseUrl = roxyFileman;
        config.filebrowserImageBrowseUrl = roxyFileman+'?type=image';
        config.removeDialogTabs = 'link:upload;image:upload';

3. On public/fileman/conf.json change INTEGRATION to "ckeditor".

[0] http://www.roxyfileman.com/CKEditor-file-browser


Credits
--------

This module generator is created by [Aitor Ibañez](https://github.com/aitiba).

This package is based on [laravel-api-generator](https://github.com/mitulgolakiya/laravel-api-generator).

**Bugs & Forks are welcomed :)**
