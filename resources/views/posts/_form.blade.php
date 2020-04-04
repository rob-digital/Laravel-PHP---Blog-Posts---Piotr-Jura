<div class="form-group">
    <label for="">Title</label>
    <input type="text"
       name="title"
       class="form-control"
       value="{{ old('title', $post->title ?? null) }}"/>
</div>

<div class="form-group">
    <label for="">Content</label>
    <input type="text"
       name="content"
       class="form-control"
       value="{{ old('content', $post->content ?? null) }}"/>
</div>

<div class="form-group mt-3 mb-3">
    <label for="">Thumbnail</label>
    <input type="file"
       name="thumbnail"
       class="form-control-file"
>
</div>

<x-errors></x-errors>
