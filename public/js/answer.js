function deleteAnswer(answerId){
    if (confirm('Are you sure you want to delete this question?')) {
        sendAjaxRequest('DELETE', '/api/answers/' + answerId + '/delete', null, function () {
            answerDeletedHandler(answerId).apply(this);
        });
    }
}

function answerDeletedHandler(answerId){
    return function () {
        console.log('Response:', this.responseText);

        if (this.status === 200) {
            console.log('Answer deleted successfully');
            createNotificationBox('Successfully saved!', 'Answer deleted successfully!');
            const questionElement = document.getElementById(answerId);
            if (questionElement) {
                questionElement.remove();
            }
        } else {
            console.error('Answer delete failed:', this.statusText);
        }
    };
}
