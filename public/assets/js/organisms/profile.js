
    function toggleTab(tabId) {
        const tabs = ['timeline', 'settings', 'password'];
        tabs.forEach(id => {
            document.getElementById(id).classList.toggle('hidden', id !== tabId);
            document.getElementById(id).classList.toggle('block', id === tabId);
        });
    }
