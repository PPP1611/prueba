function setupModal(openBtnId, closeBtnId, modalId) {
    const openBtn = document.getElementById(openBtnId);
    const closeBtn = document.getElementById(closeBtnId);
    const modal = document.getElementById(modalId);

    if (openBtn && closeBtn && modal) {
        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    }
}

// Modal de filtros
setupModal('filterIcon', 'closeFilter', 'filterModal');

// Modal de suscripción (usando userIcon)
setupModal('userIcon', 'closeSubscribe', 'subscribeModal');

