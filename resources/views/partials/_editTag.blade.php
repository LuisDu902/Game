<div id="tag{{ $tag->id }}" class="edit-tag d-flex flex-row text-center" data-id="{{ $tag->id }}">
    <input class="col-8" type="text" value="{{ $tag->name }}">
    <ion-icon name="close-circle-outline" class="cancel text-center" onclick="restoreTag()"></ion-icon>
    <ion-icon name="checkmark-circle-outline" class="confirm text-center" onclick="updateTag()"></ion-icon>
</div>
    
