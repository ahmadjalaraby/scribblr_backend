<?php


namespace App\ViewModels\Tag;


use App\Models\Tag;
use App\ViewModels\ViewModel;

final class EditTagViewModel extends ViewModel
{

    public function __construct(private readonly Tag $tag)
    {
        parent::__construct(null);
    }

    /**
     * This function will return the Tag model with image relation
     * @return Tag
     */
    public function tag(): Tag
    {
        return $this->tag->load('image');
    }
}
