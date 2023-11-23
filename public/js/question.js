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




document.addEventListener('DOMContentLoaded', function () {
    const upVote = document.getElementById('up');
    const downVote =  document.getElementById('down');
    const questionContainer = document.querySelector('.question-detail-section');
    const questionId = questionContainer.dataset.id;

    

    upVote.addEventListener('click', function(){
        
        console.log("batata2");
        if(upVote.classList.contains('hasvoted') && !upVote.classList.contains('baixo')  ){
            console.log("batataranho");
            sendAjaxRequest('post', '/api/questions/' + questionId + "/unvote", {reaction: true}, voteHandler);
            upVote.classList.remove('hasvoted');
            upVote.classList.add('notvoted');
            setTimeout(function() {
                location.reload();
            }, 10);

            
            
        }
        else if(  !upVote.classList.contains('baixo') && !upVote.classList.contains('cima')){
            console.log("ergr");
            sendAjaxRequest('post', '/api/questions/' + questionId + "/vote", {reaction: true}, voteHandler);
        
            upVote.classList.remove('notvoted');
            upVote.classList.add('hasvoted');
            setTimeout(function() {
                location.reload();
            }, 10);
            
        }

    })

    downVote.addEventListener('click', function(){
        console.log("batata2");
        if(downVote.classList.contains('hasvoted')  && !upVote.classList.contains('cima')){
            sendAjaxRequest('post', '/api/questions/' + questionId + "/unvote", {reaction: false}, voteHandler);
            downVote.classList.remove('hasvoted');
            downVote.classList.add('notvoted');
            setTimeout(function() {
                location.reload();
            }, 10);
            
           
        }
        else if(!downVote.classList.contains('baixo') && !downVote.classList.contains('cima')) {
            sendAjaxRequest('post', '/api/questions/' + questionId + "/vote", {reaction: false}, voteHandler);
        
            downVote.classList.remove('notvoted');
            downVote.classList.add('hasvoted');
            setTimeout(function() {
                location.reload();
            }, 10);
            


        }
    })
});



function voteHandler(){

}


