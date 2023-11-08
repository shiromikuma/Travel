<h1>Edit Blog</h1>
    <form method="POST" action="">
        <input type="hidden" name="id_blog" value="<?php echo $data['blog']['id_blog']; ?>">
        <label for="judul">Judul:</label>
        <input type="text" name="judul" value="<?php echo $data['blog']['judul']; ?>" required>
        <br>
        
        <label for="author">Author:</label>
        <input type="text" name="author" value="<?php echo $data['blog']['author']; ?>" required>
        <br>
        
        <label for="konten">Konten:</label>
        <textarea name="konten" required><?php echo $data['blog']['konten']; ?></textarea>
        <br>
        
        <input type="submit" value="Update">
    </form>