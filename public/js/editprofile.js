function toggleEdit() {
    var form = document.getElementById('profileForm');
    var inputs = form.getElementsByTagName('input');
    var textarea = form.querySelector('textarea');

    for (var i = 0; i < inputs.length; i++) {
        inputs[i].disabled = !inputs[i].disabled;
    }

    textarea.disabled = !textarea.disabled;

    var profileButtons = document.querySelector('.edit-profile-buttons');
    var profileButton = document.querySelector('.edit-profile-button');
    
    var profileButtonsDisplay = window.getComputedStyle(profileButtons).getPropertyValue('display');
    var profileButtonDisplay = window.getComputedStyle(profileButton).getPropertyValue('display');
    
    profileButtons.style.display = profileButtonsDisplay === 'block' ? 'none' : 'block';
    profileButton.style.display = profileButtonDisplay === 'block' ? 'none' : 'block';
}

function saveChanges() {

    var form = document.getElementById('profileForm');
    var inputs = form.getElementsByTagName('input');
    var textarea = form.querySelector('textarea');

    for (var i = 0; i < inputs.length; i++) {
        inputs[i].removeAttribute('disabled');
    }

    textarea.removeAttribute('disabled');

    form.submit();

    console.log('Changes saved');

    toggleEdit();
}

function cancelChanges() {
    var form = document.getElementById('profileForm');
    var inputs = form.getElementsByTagName('input');
    var textarea = form.querySelector('textarea');

    for (var i = 0; i < inputs.length; i++) {
        inputs[i].value = inputs[i].defaultValue;
    }

    textarea.value = textarea.defaultValue;

    console.log('Changes canceled');

    toggleEdit();
}