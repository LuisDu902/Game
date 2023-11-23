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
    if (answer_btn){
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
    const edit_btn = document.querySelector('.edit-question')

    if (edit_btn){
        edit_btn.addEventListener('click', function(){
            if (edit_btn.textContent == 'Edit') {
                const title = document.querySelector('.question-title h1')
                title.innerHTML = `<input type="text" value="${title.textContent}" class="question-input" required>`
                const content = document.querySelector('.question-description p')
                content.innerHTML = `<textarea class="question-c" placeholder="Question details..." value="${content.textContent}">${content.textContent}</textarea>`
                edit_btn.textContent = 'Save'
            } else {
                const new_title = document.querySelector('.question-input').value;
                const new_content = document.querySelector('.question-c').value;
                if (new_title != '' && new_content != ''){
                    sendAjaxRequest('put', '/api/questions/' + questionId + '/edit', {title: new_title, content: new_content}, editQuestionHandler);
                    edit_btn.textContent = 'Edit'
                }
            }
        })
    }

    const answer_btns = document.querySelectorAll(".edit-answer")

    if (answer_btns) {
        for (let edit_button of answer_btns) {
            edit_button.addEventListener('click', function(){
                const content = event.target.closest('div').querySelector('p');
                if (edit_button.textContent == 'Edit') {
                    content.innerHTML = `<input type="text" value="${content.textContent}" class="answer-input" required>`
                    edit_button.textContent = 'Save'
                } else {
                    const new_content = event.target.closest('div').querySelector('p input').value;
                    const time = event.target.closest('.answer-content').querySelector('.a-modi');
                    const answerId = edit_button.getAttribute('data-id');
                    
                    if (new_content != '') {
                        sendAjaxRequest('put', '/api/answers/' + answerId + '/edit', {content: new_content}, editAnswerHandler);
                        content.innerHTML = `${new_content}`;
                        time.textContent = 'Modified 0 seconds ago'
                    }
                    edit_button.textContent = 'Edit'
                }
            })
        }
    }
    
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
        const questionId = questionContainer.dataset.id;
        const userId = questionContainer.getAttribute('data-user');
        const newAnswerFormContainer = document.querySelector('#answerFormContainer');

        const textareaContent = document.querySelector('#content').value;
        newAnswerFormContainer.remove();
        const user = questionContainer.getAttribute('data-username');
        const answerContainer = document.querySelector('.other-answers');
        const h2 = document.querySelector('.other-answers h2');
        if (!h2){
            answerContainer.innerHTML += `<h2>Answers</h2>`
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
    }
    )}
}



function editQuestionHandler() {
    if (this.status == 200) {
        const new_title = document.querySelector('.question-input').value;
        const new_content = document.querySelector('.question-c').value;
        const title = document.querySelector('.question-title h1')
        title.innerHTML = `${new_title}`
        const content = document.querySelector('.question-description p')
        content.innerHTML =  `${new_content}`
        createNotificationBox('Question successfully edit!')
        const modi = document.querySelector('#q-modi')
        modi.textContent = 'Modified 0 seconds ago'
    }
}



function editAnswerHandler() {
    if (this.status == 200) {
        createNotificationBox('Answer successfully edit!')
    }
}