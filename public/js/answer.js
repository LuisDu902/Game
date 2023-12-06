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


const answerPage = document.querySelector('#answerFormContainer form');

if (answerPage) {

    document.addEventListener('DOMContentLoaded', function() {
        const textareas = document.querySelectorAll('textarea');
        textareas.forEach(function(textarea) {
          textarea.value = '';
        });
    });

    const answerImages = document.querySelector('.answer-images');
    const answerDocs = document.querySelector('.answer-files');

    function uploadAFiles() {
        event.preventDefault();
        const fileInput = document.getElementById('file');
        fileInput.click();
    }

    function fileInputChange() {
        const fileInput = document.getElementById('file');
        const files = fileInput.files; 
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const imageExtentions = ["png", "jpeg", "jpg", "gif"];
            const documentExtentions = ["doc", "docx", "txt", "pdf"];
            const fileExtension = file.name.split('.').pop().toLowerCase();
            
            if (fileNames.includes(file.name)) {
                createNotificationBox('Repeated file!', 'This file was already upload!', 'warning');
                continue;
            }
            else if (documentExtentions.includes(fileExtension)) {
                validFiles.push(file);
                fileNames.push(file.name);
                const reader = new FileReader();

                reader.onload = function(event) {
                    const fileDataUrl = event.target.result;
                    answerDocs.innerHTML += `<div data-filename="${file.name}">
                        <ion-icon name="document"></ion-icon>
                        <a href="${fileDataUrl}" download="${file.name}">
                            <span>${file.name}</span>
                        </a>
                        <ion-icon name="close-circle" class="close"></ion-icon>
                    </div>`;
                }
                reader.readAsDataURL(file);

            }  else if (imageExtentions.includes(fileExtension)){
                validFiles.push(file);
                fileNames.push(file.name);
                const reader = new FileReader();
                
                reader.onload = function(event) {
                    const src = event.target.result;
                    answerImages.innerHTML += `<div data-filename="${file.name}">
                        <img src="${src}">
                        <ion-icon name="close-circle"></ion-icon>
                    </div>`;
                }
                reader.readAsDataURL(file);
            }
            else {
                createNotificationBox('Invalid file type!', 'Please choose a valid file type to upload!', 'error');
                this.value = ''; 
            }
            
        }
    }

    answerImages.addEventListener('click', () => removeImage(event));

    answerDocs.addEventListener('click', () => removeDocument(event));


    function createAnswer(){
        event.preventDefault();
        const content = document.getElementById('content').value;
        const question = document.querySelector('.question-detail-section').getAttribute('data-id');
        sendAjaxRequest('post', '/api/answers', {content: content, question_id: question}, createAnswerHandler);
    }
}

function answerFileHandler() {
    count++;
    if (validFiles.length == count) {
        const id = JSON.parse(this.responseText).id;
        const answer = document.getElementById('answer' + id);
        const aFiles = document.querySelectorAll('.answer-files div');
        const aImgs = document.querySelectorAll('.answer-images img');
        
        const answerF = answer.querySelector('.a-files');
        const answerI = answer.querySelector('.a-img');

        for (const image of aImgs) {
            answerI.innerHTML += image.outerHTML;
        }

        for (const file of aFiles) {
            file.querySelector('.close').remove();
            file.classList.add('a-file');
            answerF.innerHTML += file.outerHTML;
        }

        aFiles.innerHTML = ``;
        aImgs.innerHTML = ``;

        tags = [];
        selectHtml = '';
        validFiles = [];
        fileNames = [];
        count = 0;
        deletedFiles = [];

    }
}

function createAnswerHandler(){
    if (this.status == 200) {
        const otherAnswers = document.querySelector('.other-answers');
        if (otherAnswers) {
            if (!otherAnswers.querySelector('h2')) {
                otherAnswers.innerHTML += ' <h2>Other answers</h2>'
            }
            otherAnswers.innerHTML += this.responseText;
        }
        else {
            const answers = document.querySelector('.answerFormContainer');
            answers.outerHTML = `
            <div class="top-answer">
                <h2>Top answer</h2>
                ${this.responseText}
            </div><div class="other-answers"></div>` + answers.outerHTML;
        }

        let tmp = document.createElement('div');
        tmp.innerHTML = this.responseText;
        const id = tmp.querySelector('.answer-details').getAttribute('data-id');

        createNotificationBox('Answer created!', 'Answer created successfully!');
        document.querySelector('#answerFormContainer form textarea').value = ''; 
        
        if (validFiles.length > 0) {
            count = 0;
            validFiles.map(async function(file) {
                let formData = new FormData();
                formData.append('file', file); 
                formData.append('id', id);
                formData.append('type', 'answer');    
                let request = new XMLHttpRequest();
                request.open('post', '/api/file/upload', true);
                request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
                request.addEventListener('load', answerFileHandler);
                request.send(formData);
            });
        } else {
            tags = [];
            selectHtml = '';
            validFiles = [];
            fileNames = [];
            count = 0;
            deletedFiles = [];
        }
       
    }
 
}