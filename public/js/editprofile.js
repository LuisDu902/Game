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
    
    // Get the computed style of the elements
    var profileButtonsDisplay = window.getComputedStyle(profileButtons).getPropertyValue('display');
    var profileButtonDisplay = window.getComputedStyle(profileButton).getPropertyValue('display');
    
    // Toggle the display value
    profileButtons.style.display = profileButtonsDisplay === 'block' ? 'none' : 'block';
    profileButton.style.display = profileButtonDisplay === 'block' ? 'none' : 'block';
}

function saveChanges() {
    var form = document.getElementById('profileForm');
    var updatedValues = {
        name: form.elements['name'].value,
        username: form.elements['username'].value,
        email: form.elements['email'].value,
        description: form.elements['description'].value,
    };

    fetch('/profile', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(updatedValues)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Changes saved:', data);
        // You can handle the response from the server here
    })
    .catch(error => {
        console.error('Error saving changes:', error);
    });

    // Add logic to save changes to the server or perform other actions
    console.log('Changes saved:', updatedValues);

    // Hide the Save and Cancel buttons after saving
    toggleEdit();
}

function cancelChanges() {
    // Reset form elements to their original values
    var form = document.getElementById('profileForm');
    var inputs = form.getElementsByTagName('input');
    var textarea = form.querySelector('textarea');

    for (var i = 0; i < inputs.length; i++) {
        // Use the defaultValue property to get the original value
        inputs[i].value = inputs[i].defaultValue;
    }

    // Use the defaultValue property for the textarea as well
    textarea.value = textarea.defaultValue;
    // Add logic to revert changes or perform other actions
    console.log('Changes canceled');

    // Hide the Save and Cancel buttons after canceling
    toggleEdit();
}