<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <header>
        <h1>
            {{ $post->title }}
        </h1>
    </header>
    <div class="clearfix">
        @if ($post->image)
            <img class="float-left mr-2 img-fluid" width="500" src="{{ asset('storage/' . $post->image) }}"
                alt="{{ $post->slug }}">
        @endif
        <p>
            <strong>Categoria:</strong>
            @if ($post->category)
                {{ $post->category->label }}
            @else
                Nessuna
            @endif
        </p>
        <div class="mb-2">
            <strong>Tags:</strong>
            @forelse($post->tags as $tag)
                <span class="badge text-white p-1"
                    style="background-color: {{ $tag->color }}">{{ $tag->label }}</span>
            @empty
                Nessun tag
            @endforelse
        </div>
        <div>
            <p>{{ $post->content }}</p>
        </div>



        <div><strong>Creato il:</strong> <time>{{ $post->created_at }}</time></div>
        <div><strong> Modificato il:</strong> <time>{{ $post->updated_at }}</time></div>
        <div>
            @if ($post->user)
                <strong>Autore:</strong> {{ $post->user->name }}
            @else
                Autore anonimo
            @endif
        </div>
    </div>
   

</body>
</html>