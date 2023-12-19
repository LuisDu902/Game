/* Create game category page */

const newPageGame = document.querySelector('.new-game-form form');


if (newPageGame) {

    const gameC = document.querySelector('.game-section');

    const categoryId = gameC.getAttribute('data-id');
    
    const createBtn1 = document.getElementById('create-game');
    createBtn1.addEventListener('click', function(){
        event.preventDefault();
        const name = document.getElementById('name').value;
        const description = document.getElementById('description').value;
        if (name === '') {
            createNotificationBox('Empty game title', 'Please enter your game title!', 'warning');
            document.getElementById('name').focus();
        } else if (description === '') {
            createNotificationBox('Empty game content', 'Please enter your game content!', 'warning');
            document.getElementById('description').focus();
        } else {
            sendAjaxRequest('post', '/api/game/'+categoryId, {name: name, description: description}, createHandlerGame);
        }
    });
}

function createHandlerGame() {

    const gameC = document.querySelector('.game-section');

    const categoryId = gameC.getAttribute('data-id');
    if (this.status === 200) {
        window.location.href = '/categories/'+categoryId;
        //createNotificationBox('Game Category created!', 'Game Category created successfully!');
    }
}