<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Slideshow extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 'image', 'caption', 'description', 'link', 'status', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
