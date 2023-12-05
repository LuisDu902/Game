/*
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
*/

const answerVote = document.querySelectorAll('.answer-btns');

if (answerVote) {
    for (const answer of answerVote) {
        answer.addEventListener('click', function() {
            const id = answer.getAttribute('data-id');
            
            if (event.target.tagName === 'ION-ICON'){
                const upVote = answer.querySelector('.up-vote ion-icon');
                const downVote = answer.querySelector('.down-vote ion-icon');

                if (event.target.closest('.up-vote')) {
                    if(upVote.classList.contains('hasvoted')){
                        sendAjaxRequest('post', '/api/answers/' + id + "/unvote", {}, uVoteHandler);
                    } else {
                        if (downVote.classList.contains('hasvoted')) {
                            sendAjaxRequest('post', '/api/answers/' + id + "/unvote", {}, dVoteHandler);
                        }
                        sendAjaxRequest('post', '/api/answers/' + id + "/vote", {reaction: true}, uVoteHandler);
                    }
                } else if (event.target.closest('.down-vote')) {
                    if(downVote.classList.contains('hasvoted')){
                        sendAjaxRequest('post', '/api/answers/' + id + "/unvote", {}, dVoteHandler);
                    } else {
                        if (upVote.classList.contains('hasvoted')) {
                            sendAjaxRequest('post', '/api/answers/' + id + "/unvote", {}, uVoteHandler);
                        }
                        sendAjaxRequest('post', '/api/answers/' + id + "/vote", {reaction: false}, dVoteHandler);
                    }
                }
            }
        });
    }
}

function uVoteHandler(){
    if (this.status === 200) {
        const response = JSON.parse(this.responseText);
        const id = response.id;
        const answer = document.querySelector(`#answer${id}`);
        const upVote = answer.querySelector('.up-vote ion-icon');
        const nr = answer.querySelector('.answer-btns span');
        if (response.action == 'vote'){
            upVote.classList.add('hasvoted');
            upVote.classList.remove('notvoted');
            nr.textContent = parseInt(nr.textContent, 10) + 1;
        }
        else if (response.action == 'unvote') {
            upVote.classList.add('notvoted');
            upVote.classList.remove('hasvoted');
            nr.textContent = parseInt(nr.textContent, 10) - 1;
        }
    }
}

function dVoteHandler(){
    if (this.status === 200) {
        const response = JSON.parse(this.responseText);
        const id = response.id;
        const answer = document.querySelector(`#answer${id}`);
        const downVote = answer.querySelector('.down-vote ion-icon');
        const nr = answer.querySelector('.answer-btns span');
        if (response.action == 'vote'){
            downVote.classList.add('hasvoted');
            downVote.classList.remove('notvoted');
            nr.textContent = parseInt(nr.textContent, 10) - 1;
        }
        else if (response.action == 'unvote') {
            downVote.classList.add('notvoted');
            downVote.classList.remove('hasvoted');
            nr.textContent = parseInt(nr.textContent, 10) + 1;
        }
    }
}


function showAnswerDelete() {
    const modal = document.querySelector('#answerDeleteModal');
    modal.style.display = 'block';

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };

    const cancel = document.getElementById('ad-cancel');

    cancel.addEventListener('click', function(){
        modal.style.display = 'none';
    });

    const id = event.target.closest('.answer-details').getAttribute('data-id');
    
    const confirm = document.getElementById('ad-confirm');
    
    confirm.addEventListener('click', function(){
        event.preventDefault();
        sendAjaxRequest('delete', '/api/answers/' + id, {}, answerDeleteHandler);
    });
    
}


function answerDeleteHandler() {
    if (this.status === 200) {
        const response = JSON.parse(this.responseText);
        const id = response.id;
        const answer = document.querySelector(`#answer${id}`);
        const modal = document.querySelector('#answerDeleteModal');
        modal.style.display = 'none';
        answer.remove();
        createNotificationBox('Successfully saved!', 'Answer deleted successfully!');

        const other = document.querySelector('.other-answers');
        

        const top = document.querySelector('.top-answer');

        const hasTopAnswer = top.querySelector('.answer-details');
        if (!hasTopAnswer) {
            const nextAnswer = other.querySelector('.answer-details');
            top.innerHTML += nextAnswer.outerHTML;
            nextAnswer.remove();
        }

        const hasMoreAnswers = other.querySelector('.answer-details');
        
        if (!hasMoreAnswers) {
            other.querySelector('h2').remove();
        }
    }
}