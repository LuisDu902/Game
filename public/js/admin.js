const selectElements = document.querySelectorAll('.status');
let changedSelects = [];

function sendUpdateStatusRequest() {
    changedSelects.forEach(item => {
        const { id, selectedValue } = item;
        sendAjaxRequest('post', '/api/users/' + id, { status: selectedValue }, statusUpdatedHandler);
    });
    changedSelects = [];
}

function statusUpdatedHandler() {
    if (this.status === 200) {
        let item = JSON.parse(this.responseText);
        console.log('Status updated:', item);
        createNotificationBox('User status successfully updated!')
    } else {
        console.error('Status update failed:', this.statusText);
    }
}

if (selectElements) {
    selectElements.forEach(function(selectElement) {
        selectElement.addEventListener('change', function() {
            handleSelectChange(this);
        });
    });
}

function handleSelectChange(selectElement) {
    const selectedValue = selectElement.value;
    const id = selectElement.getAttribute('data-user');
    
    if (selectedValue === 'banned') {
        selectElement.classList.remove('active');
        selectElement.classList.add('banned');
    } else {
        selectElement.classList.remove('banned');
        selectElement.classList.add('active');
    }

    const existingIndex = changedSelects.findIndex(item => item.id === id);
    if (existingIndex === -1) {
        changedSelects.push({ id, selectedValue });
    } else {
        changedSelects.splice(existingIndex, 1);
    }
}

const edit_status_btn = document.querySelector('#edit-status-btn');

if (edit_status_btn){ 
    edit_status_btn.addEventListener('click', function() {
        const selects = document.querySelectorAll('.users-table select');
        if (edit_status_btn.textContent == 'Edit') { 
            selects.forEach(select => {
                select.removeAttribute('disabled');
                select.classList.remove('hidden');
            });
            edit_status_btn.textContent = 'Save';
        } else {
            selects.forEach(select => {
                select.setAttribute('disabled', 'true');
                select.classList.add('hidden');
            });
            edit_status_btn.textContent = 'Edit';

            if (changedSelects.length > 0) {
                sendUpdateStatusRequest();
            }
        }
    });
}

function sendUserListRequest() {
    changedSelects.forEach(item => {
        const { id, selectedValue } = item;
        sendAjaxRequest('post', '/api/users/' + id, { status: selectedValue }, statusUpdatedHandler);
    });
    changedSelects = [];
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
        console.log(this);
        const links = document.querySelectorAll('.pagination a');
        for (const link of links){
            link.addEventListener('click', function(){
                event.preventDefault();
                sendAjaxRequest('get', link.href, {}, questionListHandler);
            });
        }
        const selects = document.querySelectorAll('.status');
        selects.forEach(function(selectElement) {
            selectElement.addEventListener('change', function() {
                handleSelectChange(this);
            });
        });
        
    } else {
        console.error('User list failed:', this.statusText);
    }
}
 

