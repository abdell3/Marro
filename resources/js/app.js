import './bootstrap';


// import Alpine from 'alpine.js';

// window.Alpine = Alpine;

// Alpine.start();


document.addEventListener('DOMContentLoaded', function() {
    
    document.querySelectorAll('.reply-button').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            document.getElementById(`reply-form-${commentId}`).classList.remove('hidden');
        });
    });
    
    
    document.querySelectorAll('.cancel-reply').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            document.getElementById(`reply-form-${commentId}`).classList.add('hidden');
        });
    });
});


window.openAwardModal = function(badgeId, badgeName) {
    const badgeIdInput = document.getElementById('badgeId');
    const badgeNameSpan = document.getElementById('badgeName');
    const modal = document.getElementById('awardBadgeModal');

    if (badgeIdInput && badgeNameSpan && modal) {
        badgeIdInput.value = badgeId;
        badgeNameSpan.textContent = badgeName;
        modal.classList.remove('hidden');
    }
};

window.closeAwardModal = function() {
    const modal = document.getElementById('awardBadgeModal');
    if (modal) {
        modal.classList.add('hidden');
    }
};

window.submitAwardForm = function() {
    const form = document.getElementById('awardBadgeForm');
    if (form) {
        form.submit();
    }
};
