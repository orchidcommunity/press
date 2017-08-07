<?php

namespace Orchid\CMS\Http\Forms\Posts;

use Illuminate\Contracts\View\View;
use Orchid\CMS\Core\Models\Attachment;
use Orchid\Platform\Forms\Form;

class UploadPostForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Uploads';

    /**
     * Display Base Options.
     *
     * @return \Illuminate\Contracts\View\View
     *
     * @internal param null $type
     * @internal param null|Post $post
     */
    public function get(): View
    {
        return view('cms::container.posts.modules.upload');
    }

    /**
     * @param null $type
     * @param null $post
     *
     * @return mixed|void
     */
    public function persist($type = null, $post = null)
    {
        if ($this->request->has('files')) {
            $files = $this->request->input('files');
            foreach ($files as $file) {
                $uploadFile = Attachment::find($file);
                $uploadFile->post_id = $post->id;
                $uploadFile->save();
            }
        }
    }
}
