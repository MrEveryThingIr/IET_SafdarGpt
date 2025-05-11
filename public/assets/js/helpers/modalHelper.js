/**
 * Simple modal helper with auth check
 * @param {string} triggerId - ID of trigger button
 * @param {string} modalId - ID of modal element
 * @param {Object} [options] - Configuration options
 */
export default function modalHelper(triggerSelector, modalSelector, options = {}) {
    const config = {
        loginRoute: _AUTH_STATE.loginRoute,
        hiddenClass: 'hidden',
        visibleClass: 'block',
        closeSelector: '.close',
        ...options
    };

   // Handle both ID (#) and class (.) selectors
   const trigger = document.querySelector(
    triggerSelector.startsWith('.') || triggerSelector.startsWith('#') 
        ? triggerSelector 
        : `#${triggerSelector}`
);

const modal = document.querySelector(
    modalSelector.startsWith('.') || modalSelector.startsWith('#') 
        ? modalSelector 
        : `#${modalSelector}`
);
    
    if (!trigger || !modal) {
        console.warn('Modal elements not found');
        return;
    }

    // Open modal
    trigger.addEventListener('click', (e) => {
        e.preventDefault();
        
        if (window._AUTH_STATE.isLoggedIn) {
            modal.classList.remove(config.hiddenClass);
            modal.classList.add(config.visibleClass);
        } else {
            window.location.href = config.loginRoute;
        }
    });

    // Close modal
    const closeBtn = modal.querySelector(config.closeSelector);
    if (closeBtn) {
        closeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            modal.classList.add(config.hiddenClass);
            modal.classList.remove(config.visibleClass);
        });
    }

    // Close when clicking outside
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add(config.hiddenClass);
            modal.classList.remove(config.visibleClass);
        }
    });
}