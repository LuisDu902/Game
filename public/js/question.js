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

function deleteQuestion(questionId){
    if (confirm('Are you sure you want to delete this question?')) {
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
            createNotificationBox('Successfully saved!', 'Question deleted successfully!');
            const questionElement = document.getElementById(questionId);
            if (questionElement) {
                questionElement.remove();
            }
        } else {
            console.error('Question delete failed:', this.statusText);
        }
    };
}



/* Question detail page */

const questionContainer = document.querySelector('.question-detail-section');

if (questionContainer) {
    const upVote = document.getElementById('up');
    const downVote =  document.getElementById('down');
    const questionId = questionContainer.dataset.id;
    const userId = questionContainer.getAttribute('data-user');
    const deleteBtn = document.querySelector('#delete-question');
    const editBtn = document.querySelector('#edit-question');

    if (!userId) {
        const no_up = document.querySelectorAll('.no-up');
        const no_down = document.querySelectorAll('.no-down');
        no_up.forEach(element => {
            element.addEventListener('click', showLoginModal);
        });
    
        no_down.forEach(element => {
            element.addEventListener('click', showLoginModal);
        });
    }

    if (upVote) {
    upVote.addEventListener('click', function(){
        if(upVote.classList.contains('hasvoted')){
            sendAjaxRequest('post', '/api/questions/' + questionId + "/unvote", {}, upVoteHandler);
        } else {
            if (downVote.classList.contains('hasvoted')) {
                sendAjaxRequest('post', '/api/questions/' + questionId + "/unvote", {}, downVoteHandler);
            }
            sendAjaxRequest('post', '/api/questions/' + questionId + "/vote", {reaction: true}, upVoteHandler);
        }
    });}

    if (downVote) {
    downVote.addEventListener('click', function(){
        if(downVote.classList.contains('hasvoted')){
            sendAjaxRequest('post', '/api/questions/' + questionId + "/unvote", {}, downVoteHandler);
        } else {
            if (upVote.classList.contains('hasvoted')) {
                sendAjaxRequest('post', '/api/questions/' + questionId + "/unvote", {}, upVoteHandler);
            }
            sendAjaxRequest('post', '/api/questions/' + questionId + "/vote", {reaction: false}, downVoteHandler);
        }
    });}

    if (deleteBtn) {
        deleteBtn.addEventListener('click', showDeleteModal);
    }

}


function showDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.style.display = 'block';

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };

    const cancel = document.getElementById('d-cancel');

    cancel.addEventListener('click', function(){
        modal.style.display = 'none';
    });
}

function showLoginModal() {

    const modal = document.getElementById('loginModal');
    modal.style.display = 'block';
    
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };
}


function upVoteHandler(){
    console.log(this)
    const upVote = document.getElementById('up');
   
    const nr = document.querySelector('.vote-btns span');
    if (this.status == 200){
        if (this.responseText == '{"action":"vote"}'){
            upVote.classList.add('hasvoted');
            upVote.classList.remove('notvoted');
            nr.textContent = parseInt(nr.textContent, 10) + 1;
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





const newPage = document.querySelector('.new-question-form');
let tags = [];
let selectHtml = '';
let validFiles = [];
let fileNames = [];

if (newPage) {
    
    const selectTag = document.getElementById('tag_id');
    const newTagsDiv = document.querySelector('.new-tags');

    selectTag.addEventListener('change', tagHandler);

    newTagsDiv.addEventListener('click', function(event) {
        if (event.target.tagName === 'ION-ICON') {
            const tagDiv = event.target.parentElement;
            const tagId = tagDiv.getAttribute('data-tagid');

            const index = tags.indexOf(tagId);
            if (index !== -1) {
                tags.splice(index, 1);
            }

            tagDiv.remove();
        }
    });

    const createTag = document.getElementById('create-tag');
    if (createTag) {
        createTag.addEventListener('click', createTagHandler);
    }

    const uploadButton = document.getElementById('up-f');
    const fileInput = document.getElementById('file');
    const questionImages = document.querySelector('.question-img');
    const questionDocs = document.querySelector('.question-files');

    uploadButton.addEventListener('click', function(){
        event.preventDefault();
        fileInput.click(); 
    })

    fileInput.addEventListener('change', function() {
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
                    questionDocs.innerHTML += `<div data-filename="${file.name}>
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
                    questionImages.innerHTML += `<div data-filename="${file.name}">
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
    });

    questionImages.addEventListener('click', function(event) {
        if (event.target.tagName === 'ION-ICON') {
            const imgDiv = event.target.parentElement;
            const filenameToRemove = imgDiv.getAttribute('data-filename');
            fileNames = fileNames.filter(name => name !== filenameToRemove);
            const indexToRemove = validFiles.findIndex(file => file.name === filenameToRemove);
            if (indexToRemove !== -1) {
                validFiles.splice(indexToRemove, 1);
            }
            imgDiv.remove();
        }
    }); 

    questionDocs.addEventListener('click', function(event) {
        if (event.target.tagName === 'ION-ICON') {
            const imgDiv = event.target.parentElement;
            const filenameToRemove = imgDiv.getAttribute('data-filename');
            fileNames = fileNames.filter(name => name !== filenameToRemove);
            const indexToRemove = validFiles.findIndex(file => file.name === filenameToRemove);
            if (indexToRemove !== -1) {
                validFiles.splice(indexToRemove, 1);
            }
            imgDiv.remove();
        }
    }); 
}

function createTagHandler() {
    const tagBtns = document.querySelector('.tag-btns');
    const selectTag = document.getElementById('tag_id');
    selectHtml = selectTag.outerHTML;
    tagBtns.innerHTML = `<button id="cancel-tag">Cancel</button>
    <button id="conf-tag">Create</button>`;

    const tagsLabel = document.querySelector('label[for="tags"]');
    tagsLabel.textContent = 'New tag:';
    selectTag.outerHTML = '<input type="text" name="tag-name" placeholder="New tag name..." required>';

    const confirm = document.getElementById('conf-tag');
    confirm.addEventListener('click', async function(){
        event.preventDefault();
        const newTag = document.querySelector('.tag-con input');
        if (newTag.value !== '') {
            sendAjaxRequest('post', '/api/tags', {name: newTag.value}, newTagHandler);
        }
    });

    const cancel = document.getElementById('cancel-tag');
    cancel.addEventListener('click', () => { event.preventDefault(); closeTag()});   

}

function closeTag() {
    const tagsLabel = document.querySelector('label[for="tags"]');
    const tagBtns = document.querySelector('.tag-btns');
    tagsLabel.textContent = 'Tags:';
    document.querySelector('.tag-con input').outerHTML = selectHtml;
    tagBtns.innerHTML = '<button id="create-tag">Create new tag</button>';
    const createTag = document.getElementById('create-tag');
    createTag.addEventListener('click', createTagHandler);
    const select = document.getElementById('tag_id');
    select.addEventListener('change', tagHandler);
}

function tagHandler() {
    const selectTag = document.getElementById('tag_id');
    const newTagsDiv = document.querySelector('.new-tags');
    const selectedOption = selectTag.options[selectTag.selectedIndex];
    if (selectedOption.value !== "None") {
        const tagId = selectedOption.value;
        const tagName = selectedOption.text;
        if (!tags.includes(tagId)) {
            tags.push(tagId);
            newTagsDiv.innerHTML += ` <div class="new-tag" data-tagid=${tagId}><span>${tagName}</span><ion-icon name="close-circle"></ion-icon></div>`;
        }
    }
}

function newTagHandler() {
    if (this.status == 200) {
        const tagId = JSON.parse(this.responseText).id;
        const name = JSON.parse(this.responseText).name;
        createNotificationBox('Successfully created!', 'A new tag has created successfully!');
        selectHtml = selectHtml.replace('</select>', '');
        selectHtml += `<option value="${tagId}"> ${ name }</option>`;
        selectHtml += '</select>';
        closeTag();
        tags.push(tagId);
        const newTagsDiv = document.querySelector('.new-tags');
        newTagsDiv.innerHTML += ` <div class="new-tag" data-tagid=${tagId}><span>${name}</span><ion-icon name="close"></ion-icon></div>`;

    } else {
        const errorResponse = JSON.parse(this.responseText);
        createNotificationBox('Something went wrong!', errorResponse.error.name, 'error');
        const input = document.querySelector('.tag-con input');
        input.focus();
    }
}