<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsLabel extends Model
{
    public function label(){

        return $this->hasOne(Label::class, 'id', 'label_id');
    }
}
