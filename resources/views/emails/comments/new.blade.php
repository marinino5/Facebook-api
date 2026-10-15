
<x-mail::message>
# Nuevo comentario en tu publicación

Hola,

Alguien ha comentado tu publicación **{{ $comment->post->title }}**.

**Usuario:** {{ $comment->author }}

**Comentario:**

{{ $comment->content }}

Gracias por utilizar nuestra plataforma.

Facebook API
</x-mail::message>

