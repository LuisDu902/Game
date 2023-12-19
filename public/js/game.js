const gamePage = document.querySelector('.new-game-form');

if (gamePage) {
    const uploadButton = document.getElementById('up-image');
    const fileInput = document.getElementById('file');
    const category_id = gamePage.getAttribute('data-id');

    uploadButton.addEventListener('click', function(){
        event.preventDefault();
        fileInput.click(); 
    })

    const preview = gamePage.querySelector('img');

    fileInput.addEventListener('change', function() {
        const file = this.files[0];

        if (file) {
            const allowedExtensions = ['png', 'jpeg', 'jpg'];
            const fileExtension = file.name.split('.').pop().toLowerCase();
    
            if (allowedExtensions.includes(fileExtension)) {
                const reader = new FileReader();
    
                reader.onload = function(event) {
                    preview.src = event.target.result;
                }
                reader.readAsDataURL(file);
            } else {
                createNotificationBox('Invalid file type!', 'Please choose a valid file type to upload!', 'error');
                this.value = ''; 
            }
        }
    });

    function createGame(){
        event.preventDefault();
        const title = gamePage.querySelector('#name');
        const description = gamePage.querySelector('#description');
        console.log(category_id)
        if (title.value === ''){
            title.focus();
            createNotificationBox('Empty game title', 'Please enter your game title!', 'warning');
        }
        else if (description.value == '') {
            description.focus();
            createNotificationBox('Empty game description', 'Please enter your game description!', 'warning');
        } else {
            sendAjaxRequest('post', '/api/game', {name: title.value, description: description.value, category_id: category_id}, createGameHandler);
        }
    }

    function createGameHandler(){
        if (this.status === 200) {
            const id = JSON.parse(this.responseText).id;
            if (fileInput.files.length > 0) {
                const formData = new FormData();
                formData.append('file', fileInput.files[0]); 
                formData.append('id', id);
                formData.append('type', 'game');    
        
                let request = new XMLHttpRequest();
                request.open('post', '/api/file/upload', true);
                request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
                request.addEventListener('load', gameImage);
                request.send(formData);
            } else {
                window.location.href = '/categories/' + category_id;
            }
        }
    }
    function gameImage(){
        if (this.status == 200) {
            window.location.href = '/categories/' + category_id;
        }
    }
}