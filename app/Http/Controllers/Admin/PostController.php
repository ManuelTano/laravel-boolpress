<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('updated_at', 'DESC')->orderBy('created_at', 'DESC')->get();
        $categories = Category::all();
        return view('admin.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new Post();
        $categories = Category::select('id', 'label')->get();
        $tags = Tag::select('id', 'label')->get();
        return view('admin.posts.create', compact('post', 'categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate ([
            'title' => 'required|string|min:5|max:50|unique:posts',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png',
            'category_id' => 'nullable | exists:categories,id',
            'tags' => 'nullable|exists:tags,id',
            ], [
                'title.required' => 'Il titolo è obbligatorio',
                'title.min' => 'Il titolo deve avere almeno :min caratteri',
                'title.max' => 'Il titolo deve avere almeno :max caratteri',
                'title.unique' => "Esiste già un post dal titolo $request->title",
                'image.image '=> 'Il file caricato non è di tipo immagine',
                'image.mimes' => 'Le immagini ammesse sono solo in formato .jpeg .jpg o .png',
                'category_id.exists' => 'Non esiste una categoria associabile',
                'tags.exists' => "Tag indicati non validi",
            ]);

            $data = $request->all();
            $post = new Post();
            $post->fill($data);
            $post->slug = Str::slug($post->title, '-');

            if(array_key_exists('image', $data)) {
                
                $image_url = Storage::put('posts', $data['image']);
                // dentro la variabile image_url mi troverò l'indirizzo dell'immagine salvata
                $post->image = $image_url; // lo salvo nel db
            };

            $post->save();

            if (!array_key_exists('tags', $data)) $post->tags()->detach();

            else $post->tags()->sync($data['tags']);

            return redirect()->route('admin.posts.show', $post)->with('message', "Post creato con successo")->with('type', "success");
    }

    /**
     * Display the specified resource.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view ('admin.posts.show', compact ('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = Tag::select('id', 'label')->get();
        $categories = Category::select('id', 'label')->get();
        $prev_tags = $post->tags->pluck('id')->toArray();
        return view('admin.posts.edit', compact('post', 'categories', 'tags', 'prev_tags'));
    }

    public function update(Request $request, Post $post)
    {

        $request->validate([
            'title' => ['required', 'string', 'min:5', 'max:50', Rule::unique('posts')->ignore($post->id)],
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png',
            'category_id' => 'nullable | exists:categories,id',
            'tags' => 'nullable|exists:tags,id',

        ], [
            'title.required' => 'Il titolo è obbligatorio',
            'content.required' => 'Devi scrivere il contenuto del post',
            'title.min' => 'Il titolo deve avere almeno :min caratteri',
            'title.max' => 'Il titolo deve avere almeno :max caratteri',
            'title.unique' => "Esiste già un post dal titolo $request->title",
            'image.image '=> 'Il file caricato non è di tipo immagine',
            'image.mimes' => 'Le immagini ammesse sono solo in formato .jpeg .jpg o .png',
            'category_id.exists' => 'Non esiste una categoria associabile',
            'tags.exists' => "Tag indicati non validi",
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');

        if(array_key_exists('image', $data)) {
            if ($post->image) Storage::delete($$post->image);
            $image_url = Storage::put('posts', $data['image']);
            $post->image = $image_url; 
        }

        $post->update($data);

        if (!array_key_exists('tags', $data)) $post->tags()->detach();
        else $post->tags()->sync($data['tags']);
        return redirect()->route('admin.posts.show', $post)->with('message', "Post modificato con successo")->with('type', "success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($post->image) Storage::delete($post->image);
        $post->delete();
        return redirect()->route('admin.posts.index')
        ->with('message', 'Il post è stato eliminato correttamente')
        ->with('type', 'success');
    }
}
