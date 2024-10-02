<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart'; // ここで任意の名前を設定
    protected $primaryKey = 'ident';
    public $timestamps = false; // saveメソッドでデータを保存する際、created_atとupdated_atを自動的に更新しないようにする
    protected $fillable = ['quantity'];

    // Itemモデルとのリレーションシップを定義する
    public function item()
    {
        return $this->belongsTo(Item::class, 'ident', 'ident');
    }
}
