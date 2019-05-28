
# Сущности системы управления содержимым

Сущность является основной частью системы управления содержимым ORCHID, вместо того, чтобы генерировать CRUD для каждой модели
можно выбрать любой объект в отдельном типе, и легко управлять им. Сущность применяются только к
моделям на основе 'Post', так как она является базовой для типичных данных.

Вам необходимо описать поля которые хотите получить и в каком виде, а её CRUD построиться сам.

![Entities](https://orchid.software/assets/img/scheme/entities.jpg)

## Создание сущности

Вы можете создать сущность с помощью команд:

```php
//Создать сущность для одной записи  
php artisan orchid:entity-single   

//Создать сущность для многих записей
php artisan orchid:entity-many
```

> Для отображения сущности пользователю, необходимо наделить его
или группу (роли) необходимыми правами с помощью графического интерфейса.

Тип выглядит следующим образом:

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

Вы можете расширить тип данных всеми доступными методами,
 чтобы добавить к нему новую функциональность, которая соответствует вашему приложению.

 
## Модификация сетки
 

Данные, которые вы хотите отобразить в сетке, можно изменить,
 передав массив с именем и функцией вместо значения ключа,
  где переданный параметр является исходным срезом данных.

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


# Записи

Платформа предоставляется с возможностями CMS и она предполагает, что по умолчанию любые элементы, содержащие данные сайта, являются моделью `Post`.
Такая структура подходит для большинства публичных веб-сайтов, так как их структура очень сильно похожа.
Как например:
- Новости,
- Акции,
- Страницы,
- Вакансии

Вы можете придумать сотни вариаций. Для того, что бы не использовать почти одинаковые модели
и миграции ORCHID использует базовую модель `Post`. Она использует JSON тип для колонок, что 
гораздо удобнее и проще, чем EAV формат, кроме того, это позволяет делать перевод. 
Некоторые подходы мы специально воспроизвели с WordPress для Laravel, что позволит вам быть эффективнее.

## Получение данных
Итак, теперь вы можете получить данные базы данных:

```php
use Orchid\Press\Models\Post;

$posts = Post::all();
```

```php
// Все опубликованные записи
$posts = Post::published()->get();
$posts = Post::status('publish')->get();

// Конкретная запись
$post = Post::find(42);

//Название записи с учетом текущей локализации
echo $post->getContent('name');

```


Возможность хранения локализации в JSON не означает, что вы должны заполнять все значения,
например запись информации о баре, может быть на русском и английском, но количество мест
не изменится ни для какого языка. Соответственно, нет смысла дублировать такие параметры, а выносить их в `опции`


```php
// Конкретная запись
$post = Post::find(42);

//Получить все опции
echo $post->getOptions();

//Получить все параметры локализации из опций
echo $post->getOption('locale');

// Если опции не существует или она не указана
// можно указать второй параметр, который будет возвращаться.
echo $post->getOption('countPlace',10);

```





## Наследование одиночной таблицы

Если вы решили создать новый класс для своего настраиваемого типа сообщений, вы можете вернуть этот класс для всех экземпляров этого типа сообщений.

Определение поведения записи основано на указанном `типе`.
```php
//Все объекты в коллекции $videos будут экземплярами Post
$videos = Post::type('video')->status('publish')->get();
```


## Таксонометрия

Вы можете получить таксонометрию для определенной записи, например:

```php
$post = Post::find(42);
$taxonomy = $post->taxonomies()->first();
echo $taxonomy->taxonomy;
```

Или вы можете искать записи, используя свою таксонометрию:

```php
$post = Post::taxonomy('category', 'php')->first();
```


Возможны более сложные формы, например, получить все записи из категории `main` включая её дочерние категории:

```php
$posts  = Post::whereHas('taxonomies.term', function($query){
	$query->whereIn('slug',
	    Category::slug('main')->with('childrenTerm')
	    ->first()->childrenTerm->pluck('term.slug')
	);
})->get()
```

Помните, что такие записи могут быть менее эффективны в скорости выборки и приведены для примера.

## Категории и Таксонометрия
Для получения категории, таксонометрии или записи из определенной категории можно воспользоваться следующими методами:

```php
// все категории
$category = Taxonomy::category()->slug('uncategorized')->posts()->first();


// Только все категории и записи, связанные с ним
$category = Taxonomy::where('taxonomy', 'category')->with('posts')->get();
$category->each(function($category) {
    echo $category->term->getContent('name');
});

// все записи из категории
$category = Category::slug('uncategorized')->posts()->first();
$category->posts->each(function($post) {
    echo $post->getContent('name');
});
```


## Вложения

Вложения - это файлы, относящиеся к записи.
Эти файлы могут быть разных форматов и разрешений.
```php
$item = Post::find(42);
$image->attachment()->first();
$image->url();
```


## Полнотекстовый поиск

Платформа поставляется с пакетом Scout который является абстракцией для полнотекстового поиска в ваши модели Eloquent. 
Так как Scout не содержит самого "драйвера" поиска, требуется поставить и указать требуемое решение, это могут быть 
elasticsearch, algolia, sphinx или другие решение.


Для использования полнотекстового поиска требуется добавить новый метод в ваш класс поведения:

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


Принимать он будет все данные модели, а возвращать элементы которые требуются для индексации.

Возьмём для примера стандартный “DemoPost.php”, он имеет множество параметров, но действительно, нам необходимы лишь два:

- Название статьи
- Содержание статьи

Для этого мы должны их вернуть:

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

Мы вернули все данные на английском языке, с индексом.

Для импортирования осталось лишь применить команду:

```php
php artisan scout:import Orchid\\Press\\Models\\Post
```

Теперь мы можем использовать поиск в своих проектах:

```php
use Orchid\Press\Models\Post;
$articles = Post::search('как пропатчить kde2 под freebsd')->get();
```


# Теги

Тег (метка) — слово или фраза которая может объединять группу текста, изображений и т.п по теме 


## Использование

Теги можно подключать ко всем созданным моделям, с помощью трейта

```php
use Orchid\Press\TraitsTaggableTrait;

class Product extends Eloquent
{
    use TaggableTrait;
}
```


В модель `Post`, он входит по умолчанию, по этому примеры будут на нём.

## Добавление

В этом разделе мы покажем, как вы можете управлять своими субъектами тегов.

```php
use Orchid\Press\Models\Post;

// Get the entity object
$post = Post::find(1);

// Through a string
$post->tag('foo, bar, baz');

// Through an array
$post->tag([ 'foo', 'bar', 'baz']);
```




## Удаление

Удаляет один или несколько тегов объекта через массив или через строку разделенных сущности разделителем.

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



## Настройка

Этот метод очень похож на метод `tag()`, но он сочетает в себе `untag()`, так что он автоматически идентифицирует теги для добавления и удаления. Это очень полезный метод при запуске обновления на субъектов, и вы не хотите иметь дело с проверками, чтобы проверить, какие теги должны быть добавлены или удалены.

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


## Чтение

У нас есть некоторые методы, чтобы помочь вам получить все теги, прикрепленные к объекту и делать обратное и получить все объекты с заданными тегами.

```php
// Get the entity object
$post = Post::whereTag('foo, bar')->get();


$post = Post::find(1);
$tags = $post->tags;

$tags = Post::allTags();
```


# Комментарии

Комментарии необходимый атрибут для некоторых видов веб-сайтов.
Благодаря им пользователи могут высказывать своё мнение относительно какой-либо записи, 
поддерживать или опровергать высказанные мнения, вести диалог с другими пользователями.


## Создание комментария

Комментарии крепятся к записям ORCHID

```php
use Orchid\Press\Models\Comment;
use Orchid\Press\Models\Post;

// Конкретная запись
$post = Post::find(42);

//Создать комментарий
$comment = Comment::create([
    'post_id'   => $post->id, // номер записи
    'user_id'   => Auth::id(), // номер пользователя
    'parent_id' => 0, // родительский комментарий
    'content'   => 'Моё важное высказывание', // текст коментария
    'approved'  => 1, // одобрен/не одобрен
]);

```


## Отношения


```php

// Получить все комментарии для конкретной записи Post
$comments = Comment::findByPostId(42);


$comment = Comment::find(1);

// Получить связь с Post
$post = $comment->post();

// Получить родительский комментарий
$comment = $comment->original();

// Получить дочерние комментарии
$comment = $comment->replies();

// Получить автора комментария
$comment = $comment->author();

```


## Проверки

```php
$comment = Comment::find(1);


// Проверить опубликован ли комментарий
$comment->isApproved();

// Проверить является ли комментарий ответом на другой комментарий
$comment->isReply();

// Проверить существуют ли у комментария ответы
$comment->hasReplies();
```


#Меню

Пакет включает в себя простой в использовании механизм для создания настраиваемых меню (навигации),
с использованием drag & drop и поддержкой локализации.


## Конфигурация

Большинство меню отображаются в верхней части сайта, 
но расположение может отличаться для разных приложений, 
количество меню ограничено и определяется в файле конфигурации `config/press.php`

```php
'menu' => [
    'header'  => 'Top Menu',
    'sidebar' => 'Sidebar Menu',
    'footer'  => 'Footer Menu',
],
```

## Модель
Класс Menu - обычная модель `Eloquent`, ей доступны все его возможности,
например, что бы вывести только родительские пункты меню с дочерними ссылками 
и учётом локализации необходимо:

```php
namespace Orchid\Press\Models\Menu;

$menu = Menu::where('lang', app()->getLocale()())
    ->where('parent',0)
    ->where('type', 'footer')
    ->with('children')
    ->get();
```


Доступны методы:

```php
//Первый дочерний элемент
$menu = Menu::find(1)->children()->first();


//Родительский элемент
$menu = Menu::find(1)->parent()->get();
```
