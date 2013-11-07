<!DOCTYPE html>
<html>
<head>
    <title><?= $pageTitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="./_library/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Campaign Manager</a>
        </div>
    </div>
</div>

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <div class="container">
        <h1>Welcome!</h1>
        <p>This application demonstration was constructed using a lightweight MVC framework authored by Kevin Crawley,
            which incorporates REST, Twitter Bootstrap and jQuery.</p>
        <p><a id="learnMore" class="btn btn-primary btn-lg" role="button">Learn more &raquo;</a></p>
    </div>
</div>

<div class="container">
    <!-- Example row of columns -->
    <div class="row">
        <div class="col-md-4">
            <h2>Client</h2>
            <!-- Split button -->
            <div id="client" class="btn-group">
                <button id="addNewClient" type="button" class="client-primary btn btn-primary">Add New Record</button>
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="data-list dropdown-menu" role="menu">
                </ul>
            </div>
            <dl id="formatted-client-list"></dl>
        </div>
        <div class="col-md-4">
            <h2>Client Contact</h2>
            <div id="client-contact" class="btn-group">
                <button id="addNewContact" type="button" class="contact-primary btn btn-primary">Add New Record</button>
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="data-list dropdown-menu" role="menu">
                    <li><a>Please select a client</a></li>
                </ul>
            </div>
            <dl id="formatted-contact-list"></dl>
        </div>
        <div class="col-md-4">
            <h2>Project Type</h2>
            <div id="project-type" class="btn-group">
                <button id="addNewProject" type="button" class="project-primary btn btn-primary">Add New Record</button>
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="data-list dropdown-menu" role="menu">
                    <li><a>Please select a client</a></li>
                </ul>
            </div>
            <dl id="formatted-project-list"></dl>
        </div>
    </div>

    <hr>

    <footer>
        <p>&copy; Kevin Crawley 2013</p>
    </footer>
</div> <!-- /container -->

<div id="modal" class="modal fade"></div>
<div id="moreinfo" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Hello! Thanks for checking this project out.</h4>
            </div>
            <div class="modal-body">
                <p class="lead">The entire project is powered by a mini-framework that was built solely by me. I've used
                    this framework in small projects that don't require CI/Symfony2/Laravel/etc.</p>

                <p>If you're familiar with Laravel you'll see that I borrowed some stuff. Most of the stuff you see in
                    here I built some time ago, but things like the Database model I did from scratch since I use
                    Eloquent or ActiveRecord almost exclusively these days. The exception is when I'm working with
                    legacy projects, which is mostly mysql_ (yuck!).</p>

                <p>That being said, I wanted to demonstrate my ability to build a framework from the ground up. I
                    believe that I have a firm understanding of the MVC foundation and OOP principles. I was also
                    determined to hand over something above and beyond, yet simple to understand. You'll find that
                    there was some functionality added, and some UX enhancements. I hope you enjoy a preview of my
                    development techniques and abilities.</p>

                <p>If you have any questions, please feel free to ask. I apologize for my documentation within the
                    framework, it's hit or miss (depending on how much time I had to build a certain component).</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="./_library/js/jquery-2.0.3.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="./_library/js/bootstrap.min.js"></script>
<script src="./_library/js/main.js"></script>
<script>campaignManager.initialize();</script>
</body>
</html>