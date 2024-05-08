<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::query();
        $limit = $request->query('limit', 5);
        $posts = $query->paginate($limit);
        return response()->json($posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $item = $request->all();
        $validator = Validator::make($request->all(), [
            'authorId' => 'required|exists:users,id',
            'parentId' => 'nullable|exists:posts,id',
            'tag' => 'required',
            'title' => 'required|string|max:75',
            'metaTitle' => 'required|string|max:100',
            'slug' => 'required|string|max:100',
            'sumary' => 'required|string',
            'published' => 'required|boolean',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $name = $request->get('tag');
        $tag = Tag::where('name', '=', $name)->first();

        DB::beginTransaction();
        try {
            if ($tag) {
                $item['tag'] = $tag->id;
            } else {
                $newTag = Tag::create([
                    'name' => $name,
                    'slug' => $name,
                ]);
                $item['tag'] = $newTag->id;
            }
            $post = Post::create($item);
            DB::commit();

        } catch (\Exception $e) {
            return $e;
            DB::rollback();
        }

        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return response()->json($post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'authorId' => 'required|exists:users,id',
            'parentId' => 'nullable|exists:posts,id',
            'tag' => 'required',
            'title' => 'sometimes|required|string|max:50',
            'metaTitle' => 'sometimes|required|string|max:50',
            'slug' => 'sometimes|required|string|max:50',
            'sumary' => 'sometimes|required|string',
            'published' => 'required|in:0,1',
            'content' => 'sometimes|required|string|'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $name = $request->get('tag');
        $tag = Tag::where('name', '=', $name)->first();
        $post = Post::findOrFail($id);
        // Chỉ cập nhật các trường có trong request
        $post->fill($request->only([
            'title',
            'metaTitle',
            'slug',
            'sumary',
            'published',
            'content',
        ]));

        DB::beginTransaction();
        try {
            if ($tag) {
                $post['tag'] = $tag->id;
            } else {
                $newTag = Tag::create([
                    'name' => $name,
                    'slug' => $name,
                ]);
                $post['tag'] = $newTag->id;
            }
            $post->save();
            DB::commit();

        } catch (\Exception $e) {
            return $e;
            DB::rollback();
        }

        return response()->json($post, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        $res = [
            "message" => "Post and related tags deleted",
            "status" => 200,
            "data" => $post,
        ];
        return response()->json($res);
    }
}
