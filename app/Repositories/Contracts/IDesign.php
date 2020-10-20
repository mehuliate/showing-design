<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface IDesign
{
    public function applyTags($id, array $data);
    public function addComment($designId, array $data);
    public function like($designId);
    public function isLikedByUser($id);
    public function search(Request $request);
}
