const filterBtn = document.getElementById('filterIcon');
const closeBtn = document.getElementById('closeFilter');
const modal = document.getElementById('filterModal');

filterBtn.addEventListener('click', () => {
    modal.classList.remove('hidden');
});

closeBtn.addEventListener('click', () => {
    modal.classList.add('hidden');
});
