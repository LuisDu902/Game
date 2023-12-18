const selectElements = document.querySelectorAll('.status');

function showUserStatus() {
    const modal = document.querySelector('#userDeleteModal');
    modal.style.display = 'block';
    const status = event.target.value;
    const sel = event.target;

    if (status == 'banned') {
        sel.classList.remove('active');
        sel.classList.add('banned');
    } else {
        sel.classList.remove('banned');
        sel.classList.add('active');
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };
    modal.querySelector('#ad-confirm').textContent = 'Confirm';

    if (event.target.value == 'active'){
        modal.querySelector('h2').textContent = 'Activate account';
        modal.querySelector('p').textContent = 'Are you sure you want to activate this account? All its activity will become public and visible.'
    } else {
        modal.querySelector('h2').textContent = 'Ban account';
        modal.querySelector('p').textContent = 'Are you sure you want to ban this account? All its activity will become private.'
    }
    const cancel = document.getElementById('ad-cancel');
   
    cancel.addEventListener('click', function(){
        modal.style.display = 'none';
        if (status == 'active') {
            sel.classList.remove('active');
            sel.classList.add('banned');
            sel.value = 'banned';
        } else {
            sel.classList.remove('banned');
            sel.classList.add('active');
            sel.value = 'active';
        }
    });

    const id = event.target.closest('.user-info').getAttribute('data-id');

    console.log('User ID:', id);
    const confirm = document.getElementById('ad-confirm');
    confirm.addEventListener('click', function(){
        event.preventDefault();
        sendAjaxRequest('post', '/api/users/' + id, { status: status }, statusUpdatedHandler);
        modal.style.display = 'none';
    });
    
}

function statusUpdatedHandler() {
    if (this.status === 200) {
        let item = JSON.parse(this.responseText);
        console.log('Status updated:', item);
        createNotificationBox('Successfully saved!', 'User status successfully updated!')
    } else {
        console.error('Status update failed:', this.statusText);
    }
}




const order_user = document.querySelector('#order-user');
const search_user = document.querySelector('#search-user');
const filter_user = document.querySelector('#filter-user');

if (document.querySelector('.user-manage-section')) {
    order_user.addEventListener('change', function() {
        sendAjaxRequest('get', '/api/users?' + encodeForAjax({search: search_user.value, filter: filter_user.value, order: order_user.value}), {}, userListHandler);
    });
    search_user.addEventListener('input', function() {
        sendAjaxRequest('get', '/api/users?' + encodeForAjax({search: search_user.value, filter: filter_user.value, order: order_user.value}), {}, userListHandler);
    });
    filter_user.addEventListener('change', function() {
        sendAjaxRequest('get', '/api/users?' + encodeForAjax({search: search_user.value, filter: filter_user.value, order: order_user.value}), {}, userListHandler);
    });

    document.addEventListener("DOMContentLoaded", function() {
        search_user.value = '';
        order_user.value = 'username';
        filter_user.value = '';
    });
}



function userListHandler() {
    if (this.status === 200) {
        const table = document.querySelector('.users');
        table.innerHTML = this.response;
        const links = document.querySelectorAll('.custom-pagination a');
        for (const link of links){
            link.addEventListener('click', function(){
                event.preventDefault();
                sendAjaxRequest('get', link.href, {}, userListHandler);
            });
        }
    } else {
        console.error('User list failed:', this.statusText);
    }
}


function showUserDelete() {
    const modal = document.querySelector('#userDeleteModal');
    modal.style.display = 'block';

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };

    const cancel = document.getElementById('ad-cancel');

    cancel.addEventListener('click', function(){
        modal.style.display = 'none';
    });

    const id = event.target.closest('.user-info').getAttribute('data-id');

    console.log('User ID:', id);
    
    const confirm = document.getElementById('ad-confirm');
    
    confirm.addEventListener('click', function(){
        event.preventDefault();
        sendAjaxRequest('delete', '/api/users/' + id, {}, userDeleteHandler);
    });
    
}


function userDeleteHandler() {
    if (this.status === 200) {
        const response = JSON.parse(this.responseText);
        const id = response.id;
        const user = document.querySelector(`#user${id}`);
        const modal = document.querySelector('#userDeleteModal');
        modal.style.display = 'none';
        user.remove();
        createNotificationBox('Successfully deleted!', 'User deleted successfully!');
    }
}
 

const adminActions = document.querySelectorAll('.admin-actions button');

if (adminActions) {
    adminActions.forEach(button => {
        button.addEventListener('click', function () {
            adminActions.forEach(btn => btn.classList.remove('selected'));
            this.classList.add('selected');
            sendAjaxRequest('get', '/api/admin/' + this.textContent, {}, toggleAdminSection);
        });
    });
}

function toggleAdminSection() {

}