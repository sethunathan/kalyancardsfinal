<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;
    
    protected $table = 'posts';
    protected $fillable = ['title','category_id','item_url','thumb_url','language','type'];

    public function section()
    {
        return $this->hasOne("App\Models\Section", "id", "section_id");
    }
    public function businesssection()
    {
        return $this->hasOne("App\Models\BusinessSection", "id", "business_section_id");
    }
    public function brandingsection()
    {
        return $this->hasOne("App\Models\BrandingSection", "id", "branding_section_id");
    }
    public function customsection()
    {
        return $this->hasOne("App\Models\CustomSection", "id", "custom_section_id");
    }
}

