const form = document.getElementById('profileForm')

if (form) {
    document.addEventListener('DOMContentLoaded', function(){
        const inputs = form.getElementsByTagName('input');
        const textarea = form.querySelector('textarea');
    
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].disabled = true;
        }
    
        textarea.disabled = true;
    })
}

function toggleEdit() {
    const form = document.getElementById('profileForm');
    const inputs = form.getElementsByTagName('input');
    const textarea = form.querySelector('textarea');

    for (var i = 0; i < inputs.length; i++) {
        inputs[i].disabled = !inputs[i].disabled;
    }

    textarea.disabled = !textarea.disabled;

    const profileButtons = document.querySelector('.edit-profile-buttons');
    const profileButton = document.querySelector('.edit-profile-button');
    
    const profileButtonsDisplay = window.getComputedStyle(profileButtons).getPropertyValue('display');
    const profileButtonDisplay = window.getComputedStyle(profileButton).getPropertyValue('display');
    
    profileButtons.style.display = profileButtonsDisplay === 'block' ? 'none' : 'block';
    profileButton.style.display = profileButtonDisplay === 'block' ? 'none' : 'block';
}

function saveChanges() {

    const form = document.getElementById('profileForm');
    const inputs = form.getElementsByTagName('input');
    const textarea = form.querySelector('textarea');

    const name = document.getElementById('profile-name').value;
    const username = document.getElementById('profile-username').value;
    const email = document.getElementById('profile-email').value;
    const description = document.getElementById('profile-description').value;
    const id = form.getAttribute('data-id');

    for (var i = 0; i < inputs.length; i++) {
        inputs[i].removeAttribute('disabled');
    }

    textarea.removeAttribute('disabled');
    sendAjaxRequest('post', '/api/users/' + id + '/edit', { name: name, username: username, email: email, description: description }, profileEditdHandler);


    console.log('Changes saved');

    toggleEdit();
}

function cancelChanges() {
    const form = document.getElementById('profileForm');
    const inputs = form.getElementsByTagName('input');
    const textarea = form.querySelector('textarea');

    for (let i = 0; i < inputs.length; i++) {
        inputs[i].value = inputs[i].defaultValue;
    }

    textarea.value = textarea.defaultValue;

    console.log('Changes canceled');

    toggleEdit();
}


function profileEditdHandler(){
    if (this.status === 200) {
        let item = JSON.parse(this.responseText);
        console.log('Profile updated:', item);
        createNotificationBox('Profile successfully updated!')
    } else {
        console.error('Profile update failed:', this.statusText);
    }
}