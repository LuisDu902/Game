

document.addEventListener('DOMContentLoaded', function () {


        






});


function deleteAnswer(answerId){
    if (confirm('Are you sure you want to delete this question?')) {

        // Use the sendAjaxRequest function to send a DELETE request
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
            createNotificationBox('Answer deleted successfully!');
            const questionElement = document.getElementById(answerId);
            if (questionElement) {
                questionElement.remove();
            }
        } else {
            console.error('Answer delete failed:', this.statusText);
        }
    };
}
