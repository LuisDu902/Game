/* Create game category page */

const newPage2 = document.querySelector('.new-gamecategory-form form');


if (newPage2) {
    
    const createBtn1 = document.getElementById('create-game-category');
    createBtn1.addEventListener('click', function(){
        event.preventDefault();
        const name = document.getElementById('name').value;
        const description = document.getElementById('description').value;
        if (name === '') {
            createNotificationBox('Empty game category title', 'Please enter your game category title!', 'warning');
            document.getElementById('name').focus();
        } else if (description === '') {
            createNotificationBox('Empty game category content', 'Please enter your game category content!', 'warning');
            document.getElementById('description').focus();
        } else {
            sendAjaxRequest('post', '/api/gamecategories', {name: name, description: description}, createHandlerCategory);
        }
    });
}

function createHandlerCategory() {
    if (this.status === 200) {
        window.location.href = '/categories';
        //createNotificationBox('Game Category created!', 'Game Category created successfully!');
    }
}