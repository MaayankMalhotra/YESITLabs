<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Users</h1>
    <div class="container mt-5">
     
    </div>
    <div>
        <a href="{{ route('users.create') }}" class="btn btn-primary">Create User</a>
        <a href="{{ route('users_export') }}" class="btn btn-success">Export Users to CSV</a>
        <a href="{{ route('distance') }}" class="btn btn-primary">GeoLocation Check</a>
    </div>
</div>

<form id="uploadForm" action="{{ route('upload.audio') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="audioFile">Select an MP3 file:</label>
        <input type="file" class="form-control-file" id="audioFile" name="audioFile">
    </div>
    <button type="submit" class="btn btn-primary">Upload</button>
</form>

<div id="audioLengthResult" class="mt-3">
    <span id="audioLength"></span>
</div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Profile Pic</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->mobile }}</td>
                    <td>
                        @if ($user->profile_pic)
                        <img src="{{ Storage::url($user->profile_pic) }}" width="50">
                        @else
                        N/A
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
    var uploadForm = document.getElementById('uploadForm');
    var audioLengthElement = document.getElementById('audioLength');

    uploadForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        var formData = new FormData(uploadForm);
        
        fetch(uploadForm.getAttribute('action'), {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            audioLengthElement.textContent = 'Audio Length: ' + data;
        })
        .catch(error => {
            console.error('Error uploading file', error);
            alert('Error uploading file');
        });
        
        return false;
    });
});

    

    </script>
</body>
</body>
</html>
