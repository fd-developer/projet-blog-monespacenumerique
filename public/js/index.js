console.log('hello Dyma !');

const headermobileButton = document.querySelector('.header-mobile-icon');
const headermobileList = document.querySelector('.header-mobile-list');

headermobileButton.addEventListener('click',()=>{
    headermobileList.classList.toggle('show');
})