let c_answer_id = 0;

function submitComment() {
    event.preventDefault();
    const answer = event.target.closest('.answer-details');
    const answer_id = answer.getAttribute('data-id');
    c_answer_id = answer_id;
    const content = answer.querySelector('#c-content').value;

    if (content !== '') {
        sendAjaxRequest('post', '/api/comments', {answer_id : answer_id, content: content}, submitCommentHandler);
    } else {
        createNotificationBox('Empty comment content', 'Please enter your comment before posting!', 'warning');
    }

}

function submitCommentHandler() {
    if (this.status == 200) {
        const answer = document.querySelector('#answer' + c_answer_id);
        const noComments = answer.querySelector('.no-comment');
        if (noComments) {
            noComments.remove();
        } 
        const comments = answer.querySelector('.answer-comment-list');
        comments.innerHTML += this.responseText;

        answer.querySelector('#c-content').value = '';
        createNotificationBox('Comment created!', 'Comment was created successfully!');

        const count = answer.querySelector('.comment-count');

        let nr = parseInt(count.textContent.replace(/\D/g, ''), 10) + 1;

        count.textContent = `${nr} comments`;
    }
}