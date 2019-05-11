<?php

namespace Orchid\Press\Http\Controllers;



use Orchid\Press\Models\Post;
use Orchid\Press\Models\Comment;
use Orchid\Press\Models\Category;
use Orchid\Platform\Http\Controllers\Controller;

use Cartalyst\Tags\IlluminateTag as Tag;

use Orchid\BlogCMS\Models\Field;



class PressController extends Controller
{
    /**
     * @var string
     */
    public $type = 'demo-screen';

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $posts = Post::type($this->type)
            ->status('publish')
            ->with('attachment')
            ->orderBy('publish_at','Desc')
            ->with('taxonomies')
            ->paginate(10);

        return view(config('press.view').'pages.main', [
            'posts' => $posts,
        ]);	

    }


    /**
     * @param Post $post
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function post($categorySlug, Post $post)
    {
        $category = Category::slug($categorySlug)
                ->first();
        $categorypage = Post::type('cathead')
                ->whereSlug($categorySlug)
                ->with('attachment')
                ->first();  

        $comments = Comment::findByPostId($post->id)->where('parent_id', 0)->where('approved', 1);

        $post->setRelation('category',$category);
        $post->setRelation('categorypage',$categorypage);
        
        $subposts = Post::type('subblog')
                ->whereRaw("JSON_EXTRACT(`content`, '$.ru.parentpost') = '".$post->slug."'")
                ->with('attachment')
                ->get();  
        $post->setRelation('subposts',$subposts);
        
        $list=(empty($post->getContent('list')) || is_null($post->getContent('list')[0]))
                ?['name','picture','body','map','tags']
                :$post->getContent('list');	
                
        return view(config('press.view').'pages.post', [
            'post'     => $post,
            'comments' => $comments,
			'list'	   => $list,
        ]);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category($categorySlug)
    {

        $category = Category::slug($categorySlug)
            ->with(['posts' => function($query)	{
                $query->type($this->type)
                    ->status('publish')
                    ->with('attachment')
                    ->orderBy('publish_at','Desc')
                    ->get();
            }])
            ->first();
        $childcats = $category
            ->allChildrenTerm()
            ->with(['posts' => function($query)	{
                $query->type($this->type)
                    ->status('publish')
                    ->with('attachment')
                    ->orderBy('publish_at','Desc')
                    ->get();
            }])
            ->get();

        $page = Post::type('cathead')
            ->whereSlug($categorySlug)
            ->with('attachment')
            ->first();

        return view(config('press.view').'pages.category', [
            'category'  => $category,
            'childcats'  => $childcats,
            'page'      => $page,
        ]);
    }


    /**
     * @param Post $post
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function subpost($category_slug, $prefpost, $subpost)
    {
        $category = Category::slug($category_slug)->first();

        $parentpost = Post::type($this->type)
                ->whereSlug($prefpost)
                ->first();   

        if (!is_null($category))  $parentpost->setRelation('category',$category);
        
        $subblog_slug=$prefpost.'-'.$subpost;
        
        $post = Post::type('subblog')
                ->whereSlug($subblog_slug)
                ->with('attachment')
                ->first();

        if (!is_null($category))  $post->setRelation('category',$category);
        if (!is_null($parentpost)) $post->setRelation('parentpost',$parentpost);

        if (!is_null($post)) $comments = Comment::findByPostId($post->id)->where('parent_id', 0)->where('approved', 1);
        
        

        $list=(empty($post->getContent('list')) || is_null($post->getContent('list')[0]))
                ?['name','body','carousel','tags']
                :$post->getContent('list');	
        
        return view(config('press.view').'pages.subpost', [
            'post'      => $post,
            'comments'  => $comments,
			'list'	    => $list,
        ]);

    }		


    /**
     * @param Post $post
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	
	public function tagsPosts($tag_slug)
    {
	
		$posts = Post::type($this->type)
			->whereTag($tag_slug)
            ->status('publish')
            ->with('attachment')
            ->with('scopeTaxonomies')
            ->orderBy('publish_at','Desc')
            ->get();
            
        $images=$posts->map(function ($item, $key) {
                    if (!is_null($item->attachment('image')->where('sort',0)->first())) {
                       return $item->attachment('image')->where('sort',0)->first();
                    }
                })->filter()->sortBy('size');
                
        $tag = Tag::whereSlug($tag_slug)->first();
			
        return view(config('press.view').'pages.tags', [
            'posts'   => $posts,
            'tag'     => $tag,
            'images'  => $images,
        ]);
		
		
		
    }
	
}