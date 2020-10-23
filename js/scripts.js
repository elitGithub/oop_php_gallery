const deconstructedUrl = window.location.pathname.split('/');
let requestedFile = deconstructedUrl[deconstructedUrl.length - 1];
if (requestedFile === 'photo.php') {
    document.addEventListener('DOMContentLoaded', () => {
        const commentForm = document.getElementById('add_comment');
        commentForm.addEventListener('submit', async e => {
            e.preventDefault();
            const urlParams = new URLSearchParams(window.location.search);
            const photo_id = urlParams.get('id');
            const commentForm = document.getElementById('add_comment');
            const requestBody = new FormData(commentForm);
            requestBody.append('photo_id', photo_id);
            let request = {
                method: "POST",
                body: requestBody,
            };
            await fetch('includes/api/addcomment.php', request);
        });
    });
}