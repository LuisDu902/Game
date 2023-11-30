function createNotificationBox(title, content) {
    const notificationBox = document.querySelector('.notification-box');
    notificationBox.style.display = 'flex';

    const span1 = document.querySelector('.notification-box span:first-child');
    span1.textContent = title;

    const span2 = document.querySelector('.notification-box span:last-child');
    span2.textContent = content;

    const close = document.querySelector('#close-notification');
    close.addEventListener('click', function(){
        notificationBox.style.display = 'none';
    });
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
