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
const changedSelects = [];

function sendUpdateStatusRequest() {
    changedSelects.forEach(item => {
        const { id, selectedValue } = item;
        sendAjaxRequest('post', '/api/user/' + id, { status: selectedValue }, statusUpdatedHandler);
    });
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
            const selectedValue = this.value;
            const id = this.getAttribute('data-user');
            if (selectedValue === 'banned') {
                this.classList.remove('active');
                this.classList.add('banned');
            } else {
                this.classList.remove('banned');
                this.classList.add('active');
            }
            const existingIndex = changedSelects.findIndex(item => item.id === id);
            if (existingIndex === -1) {
                changedSelects.push({id, selectedValue});
            } else {
                changedSelects.splice(existingIndex, 1);
            }
        });
    });
}


const edit_status_btn = document.querySelector('#edit-status-btn');

if (edit_status_btn){
    const selects = document.querySelectorAll('.users-table select');
    
    edit_status_btn.addEventListener('click', function() {
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
                console.log('Changed selects:', changedSelects);
                sendUpdateStatusRequest();
            }
        }
    });
}






  