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
    'uploads.php',
    'comments.php',
];
const usersEditForm = document.getElementById('userEditForm');
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

function innerHtml(requestedFile) {
    switch (requestedFile) {
        case 'index.php':
            document.title = 'Content Management Admin';
            return `<div class="col-lg-12">
                        <h1 class="page-header">
                            Index Page!
                            <small>This is sum shiet</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>`;
        case 'users.php':
            document.title = 'User Management';
            fetchAllUsers().then(usersList => usersList.json().then(users => {
                return printUsersTableWithData(users);
            }));
            break;
        case 'uploads.php':
            document.title = 'Uploads';
            return `<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Uploads Page!
                            <small>This is sum shiet</small>
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
            return `<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Comments Page!
                            <small>This is sum shiet</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="comments.php">Comments</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>
                </div>`;
        case 'photos.php':
            document.title = 'Photos';
            return `<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Photos Page!
                            <small>This is sum shiet</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="photos.php">Photos</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>
                </div>`;
        default:
            document.title = 'Not Found!';
            return `<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Not found
                            <small>The page you were looking for is not here.</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Comments</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
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
            <small>Manage Users</small>
        </h1>
    <table class="table table-striped table-bordered">
    <tr>
    <th>ID</th>
    <th>Username</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Email</th>
    <th>Actions</th>
    </tr>
    `;
    for (const dataItem of data) {
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
        console.log(e.target.id);
    }));

}

async function updateUser(options = {}) {
    let url = 'api/users/updateusers.php';
    const headers = new Headers();
    headers.append('Content-Type', 'application/json');
    let request = {
        method: "POST",
        body: JSON.stringify(options),
        datatype: 'json',
        credentials: 'include',
        headers: headers
    };
    return await fetch( url, request);
}

async function logout() {
    await fetch('api/users/logout.php');
    window.location.href = 'login.php';
}

function manageSingleUser(userId) {
    let url = `api/users/fetchusers.php?find_one&id=${userId}`;
        fetch(url).then(response => response.json()).then(res => {
            modalContent.innerHTML = `<span id="closeUserEdit" class="close">x</span>
        <form class="form-align-center" id="editUser">
            <div class="edit-user-header">
                Editing User: ${res.username}
            </div>
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" name="firstName" id="firstName" value="${res.firstName}">
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control" name="lastName" id="lastName" value="${res.lastName}">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" name="email" id="email" value="${res.email}">
            </div>
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" class="form-control" name="password" id="password" value="${res.password}">
            </div>
<!--            <div class="form-group">-->
<!--                <label for="exampleInputFile">User Image</label>-->
<!--                <input type="file" id="userimage" name="userimage">-->
<!--            </div>-->
            <div class="form-buttons">
                <button type="submit" value="update_user" data-id="${res.id}" id="update_user" name="update_user" class="btn btn-success">Submit</button>
                <button id="cancelUserEdit" class="btn btn-danger">Cancel</button>
            </div>
        </form>`;
            const submitBtn = document.getElementById('update_user');
            document.getElementById('closeUserEdit').addEventListener('click', closeUserEditForm);
            document.getElementById('cancelUserEdit').addEventListener('click', closeUserEditForm);
            usersEditForm.style.display = 'block';
            const form = document.querySelector('#editUser');
            form.addEventListener('submit', e => {
                e.preventDefault();
                options = {
                    update_user: Object.fromEntries(new FormData(form)),
                    user_id: submitBtn.dataset.id
                };
                updateUser(options).then(res => res.json()).then(resJson => {
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
                            Failed to update user details!
                    </div>
                    <div class="form-buttons">
                        <button id="closeErrorMessage" class="btn btn-danger">OK</button>
                    </div>`;
                        document.getElementById('closeMessage').addEventListener('click', closeUserEditForm);
                        messageModal.style.display = 'block';
                    }
                }).then(() => getPageContent({rerenderPage: 'users.php'}));
            });
    });
}

function closeUserEditForm() {
    usersEditForm.style.display = 'none';
    messageModal.style.display = 'none';
    modalContent.innerHTML = '';
    resultModalContent.innerHTML = '';
}