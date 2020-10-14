<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{

    public function site(){

        return $this->hasOne(Site::class, 'id', 'site_id');
    }

    public function newsLabels(){

        return $this->hasMany(NewsLabel::class, 'news_id', 'id');
    }

    public function labels(){

        return $this->belongsToMany(Label::class, 'news_labels', 'news_id','label_id');
    }
}
