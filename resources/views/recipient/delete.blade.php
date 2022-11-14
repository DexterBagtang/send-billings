<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Delete Record using Ajax in Laravel 8 - codeanddeploy.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                var button = $(this);

                bootbox.confirm({
                    title: "Are you sure?",
                    message: "Your about to delete this post!",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger'
                        }
                    },
                    callback: function (result) {
                        if(result) {
                            $.ajax({
                                type: 'post',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: button.data('route'),
                                data: {
                                    '_method': 'delete'
                                },
                                success: function (response, textStatus, xhr) {

                                    bootbox.alert({
                                        message: response,
                                        callback: function () {
                                            window.location='/posts'
                                        }
                                    });
                                }
                            });
                        }
                    }
                });


            })
        });
    </script>
</head>

<body>
<div class="container mt-5">
    @if(Session::get('success', false))
        <?php $data = Session::get('success'); ?>
        @if (is_array($data))
            @foreach ($data as $msg)
                <div class="alert alert-success" role="alert">
                    <i class="fa fa-check"></i>
                    {{ $msg }}
                </div>
            @endforeach
        @else
            <div class="alert alert-success" role="alert">
                <i class="fa fa-check"></i>
                {{ $data }}
            </div>
        @endif
    @endif

    <table class="table table-striped" id="users-table">
        <thead>
        <tr>
            <th scope="col"><input type="checkbox" class="check-all"></th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
{{--            <th scope="col">Body</th>--}}
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td><input type="checkbox" class="check"></td>
                <td>{{$post->recipient_name}}</td>
                <td>{{$post->recipient_email}}</td>
{{--                <td>{{$post->body}}</td>--}}
                <td>
                    <form method="post" class="delete-form" data-route="{{route('posts.destroy',$post->id)}}">
                        @method('delete')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
