const questions_section = document.querySelector('.questions-sec');

if (questions_section) {
    const recent_btn = document.querySelector('#recent');
    const popular_btn = document.querySelector('#popular');
    const unanswered_btn = document.querySelector('#unanswered');

    recent_btn.addEventListener('click', function(){
        sendAjaxRequest('get', '/api/questions?' + encodeForAjax({criteria: 'recent'}), {}, questionListHandler);
    })
    popular_btn.addEventListener('click', function(){
        sendAjaxRequest('get', '/api/questions?' + encodeForAjax({criteria: 'popular'}), {}, questionListHandler);
    })
    unanswered_btn.addEventListener('click', function(){
        sendAjaxRequest('get', '/api/questions?' + encodeForAjax({criteria: 'unanswered'}), {}, questionListHandler);
    })
}

function questionListHandler() {
    if (this.status === 200) {
        const table = document.querySelector('.questions-list');
        table.innerHTML = this.response;
        const links = document.querySelectorAll('.custom-pagination a');
        for (const link of links){
            link.addEventListener('click', function(){
                event.preventDefault();
                sendAjaxRequest('get', link.href, {}, questionListHandler);
            });
        }
    } else {
        console.error('Question list failed:', this.statusText);
    }
}

function deleteQuestion(questionId){
    if (confirm('Are you sure you want to delete this question?')) {

        // Use the sendAjaxRequest function to send a DELETE request
        sendAjaxRequest('DELETE', '/api/questions/' + questionId + '/delete', null, function () {
            questionDeletedHandler(questionId).apply(this);
        });
    }
}

function questionDeletedHandler(questionId){
    return function () {
        console.log('Response:', this.responseText);

        if (this.status === 200) {
            console.log('Question deleted successfully');
            createNotificationBox('Question deleted successfully!');
            const questionElement = document.getElementById(questionId);
            if (questionElement) {
                questionElement.remove();
            }
        } else {
            console.error('Question delete failed:', this.statusText);
        }
    };
}

