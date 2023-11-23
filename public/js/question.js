const questionsBtns = document.querySelectorAll('.questions-sort button');

if (questionsBtns) {
    questionsBtns.forEach(button => {
        button.addEventListener('click', function () {
            questionsBtns.forEach(btn => btn.classList.remove('selected'));
            this.classList.add('selected');
        });
    });
}

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




/* Question detail page */

const questionContainer = document.querySelector('.question-detail-section');


if (questionContainer) {
    const upVote = document.getElementById('up');
    const downVote =  document.getElementById('down');
    const questionId = questionContainer.dataset.id;
    const userId = questionContainer.getAttribute('data-user');

    upVote.addEventListener('click', function(){
        if(upVote.classList.contains('hasvoted')){
            sendAjaxRequest('post', '/api/questions/' + questionId + "/unvote", {}, upVoteHandler);
        } else {
            if (downVote.classList.contains('hasvoted')) {
                sendAjaxRequest('post', '/api/questions/' + questionId + "/unvote", {}, downVoteHandler);
            }
            sendAjaxRequest('post', '/api/questions/' + questionId + "/vote", {reaction: true}, upVoteHandler);
        }
    });

    downVote.addEventListener('click', function(){
        if(downVote.classList.contains('hasvoted')){
            sendAjaxRequest('post', '/api/questions/' + questionId + "/unvote", {}, downVoteHandler);
        } else {
            if (upVote.classList.contains('hasvoted')) {
                sendAjaxRequest('post', '/api/questions/' + questionId + "/unvote", {}, upVoteHandler);
            }
            sendAjaxRequest('post', '/api/questions/' + questionId + "/vote", {reaction: false}, downVoteHandler);
        }
    });


    const answer_btn = document.querySelector('.answer')

    answer_btn.addEventListener('click', function(){
        const answer = document.querySelector('#answerFormContainer')
        if (!answer) {
            const no_answers = document.querySelector('.no-answers');
            if (no_answers) {
                no_answers.remove();
            }
            questionContainer.innerHTML += ` <div id="answerFormContainer" class="answerFormContainer" >
                 <form >
                    <div class="form-group">
                        <label for="content">Answer <span>*</span></label>
                        <input type="hidden" name="userId" id="userId" value="${userId}">
                        <input type="hidden" name="questionId" id="questionId" value="${questionId}">
                        <textarea name="content" id="content" class="form-control" placeholder="Enter your answer here..." required></textarea>
                    </div>
                    <button class="btn btn-primary">Post Answer</button>
                </form>
            </div>`;
            const post_answer = document.querySelector('#answerFormContainer button');
            post_answer.addEventListener('click', function(){
                event.preventDefault();
                const textareaContent = document.querySelector('#content').value;
                sendAjaxRequest('post', '/api/answers', { content: textareaContent, userId: userId, questionId: questionId }, answerHandler);
            });
            const newAnswerFormContainer = document.querySelector('#answerFormContainer');
            newAnswerFormContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    })

  


}


function upVoteHandler(){
    console.log(this)
    const upVote = document.getElementById('up');
   
    const nr = document.querySelector('.vote-btns span');
    if (this.status == 200){
        if (this.responseText == '{"action":"vote"}'){
            upVote.classList.add('hasvoted');
            upVote.classList.remove('notvoted');
            nr.textContent = parseInt(nr.textContent, 10) +1;
        }
        else if (this.responseText == '{"action":"unvote"}') {
            upVote.classList.add('notvoted');
            upVote.classList.remove('hasvoted');
            nr.textContent = parseInt(nr.textContent, 10) - 1;
        }
    }
}

function downVoteHandler(){
    const downVote =  document.getElementById('down');
    const nr = document.querySelector('.vote-btns span');
    if (this.status == 200){
        if (this.responseText == '{"action":"vote"}'){
            downVote.classList.add('hasvoted');
            downVote.classList.remove('notvoted');
            nr.textContent = parseInt(nr.textContent, 10) - 1;
        }
        else if (this.responseText == '{"action":"unvote"}') {
            downVote.classList.add('notvoted');
            downVote.classList.remove('hasvoted');
            nr.textContent = parseInt(nr.textContent, 10) + 1;
        }
    }
}


function answerHandler() {
    if (this.status == 200){
        const newAnswerFormContainer = document.querySelector('#answerFormContainer');

        const textareaContent = document.querySelector('#content').value;
        newAnswerFormContainer.remove();
        const user = questionContainer.getAttribute('data-username');
        const answerContainer = document.querySelector('.other-answers');
        if(answerContainer){
            console.log('here')
        }
        answerContainer.innerHTML += `<div class="answer-details">
        <div class="vote-btns">
        
        </div>
        <div class="answer-content"> 
            <div>
                <img src="../images/user.png" alt="user">
                <p>
                    ${textareaContent}
                </p>
            </div>
            <ul>
                <li> <a href="#" class="purple"> ${user} </a> answered 0 seconds ago</li>
                <li> Modified 0 seconds ago </li>
                <li> 0 comments </li>
            </ul>
            <div class="answer-comments">
                <ul id="answer-comment-list">
                    <li>
                        <div class="comment-input">
                            <img src="../images/user.png" alt="user">
                            <input type="text" placeholder="Add new comment">
                            <button>
                                <ion-icon name="arrow-forward-circle-outline"></ion-icon>
                            </button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>`
    }

}


