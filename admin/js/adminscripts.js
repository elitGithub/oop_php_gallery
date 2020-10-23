// TODO: Refactor this file. Most of this code can be simplified
// TODO: and moved to smaller chunks of code
// TODO: this could probably use some cleaning
const sideBarNav = document.getElementById('sidebar_nav');
const topNavItems = document.getElementById('top_nav_items');
const pageContent = document.getElementById('page_content');
const modalContent = document.getElementById('theModalContent');
const messageModal = document.getElementById('editUserResultMessage');
const resultModalContent = document.getElementById('messageContent');
const messages = getUserMessages();
const alerts = getUserAlerts();
const sideBarItems = getSideBarItems();
const routes = [
    'index.php',
    'users.php',
    'photos.php',
    'uploads.php',
    'comments.php',
];
const usersEditForm = document.getElementById('userEditForm');
const chartData = {};
const browserCookies = {};


let activeRoute = window.location.pathname;

async function getLoggedInUser() {
    let data = await fetch('api/users/loggedinuser.php');
    return data.json();
}

async function mainPageContent() {
    const loggedInUser = await getLoggedInUser();
    topNavItems.innerHTML = `<li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
        <ul class="dropdown-menu message-dropdown">
        ${messages}
            <li class="message-footer">
                <a href="#">Read All New Messages</a>
            </li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
        <ul class="dropdown-menu alert-dropdown">
        ${alerts}
        <li class="divider"></li>
        <li>
            <a href="#">View All</a>
        </li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> ${loggedInUser.data['firstName']} ${loggedInUser.data['lastName']}<b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>
                <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="#" id="logout-link"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
            </li>
        </ul>
    </li>`;
    sideBarNav.innerHTML = sideBarItems;
    const logoutLink = document.getElementById('logout-link');
    pageContent.innerHTML = getPageContent({activeRoute});
    logoutLink.addEventListener('click', logout);
}

document.addEventListener('DOMContentLoaded', mainPageContent);

function getUserMessages(options = {}) {
    let html = '';
    // Will be a fetch request
    let messages = [
        `<li class="message-preview">
                <a href="#">
                    <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                        <div class="media-body">
                            <h5 class="media-heading">
                                <strong>John Smith</strong>
                            </h5>
                            <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                            <p>Lorem ipsum dolor sit amet, consectetur...</p>
                        </div>
                    </div>
                </a>
            </li>`,
        `<li class="message-preview">
                <a href="#">
                    <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                        <div class="media-body">
                            <h5 class="media-heading">
                                <strong>John Smith</strong>
                            </h5>
                            <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                            <p>Lorem ipsum dolor sit amet, consectetur...</p>
                        </div>
                    </div>
                </a>
            </li>`,
        `<li class="message-preview">
                <a href="#">
                    <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                        <div class="media-body">
                            <h5 class="media-heading">
                                <strong>John Smith</strong>
                            </h5>
                            <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                            <p>Lorem ipsum dolor sit amet, consectetur...</p>
                        </div>
                    </div>
                </a>
            </li>`,
    ];
    for (const message of messages) {
        html += message;
    }
    return html;
}

function getUserAlerts(options = {}) {
    let html = '';
    let alerts = [
        `<li>
            <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
        </li>`,
        `<li>
            <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
        </li>`,
        `<li>
            <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
        </li>`,
        `<li>
            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
        </li>`,
        `<li>
            <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
        </li>`,
        `<li>
            <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
        </li>`,
    ];
    for (const alert of alerts) {
        html += alert;
    }
    return html;
}

function getSideBarItems(options = {}) {
    let html = '';
    let sidebarItems = [
        `<li>
            <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
        </li>`,
        `<li>
            <a href="users.php"><i class="fa fa-fw fa-bar-chart-o"></i> Users</a>
        </li>`,
        `<li>
            <a href="uploads.php"><i class="fa fa-fw fa-table"></i> Upload</a>
        </li>`,
        `<li>
            <a href="photos.php"><i class="fa fa-fw fa-table"></i> Photos</a>
        </li>`,
        `<li>
            <a href="comments.php"><i class="fa fa-fw fa-edit"></i> Comments</a>
        </li>`,
        `<li>
            <a href="javascript:" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Dropdown <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="demo" class="collapse">
                <li>
                    <a href="#">Dropdown Item</a>
                </li>
                <li>
                    <a href="#">Dropdown Item</a>
                </li>
            </ul>
        </li>`,
        `<li>
            <a href="index.php"><i class="fa fa-fw fa-file"></i> Blank Page</a>
        </li>`,
        `<li>
            <a href="#"><i class="fa fa-fw fa-dashboard"></i> RTL Dashboard</a>
        </li>`,
    ];

    for (const item of sidebarItems) {
        html += item;
    }
    return html;
}

async function getAllPhotos() {
    return await fetch('api/photos/getphotos.php?get_all');
}

async function printPhotosTableWithData(photos) {
    let table = `<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Photo Management
            <small>${photos.data.count.totalRecords} Photos</small>
        </h1>
        <button id="add_photos_button" class="btn btn-primary pull-right add-users-button">Add Photo</button>
    </div>`;

    for (const photo of photos.data.photos) {
        table += `<div class="col-sm-3 col-md-3">
                    <div class="thumbnail">
                      <img src="${photo.filename}" alt="${photo.placeholder}">
                      <div class="caption">
                        <h3>${photo.title}</h3>
                        <p>${photo.description}</p>
                        <a href="#"><i class="fa fa-pencil" id="${photo.id}"></i></a>
                        <a href="#"><i class="fa fa-trash" id="${photo.id}"></i></a>
                      </div>
                    </div>
                  </div>`;
    }
    pageContent.innerHTML = table;
    document.getElementById('add_photos_button').addEventListener('click', async e => {
        await addNewPhoto(e);
        usersEditForm.style.display = 'block';
    });
    const editButtons = document.querySelectorAll('.fa-pencil');
    const deleteButtons = document.querySelectorAll('.fa-trash');
    editButtons.forEach(button => button.addEventListener('click', e => {
        e.preventDefault();
        managePhoto(e.target.id);
    }));

    deleteButtons.forEach(button => button.addEventListener('click', e => {
        e.preventDefault();
        deletePhoto(e.target.id);
    }));
}

async function addNewPhoto(e) {
    modalContent.innerHTML = `<span id="closeUserEdit" class="close">x</span>
        <div class="errors alert-danger"></div>
        <form class="form-align-center" id="addPhoto" enctype="multipart/form-data">
            <div class="edit-user-header">
               Add New Photo
            </div>
            <div class="form-group">
                <label for="image"">New Image</label>
                <input type="file" id="image" name="image">
            </div>
            <div class="form-group">
                <label for="title">Photo Title</label>
                <input type="text" class="form-control" required minlength="2" name="title" id="title">
            </div>
            <div class="form-group">
                <label for="alt_text">Alt Text</label>
                <input type="text" class="form-control" required minlength="2" name="alt_text" id="alt_text">
            </div>
            <div class="form-group">
                <label for="caption">Caption</label>
                <input type="text" class="form-control" required minlength="2" name="caption" id="caption">
            </div>
            <div class="form-group">
                <label for="description">Photo Description</label>
                <textarea class="form-control" required minlength="2" name="description" id="add_description"></textarea>
            </div>
            <div class="form-buttons">
                <button type="submit" value="create_new" id="create_new" name="create_new" class="btn btn-success">Create </button>
                <button id="cancelUserEdit" class="btn btn-danger">Cancel </button>
            </div>
        </form>`;
    document.getElementById('closeUserEdit').addEventListener('click', closeUserEditForm);
    document.getElementById('cancelUserEdit').addEventListener('click', closeUserEditForm);
    document.getElementById('create_new').addEventListener('click', e => uploadFile(e));
    tinymce.init({
        selector:'#add_description',
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        }
    });
}

async function fetchAllComments() {
    return await fetch('api/comments/getcomments.php?find_all');
}

async function printCommentsTableWithData(comments) {
    let table = `<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Comments Management
            <small>${comments.data.count.totalRecords} Comments</small>
        </h1>
    <table class="table table-striped table-bordered">
    <tr>
    <th>Author</th>
    <th>Image</th>
    <th>Comment Content</th>
    <th>Actions</th>
    </tr>
    `;
    for (const comment of comments.data.comments) {
        table += `<tr>
                <td>${comment.author}</td>
                <td><img class="thumbnail" src="${comment.filename}" alt=""></td>
                <td>${comment.body}</td>
                <td>
                <a href="#"><i class="fa fa-pencil" id="${comment.id}"></i></a>
                <a href="#"><i class="fa fa-trash" id="${comment.id}"></i></a>
                </td>
                </tr>`;
    }
    table += '</table></div>';
    pageContent.innerHTML = table;
    const editButtons = document.querySelectorAll('.fa-pencil');
    const deleteButtons = document.querySelectorAll('.fa-trash');
    editButtons.forEach(button => button.addEventListener('click', e => {
        e.preventDefault();
        editComment(e.target.id);
    }));

    deleteButtons.forEach(button => button.addEventListener('click', e => {
        e.preventDefault();
        deleteComment(e.target.id);
    }));
}

async function buildCommentEditForm(commentData) {
    commentData.json().then(commentObj => {
        modalContent.innerHTML = `<span id="closeUserEdit" class="close">x</span>
        <div class="errors"></div>
        <form class="form-align-center" id="editComment" enctype="multipart/form-data">
            <div class="edit-user-header">
                Editing User: ${commentObj.data.id}
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" class="form-control" required minlength="2" name="author" id="author" value="${commentObj.data.author}">
            </div>
            <div class="form-group">
                <label for="comment_content">Comment Content</label>
                <textarea class="form-control" name="comment_content" id="comment_content">${commentObj.data.comment_content}</textarea>
            </div>
            <div class="form-buttons">
                <button type="submit" value="update_user" data-id="${commentObj.data.id}" id="update_comment" name="update_comment" class="btn btn-success">Submit</button>
                <button id="cancelUserEdit" class="btn btn-danger">Cancel</button>
            </div>
        </form>`;
        document.getElementById('closeUserEdit').addEventListener('click', closeUserEditForm);
        document.getElementById('cancelUserEdit').addEventListener('click', closeUserEditForm);
        tinymce.init({
            selector:'#comment_content',
            setup: function (editor) {
                editor.on('change', function () {
                    tinymce.triggerSave();
                });
            }
        });
    });
}

async function updateComment(options = {}) {
    let url = 'api/comments/updatecomment.php';
    let request = {
        method: "POST",
        body: options,
    };
    return (await fetch(url, request)).json();
}

async function editComment(id) {
    let url = `api/comments/getcomments.php?find_one&id=${id}`;
    await buildCommentEditForm(await fetch(url));
    usersEditForm.style.display = 'block';

    usersEditForm.addEventListener('submit', e => {
        e.preventDefault();
        const form = document.querySelector('#editComment');
        if (!validateForm(form)) {
            return false;
        }
        const formData = new FormData();
        for (let forms of form) {
            formData.append(forms.name, forms.value);
        }
        formData.append('id', id);
        updateComment(formData).then(resJson => {
            if (resJson.success) {
                usersEditForm.style.display = 'none';
                resultModalContent.innerHTML = `<div class="alert alert-success center-message" role="alert">
                        Photo Updated successfully!
                </div>
                <div class="form-buttons">
                    <button id="closeMessage" class="btn btn-success">OK</button>
                </div>`;
                document.getElementById('closeMessage').addEventListener('click', closeUserEditForm);
                messageModal.style.display = 'block';
            } else {
                usersEditForm.style.display = 'none';
                resultModalContent.innerHTML = `<div class="alert alert-danger center-message" role="alert">
                        Failed to update picture details! ${resJson.message}.
                </div>
                <div class="form-buttons">
                    <button id="closeMessage" class="btn btn-danger">OK</button>
                </div>`;
                document.getElementById('closeMessage').addEventListener('click', closeUserEditForm);
                messageModal.style.display = 'block';
            }
        }).then(() => getPageContent({rerenderPage: 'comments.php'}));
    });
}

async function deleteComment(id) {
    let confirmDelete = confirm('Warning! Deleting a comment is permanent and cannot be reversed! Continue?');
    if (confirmDelete) {
        let url = `api/comments/deletecomment.php?id=${id}`;
        await fetch(url).then(() => getPageContent({rerenderPage: 'comments.php'}));
    }
}

async function dashboardMainPage() {
    return fetch('api/general/dashboard.php');
}

async function printMainDashBoard(dashboardInfo) {
    chartData.totalPhotos = dashboardInfo.data.photos.totalRecords || 0;
    chartData.totalUsers = dashboardInfo.data.photos.totalRecords || 0;
    chartData.totalComments = dashboardInfo.data.photos.totalRecords || 0;
    chartData.totalViews = dashboardInfo.data.views || 0 ;
    pageContent.innerHTML = `<div class="col-lg-12">
                        <h1 class="page-header">
                            Index Page!
                            <small>Dashboard</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>
                    <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">${chartData.totalViews}</div>
                                        <div>New Views</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                  <span class="pull-left">View Details</span> 
                               <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span> 
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                     <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-photo fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">${chartData.totalPhotos}</div>
                                        <div>Photos</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">Total Photos in Gallery</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                     <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">${chartData.totalUsers}
                                        </div>
                                        <div>Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">Total Users</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                      <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-support fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">${chartData.totalComments}</div>
                                        <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">Total Comments</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
          </div> <!--First Row-->
          <div class="google-pie-chart">
          <div class="the-pie" id="piechart"></div>
</div>`;
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
}

function innerHtml(requestedFile) {
    switch (requestedFile) {
        case 'index.php':
            document.title = 'Content Management Admin';
            dashboardMainPage()
                .then(dataList => dataList.json())
                .then(data => printMainDashBoard(data));
            break;
        case 'users.php':
            document.title = 'User Management';
            fetchAllUsers()
                .then(usersList => usersList.json())
                .then(users => {
                return printUsersTableWithData(users.data);
            });
            break;
        case 'uploads.php':
            // TODO: add this
            document.title = 'Uploads';
            return `<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Uploads Page!
                            <small>Upload here</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="uploads.php">Uploads</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>
                </div>`;
        case 'comments.php':
            document.title = 'Comments';
            fetchAllComments()
                .then(commentsList => commentsList.json())
                .then(comments => {
                    return printCommentsTableWithData(comments);
                });
            break;
        case 'photos.php':
            document.title = 'Photos';
            getAllPhotos()
                .then(photoList => photoList.json())
                .then(photos => {
                    return printPhotosTableWithData(photos);
                });
            break;
        default:
            document.title = 'Not Found';
            return `<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Not found
                            <small>The page you were looking for is not here.</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Back Home </a>
                            </li>
                        </ol>
                    </div>
                </div>`;
    }
}

function getPageContent(options = {}) {
    if (!options['rerenderPage']) {
        let deconstructedUrl = options.activeRoute.split('/');
        let requestedFile = deconstructedUrl[deconstructedUrl.length - 1];
        requestedFile === '' ? requestedFile = 'index.php' : requestedFile;
        if (routes.find(route => route === requestedFile)) {
            return innerHtml(requestedFile);
        }
    }
    if (options['rerenderPage']) {
        return innerHtml(options['rerenderPage']);
    }
}

async function fetchAllUsers() {
    return await fetch('api/users/fetchusers.php?find_all');
}

function printUsersTableWithData(data) {
    let table = `<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            User Management 
            <small>${data.count.totalRecords} Users</small>
        </h1>
        <button id="add_users_button" class="btn btn-primary pull-right add-users-button">Add User</button>
    <table class="table table-striped table-bordered">
    <tr>
    <th>ID</th>
    <th>Username</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Email</th>
    <th>Actions</th>
    </tr>`;

    for (const dataItem of data['users']) {
        table += `<tr>
                <td>${dataItem.id}</td>
                <td>${dataItem.username}</td>
                <td>${dataItem.firstName}</td>
                <td>${dataItem.lastName}</td>
                <td>${dataItem.email}</td>
                <td>
                <a href="#"><i class="fa fa-pencil" id="${dataItem.id}"></i></a>
                <a href="#"><i class="fa fa-trash" id="${dataItem.id}"></i></a>
                </td>
                </tr>`;
    }
    table += '</table></div>';
    pageContent.innerHTML = table;
    const editButtons = document.querySelectorAll('.fa-pencil');
    const deleteButtons = document.querySelectorAll('.fa-trash');
    editButtons.forEach(button => button.addEventListener('click', e => {
        manageSingleUser(e.target.id);
    }));

    deleteButtons.forEach(button => button.addEventListener('click', e => {
        e.preventDefault();
        deleteUser(e.target.id);
    }));

    document.getElementById('add_users_button').addEventListener('click', e => addNewUser(e));
}

async function addNewUser(e) {
    modalContent.innerHTML = `<span id="closeUserEdit" class="close">x</span>
        <div class="errors alert-danger"></div>
        <form class="form-align-center" id="createNewUser" enctype="multipart/form-data">
            <div class="edit-user-header">
               Add New User
            </div>
            <div class="form-group">
                <label for="username">User Name</label>
                <input type="text" class="form-control" required minlength="2" name="username" id="username">
            </div>
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" required minlength="2" name="firstName" id="firstName">
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control"  name="lastName" id="lastName">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" required minlength="6" name="email" id="email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" required name="password" minlength="6" maxlength="32" id="password">
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" required name="confirm_password" minlength="6" maxlength="32" id="confirm_password">
            </div>
            <div class="form-group">
                <label for="image"">User Image</label>
                <input type="file" id="image" name="image">
            </div>
            <div class="form-buttons">
                <button type="submit" value="create_new" id="create_new" name="create_new" class="btn btn-success">Create </button>
                <button id="cancelUserEdit" class="btn btn-danger">Cancel</button>
            </div>
        </form>`;
    document.getElementById('closeUserEdit').addEventListener('click', closeUserEditForm);
    document.getElementById('cancelUserEdit').addEventListener('click', closeUserEditForm);
    document.getElementById('create_new').addEventListener('click', e => createNewUser(e));
    usersEditForm.style.display = 'block';
}

async function updateUser(options = {}) {
    let url = 'api/users/updateusers.php';
    let request = {
        method: "POST",
        body: options,
    };
    return (await fetch(url, request)).json();
}

async function updatePhoto(options) {
    let url = 'api/photos/updatephotos.php';
    let request = {
        method: "POST",
        body: options,
    };
    return (await fetch(url, request)).json();
}

async function logout() {
    await fetch('api/users/logout.php');
    window.location.href = 'login.php';
}

/**
 *
 * @param userId
 * @returns {Promise<void>}
 */
async function manageSingleUser(userId) {
    let url = `api/users/fetchusers.php?find_one&id=${userId}`;
    await buildUserEditForm(await fetch(url));
    usersEditForm.style.display = 'block';

    usersEditForm.addEventListener('submit', e => {
            e.preventDefault();
            const form = document.querySelector('#editUser');
            if (!validateForm(form)) {
                return false;
            }
            const formData = new FormData();
            for (let forms of form) {
                formData.append(forms.name, forms.value);
            }
            formData.append('user_id', document.getElementById('update_user').dataset.id);
            const userImage = document.querySelector('#image');
            if (userImage.files.length > 0) {
                formData.append('image', userImage.files[0]);
            }
            updateUser(formData).then(resJson => {
                if (resJson.success) {
                    usersEditForm.style.display = 'none';
                    resultModalContent.innerHTML = `<div class="alert alert-success center-message" role="alert">
                        User Details Updated successfully!
                </div>
                <div class="form-buttons">
                    <button id="closeMessage" class="btn btn-success">OK</button>
                </div>`;
                    document.getElementById('closeMessage').addEventListener('click', closeUserEditForm);
                    messageModal.style.display = 'block';
                } else {
                    usersEditForm.style.display = 'none';
                    resultModalContent.innerHTML = `<div class="alert alert-danger center-message" role="alert">
                        Failed to update user details! ${resJson.message}.
                </div>
                <div class="form-buttons">
                    <button id="closeMessage" class="btn btn-danger">OK</button>
                </div>`;
                    document.getElementById('closeMessage').addEventListener('click', closeUserEditForm);
                    messageModal.style.display = 'block';
                }
            }).then(() => getPageContent({rerenderPage: 'users.php'}));
        });
}

/**
 *
 */
function closeUserEditForm() {
    usersEditForm.style.display = 'none';
    messageModal.style.display = 'none';
    modalContent.innerHTML = '';
    resultModalContent.innerHTML = '';
}

/**
 *
 * @param userData
 * @returns {Promise<void>}
 */
async function buildUserEditForm(userData) {
    userData.json().then(userObj => {
        modalContent.innerHTML = `<span id="closeUserEdit" class="close">x</span>
        <div class="errors"></div>
        <form class="form-align-center" id="editUser" enctype="multipart/form-data">
            <div class="edit-user-header">
                Editing User: ${userObj.data.username}
            </div>
            <div class="img img-thumbnail center-form user-avatar-wrapper">
                  <img class="img img-thumbnail user-avatar" src="${userObj.data.image}" alt="user avatar" id="user_image">
            </div>
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" required minlength="2" name="firstName" id="firstName" value="${userObj.data.firstName}">
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control"  name="lastName" id="lastName" value="${userObj.data.lastName}">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" required minlength="6" name="email" id="email" value="${userObj.data.email}">
            </div>
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" class="form-control" name="password" minlength="6" maxlength="32" id="password">
            </div>
            <div class="form-group">
                <label for="image"">User Image</label>
                <input type="file" id="image" name="image">
            </div>
            <div class="form-buttons">
                <button type="submit" value="update_user" data-id="${userObj.data.id}" id="update_user" name="update_user" class="btn btn-success">Submit</button>
                <button id="cancelUserEdit" class="btn btn-danger">Cancel</button>
            </div>
        </form>`;
        document.getElementById('closeUserEdit').addEventListener('click', closeUserEditForm);
        document.getElementById('cancelUserEdit').addEventListener('click', closeUserEditForm);
    });
}

// For general purpose file upload
async function uploadFile(e) {
    e.preventDefault();
    const form = document.getElementById('addPhoto');
    const formData = new FormData(form);
    const image = document.querySelector('#image');

    if (image.files.length > 0) {
        formData.append('image', image.files[0]);
    }
    let url = 'api/photos/addphoto.php';
    let request = {
        method: "POST",
        body: formData,
    };
    await fetch(url, request).then(response => response.json()).then(resJson => {
        if (resJson.success) {
            usersEditForm.style.display = 'none';
            resultModalContent.innerHTML = `<div class="alert alert-success center-message" role="alert">
                        Photos Uploaded Successfully
                </div>
                <div class="form-buttons">
                    <button id="closeMessage" class="btn btn-success">OK</button>
                </div>`;
            document.getElementById('closeMessage').addEventListener('click', closeUserEditForm);
            messageModal.style.display = 'block';
        } else {
            usersEditForm.style.display = 'none';
            resultModalContent.innerHTML = `<div class="alert alert-danger center-message" role="alert">
                        Failed to upload photo! ${resJson.message}.
                </div>
                <div class="form-buttons">
                    <button id="closeMessage" class="btn btn-danger">OK</button>
                </div>`;
            document.getElementById('closeMessage').addEventListener('click', closeUserEditForm);
            messageModal.style.display = 'block';
        }
    }).then(() => getPageContent({rerenderPage: 'photos.php'}));
}

/**
 *
 * @param form
 * @returns {boolean}
 */
function validateForm(form) {
    let errors = [];
    for (let i = 0; i < form.elements.length; i++) {
        if (form[i].name === 'firstName' || form[i].name === 'lastname') {
            if (form[i].value === '' || form[i].value.length < 2) {
                errors.push('You are missing required fields!');
            }
        }

        if (form.id === 'createNewUser') {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            if (form[i].name === 'password' || form[i].name === 'confirm_password') {
                if (form[i].value === '' || form[i].value.length < 2) {
                    errors.push('Password too short!');
                }
                if (password.value !== confirmPassword.value) {
                    errors.push('Passwords do not match!');
                }
            }
        }

        if (form[i].name === 'email') {
            const emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            if (!emailRegex.test(form[i].value)) {
                errors.push('Invalid email');
            }
        }

        if (form[i].name === 'image' && form[i].files && form[i].files[0]) {
            let filePath = form[i].value;
            let allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
            if (!allowedExtensions.exec(filePath)) {
                errors.push('Invalid file');
                form[i].value = '';
            }
        }
    }
    if (errors.length > 0) {
        for (let error of errors) {
            document.querySelector('.errors').innerHTML = error;
        }
        document.querySelector('.errors').style.display = 'flex';
    }
    return errors.length < 1;
}

async function createNewUser(e) {
    e.preventDefault();
    const form = document.getElementById('createNewUser');
    if (validateForm(form)) {
        const formData = new FormData();
        for (let forms of form) {
            formData.append(forms.name, forms.value);
        }
        const userImage = document.querySelector('#image');
        if (userImage.files.length > 0) {
            formData.append('image', userImage.files[0]);
        }

        const username = document.getElementById('username');
        let validation = await validateNewUser(username.value);
        if (validation.success === true) {
            let url = 'api/users/insertusers.php';
            let request = {
                method: "POST",
                body: formData,
            };
            await fetch(url, request).then(response => response.json()).then(resJson => {
                if (resJson.success) {
                usersEditForm.style.display = 'none';
                resultModalContent.innerHTML = `<div class="alert alert-success center-message" role="alert">
                        User created successfully!
                </div>
                <div class="form-buttons">
                    <button id="closeMessage" class="btn btn-success">OK</button>
                </div>`;
                document.getElementById('closeMessage').addEventListener('click', closeUserEditForm);
                messageModal.style.display = 'block';
            } else {
                usersEditForm.style.display = 'none';
                resultModalContent.innerHTML = `<div class="alert alert-danger center-message" role="alert">
                        Failed to create new user! ${resJson.message}.
                </div>
                <div class="form-buttons">
                    <button id="closeMessage" class="btn btn-danger">OK</button>
                </div>`;
                document.getElementById('closeMessage').addEventListener('click', closeUserEditForm);
                messageModal.style.display = 'block';
            }
        }).then(() => getPageContent({rerenderPage: 'users.php'}));
        } else {
            document.querySelector('.errors').innerHTML = 'User already exists'
            document.querySelector('.errors').style.display = 'flex';
        }
    }
    return false;

}

async function validateNewUser(username) {

    if (username.length < 1 || username === '') {
        return false;
    }

    let url = `api/users/fetchusers.php?find_by_username&username=${username}`;
    let result = await fetch(url);
    return result.json();

}

async function deleteUser(userId) {
    let confirmDelete = confirm('Warning! Deleting a user is permanent and cannot be reversed! Continue?');
    if (confirmDelete) {
        let url = `api/users/deleteuser.php?id=${userId}`;
        await fetch(url).then(() => getPageContent({rerenderPage: 'users.php'}));
    }
}

async function deletePhoto(photoId) {
    let confirmDelete = confirm('Warning! Deleting a photo is permanent and cannot be reversed! Continue?');
    if (confirmDelete) {
        let url = `api/photos/deletephoto.php?id=${photoId}`;
        await fetch(url).then(() => getPageContent({rerenderPage: 'photos.php'}));
    }
}

async function managePhoto(photoId) {
    let url = `api/photos/getphotos.php?find_one&id=${photoId}`;
    await buildPhotoEditForm(await fetch(url));
    usersEditForm.style.display = 'block';

    usersEditForm.addEventListener('submit', e => {
        e.preventDefault();
        const form = document.querySelector('#editPhoto');
        if (!validateForm(form)) {
            return false;
        }
        const formData = new FormData();
        for (let forms of form) {
            formData.append(forms.name, forms.value);
        }
        formData.append('photo_id', photoId);
        updatePhoto(formData).then(resJson => {
            if (resJson.success) {
                usersEditForm.style.display = 'none';
                resultModalContent.innerHTML = `<div class="alert alert-success center-message" role="alert">
                        Photo Updated successfully!
                </div>
                <div class="form-buttons">
                    <button id="closeMessage" class="btn btn-success">OK</button>
                </div>`;
                document.getElementById('closeMessage').addEventListener('click', closeUserEditForm);
                messageModal.style.display = 'block';
            } else {
                usersEditForm.style.display = 'none';
                resultModalContent.innerHTML = `<div class="alert alert-danger center-message" role="alert">
                        Failed to update picture details! ${resJson.message}.
                </div>
                <div class="form-buttons">
                    <button id="closeMessage" class="btn btn-danger">OK</button>
                </div>`;
                document.getElementById('closeMessage').addEventListener('click', closeUserEditForm);
                messageModal.style.display = 'block';
            }
        }).then(() => getPageContent({rerenderPage: 'photos.php'}));
    });
}

async function buildPhotoEditForm(photoData) {
    photoData.json().then(photoObj => {
        modalContent.innerHTML = `<span id="closePhotoEdit" class="close">x</span>
        <div class="errors"></div>
        <form class="form-align-center" id="editPhoto" enctype="multipart/form-data">
            <div class="edit-user-header">
                Editing Photo
            </div>
            <div class="img thumbnail center-form user-avatar-wrapper">
                  <img class="user-avatar" src="${photoObj.data.filename}" alt="a picture" id="photo">
            </div>
            <div class="form-group">
                <label for="title">Caption</label>
                <input type="text" class="form-control" required minlength="2" name="title" id="title" value="${photoObj.data.title}">
            </div>
            <div class="form-group">
                <label for="title">Alternate Text</label>
                <input type="text" class="form-control" required minlength="2" name="alt_text" id="alt_text" value="${photoObj.data.alt_text}">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description">${photoObj.data.description}</textarea>
            </div>
            <div class="form-buttons">
                <button type="submit" value="update_photo" data-id="${photoObj.data.id}" id="update_photo" name="update_photo" class="btn btn-success">Submit</button>
                <button id="cancelPhotoEdit" class="btn btn-danger">Cancel </button>
            </div>
        </form>`;
        tinymce.init({
            selector:'#description',
            setup: function (editor) {
                editor.on('change', function () {
                    tinymce.triggerSave();
                });
            }
        });
        document.getElementById('closePhotoEdit').addEventListener('click', closeUserEditForm);
        document.getElementById('cancelPhotoEdit').addEventListener('click', closeUserEditForm);
    });
}

function drawChart() {
    const data = google.visualization.arrayToDataTable([
        ['Statistic', 'Numbers'],
        ['Views',    chartData.totalViews],
        ['Users',    chartData.totalUsers],
        ['Photos',   chartData.totalPhotos],
        ['Comments', chartData.totalComments],
    ]);

    const options = {
        title: 'Statistics',
        legend : 'none',
        pieSliceText: 'label',
        backgroundColor: 'transparent'
    };

    const chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);
}