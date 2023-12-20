<div id="tag{{ $tag->id }}" class="edit-tag" data-id="{{ $tag->id }}">
    <input class="col-8" type="text" value="{{ $tag->name }}">
    <button class="cancel" onclick="restoreTag()">Cancel</button>
    <button class="confirm" onclick="updateTag()">Confirm</button>
</div>
    
