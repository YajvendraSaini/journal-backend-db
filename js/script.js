document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded');
    const callForPapersLink = document.getElementById('call-for-papers-link');
    if (callForPapersLink) {
        console.log('Call for Papers link found');
        callForPapersLink.addEventListener('click', function(e) {
            console.log('Call for Papers link clicked');
            e.preventDefault();
            showLoginPopup();
        });
    } else {
        console.log('Call for Papers link not found');
    }
});

function showLoginPopup() {
    console.log('Showing login popup');
    const popup = document.createElement('div');
    popup.className = 'popup';
    popup.innerHTML = `
        <div class="popup-content">
            <h2>Login Required</h2>
            <p>You must be logged in to submit a paper.</p>
            <div class="popup-buttons">
                <a href="login.php" class="button">Login</a>
                <button onclick="closePopup()" class="button secondary">Close</button>
            </div>
        </div>
    `;
    document.body.appendChild(popup);
}

function closePopup() {
    console.log('Closing popup');
    const popup = document.querySelector('.popup');
    if (popup) {
        popup.remove();
    }
}
