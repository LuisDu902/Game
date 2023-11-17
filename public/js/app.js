const openSidebarButton = document.querySelector('.open-sidebar');


if (openSidebarButton) {
    const overlay = document.querySelector('.overlay');
    const sidebar = document.querySelector('.sidebar');
    
    openSidebarButton.addEventListener('click', () => {
        sidebar.style.left = '0';
        overlay.style.display = 'block';
    });

    overlay.addEventListener('click', () => {
        sidebar.style.left = '-400px';
        overlay.style.display = 'none';
    });
}

const dropDownButton = document.querySelector('.dropbtn');

if (dropDownButton) {
    let isOpen = false;
    const dropdownContent = document.querySelector('.dropdown-content');
    
    dropDownButton.addEventListener('click', function () {
        if (isOpen) {
            dropDownButton.innerHTML = '<ion-icon name="chevron-down"></ion-icon>';
            dropdownContent.style.display = 'none';
        } else {
            dropDownButton.innerHTML = '<ion-icon name="chevron-up"></ion-icon>';
            dropdownContent.style.display = 'flex';
        }

        isOpen = !isOpen;
    });

}


const questions_btns = document.querySelectorAll('.questions-sort button');


if (questions_btns) {
    questions_btns.forEach(button => {
        button.addEventListener('click', function () {
            questions_btns.forEach(btn => btn.classList.remove('selected'));
            this.classList.add('selected');
        });
    });
}


const selectElements = document.querySelectorAll('.status');

if (selectElements) {
    selectElements.forEach(function(selectElement) {
        selectElement.addEventListener('change', function() {
            const selectedValue = this.value;
            
            if (selectedValue === 'banned') {
                this.classList.remove('active');
                this.classList.add('banned');
            } else {
                this.classList.remove('banned');
                this.classList.add('active');
            }
        });
    });
}






