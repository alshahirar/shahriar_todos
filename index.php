<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="lib/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>
<br />
<!--Task Add Input-->
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 panel0">
            <div class="table-responsive" id="add">
                <span id="message"></span>
                <form id="insert_from" class="form-inline" method="POST">
                    <div class="form-group">
                        <input type="text" class="form_text_input" id="task" autocomplete="off" placeholder="Whats need to be done?" name="task" />

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!--Task list-->
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 panel1">
            <div class="table-responsive" id="tableData">
                <h3 class="text-center text-success" style="margin-top: 150px;">Loading...</h3>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.22/datatables.min.js"></script>
<script type="text/javascript" src="lib/shahriar_todo.js">
</script>
</body>
</html>
