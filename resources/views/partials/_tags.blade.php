<div class="manage-tags d-flex flex-row flex-wrap mx-auto border-end border-start rounded">
    @foreach($tags as $tag)
        <p class="col-2">{{ $tag->name }}</p>
    @endforeach
</div>