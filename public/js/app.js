const dropDownButton = document.querySelector('.dropbtn');

if (dropDownButton) {
    let isOpen = false;
    const dropdownContent = document.querySelector('.dropdown-content');
    
    dropDownButton.addEventListener('click', function () {
        if (isOpen) {
            dropDownButton.innerHTML = '<ion-icon name="chevron-down"></ion-icon>';
            dropdownContent.style.display = 'none';
        } else {
            dropDownButton.innerHTML = '<ion-icon name="chevron-up"></ion-icon>';
            dropdownContent.style.display = 'flex';
        }

        isOpen = !isOpen;
    });

}

const questionsBtns = document.querySelectorAll('.questions-sort button');

if (questionsBtns) {
    questionsBtns.forEach(button => {
        button.addEventListener('click', function () {
            questionsBtns.forEach(btn => btn.classList.remove('selected'));
            this.classList.add('selected');
        });
    });
}


function createNotificationBox(text) {
    const notificationBox = document.querySelector('.notification-box');
    notificationBox.style.display = 'flex';

    const span = document.createElement('span');
    span.textContent = text;
    
    const close = document.createElement('ion-icon');
    close.setAttribute('name', 'close');

    close.addEventListener('click', function(){
        notificationBox.style.display = 'none';
        notificationBox.innerHTML = '';
    })

    notificationBox.appendChild(span);
    notificationBox.appendChild(close);

}

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
