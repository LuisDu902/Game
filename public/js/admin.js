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

if (order_user) {
    order_user.addEventListener('change', function() {
        sendAjaxRequest('get', '/api/users?' + encodeForAjax({search: search_user.value, filter: filter_user.value, order: order_user.value}), {}, listHandler);
    });
}

if (search_user) {
    search_user.addEventListener('input', function() {
        sendAjaxRequest('get', '/api/users?' + encodeForAjax({search: search_user.value, filter: filter_user.value, order: order_user.value}), {}, listHandler);
    });
}

if (filter_user) {
    filter_user.addEventListener('change', function() {
        sendAjaxRequest('get', '/api/users?' + encodeForAjax({search: search_user.value, filter: filter_user.value, order: order_user.value}), {}, listHandler);
    });
}

function listHandler() {
    if (this.status === 200) {
        const response = JSON.parse(this.responseText);
        const users = response.data;
        console.log(response);
        const table = document.querySelector('.users-table tbody');
        table.innerHTML = '';
        for (const user of users){
            user_row = createUserRow(user);
            table.appendChild(user_row);
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
    let paginationHTML = '';
    const links = response.links;
    // Previous page link
    if (response.prev_page_url) {
        paginationHTML += `<li class="page-item"><a class="page-link" href="#" data-ref="${links.prev_page_url}">&lsaquo;</a></li>`;
    }

    links.shift();
    links.pop();
    // Page numbers
    links.forEach(link => {
        
        if (link.url) {
            paginationHTML += `<li class="page-item"><a class="page-link" href="#" data-ref="${link.url}">${link.label}</a></li>`;
        } else {
            paginationHTML += `<li class="page-item current"><span class="page-link">${link.label}</span></li>`;
        }
    });

    // Next page link
    if (response.next_page_url) {
        paginationHTML += `<li class="page-item"><a class="page-link" href="#" id="nextPage" data-ref="${links.next_page_url}">&rsaquo;</a></li>`;
    }

        

    // Attach click event handlers to pagination links
    if (links.prev_page_url) {
        document.getElementById('prevPage').addEventListener('click', function (e) {
            e.preventDefault();
            const url = this.querySelector('a').getAttribute('data-ref');
            sendAjaxRequest('get', url, {}, listHandler);
        });
    }

    if (links.next_page_url) {
        document.getElementById('nextPage').addEventListener('click', function (e) {
            e.preventDefault();
            console.log('IM REALLY HERE\N');
            const url = this.querySelector('a').getAttribute('data-ref');
            sendAjaxRequest('get', url, {}, listHandler);
        });
    }

    // For page numbers
    document.querySelectorAll('.page-item a').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const url = this.getAttribute('data-rref');
            sendAjaxRequest('get', url, {}, listHandler);
        });
    });

    // Update the pagination bar in the DOM
    pagination.innerHTML = paginationHTML;
}