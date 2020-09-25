const sideBarNav = document.getElementById('sidebar_nav');
const topNavItems = document.getElementById('top_nav_items');
const pageContent = document.getElementById('page_content');
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

document.addEventListener('DOMContentLoaded', () => {
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
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> John Smith <b class="caret"></b></a>
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
                <a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
            </li>
        </ul>
    </li>`;
    sideBarNav.innerHTML = sideBarItems;
    pageContent.innerHTML = getPageContent({activeRoute});
});

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
                return printTableWithData(users);
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
    let deconstructedUrl = options.activeRoute.split('/');
    let requestedFile = deconstructedUrl[deconstructedUrl.length - 1];
    requestedFile === '' ? requestedFile = 'index.php' : requestedFile;
    if (routes.find(route => route === requestedFile)) {
        return innerHtml(requestedFile);
    }
}

function fetchAllUsers() {
    return fetch('api/fetchusers.php?find_all');
}

function printTableWithData(data) {
    let table = `<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            User Management
            <small>Manage Users</small>
        </h1>
    <table class="table table-striped">
    <tr>
    <th>ID</th>
    <th>Username</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Actions</th>
    </tr>
    `;
    for (const dataItem of data) {
        table += `<tr>
                <td>${dataItem.id}</td>
                <td>${dataItem.username}</td>
                <td>${dataItem.first_name}</td>
                <td>${dataItem.last_name}</td>
                <td>
                <a href="#"><i class="fa fa-pencil" id="${dataItem.id}"></i></a>
                </td>
                </tr>`;
    }
    table += '</table>';
    pageContent.innerHTML = table;
    const editButtons = document.querySelectorAll('.fa-pencil');
    editButtons.forEach(button => button.addEventListener('click', e => {
        manageSingleUser(e.target.id);
    }));
}

async function updateUser(options = {}) {
    let response = await fetch( 'api/updateusers.php',{
        method: 'POST',
        body: JSON.stringify(options),
        mode: 'cors',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    });
    console.log(response);
}

function manageSingleUser(userId) {
    let url = `api/fetchusers.php?find_one&id=${userId}`;
        fetch(url).then(response => response.json()).then(res => {
            document.getElementById('theModalContent').innerHTML = `
<span id="closeUserEdit" class="close">x</span>
<form class="form-align-center" id="editUser">
            <div class="edit-user-header">
                Editing User: ${res.username}
            </div>
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" name="first_name" id="first_name" value="${res.first_name}">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" name="last_name" id="last_name" value="${res.last_name}">
            </div>
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" class="form-control" name="password" id="password" value="${res.password}">
            </div>
            <div class="form-group">
                <label for="exampleInputFile">User Image</label>
                <input type="file" id="userimage" name="userimage">
            </div>
            <div class="form-buttons">
                <button value="update_user" data-id="${res.id}" id="update_user" name="update_user" class="btn btn-success">Submit</button>
                <button id="cancelUserEdit" class="btn btn-danger">Cancel</button>
            </div>
        </form>`;
            const submitBtn = document.getElementById('update_user');
            document.getElementById('closeUserEdit').addEventListener('click', () => usersEditForm.style.display = 'none');
            document.getElementById('cancelUserEdit').addEventListener('click', () => usersEditForm.style.display = 'none');
            usersEditForm.style.display = 'block';
            let form = document.querySelector('#editUser');
            submitBtn.addEventListener('click', e => {
                e.preventDefault();
                updateUser({
                    submit_user: 'submit_user',
                    form_data: new FormData(form),
                    user_id: submitBtn.dataset.id
                });
            });
    });
}