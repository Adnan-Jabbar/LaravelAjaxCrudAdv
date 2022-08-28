<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Crud Using AJAX</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.0/css/all.min.css">
</head>

<body>
    <br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <form enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email" 
                        @if (isset($row[0]))
                        value="{{ $row[0]->email }}"
                        @endif
                        >
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" 
                        @if (isset($row[0]))
                        value="{{ $row[0]->password }}"
                        @endif
                        >
                    </div>
                    <div class="form-group image-box">
                        <label for="image">Image:</label>
                        <span class="badge badge-secondary" onclick="add_more()"><i class="fa fa-plus"></i></span>
                        <input type="file" id="image" name="images[]" class="form-control-file" multiple>
                    </div>
                    @if (isset($row[0]))
                        @if ($row[0]->images != '')
                            @php
                                $imageArr = explode(',', $row[0]->images);
                            @endphp
                            <div class="p-4">
                                @foreach($imageArr as $image)
                                    <span class="p-2">
                                        <img src="{{ asset('storage/media/'.$image) }}" alt="" width="100px">
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    @endif
                    {{-- <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="file" name="image" id="image">
                            </div>
                            <div class="col-md-4">
                                <span class="btn btn-danger"><i class="fa fa-minus"></i> Remove</span>
                            </div>
                        </div>
                    </div> --}}
                    @if (isset($row[0]))
                        <a href="/" class="btn btn-secondary">Back</a>
                        <input type="hidden" id="id" name="id" value="{{ $row[0]->id }}">
                        <button type="submit" id="submit" class="btn btn-primary">Update</button>
                    @else
                        <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <br><br>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tr>
                      <th>ID</th>
                      <th>Email</th>
                      <th>Password</th>
                      <th>Images</th>
                      <th>Action</th>
                    </tr>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->password }}</td>
                            @php
                                $imageArr = explode(',', $row->images);
                            @endphp
                            <td>
                                <div class="p-4">
                                    @foreach($imageArr as $image)
                                        <img src="{{ asset('storage/media/'.$image) }}" alt="" width="100px">
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <a href="{{ url('/edit/'.$row->id) }}", class="btn btn-secondary">Edit</a>
                                <a href="{{ url('/delete/'.$row->id) }}", class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                  </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var count = 0;
        function add_more() {
            count++;
            var html = '<div class="form-group" id="image_box_' + count + '"><div class="row"><div class="col-md-6"><input type="file"  id="image" name="images[]" multiple></div><div class="col-md-4"><span class="btn btn-danger" onclick="remove_more('+ count +')"><i class="fa fa-minus"></i> Remove</span></div></div></div>';
            
            $('.image-box').after(html);
        }

        function remove_more(count) {
            $('#image_box_'+count).remove();
        }

        $(document).ready(function() {
            $('form').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: '/manage',
                    data: formData,
                    type: 'POST',
                    success: function (result) {
                        alert(result);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

            })
        });
    </script>

</body>

</html>
