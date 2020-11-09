## CMS package for Laravel Orchid Platform


<p align="left">
  <a href="https://packagist.org/packages/orchid/press">
    <img src="https://poser.pugx.org/orchid/press/v/stable"/>
  </a>
  <a href="https://packagist.org/packages/orchid/press">
    <img src="https://poser.pugx.org/orchid/press/downloads"/>
  </a>
  <a href="https://packagist.org/packages/orchid/press">
    <img src="https://poser.pugx.org/orchid/press/license"/>
  </a>
</p>


> **This package is not looking for a maintainer!** If you want to be one, write to the mail bliz48rus@gmail.com


## Content Management System Entities

The entity is the main part of the Press content management system. Instead of generating a CRUD for each model,
you can select any object in a separate type and easily manage it. Essence only applies to
models based on 'Post', as it is the base for typical data.

It would help if you described the fields you want to receive and in what form, and its CRUD will be built by itself.

![Entities](https://orchid.software/assets/img/scheme/entities.jpg)

You can create an entity using the commands:

```php
// Create entity for one record
php artisan orchid:entity-single   

// Create entity for many records
php artisan orchid:entity-many
```

> To display an entity to a user, you must endow it
or group (roles) with the necessary rights using the graphical interface.

The type looks like this:

```php
namespace DummyNamespace;

use Orchid\Press\Entities\Many;

class DummyClass extends Many
{

    /**
     * @var string
     */
    public $name = '';

    /**
     * @var string
     */
    public $slug = '';

    /**
     * @var string
     */
    public $icon = '';

    /**
     * Slug url /news/{name}.
     * @var string
     */
    public $slugFields = '';

    /**
     * Rules Validation.
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @return array
     */
    public function fields()
    {
        return [];
    }

    /**
     * Grid View for post type.
     */
    public function grid()
    {
        return [];
    }

    /**
     * @return array
     */
    public function options()
    {
        return [];
    }
}

```

You can extend the datatype with all available methods,
  to add new functionality to it that suits your application.

 
## Mesh modification
 

The data you want to display in the grid can be changed by
  passing an array with a name and a function instead of a key-value,
   where the passed parameter is the original data slice.

 ```php
 /**
  * Grid View for post type.
  */
 public function grid()
 {
     return [
         TD::set('name','Name'),
         TD::set('publish_at','Date of publication'),
         TD::set('created_at','Date of creation'),
         TD::name('full_name','Full name')->render(function($post){
             return  "{$post->getContent('fist_name')} {$post->getContent('last_name')}";
         })
     ];
 }

```

# Posts

The press assumes that by default, any elements containing site data are the `Post` model.
This structure is suitable for most public websites as their structure is very similar.
Such as:
- News,
- Promotions,
- Pages,
- Vacancies

You can think of hundreds of variations. In order not to use almost identical models
and migration uses the basic `Post` model. It uses the JSON type for columns, so
much more convenient and simpler than the EAV format. Also, it allows for translation.
We have specially reproduced some approaches with WordPress for Laravel, which will allow you to be more efficient.

## Getting data
So now you can get the database data:

```php
use Orchid\Press\Models\Post;

$posts = Post::all();
```

```php
// All posted posts
$posts = Post::published()->get();
$posts = Post::status('publish')->get();

// Specific entry
$post = Post::find(42);

// Post name based on the current localization
echo $post->getContent('name');

```


Being able to store localization in JSON does not mean that you have to fill in all values. For example, a record of information about a bar, it can be in Russian and English, but the number of seats
will not change for any language. Accordingly, it makes no sense to duplicate such parameters but put them in the `options`.


```php
// Specific entry
$post = Post::find(42);

// All options
echo $post->getOptions();

// Get all localization parameters from options
echo $post->getOption('locale');

// If the option does not exist or is not specified
// you can specify the second parameter that will be returned.
echo $post->getOption('countPlace',10);

```


## Single table inheritance

If you choose to create a new class for your custom post type, you can return that class for all instances of that post type.

The definition of write behavior is based on the specified `type`.
```php
//Все объекты в коллекции $videos будут экземплярами Post
$videos = Post::type('video')->status('publish')->get();
```


## Taxonometry

You can get taxonometry for a specific post, for example:

```php
$post = Post::find(42);
$taxonomy = $post->taxonomies()->first();
echo $taxonomy->taxonomy;
```

Or, you can search for records using your taxonomy:

```php
$post = Post::taxonomy('category', 'php')->first();
```


More complex forms are possible, for example, get all entries from the `main` category including its child categories:

```php
$posts  = Post::whereHas('taxonomies.term', function($query){
	$query->whereIn('slug',
	    Category::slug('main')->with('childrenTerm')
	    ->first()->childrenTerm->pluck('term.slug')
	);
})->get()
```

Remember that such records may be less efficient in sampling rate and are given as an example.

## Categories and Taxonometry
You can use the following methods to retrieve a category, taxonometry, or record from a specific category:

```php
// All categories
$category = Taxonomy::category()->slug('uncategorized')->posts()->first();


// Only all categories and entries associated with it
$category = Taxonomy::where('taxonomy', 'category')->with('posts')->get();
$category->each(function($category) {
    echo $category->term->getContent('name');
});

// all posts from category
$category = Category::slug('uncategorized')->posts()->first();
$category->posts->each(function($post) {
    echo $post->getContent('name');
});
```


## Attachments

Attachments are files related to a recording.
These files can be of different formats and resolutions.
```php
$item = Post::find(42);
$image->attachment()->first();
$image->url();
```


## Full text search

To use full text search, you need to add a new method to your behavior class:

```php
/**
 * Get the indexable data array for the model.
 *
 * @param $array
 *
 * @return mixed
 */
public function toSearchableArray($array)
{
    // Customize array...

    return $array;
}
```


It will accept all model data, and return elements that are required for indexing.

Let's take the standard “DemoPost.php” for example, it has many parameters, but really, we only need two:

- Article title
- The content of the article

To do this, we must return them:

```php
/**
 * Get the indexable data array for the model.
 *
 * @param $array
 *
 * @return mixed
 */
public function toSearchableArray($array)
{
    $array['content']['en']['id'] = $array['id'];

    return $array['content']['en'];
}
```

We returned all data in English, with a zip code.

To import, it remains only to apply the command:

```php
php artisan scout:import Orchid\\Press\\Models\\Post
```

Now we can use search in our projects:

```php
use Orchid\Press\Models\Post;
$articles = Post::search('как пропатчить kde2 под freebsd')->get();
```


## Tags

Tag (tag) - a word or phrase that can unite a group of text, images, etc. on a topic

Tags can be connected to all created models using the trait

```php
use Orchid\Press\TraitsTaggableTrait;

class Product extends Eloquent
{
    use TaggableTrait;
}
```

In the `Post` model, it is included by default, so examples will be on it.
In this section, we'll show you how you can manage your tag subjects.

```php
use Orchid\Press\Models\Post;

// Get the entity object
$post = Post::find(1);

// Through a string
$post->tag('foo, bar, baz');

// Through an array
$post->tag([ 'foo', 'bar', 'baz']);
```

Removes one or more tags from an object via an array or an entity-delimited string.

```php
// Get the entity object
$post = post::find(1);

// Through a string
$post->untag('bar, baz');

// Through an array
$post->untag(['bar', 'baz']);

// Remove all the tags
$post->untag();
```


This method is very similar to the `tag()` method, but it combines `untag()` to automatically identify the tags to add and remove. This is a beneficial technique when running an update on subjects, and you don't want to deal with checks to check which tags should be added or removed.

```php
// Get the entity object
$post = Post::find(1);

// Through a string
$post->setTags('foo, bar, baz');

// Through an array
$post->setTags(['foo', 'bar', 'baz']);

// Using the `slug` column
$post->setTags(['foo', 'bar', 'baz'], 'slug');
```

We have some methods to help you get all the tags attached to an object and do the opposite and get all the objects with the given tags.

```php
// Get the entity object
$post = Post::whereTag('foo, bar')->get();


$post = Post::find(1);
$tags = $post->tags;

$tags = Post::allTags();
```


# Comments

Comments are a required attribute for some types of websites.
Thanks to them, users can express their opinion on any record,
support or refute the opinions expressed, conduct a dialogue with other users.

Comments are attached to Post entries

```php
use Orchid\Press\Models\Comment;
use Orchid\Press\Models\Post;

$post = Post::find(42);

$comment = Comment::create([
    'post_id'   => $post->id,
    'user_id'   => Auth::id(),
    'parent_id' => 0,
    'content'   => 'Any text',
    'approved'  => 1,
]);

```


## Relationship


```php

// Retrieve all comments for a specific Post
$comments = Comment::findByPostId(42);


$comment = Comment::find(1);

// Get in touch with Post
$post = $comment->post();

// Get parent comment
$comment = $comment->original();

// Get child comments
$comment = $comment->replies();

// Get the author of the comment
$comment = $comment->author();

```


## Checks

```php
$comment = Comment::find(1);


// Check if a comment has been posted
$comment->isApproved();

// Check if a comment is a response to another comment
$comment->isReply();

// Check if the comment has answers
$comment->hasReplies();
```


# Menu

The package includes an easy-to-use mechanism for creating custom menus (navigation),
using drag & drop and localization support.


## Configuration

Most of the menus are displayed at the top of the site,
but the location may be different for different applications,
the number of menus is limited and defined in the configuration file `config/press.php`

```php
'menu' => [
    'header'  => 'Top Menu',
    'sidebar' => 'Sidebar Menu',
    'footer'  => 'Footer Menu',
],
```

## Model

The Menu class is a regular `Eloquent` model, all its capabilities are available to it,
for example, to display only parent menu items with child links
and taking into account localization, it is necessary:

```php
namespace Orchid\Press\Models\Menu;

$menu = Menu::where('lang', app()->getLocale()())
    ->where('parent',0)
    ->where('type', 'footer')
    ->with('children')
    ->get();
```


Methods available:

```php
//First child
$menu = Menu::find(1)->children()->first();


//Parent element
$menu = Menu::find(1)->parent()->get();
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
