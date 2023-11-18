function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
  }
  
function sendAjaxRequest(method, url, data, handler) {
    let request = new XMLHttpRequest();
    request.open(method, url, true);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));
}

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
    } else {
        console.error('Status update failed:', this.status);
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
        sendAjaxRequest('get', '/api/users?' + encodeForAjax({search: search_user.value, filter: filter_user.value, order: order_user.value}), {}, listHandler);
    });
    search_user.addEventListener('input', function() {
        sendAjaxRequest('get', '/api/users?' + encodeForAjax({search: search_user.value, filter: filter_user.value, order: order_user.value}), {}, listHandler);
    });
    filter_user.addEventListener('change', function() {
        sendAjaxRequest('get', '/api/users?' + encodeForAjax({search: search_user.value, filter: filter_user.value, order: order_user.value}), {}, listHandler);
    });

    document.addEventListener("DOMContentLoaded", function() {
        search_user.value = '';
        order_user.value = 'username';
        filter_user.value = '';
    });
}



function listHandler() {
    if (this.status === 200) {
        const response = JSON.parse(this.responseText);
        const users = response.data;
        
        const table = document.querySelector('.users-table tbody');
        table.innerHTML = '';
        for (const user of users) {
            user_row = createUserRow(user);
            table.appendChild(user_row);
        }
        if (users.length == 0) {
            table.innerHTML = '<tr><td></td><td></td><td></td><td id="no-records">No matching users</td><td></td><td></td></tr>';
        }
        createPaginationBar(response);
        
    } else {
        console.error('Status update failed:', this.status);
    }
}
  
function createUserRow(user) {
    const tr = document.createElement('tr');
    tr.classList.add('user-info');

    const td1 = document.createElement('td');
    const img = document.createElement('img');
    img.src = '../images/user.png';
    img.alt = 'User Image';
    td1.appendChild(img);

    const td2 = document.createElement('td');
    const link = document.createElement('a');
    link.href = '#';
    link.textContent = user.username;
    td2.appendChild(link);

    const td3 = document.createElement('td');
    td3.textContent = user.name;

    const td4 = document.createElement('td');
    td4.textContent = user.email;

    const td5 = document.createElement('td');
    td5.classList.add(user.rank);
    td5.textContent = user.rank;

    const td6 = document.createElement('td');
    const select = document.createElement('select');
    select.name = '';
    select.classList.add('status', 'hidden', user.is_banned ? 'banned' : 'active');
    select.id = 'user-status';
    select.disabled = true;
    select.dataset.user = user.id;

    const option1 = document.createElement('option');
    option1.value = 'active';
    option1.textContent = 'Active';
    if (!user.is_banned) {
        option1.selected = true;
    }

    const option2 = document.createElement('option');
    option2.value = 'banned';
    option2.textContent = 'Banned';
    if (user.is_banned) {
        option2.selected = true;
    }

    select.appendChild(option1); select.appendChild(option2);
    td6.appendChild(select);

    select.addEventListener('change', function() {
        handleSelectChange(select);
    });
    tr.appendChild(td1); tr.appendChild(td2);
    tr.appendChild(td3); tr.appendChild(td4);
    tr.appendChild(td5); tr.appendChild(td6);

    return tr;
}


function createPaginationBar(response) {
    const pagination = document.querySelector('.pagination');
    pagination.innerHTML = '';
    
    if (response.prev_page_url) {
        const prevArrow = document.createElement('li');
        prevArrow.classList.add('arrow');
        prevArrow.id = 'prevPage';
        prevArrow.setAttribute('data-url', `${response.prev_page_url}`);
        prevArrow.innerHTML = '<span>&lsaquo;</span>';
        pagination.appendChild(prevArrow);
        prevArrow.addEventListener('click', function(){
            sendAjaxRequest('get', response.prev_page_url, {}, listHandler);
        });
    }

    const links = response.links;
    links.shift(); links.pop();
    
    if (links.length > 1) {
        for (const link of links) {
            const page = document.createElement('li');
            page.classList.add('page-item');
            page.innerHTML = `<span class="page-link"> ${link.label}</span>`;
            if (link.active) page.classList.add('current');
            else {
                page.addEventListener('click', function(){
                    sendAjaxRequest('get', link.url, {}, listHandler);
                });
            }
            pagination.appendChild(page);
        }
    }
   
    if (response.next_page_url) {
        const nextArrow = document.createElement('li');
        nextArrow.classList.add('arrow');
        nextArrow.id = 'nextPage';
        nextArrow.innerHTML = '<span>&rsaquo;</span>';
        pagination.appendChild(nextArrow);
        nextArrow.addEventListener('click', function(){
            sendAjaxRequest('get', response.next_page_url, {}, listHandler);
        });
    }

}