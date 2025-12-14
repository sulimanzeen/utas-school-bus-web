// Minimal loader controller for admin dashboard
function showLoader(message){
    const el = document.getElementById('page-loader');
    if(!el) return;
    if(message){
        const sub = el.querySelector('.loader-sub');
        if(sub) sub.textContent = message;
    }
    el.classList.remove('hidden');
}

function hideLoader(){
    const el = document.getElementById('page-loader');
    if(!el) return;
    el.classList.add('hidden');
}

// Optional helper to show progress text during fetch steps
function setLoaderProgress(text){
    const sub = document.querySelector('#page-loader .loader-sub');
    if(sub) sub.textContent = text || '';
}

// Expose to global for inline script usage
window.showLoader = showLoader;
window.hideLoader = hideLoader;
window.setLoaderProgress = setLoaderProgress;

// Fallback: hide loader shortly after DOM is ready if not explicitly hidden
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        const el = document.getElementById('page-loader');
        if (el && !el.classList.contains('hidden')) {
            el.classList.add('hidden');
        }
    }, 1200);
});
