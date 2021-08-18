<h1>This is the import page</h1>

<form action="/users/imports" method="post" enctype="multipart/form-data">
    @csrf

    <div>
        <input type="file" name="file">
        <button type="submit">Upload</button>
    </div>
</form>
